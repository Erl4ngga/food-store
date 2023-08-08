<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction as TransactionModel;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Config;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;
use Illuminate\Support\Facades\Notification;
use App\Notifications\StatusNotification;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Charge;
use Midtrans\Transaction;
use Illuminate\Support\Facades\URL;
class PayPalController extends Controller
{
    /**
     * create transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTransaction()
    {
        return view('transaction');
    }
    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request)
    {
        $this->validate($request,[
            'quant.1' => 'required|integer|min:30000', // memastikan input adalah integer positif
        ]);
        
        $user=Auth()->user();
        $usertopup = User::where('id', $user->id)->first();
        if (empty(request('payment_method'))) {
            return back()->with('error','error,please fill in the payment method');
        } 
        if(request('payment_method')=='midtrans'){
            $grossAmount = $request->input('quant.1');
            $serverKey = Config::get('midtrans.serverKey');
            $clientKey = Config::get('midtrans.clientKey');
            MidtransConfig::$serverKey = $serverKey;
            MidtransConfig::$clientKey = $clientKey;

            
            // Buat transaksi baru
          // Buat transaksi baru
            $params = array(
                    'transaction_details' => array(
                    'order_id' => 'ORDER-' . time(),
                    'gross_amount' => $grossAmount,
                ),
            );
            $transactionSnap = Snap::createTransaction($params);
            
            $usertopup->update([
                'money' => $user->money + $grossAmount, // mengupdate saldo pengguna dengan nilai transaksi
            ]);
            $status = 'success'; 
            $payment_method='midtrans';
            $transaction = new TransactionModel(); 
            $transaction->user_id = $user->id; 
            $transaction->name = $usertopup->name;
            $transaction->status = $status; 
            $transaction->payment_method = $payment_method;
            $transaction->money =$grossAmount; 
            $transaction->save();
            // Redirect ke halaman pembayaran Midtrans
            return redirect($transactionSnap->redirect_url);

        } elseif (request('payment_method') == 'paypal') {
            
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction', ['quant' => $request->quant[1]]),
                "cancel_url" => route('cancelTransaction', ['quant' => $request->quant[1]]),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->quant[1],
                    ]
                ]
            ]

            ]);

            if (isset($response['id']) && $response['id'] != null) {
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('user')
                ->with('error', 'Something went wrong.');
            } else {
            return redirect()
                ->route('user')
                ->with('error', $response['message'] ?? 'Something went wrong.');
            }
        }else {
            $grossAmount = $request->input('quant.1');
            Stripe::setApiKey(config('stripe.api_key'));
            $successUrl = URL::route('successTransactionStripe', ['quant' => $request->quant[1]]);
            $cancelUrl = URL::route('cancelTransactionStripe', ['quant' => $request->quant[1]]);
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => config('stripe.currency'),
                        'product_data' => [
                            'name' => 'Top-Up',
                        ],
                        'unit_amount' => $grossAmount,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
            ]);
            
            // Redirect to the checkout page
            return redirect()->to($session->url);
        }
        
    }
    /**
     * success stripe transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
        $user=Auth()->user();
        $usertopup = User::where('id', $user->id)->first();
        $quant = $request->input('quant');
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $usertopup->update([
                'money' => $usertopup->money + $quant, // quantity of product from order
            ]);
            $users = [
                'example@email.com'
            ];
            $details=[
                'title'=>'New order created',
                'Invoice' => (strval($quant)),
                'fas'=>'fa-file-alt'
            ];
            $status = 'success'; 
            $payment_method='paypal';
            $transaction = new TransactionModel(); 
            $transaction->user_id = $user->id; 
            $transaction->name = $usertopup->name;
            $transaction->status = $status; 
            $transaction->payment_method = $payment_method;
            $transaction->money = $quant; 
            $transaction->save();
            return redirect()
                ->route('user')
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->route('user')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
    /**
     * success stripe transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransactionStripe(Request $request)
    {
        $user=Auth()->user();
        $usertopup = User::where('id', $user->id)->first();
        $quant = $request->input('quant');
            $usertopup->update([
                'money' => $usertopup->money + $quant, // quantity of product from order
            ]);
            $status = 'success'; 
            $payment_method='stripe';
            $transaction = new TransactionModel(); 
            $transaction->user_id = $user->id; 
            $transaction->name = $usertopup->name;
            $transaction->status = $status; 
            $transaction->payment_method = $payment_method;
            $transaction->money = $quant; 
            $transaction->save();
            return redirect()
                ->route('user')
                ->with('success', 'Transaction complete.');
    }
    /**
     * cancel paypal transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        $quant = $request->input('quant');
        $user=Auth()->user();
        $usertopup = User::where('id', $user->id)->first();
        $status = 'cancel'; 
        $payment_method='paypal';
        $transaction = new TransactionModel(); 
        $transaction->user_id = $user->id; 
        $transaction->name = $usertopup->name; 
        $transaction->payment_method = $payment_method;
        $transaction->status = $status;
        $transaction->money = $quant; 
        $transaction->save();
        return redirect()
            ->route('user')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
     /**
     * cancel stripe transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransactionStripe(Request $request)
    {
        $quant = $request->input('quant');
        $user=Auth()->user();
        $usertopup = User::where('id', $user->id)->first();
        $status = 'cancel'; 
        $payment_method='stripe';
        $transaction = new TransactionModel(); 
        $transaction->user_id = $user->id; 
        $transaction->name = $usertopup->name; 
        $transaction->payment_method = $payment_method;
        $transaction->status = $status;
        $transaction->money = $quant; 
        $transaction->save();
        return redirect()
            ->route('user')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
    
}