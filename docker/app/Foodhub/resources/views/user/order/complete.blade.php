@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="row justify-content-center mb-4">
        <div class="col text-center bg-info" style="border-radius: 50%;"><h3 class="mt-3">注文</h3></div>
        <div class="col text-center"><h1 class="mt-3">→</h1></div>
        <div class="col text-center bg-info" style="border-radius: 50%;"><h3 class="mt-3">入力</h3></div>
        <div class="col text-center"><h1 class="mt-3">→</h1></div>
        <div class="col text-center bg-info" style="border-radius: 50%;"><h3 class="mt-3">確認</h3></div>
        <div class="col text-center"><h1 class="mt-3">→</h1></div>
        <div class="col text-center bg-warning" style="border-radius: 50%;"><h3 class="mt-3">完了</h3></div>
      </div>
      <div class="my-3 text-center">
        <h2>
          ご注文ありがとうございました！<br>
          またのご利用お待ちしております。
        </h2>
      </div>
      <div class="card mb-5">
        <div class="card-header">{{ __('注文した情報の確認') }}</div>
          <div class="card-body">
            <div class="row">
              <div class="col">
                <table class="table table-light border text-center">
                  <thead>
                    <tr>
                      <td>店舗名</td>
                      <td>商品名</td>
                      <td>単価(税込)</td>
                      <td>数量</td>
                      <td>小計</td>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($order_items as $order_item)
                      <tr>
                        <td>{{$order_item->item->store->name}}</td>
                        <td>{{$order_item->item->name}}</td>
                        <td>{{number_format($order_item->price_after_tax)}}円</td>
                        <td>{{$order_item->quantity}}</td>
                        <td>{{number_format($order_item->price_after_tax * $order_item->quantity)}}円</td>
                      </tr>
                    @endforeach
                  </tbody>
                  <tbody>
                    <tr>
                      <td colspan="2">商品合計：{{number_format($order->total_price)}}円</td>
                      <td>送料：{{$order->postage}}円</td>
                      <td colspan="2">請求金額：<p class="d-inline-block" style="background: linear-gradient(transparent 70%, #ffff66 0%);">{{number_format($order->total_price + $order->postage)}}円</p></td>
                    </tr>
                  </tbody>
                </table>

                <table class="table table-light border">
                  <tbody>
                    <tr>
                      <td>お支払方法</td>
                      <td colspan="4">
                      @if ($order->pay_method == 0)
                        クレジットカード
                      @elseif ($order->pay_method == 1)
                        銀行振り込み
                      @endif
                      </td>
                    </tr>
                    <tr>
                      <td>お届け先</td>
                      <td>宛名　{{$order->name}}</td>
                      <td colspan="3">〒郵便番号 {{$order->post_address}}<br>住所 {{$order->address}}</td>
                    </tr>
                  </tbody>
                </table>
                <div class="text-center">
                  <a href="/home" class="btn btn-sm btn-primary">マイページに戻る</a>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection
