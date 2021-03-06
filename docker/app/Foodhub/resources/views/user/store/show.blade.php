@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row mt-3">
    <div class="col-lg-5">
      <h2>{{$store->name}}詳細</h2>
      <div class="row mb-2">
        <div class="col-3">
        @if ($store->profile_image === null)
          <img src="/storage/no_image.png" width="100" height="100" >
        @else
          <img src="{{ asset('storage/store_profiles/'.$store->profile_image) }}" width="100" height="100">
        @endif
        </div>
        <div class="col-2 offset-7">
          @if ($store->isMarkedBy(Auth::user()))
            <form method="POST" action="{{ route('user.marker.destroy', $store->id ) }}">
            @csrf
              <span class="markers" title="お気に入りからはずす">
                <input id="store_id" name="store_id" type="hidden" value="{{$store->id}}">
                <button type="submit" class="bg-light" style="border: none;">
                  <h1 class="text-warning">
                    <i class="fa fa-star">{{$store->markers->count()}}</i>
                  </h1>
                </button>
              </span>
            </form>
          @else
            <form method="POST" action="{{ route('user.marker.create') }}">
            @csrf
              <span class="markers" title="お気に入りに追加する">
                <input id="store_id" name="store_id" type="hidden" value="{{$store->id}}">
                <button type="submit" class="bg-light" style="border: none;">
                  <h1 class="text-dark">
                    <i class="fa fa-star">{{$store->markers->count()}}</i>
                  </h1>
                </button>
              </span>
            </form>
          @endif
        </div>
      </div>

      <table class="table table-light border mb-5">
        <tr>
          <td>店舗名</td>
          <td>{{$store->name}}</td>
        </tr>
        <tr>
          <td>カナ</td>
          <td>{{$store->name_kana}}</td>
        </tr>
        <tr>
          <td>ステータス</td>
          @if($store->is_deleted === 0)
            <td class="text-danger">無効</td>
          @else
            <td class="text-success">有効</td>
          @endif
          </td>
        </tr>
        <tr>
          <td>紹介文</td>
          <td>{{$store->introduction}}</td>
        </tr>
        <tr>
          <td>郵便番号</td>
          <td>〒{{$store->post_address}}</td>
        </tr>
        <tr>
          <td>住所</td>
          <td>{{$store->address}}</td>
        </tr>
        <tr>
          <td>電話番号</td>
          <td>{{$store->phone_number}}</td>
        </tr>
        <tr>
          <td>メールアドレス</td>
          <td>{{$store->email}}</td>
        </tr>
      </table>

      <table class="table table-light border">
        <thead><h4 class="text-center">{{$store->name}}での購入履歴</h4></thead>
        <tbody>
          <tr>
            <td>注文日</td>
            <td>配送先</td>
            <td>注文商品</td>
            <td>支払金額</td>
            <td>詳細</td>
          </tr>
        @foreach ($store_orders as $store_order)
          <tr>
            <td>{{date('Y年m月d日', strtotime($store_order->order->created_at))}}</td>
            <td>
              〒{{$store_order->order->post_address}}<br>
                {{$store_order->order->address}}<br>
                {{$store_order->order->name}}
            </td>
            <td>
            <?php $store_total = 0; ?>
              @foreach ($store_order->order->order_items->where('store_order_id', $store_order->id) as $order_item)
                <a href="/user/item/{{$order_item->item->id}}" class="text-dark" title='"{{$order_item->item->name}}"のページを見る'>
                  {{$order_item->item->name}} ×{{$order_item->quantity}}
                </a><br>
                <?php $store_total += $order_item->price_after_tax * $order_item->quantity; ?>
              @endforeach
            </td>
            <td>{{number_format($store_total + $postage)}}円</td>
            <td><a href="/user/order/{{$store_order->order->id}}" class="text-dark" title="この注文を見る">表示</a></td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>

    <div class="col-lg-7">
      <h2>商品一覧</h2>
      <div class="card-deck row row-cols-2 row-cols-md-3 row-eq-height mb-5">
        @foreach ($items as $item)
        <a href="/user/item/{{$item->id}}" class="text-dark" title="この商品を見る">
          <div class="col">
            <div class="card mx-auto mt-4 shadow-lg text-center" style="border-radius: 10%;">
            @if ($item->image === null)
              <img src="/storage/no_image.png" width="100%" style="border-radius: 10% 10% 0% 0%;">
            @else
              <img src="{{ asset('storage/item_images/'.$item->image) }}" width="100%" style="height: 244px; border-radius: 10% 10% 0% 0%;">
            @endif
              <div class="card-body">
                <div class="row">
                  <div class="col-12 mx-auto">
                    <p class="card-text"><i class="fas fa-utensils"></i> {{$item->name}}</p>
                  </div>
                  <div class="col-8">
                    <p class="card-text"> 説明：{{ Str::limit($item->body, 8, '...') }}</p>
                  </div>
                  <div class="col-3">
                    <h5 class="text-success" title="累計購入数"><i class="fa fa-gifts">{{$item->sales_figures}}</i></h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </a>
        @endforeach
      </div>

      <h2>投稿一覧</h2>
      <div class="card-deck row row-cols-2 row-cols-md-3 row-eq-height">
        @foreach ($posts as $post)
        <a href="/user/store_post/{{$post->id}}" class="text-dark" title="この投稿を見る">
          <div class="col">
            <div class="card mx-auto mt-4 shadow-lg text-center" style="border-radius: 10%;">
            @if ($post->post_image === null)
              <img src="/storage/no_image.png" width="100%" style="border-radius: 10% 10% 0% 0%;">
            @else
              <img src="{{ asset('storage/store_post_images/'.$post->post_image) }}" width="100%" height="244px" style="border-radius: 10% 10% 0% 0%;">
            @endif
              <div class="card-body">
                <div class="row">
                  <div class="col-7">
                    <p class="card-text">{{ Str::limit($post->body, 12, '...') }}</p>
                  </div>
                  <div class="col-1">
                    <h5 class="text-danger" title="いいね数"><i class="fas fa-heart">{{$post->favorites->count()}}</i></h5>
                  </div>
                  <div class="col-1 offset-1">
                    <h5><i class="fa fa-comments" title="コメント数">{{$post->post_comments->count()}}</i></h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
