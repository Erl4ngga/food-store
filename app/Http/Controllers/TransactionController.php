<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaction=Transaction::orderBy('id','DESC')->paginate('10');
        return view('backend.transaction.index')->with('transaction',$transaction);
    }
        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction=Transaction::find($id);
        if($transaction){
            $status=$transaction->delete();
            if($status){
                request()->session()->flash('success','transaction successfully deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('coupon.index');
        }
        else{
            request()->session()->flash('error','Transction not found');
            return redirect()->back();
        }
    }
}
