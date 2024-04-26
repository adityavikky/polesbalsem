@extends('layouts.app_blank')

@section('content')
    <div class="row justify-content-center" style="margin-top: calc(50vh - 180px);">
        <div class="div col-8">
            <form method="POST" action="{{ route('login') }}">
                <center>
                    <h2 style="color: white; font-weight: bold;">POLES BALSEM</h2>
                    <span style="color: yellow;">Pendaftaran Online Sebelum ke Balkesmas Semarang</span>
                </center>
                @csrf
                <div class="row">
                    <label for="email" class="col-12 col-form-label" style="color: white; font-weight: bold;">{{ __('Email') }}</label>
                    <div class="col-12">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-12 col-form-label" style="color: white; font-weight: bold;">{{ __('Password') }}</label>
                    <div class="col-12">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            {{ __('Login') }}
                        </button>
                    </div>
                    <div class="col-md-12" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
