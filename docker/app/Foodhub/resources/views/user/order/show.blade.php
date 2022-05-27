<!-- ★ -->
<?php
  use App\Models\OrderItem;
  use App\Models\StoreOrder;
 ?>
@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card mb-5">
        <div class="card-header">{{ __('注文情報詳細') }}</div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-8">
                <table class="table table-light border text-center">
                  <tbody>
                    <tr>
                      <td>注文日</td>
                      <td>{{date('Y年m月d日', strtotime($order->created_at))}}</td>
                    </tr>
                    <tr>
                      <td>
                        配送先<br>
                        住所<br>
                        宛名<br>
                      </td>
                      <td>
                        〒{{$order->post_address}}<br>
                          {{$order->address}}<br>
                          {{$order->name}}<br>
                      </td>
                    </tr>
                    <tr>
                      <td>支払方法</td>
                      <td>
                        @if ($order->pay_method == 0)
                          クレジットカード
                        @else
                          銀行振り込み
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>発送状況</td>
                    <!-- ★ここで使用 -->
                    @if (StoreOrder::whereOrderId($order->id) ->whereIn('order_status', [0, 1, 2, 3]) ->count() > 0)
                      <td class="text-danger">
                        まだ発送されていない商品があります
                      </td>
                    @else
                      <td class="text-success">
                        全ての商品が発送されました
                      </td>
                    @endif
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="col-md-4">
                <div class="card">
                  <div class="card-header">{{ __('注文した情報の確認') }}</div>
                    <div class="card-body">
                      <table class="table table-light border text-center">
                        <tbody>
                          <tr>
                            <td>商品合計</td>
                            <td>{{number_format($order->total_price - $order->postage)}}円</td>
                          </tr>
                          <tr>
                            <td>送料</td>
                            <td>{{$order->postage}}円</td>
                          </tr>
                          <tr>
                            <td>支払金額</td>
                            <td><p style="background: linear-gradient(transparent 70%, #ffff66 0%);">{{number_format($order->total_price)}}円</p></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col">
              @foreach ($store_orders as $store_order)
              <div class="row">
                <div class="mt-4 col-5">
                  <a href="/user/store/{{$store_order->store->id}}" class="text-dark" title='"{{$store_order->store->name}}"のページを見る'>
                  @if ($store_order->store->profile_image === null)
                    <img src="/storage/no_image.png" width="100" height="100" >
                  @else
                    <img src="{{ asset('storage/store_profiles/'.$store_order->store->profile_image) }}" width="100" height="100">
                  @endif
                  <br>
                    <strong><label class="my-1">"{{$store_order->store->name}}"での注文内容</label></strong>
                  </a>
                </div>
                <div class="col-7" style="padding-top: 130px;">
                  <strong>
                  @if ($store_order->order_status == 4)
                    <label class="text-success">注文状況：発送完了</label>
                  @else
                    <label class="text-danger">注文状況：まだ発送されていない商品があります</label>
                  @endif
                  </strong>
                </div>
              </div>
                <table class="table table-light text-center">
                  <thead>
                    <td>商品名</td>
                    <td>単価(税込)</td>
                    <td>数量</td>
                    <td>製作状況</td>
                    <td>小計</td>
                  </thead>
                  <tbody>
                  <?php $store_total = 0; ?>
                  @foreach ($store_order->order_items as $order_item)
                    <?php $subtotal = 0; ?>
                    <tr>
                      <td>
                        <a href="/user/item/{{$order_item->item->id}}" class="text-dark" title='"{{$order_item->item->name}}"の商品ページを見る'>
                        @if ($order_item->item->image === null)
                          <img src="/storage/no_image.png" width="50" height="50" >
                        @else
                          <img src="{{ asset('storage/item_images/'.$order_item->item->image) }}" width="50" height="50">
                        @endif
                          <br>
                          <label>{{$order_item->item->name}}</label>
                        </a>
                      </td>
                      <td>{{number_format($order_item->price_after_tax)}}</td>
                      <td>{{$order_item->quantity}}</td>
                      <?php $subtotal += $order_item->price_after_tax * $order_item->quantity; ?>
                      <td>
                      @if ($order_item->product_status == 0)
                        製作待ち
                      @elseif ($order_item->product_status == 1)
                        入金確認
                      @elseif ($order_item->product_status == 2)
                        製作中
                      @elseif ($order_item->product_status == 3)
                        製作完了
                      @endif
                      </td>
                      <td>{{number_format($subtotal)}}円</td>
                      <?php $store_total += $subtotal; ?>
                    </tr>
                  @endforeach
                  </tbody>
                  <tbody>
                    <tr>
                      <td colspan="3"><strong>"{{$store_order->store->name}}"での合計金額：</strong></td>
                      <td><p style="background: linear-gradient(transparent 70%, #ffff66 0%);">{{number_format($store_total)}}円</p></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              @endforeach
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection
