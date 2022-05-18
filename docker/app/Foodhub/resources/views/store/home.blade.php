@extends('layouts.app_store')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <!-- <div class="card-header">{{ __('Dashboard') }}</div> -->

          <div class="card-body">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif

          {{$store->name}}{{ __('さん、ようこそFoodhubへ!') }}
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-lg-5">
      <h2>{{$store->name}}詳細</h2>
      <div class="col-3 d-inline-block">
        <img src="/storage/no_image.png" width="100" height="100" >
      </div>
      <div class="col-4 d-inline-block">
        <ul>
          <a href="store/edit" class="btn btn-sm btn-secondary mb-2">編集</a>
          <a href="store/unsubscribe" class="btn btn-sm btn-danger mb-2">退会</a>
          <a href="store/orders" class="btn btn-sm btn-primary">注文履歴一覧</a>
        </ul>
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
    </div>

    <div class="col-lg-7">
      <div class="col-8 d-inline-block">
        <h2>商品一覧</h2>
      </div>
      <div class="col-3 d-inline-block">
        <a href="store/items/new" class="btn btn-sm btn-primary">商品を新規登録</a>
      </div>
      <table class="table table-light border text-center">
        <thead>
          <td>商品名</td>
          <td>税抜き価格</td>
          <td>ステータス</td>
        </thead>
      </table>
    </div>

    <div class="col-12">
      <div class="col-8 d-inline-block">
        <h2>投稿一覧</h2>
      </div>
      <div class="col-3 d-inline-block">
      <a href="store/posts/new" class="btn btn-sm btn-primary">新規投稿</a>
      </div>
      <div class="card-deck py-5 row row-cols-2 row-cols-md-3 row-cols-lg-4 row-eq-height">
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
