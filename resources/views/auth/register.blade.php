@extends('layouts.app')

@section('content')
<div class="container p-4" style="overflow-y: scroll"> 
  <form class="d-flex flex-column" method="POST" action="{{ route('register') }}">
      {{ csrf_field() }}

      <label for="nickname">Nickname</label>
      <input id="nickname" type="text" name="nickname" value="{{ old('nickname') }}" required autofocus>
      @if ($errors->has('nickname'))
        <span class="error">
            {{ $errors->first('nickname') }}
        </span>
      @endif

      <label for="username">Username</label>
      <input id="username" type="text" name="username" value="{{ old('username') }}" required>
      @if ($errors->has('username'))
        <span class="error">
            {{ $errors->first('username') }}
        </span>
      @endif

      <label for="birth_date">Birth Date</label>
      <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}" required>
      @if ($errors->has('birth_date'))
        <span class="error">
            {{ $errors->first('birth_date') }}
        </span>
      @endif

      <label for="email">E-Mail Address</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required>
      @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
      @endif

      <label for="password">Password</label>
      <input id="password" type="password" name="password" required>
      @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
      @endif

      <label for="password-confirm">Confirm Password</label>
      <input id="password-confirm" type="password" name="password_confirmation" required>
      <div class="buttons d-flex flex-row gap-2 mt-3">
        <button class="button" type="submit">
          Register
        </button>
      <a class="button button-outline" href="{{ route('login') }}">Login</a>
    </div>
</form>
</div>
@endsection