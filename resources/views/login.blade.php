@extends('layout')
@section('content')
    <div class="form-group m-3 flex-col">
        <h1>Login</h1>
        <form class="login" method="POST" action="{{url('login')}}" >
            @csrf
            <input type="text" placeholder="<?= __('Username')?>" name="username" value="{{old('username')}}">
            @error('username')
            <div class="error"> {{$message}} </div>
            @enderror
            <input type="text" placeholder="<?= __('Password')?>" name="password" value="{{old('password')}}">
            @error('password')
            <div class="error"> {{$message}} </div>
            @enderror
            <input type="submit" class="loginInputs" value="Login">
            <a href="{{url('index')}}"><?= __('Anonymous User')?></a>
        </form>
    </div>
@endsection
