@extends('layouts.app_admin')

@section('content')
<div class="container">
  <div class="row mt-3">
    <div class="col-lg-5">
      <h2>{{$store->name}}詳細</h2>
      <div class="row mb-3">
        <div class="col-3 d-inline-block">
        @if ($store->profile_image === null)
          <img src="/storage/no_image.png" width="100" height="100" >
        @else
          <img src="{{ asset('storage/store_profiles/'.$store->profile_image) }}" width="100" height="100">
        @endif
        </div>
        <div class="col-2 offset-7">
          <h1 class="text-warning" title="フォロワー数">
            <i class="fa fa-star">{{$store->markers->count()}}</i>
          </h1>
        </div>
      </div>
      <table class="table table-light border">
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
          <form method="POST" action="{{ route('admin.store.update', $store->id) }}">
            @csrf
          @if($store->is_deleted === 0)
            <td class="text-danger">
              無効　　　　　　　　　　　　　　　　　　
              <input id="store_id" name="store_id" type="hidden" value="{{$store->id}}">
              <input id="is_deleted" name="is_deleted" type="hidden" value="1">
              <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('ステータスの変更は加盟店にメールでお知らせします。本当に変更しますか？')">
                {{ __('有効にする') }}
              </button>
            </td>
          @else
            <td class="text-success">
              有効　　　　　　　　　　　　　　　　　　
              <input id="store_id" name="store_id" type="hidden" value="{{$store->id}}">
              <input id="is_deleted" name="is_deleted" type="hidden" value="0">
              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('ステータスの変更は加盟店にメールでお知らせします。本当に変更しますか？')">
                {{ __('無効にする') }}
              </button>
            </td>
          @endif
          </form>
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
    </div>

    <div class="col-lg-7">
      <h2>商品一覧</h2>
      <div class="card-deck row row-cols-2 row-cols-md-3 row-eq-height mb-5">
        @foreach ($items as $item)
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
        @endforeach
      </div>

      <h2>投稿一覧</h2>
      <div class="card-deck row row-cols-2 row-cols-md-3 row-cols-lg-3 row-eq-height">
        @foreach ($posts as $post)
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
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
