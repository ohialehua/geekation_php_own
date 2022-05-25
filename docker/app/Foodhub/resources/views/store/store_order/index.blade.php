@extends('layouts.app_store')

@section('content')
<div class="container">
  <div class="row  justify-content-center">
    <div class="col-lg-9">
      <div class="card mb-5">
        <div class="card-header">{{ __('注文履歴一覧') }}</div>
          <div class="card-body">
            <div class="row">
              <div class="col">
                <table class="table table-light">
                  <thead>
                    <td>注文日</td>
                    <td>配送先</td>
                    <td colspan="2">注文商品</td>
                    <td>請求金額</td>
                    <td>発送状況</td>
                    <td>注文詳細</td>
                  </thead>
                @foreach ($store_orders as $store_order)
                  <tr>
                    <td>{{date('Y年m月d日', strtotime($store_order->created_at))}}</td>
                    <td>
                      〒{{$store_order->order->post_address}}<br>
                        {{$store_order->order->address}}<br>
                        {{$store_order->order->name}}
                    </td>
                    <td>
                    <?php $store_total = 0; ?>
                    @foreach ($store_order->order_items as $order_item)
                      {{$order_item->item->name}}<br>
                      <?php $store_total += $order_item->price_after_tax * $order_item->quantity; ?>
                    @endforeach
                    </td>
                    <td>
                    @foreach ($store_order->order_items as $order_item)
                      ×{{$order_item->quantity}}<br>
                    @endforeach
                    </td>
                    <td>{{number_format($store_total)}}円</td>
                  @if ($store_order->order_status == 0)
                    <td class="text-danger">入金待ち</td>
                  @elseif ($store_order->order_status == 1)
                    <td class="text-warning">入金確認</td>
                  @elseif ($store_order->order_status == 2)
                    <td class="text-warning">製作中</td>
                  @elseif ($store_order->order_status == 3)
                    <td class="text-warning">発送準備中</td>
                  @else
                    <td class="text-success">
                      発送完了
                    </td>
                  @endif
                    <td><a href="{{$store_order->id}}" class="text-dark">表示</a></td>
                  </tr>
                @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
