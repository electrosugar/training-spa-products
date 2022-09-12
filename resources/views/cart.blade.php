@extends('layout')

@section('content')
    @foreach($products as $product)
        <div class="product">
            <img
                src="{{isset($message) ? $message->embed($product['image_path']) : asset($product['image_path'])}}"
                alt="{{$product['image_path']}}">
            <h1 class="title">
                {{$product->title . $product->id}}
            </h1>
            <span class="description">
                    {{$product->description}}
            </span>
            <span class="price">
                    {{$product->price}} $
            </span>
        </div>
        @if(!$displayMail)
            <form action="{{url('cart')}}" method="POST" id="product-remove">
                @csrf
                <input type="hidden" name="productID" value="{{$product->id}}">
                <button id="btn-submit" type="submit">Remove from cart</button>
            </form>
        @endif
    @endforeach
    @if(!$displayMail)
        <h1>{{__('Submit Order')}}</h1>
        <form action="{{url('cart/order')}}" method="post"
              class="form-group" id="product-remove">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
                @error('errors')
                <div class="error"> {{$message}} </div>
                @enderror
            @csrf
            <input type="text" name="name" placeholder="{{__('Name') }}" value="{{old('name')}}"><br>
                @error('name')
                <div class="error"> {{$message}} </div>
                @enderror
            <input type="text" name="contact" placeholder="{{__('Contact') }}" value="{{old('contact')}}"><br>
                @error('contact')
                <div class="error"> {{$message}} </div>
                @enderror
            <textarea rows="4" cols="20" name="comment"
                      placeholder="{{__('Comment') }}">{{old('comment')}}</textarea><br>
                @error('comment')
                <div class="error"> {{$message}} </div>
                @enderror
            <span class="formLinks"> <button type="submit" id="btn-submit">{{__('Checkout')}}</button></span>
        </form>
        <a href="{{ url('index') }}">{{__('Go to index')}}</a>
    @else
        {{__('Name: ') .$orderData['name']}}
        <br>
        {{__('Contact: ') .$orderData['contact']}}
        <br>
        {{__('Comment: ') . $orderData['comment']}}
    @endif
@endsection
