@extends('layouts.dashboard.app',['activePage' => 'order'])
@section('content')
<div class="container-fluid py-4">

    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-dark border-radius-lg pt-4 pb-3">
              <h6 class="text-white text-capitalize ps-3">{{__('Your Orders')}}</h6>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('Id')}}</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{'Carts'}}</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{'Status'}}</th>
                    
                  </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td><h6 class="mb-0 text-sm"> {{$order->id}}</h6></td>
                        <td>
                            @foreach ($order->carts as $cart)
                            <a data-bs-toggle="collapse" href="#multiCollapseExample{{$cart->id}}" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                              <h6 class="mb-0 text-sm"> {{ __('Cart Id')}}: {{$cart->id}}</h6>
                            </a>
                            
                            <div class="row">
                              <div class="col">
                                <div class="collapse multi-collapse" id="multiCollapseExample{{$cart->id}}">
                                  <ul class="list-group">
                                    <li class="list-group-item"><span class="fw-bold">{{ __('Product name')}}</span>:{{$cart->prod_name}}</li>
                                    <li class="list-group-item"><span class="fw-bold">{{ __('quantity')}}</span>:{{$cart->quantity}}</li>
                                    <li class="list-group-item"><span class="fw-bold">{{ __('Unit Price')}}</span>:{{$cart->price}}</li>
                                </ul>
                                </div>
                              </div>
                            </div>
                               
                            @endforeach
                        </td>
                        <td>
                          @if($order->status == 1) <span class="badge bg-info">{{__('paid')}}</span>
                          @else <span class="badge bg-warning">{{__('unpaid')}}</span> <a href="/shop/charge_later/{{$order->id}}"><span class="badge bg-success">{{__('Pay Now')}}</span></a>
                          @endif
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

</div>

@endsection