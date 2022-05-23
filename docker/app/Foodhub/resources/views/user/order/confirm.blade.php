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
                    <?php $total_price = 0 ?>
                    @foreach ($cart_items as $cart_item)
                      <tr>
                        <td>{{$cart_item->item->store->name}}</td>
                        <td>{{$cart_item->item->name}}</td>
                        <td>{{number_format($cart_item->item->price_before_tax * $tax)}}円</td>
                        <td>{{$cart_item->quantity}}</td>
                        <td>{{number_format($cart_item->item->price_before_tax * $tax * $cart_item->quantity)}}円</td>
                        <?php $total_price += $cart_item->item->price_before_tax * $tax * $cart_item->quantity ?>
                      </tr>
                    @endforeach
                  </tbody>
                  <tbody>
                    <tr>
                      <td colspan="2">商品合計：{{number_format($total_price)}}円</td>
                      <td>送料：{{$postage}}円</td>
                      <td colspan="2">請求金額：<p class="d-inline-block" style="background: linear-gradient(transparent 70%, #ffff66 0%);">{{number_format($total_price + $postage)}}円</p></td>
                    </tr>
                  </tbody>
                </table>

                <table class="table table-light border">
                  <tbody>
                    <tr>
                      <td>お支払方法</td>
                      <td colspan="4">
                      @if ($pay_method == 0)
                        クレジットカード
                      @elseif ($pay_method == 1)
                        銀行振り込み
                      @endif
                      </td>
                    </tr>
                    <tr>
                      <td>お届け先</td>
                      <td>宛名　{{$delivery->name}}</td>
                      <td colspan="3">〒郵便番号 {{$delivery->post_address}}<br>住所 {{$delivery->address}}</td>
                    </tr>
                  </tbody>
                </table>

                <div class="row mb-0">
                  <div class="col-md-6 offset-md-4 text-center">
                    <form method="POST" action="{{ route('user.order.create') }}">
                      @csrf
                      <input id="postage" name="postage" type="hidden" value="{{$postage}}">
                      <input id="total_price" name="total_price" type="hidden" value="{{$total_price + $postage}}">
                      <input id="pay_method" name="pay_method" type="hidden" value="{{$pay_method}}">
                      <input id="post_address" name="post_address" type="hidden" value="{{$delivery->post_address}}">
                      <input id="address" name="address" type="hidden" value="{{$delivery->address}}">
                      <input id="name" name="name" type="hidden" value="{{$delivery->name}}">
                      <button type="submit" class="btn btn-success">
                        {{ __('注文確定') }}
                      </button>
                    </form>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection
