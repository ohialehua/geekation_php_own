@extends('layouts.app_store')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card mb-5">
        <div class="card-header">{{ __('注文情報詳細') }}</div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <table class="table table-light border text-center">
                  <tbody>
                    <tr>
                      <td>注文日</td>
                      <td colspan="2">{{date('Y年m月d日', strtotime($store_order->created_at))}}</td>
                    </tr>
                    <tr>
                      <td>注文者氏名</td>
                      <td colspan="2">
                        {{$order->user->full_name_kana}}<br>
                        {{$order->user->full_name}}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        配送先<br>
                        住所<br>
                        宛名<br>
                      </td>
                      <td colspan="2">
                        〒{{$order->post_address}}<br>
                          {{$order->address}}<br>
                          {{$order->name}}様<br>
                      </td>
                    </tr>
                    <tr>
                      <td>支払方法</td>
                      <td colspan="2">
                        @if ($order->pay_method == 0)
                          クレジットカード
                        @else
                          銀行振り込み
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>発送状況</td>
                      <form method="POST" action="{{ route('store.store_order.update', $store_order->id) }}">
                      @csrf
                      <td>
                        <input id="store_order_id" name="store_order_id" type="hidden" value="{{$store_order->id}}">
                        <select id="order_status" class="form-control" type="number" name="order_status">
                          <option value="0" @if( $store_order->order_status === 0 ) selected @endif>入金待ち</option>
                          <option value="1" @if( $store_order->order_status === 1 ) selected @endif>入金確認</option>
                          <option value="2" @if( $store_order->order_status === 2 ) selected @endif>製作中</option>
                          <option value="3" @if( $store_order->order_status === 3 ) selected @endif>発送準備中</option>
                          <option value="4" @if( $store_order->order_status === 4 ) selected @endif>発送完了</option>
                        </select>
                      </td>
                      <td>
                        <button type="submit" class="btn btn-sm btn-secondary d-inline-block">
                          {{ __('変更') }}
                        </button>
                      </td>
                      </form>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="col-md-6">
                <table class="table table-light text-center">
                  <thead>
                    <td>商品名</td>
                    <td>単価(税込)</td>
                    <td>数量</td>
                    <td>小計</td>
                    <td colspan="2">製作状況</td>
                  </thead>
                  <tbody>
                  <?php $store_total = 0; ?>
                  @foreach ($order_items as $order_item)
                    <?php $subtotal = 0; ?>
                    <tr>
                      <td>
                        <a href="/store/item/{{$order_item->item->id}}" class="text-dark" title='"{{$order_item->item->name}}"の商品ページを見る'>
                        @if ($order_item->item->image === null)
                          <img src="/storage/no_image.png" width="50" height="50" >
                        @else
                          <img src="{{ asset('storage/item_images/'.$order_item->item->image) }}" width="50" height="50">
                        @endif
                          <br>
                          <label>{{$order_item->item->name}}</label>
                        </a>
                      </td>
                      <td>
                        {{number_format($order_item->price_after_tax)}}
                      </td>
                      <td>
                        {{$order_item->quantity}}
                      </td>
                      <td>
                        <?php $subtotal += $order_item->price_after_tax * $order_item->quantity; ?>
                        {{number_format($subtotal)}}円
                        <?php $store_total += $subtotal; ?>
                      </td>
                      <form method="POST" action="{{ route('store.order_item.update', $order_item->id) }}">
                      @csrf
                      <td>
                        <input id="order_item_id" name="order_item_id" type="hidden" value="{{$order_item->id}}">
                        <select id="product_status" class="form-control" type="number" name="product_status">
                          <option value="0" @if( $order_item->product_status === 0 ) selected @endif>入金前</option>
                          <option value="1" @if( $order_item->product_status === 1 ) selected @endif>製作待ち</option>
                          <option value="2" @if( $order_item->product_status === 2 ) selected @endif>製作中</option>
                          <option value="3" @if( $order_item->product_status === 3 ) selected @endif>製作完了</option>
                        </select>
                      </td>
                      <td>
                        <button type="submit" class="btn btn-sm btn-secondary d-inline-block">
                          {{ __('更新') }}
                        </button>
                      </td>
                      </form>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>

              <div class="col">
                <div class="card">
                  <div class="card-header">{{ __('請求情報') }}</div>
                    <div class="card-body">
                      <table class="table table-light border text-center">
                        <tbody>
                          <tr>
                            <td>商品合計</td>
                            <td>{{number_format($store_total)}}円</td>
                          </tr>
                          <tr>
                            <td>送料</td>
                            <td>{{$postage}}円</td>
                          </tr>
                          <tr>
                            <td>請求金額</td>
                            <td><p style="background: linear-gradient(transparent 70%, #ffff66 0%);">{{number_format($store_total + $postage)}}円</p></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
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
