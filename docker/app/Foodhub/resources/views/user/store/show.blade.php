@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row mt-3">
    <div class="col-lg-5">
      <h2>{{$store->name}}詳細</h2>
      <div class="col-3 d-inline-block">
      @if ($store->profile_image === null)
        <img src="/storage/no_image.png" width="100" height="100" >
      @else
        <img src="{{ asset('storage/store_profiles/'.$store->profile_image) }}" width="100" height="100">
      @endif
      </div>
      <div class="col text-right"><a>フォロワー数：○○</a></div>
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
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="col-lg-7">
      <h2>商品一覧</h2>
      <div class="card-deck row row-cols-2 row-cols-md-3 row-eq-height mb-5">
        @foreach ($items as $item)
        <a href="{{$store->id}}" class="text-dark">
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
                    <p class="card-text"><i class="fas fa-utensils"></i>{{$item->name}}</p>
                    <label>説明文</label>
                    <p class="card-text">{{$item->body}}</p>
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
          <div class="col">
            <div class="card mx-auto mt-4 shadow-lg">
              画像
              <div class="card-body">
                <div class="row">
                  <div class="col-12 mx-auto">
                    <p class="card-text">説明：</p>
                    <div class="d-inline-flex">
                      <span><i class="fas fa-utensils"></i> {{$store->name}} ｜ </span>
                      <p><i class="fas fa-comment"> コメント数</i></p>
                      <p class="text-danger ml-3"><i class="fas fa-heart"> いいね数</i></p>
                      <p class="ml-2"><i class="fas fa-eye"> 閲覧数</i></p>
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
