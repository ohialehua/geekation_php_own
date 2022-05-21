@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card mb-5">
        <div class="card-header">{{ __('配送先編集') }}</div>

          <div class="card-body">
            <form method="POST" action="{{ route('user.delivery.update', $delivery->id) }}">
              @csrf

              <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('宛名') }}</label>

                <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$delivery->name}}" required autocomplete="name" autofocus>

                  @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="post_address" class="col-md-4 col-form-label text-md-end">{{ __('郵便番号') }}</label>

                <div class="col-md-6">
                  <input id="post_address" type="number" class="form-control @error('post_address') is-invalid @enderror" name="post_address" value="{{$delivery->post_address}}" required autocomplete="post_address" autofocus>

                @error('post_address')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('住所') }}</label>

                <div class="col-md-6">
                <textarea id="address" type="text" class="form-control" name="address" required autocomplete="address" autofocus rows="2">{{$delivery->address}}</textarea>

                @error('address')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
                </div>
              </div>

              <div class="row mb-0">
                <div class="col-md-6 offset-md-4 text-center">
                  <button type="submit" class="btn btn-secondary">
                    {{ __('編集') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection
