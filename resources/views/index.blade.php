@extends('layout')

@section('content')
    @foreach($products as $product)
        <div class="product">
            <img src="{{$product->image_path}}" alt="{{$product->image_path}}">
            <h1 class="title">
               {{{$product->title }}}
            </h1>
            <span class="description">
                {{$product->description}}
            </span>
            <span class="price">
                {{$product->price}} $
            </span>
            <form action="{{url('index')}}" method="POST" id="product-add">
                @csrf
                <input type="hidden" name="productID" value="{{$product->id}}">
                <button id="btn-submit" type="submit">Add to cart</button>
            </form>
        </div>
    @endforeach
    <a href="{{ url('cart') }}">{{__('Go to cart')}}</a>
    <a href="{{ url('login') }}">{{__('Login')}}</a>
@endsection

