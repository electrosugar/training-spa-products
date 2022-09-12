@extends('layout')

<body>
@foreach($orders as $order)
    <div class="product">
        <div class="info">
            <span class="title">{{__('Name: ') . $order->name}}</span>
            <br>
            <span class="description">{{__('Contact: ') . $order->contact}}</span>
            <br>
            <span class="price">{{__('Comment: ') . $order->comment}}</span>
            <br>
            <span class="date">{{__('Date: ') . $order->creation_date}}</span>
            <br>
        </div>
        <span>{{__('Total Price: ') . $order->total_price}}</span>
        <div>
            <a href="{{url('order/' . $order->id)}}">{{__('Go to order details')}}</a>
        </div>
    </div>
@endforeach
<a href="{{url('products')}}">{{ __('Go to products') }}</a>
</body>
