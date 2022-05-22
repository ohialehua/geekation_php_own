@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="row justify-content-center mb-4">
        <div class="col text-center bg-info" style="border-radius: 50%;"><h3 class="mt-3"><a href="/user/item/index" class="text-dark" title="商品一覧画面に戻る">注文</a></h3></div>
        <div class="col text-center"><h1 class="mt-3">→</h1></div>
        <div class="col text-center bg-info" style="border-radius: 50%;"><h3 class="mt-3"><a href="/user/order/new" class="text-dark" title="注文情報入力画面に戻る">入力</a></h3></div>
        <div class="col text-center"><h1 class="mt-3">→</h1></div>
        <div class="col text-center bg-warning" style="border-radius: 50%;"><h3 class="mt-3">確認</h3></div>
        <div class="col text-center"><h1 class="mt-3">→</h1></div>
        <div class="col text-center bg-info" style="border-radius: 50%;"><h3 class="mt-3">完了</h3></div>
      </div>
      <div class="card mb-5">
        <div class="card-header">{{ __('注文情報確認') }}</div>
          <div class="card-body">
            <div class="row">
              <div class="col">
                <table class="table table-light border">
                  <thead>
                    <tr>
                      <td>店舗名</td>
                      <td>商品名</td>
                      <td>単価(税込)</td>
                      <td>数量</td>
                      <td>小計</td>
                    </tr>
                  </thead>
                  <tbody></tbody>
                  <tbody>
                    <tr>
                      <td colspan="2">商品合計：</td>
                      <td>送料：</td>
                      <td colspan="2">請求金額：</td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-light border">
                <tbody>
                    <tr>
                      <td>お支払方法</td>
                      <td colspan="4"></td>
                    </tr>
                    <tr>
                      <td>お届け先</td>
                      <td>宛名</td>
                      <td colspan="3">〒郵便番号<br>住所</td>
                    </tr>
                  </tbody>
                </table>

                <form method="POST" action="{{ route('user.order.create') }}">
                  <div class="row mb-0">
                    <div class="col-md-6 offset-md-4 text-center">
                      <button type="submit" class="btn btn-success">
                        {{ __('注文確定') }}
                      </button>
                    </div>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection
