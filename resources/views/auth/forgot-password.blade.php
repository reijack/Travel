@extends('layouts.guest')
@section('title', 'Lupa Password')

@section('content')
<div class="auth-wrap">
  <div class="logo">
    <div class="logo-icon"><i class="ti ti-compass"></i></div>
    <span class="logo-name">Travel Planner</span>
  </div>
  <div class="card">
    <h1>Lupa Password?</h1>
    <p class="sub">Masukkan email kamu, kami akan kirimkan link untuk reset password</p>

    @if(session('success'))
      <div class="alert-success">{{ session('success') }}</div>
    @endif

    @error('email')
      <div class="alert-error">{{ $message }}</div>
    @enderror

    <form action="{{ route('password.email') }}" method="POST">
      @csrf
      <label>Email</label>
      <input type="email" name="email" class="form-input" placeholder="emailkamu@gmail.com" required/>
      <button type="submit" class="btn">Kirim Link Reset</button>
    </form>

    <p class="footer">
      <a href="{{ route('login') }}">&larr; Kembali ke halaman Masuk</a>
    </p>
  </div>
</div>
@endsection