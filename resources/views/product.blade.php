@extends('layout')

@section('content')
    <h1>{{isset($product->id) ? __('Editing Product #') . $product->id : __('Creating new product')}}</h1>
    <form enctype="multipart/form-data" action="{{url('product/' . $value = isset($product->id) ? $product->id : '')}}" method="post"
          class="form-group">
        @if(session()->has('success'))
            <div class="success">
                {{ session()->get('success') }}
            </div>
        @endif
        @csrf
        <input type="text" name="title" placeholder="{{__('Title') }}" value="{{old('title') ?? $product->title ?? ''}}"><br>
            @error('title')
            <div class="error"> {{$message}} </div>
            @enderror
        <input type="text" name="description" placeholder="{{__('Description') }}"
               value="{{old('description') ?? $product->description ?? ''}}"><br>
            @error('description')
            <div class="error"> {{$message}} </div>
            @enderror
        <input type="text" name="price" placeholder="{{__('Price') }}"
               value="{{old('price') ?? $product->price ?? ''}}"><br>
            @error('price')
            <div class="error"> {{$message}} </div>
            @enderror
        <input type="file" name="image"><br>
            @if(isset($product))
            <img src="{{asset($product->image_path )}}" alt="{{$product->image_path}}">
            @endif
            @error('image')
            <div class="error"> {{$message}} </div>
            @enderror
        <span class="formLinks"> <input type="submit" value="Save"></span>
    </form>
    <a href="{{url('products')}}">{{__('See Items')}}</a>

@endsection
