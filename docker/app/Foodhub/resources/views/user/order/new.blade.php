@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="row justify-content-center mb-4">
        <div class="col text-center bg-info" style="border-radius: 50%;"><h3 class="mt-3"><a href="/user/item/index" class="text-dark" title="商品一覧画面に戻る">注文</a></h3></div>
        <div class="col text-center"><h1 class="mt-3">→</h1></div>
        <div class="col text-center bg-warning" style="border-radius: 50%;"><h3 class="mt-3">入力</h3></div>
        <div class="col text-center"><h1 class="mt-3">→</h1></div>
        <div class="col text-center bg-info" style="border-radius: 50%;"><h3 class="mt-3">確認</h3></div>
        <div class="col text-center"><h1 class="mt-3">→</h1></div>
        <div class="col text-center bg-info" style="border-radius: 50%;"><h3 class="mt-3">完了</h3></div>
      </div>
      <div class="card mb-5">
        <div class="card-header">{{ __('注文情報入力') }}</div>

          <div class="card-body">
            <form method="GET" action="{{ route('user.order.confirm') }}">
              @csrf

              <div class="row mb-3">
              <label for="pay_method" class="col-md-4 col-form-label text-md-end"><strong>{{ __('お支払方法') }}</strong></label>
                <div class="col-md-6 text-center">
                  <div class="form-check form-check-inline">
                    <input id="pay_method" type="radio" value="0" checked name="pay_method" required autocomplete="pay_method">
                    <label for="pay_method" class="form-check-label">クレジットカード</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input id="pay_method" type="radio" value="1" class="" name="pay_method" required autocomplete="pay_method">
                    <label for="pay_method" class="form-check-label">銀行振り込み</label>
                  </div>
                </div>
              </div>

              <label for="pay_method" class="col-md-4 col-form-label text-md-end"><strong>{{ __('お届け先') }}</strong></label>
              <div class="row mb-3">
                <div class="form-check form-check-inline">
                  <input id="delivery_method" type="radio" value="0" checked name="delivery_method" required autocomplete="delivery_method">
                  <label for="delivery" class="col-md-4 col-form-label text-md-end">{{ __('登録済み住所から選択') }}</label>
                </div>

                <div class="col-md-6">
                  <select class="form-select" id="delivery_id" type="text" name="delivery_id">
                    @foreach ($deliveries as $delivery)
                      <option value="{{$delivery->id}}">
                      {{$delivery->name}}様　　〒{{$delivery->post_address}}　　{{$delivery->address}}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="row mb-3">
                <div class="form-check form-check-inline">
                  <input id="delivery_method" type="radio" value="0" name="delivery_method" required autocomplete="delivery_method">
                  <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('新しいお届け先') }}</label>
                </div>

              <form method="POST" action="{{ route('user.delivery.create') }}">
                @csrf

                <div class="row mb-3">
                  <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('宛名') }}</label>

                  <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" autofocus>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="post_address" class="col-md-4 col-form-label text-md-end">{{ __('郵便番号') }}</label>

                  <div class="col-md-6">
                    <input id="post_address" type="number" class="form-control" name="post_address" autofocus>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('住所') }}</label>

                  <div class="col-md-6">
                    <textarea id="address" type="text" class="form-control" name="address" autofocus rows="2"></textarea>
                  </div>
                </div>
            </div>

              <div class="row mb-0">
                <div class="col-md-6 offset-md-4 text-center">
                  <button type="submit" class="btn btn-success">
                    {{ __('確認画面へ進む') }}
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
