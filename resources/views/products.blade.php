@extends('layout')

@section('content')
    <body>
    @foreach($products as $product)
        <div class="product">
            <img src="{{$product->image_path}}" alt="{{$product->image_path}}">
            <h1 class="title">
                {{$product->title  . $product->id}}
            </h1>
            <span class="description">
                {{$product->description}}
            </span>
            <span class="price">
                {{$product->price}} $
            </span>
            @if($errors->first('id') == $product->id)
            @error('message')
            <div class="error"> {{$message}} </div>
            @enderror
                @endif
        </div>
        <form action="{{url('products')}}" method="POST" id="product-delete">
            @csrf
            <input type="hidden" name="productID" value="{{$product->id}}">
            <button id="btn-submit" type="submit">{{__('Delete product')}}</button>
        </form>
        <a href="{{url('product/'.$product->id)}}">{{__('Edit Item')}}</a>
    @endforeach
    <br>
    <a href="{{url('product')}}">{{__('Add Item')}}</a>
    <a href="{{ url('orders') }}">{{__('Go to orders')}}</a>
    <form action="{{url('logout')}}" method="POST" id="logout">
        @csrf
        <button id="btn-submit" type="submit">{{__('Logout')}}</button>
    </form>
@endsection
