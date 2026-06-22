@extends('layouts.guest')
@section('title', 'Reset Password')

@section('content')
<div class="auth-wrap">
  <div class="logo">
    <div class="logo-icon"><i class="ti ti-compass"></i></div>
    <span class="logo-name">Travel Planner</span>
  </div>
  <div class="card">
    <h1>Buat Password Baru</h1>
    <p class="sub">Masukkan password baru untuk akun kamu</p>

    @if($errors->any())
      <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      <label>Email</label>
      <input type="email" name="email" class="form-input" value="{{ old('email', $email) }}" required readonly/>

      <label>Password Baru</label>
      <input type="password" name="password" class="form-input" placeholder="Minimal 8 karakter" required/>

      <label>Konfirmasi Password Baru</label>
      <input type="password" name="password_confirmation" class="form-input" required/>

      <button type="submit" class="btn">Reset Password</button>
    </form>
  </div>
</div>
@endsection