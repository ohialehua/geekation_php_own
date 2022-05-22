@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row mt-3">
    <div class="col-md-5 mb-4">
      <div class="card" style="border-radius: 10%;">
        @if ($item->image === null)
          <img src="/storage/no_image.png" width="100%" style="border-radius: 10% 10% 0% 0%;">
        @else
          <img src="{{ asset('storage/item_images/'.$item->image) }}" width="100%" style="border-radius: 10%;">
        @endif
      </div>
    </div>

    <div class="col-md-7">
      <div class="card">
        <div class="card-header text-center">
          {{ __('商品情報') }}
        </div>
        <div class="card-body">
          <table class="table">
            <tr>
              <td>店舗名：<span title="{{$item->store->name}}の詳細ページへ移動する"><a href="/user/store/{{$item->store->id}}" class="text-dark">{{$item->store->name}}</a></span></td>
              <td>商品名：{{$item->name}}</td>
              <td>税抜き価格：<p class="d-inline-block" style="background: linear-gradient(transparent 70%, #ffff66 0%);">{{number_format($item->price_before_tax)}}円</p></td>
            </tr>
          </table>
          <p class="text-center">紹介文</p>
          <div class="card-body border" style="border-radius: 10px;">
            {{$item->body}}
          </div>

          <div class="col-2 d-inline-block">
            <a href="index" class="btn btn-sm btn-info text-light">商品一覧</a>
          </div>
          <div class="col-4 offset-5 d-inline-block mt-3">
            <form method="POST" action="{{ route('user.cart_item.create') }}">
            @csrf
              <input id="item_id" name="item_id" type="hidden" value="{{$item->id}}">
              <select id="quantity" type="number" name="quantity">
                @for ($i=1; $i <= 20; $i++)
                  <option value="{{$i}}">{{$i}}</option>
                @endfor
              </select>
              <button type="submit" class="btn btn-sm btn-primary">
                {{ __('カートに追加') }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center mt-4">
      <div class="col-md-11 col-lg-8">
        <table class="table table-light">
          <thead><h5 class="text-center">カート内商品</h5></thead>
          <tbody class="text-center">
            <tr>
              <td>商品名</td>
              <td>単価(税込)</td>
              <td>数量</td>
              <td>小計</td>
              <td>
              @unless ( $user->cart_items ->isEmpty() )
                <form method="POST" action="{{ route('user.cart_item.destroy_all') }}">
                @csrf
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('カートの中身をすべて削除しますか？')">
                    {{ __('全削除') }}
                  </button>
                </form>
              @endif
              </td>
            </tr>
          <?php $total_price = 0 ?>
          @foreach ($user->cart_items as $cart_item)
            <tr>
              <td>{{$cart_item->item->name}}</td>
              <td>{{number_format($cart_item->item->price_before_tax * $tax)}}</td>
              <td>
                <form method="POST" action="{{ route('user.cart_item.update', $cart_item->id) }}">
                @csrf
                  <input id="item_id" name="item_id" type="hidden" value="{{$cart_item->item->id}}">
                  <select id="quantity" type="number" name="quantity">
                    @for ($i=1; $i <= 20; $i++)
                      <option value="{{$i}}" @if( $cart_item->quantity === $i ) selected @endif> {{$i}} </option>
                    @endfor
                  </select>
                  <button type="submit" class="btn btn-sm btn-secondary">
                    {{ __('変更') }}
                  </button>
                </form>
              </td>
              <td>{{number_format($cart_item->item->price_before_tax * $tax * $cart_item->quantity) }}円</td>
              <?php $total_price += $cart_item->item->price_before_tax * $tax * $cart_item->quantity ?>
              <td>
                <form method="POST" action="{{ route('user.cart_item.destroy', $cart_item->id) }}">
                @csrf
                  <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('本当に削除しますか？')">
                    {{ __('削除') }}
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
          </tbody>
          <tbody>
            <tr>
              <td colspan="5" style="text-align: right;"><h5>合計金額：{{number_format($total_price)}}円</h5></td>
            </tr>
          </tbody>
        </table>
        <div class="col text-center"><a href="/user/order/new" class="btn btn-lg btn-dark">注文へ進む</a></div>
      </div>
    </div>
  </div>
</div>
@endsection