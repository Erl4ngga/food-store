@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
  <h5 class="card-header">Order Edit</h5>
  <div class="card-body">
    <form action="{{route('order.update',$order->id)}}" method="POST">
      @csrf
      @method('PATCH')
      <div class="form-group">
        <label for="status">Status :</label>
        <select name="status" id="" class="form-control">
          <option value="new" {{($order->status=='delivered' || $order->status=="process" || $order->status=="cancel") ? 'disabled' : ''}}  {{(($order->status=='new')? 'selected' : '')}}>New</option>
          <option value="process" {{($order->status=='delivered'|| $order->status=="cancel") ? 'disabled' : ''}}  {{(($order->status=='process')? 'selected' : '')}}>process</option>
          <option value="delivered" {{($order->status=="cancel") ? 'disabled' : ''}}  {{(($order->status=='delivered')? 'selected' : '')}}>Delivered</option>
          <option value="arrived" {{($order->status=="cancel") ? 'disabled' : ''}}  {{(($order->status=='arrived')? 'selected' : '')}}>arrived</option>
          <option value="cancel" {{($order->status=='delivered') ? 'disabled' : ''}}  {{(($order->status=='cancel')? 'selected' : '')}}>Cancel</option>
        </select>
      </div>
      <div class="form-group">
        <label for="payment_status">payment :</label>
        <select name="payment_status" id="" class="form-control">
          <option value="unpaid" {{($order->status=="paid" )? 'disabled' : ''}}  {{(($order->status=='unpaid')? 'selected' : '')}}>unpaid</option>
          <option value="paid" {{($order->status=="unpaid") ? 'disabled' : ''}}  {{(($order->status=='paid')? 'selected' : '')}}>paid</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }

</style>
@endpush
