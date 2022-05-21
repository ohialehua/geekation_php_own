@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card mb-5">
        <div class="card-header">{{ __('配送先登録') }}</div>

          <div class="card-body">
            <form method="POST" action="{{ route('user.delivery.create') }}">
              @csrf

              <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('宛名') }}</label>

                <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus>

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
                  <input id="post_address" type="number" class="form-control @error('post_address') is-invalid @enderror" name="post_address" required autocomplete="post_address" autofocus>

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
                <textarea id="address" type="text" class="form-control" name="address" required autocomplete="address" autofocus rows="2"></textarea>

                @error('address')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
                </div>
              </div>

              <div class="row mb-0">
                <div class="col-md-6 offset-md-4 text-center">
                  <button type="submit" class="btn btn-success">
                    {{ __('登録') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>

      <table class="table table-light">
        <thead><h4 class="text-center">配送先一覧</h4></thead>
        <tbody>
          <tr>
            <th>宛名</th>
            <th>郵便番号</th>
            <th>住所</th>
            <th colspan="2"></th>
          </tr>
        @foreach ($deliveries as $delivery)
          <tr>
            <td>{{$delivery->name}}</td>
            <td>{{$delivery->post_address}}</td>
            <td>{{$delivery->address}}</td>
            <td><a href="/user/delivery/edit/{{$delivery->id}}" class="btn btn-sm btn-secondary">編集</a></td>
            <td>
              <form method="POST" action="{{ route('user.delivery.destroy', $delivery->id)}}">
              @csrf
                <button type="submit" class="btn btn-sm btn-danger">
                  {{ __('削除') }}
                </button>
              </form>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
