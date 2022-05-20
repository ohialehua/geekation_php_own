@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{$user->name}}{{ __('さん、ようこそFoodhubへ!') }}
                </div>
            </div>
        </div>
    </div>
  <div class="row mt-3">
    <div class="col-lg-5">
      <h2>{{$user->name}}詳細</h2>
      <div class="col-3 d-inline-block">
      @if ($user->profile_image_id === null)
        <img src="/storage/no_image.png" width="100" height="100" >
      @else
        <img src="{{ asset('storage/user_profiles/'.$user->profile_image_id) }}" width="100" height="100">
      @endif
      </div>
      <div class="col-4 d-inline-block">
        <ul>
          <a href="user/edit" class="btn btn-sm btn-secondary mb-2">編集</a>
        </ul>
      </div>
      <div class="col text-right"><a>フォロー数：○○　|　フォロワー数：○○</a></div>
      <table class="table table-light border">
        <tr>
          <td>ユーザーネーム</td>
          <td>{{$user->name}}</td>
        </tr>
        <tr>
          <td>紹介文</td>
          <td>{{$user->introduction}}</td>
        </tr>
      </table>
      <table class="table table-light border">
          <tr>
              <td>氏名</td>
              <td>{{$user->full_name}}</td>
          </tr>
          <tr>
              <td>カナ</td>
              <td>{{$user->full_name_kana}}</td>
          </tr>
          <tr>
              <td>電話番号</td>
              <td>{{$user->phone_number}}</td>
          </tr>
          <tr>
              <td>メールアドレス</td>
              <td>{{$user->email}}</td>
          </tr>
      </table>
      <div class="row mb-5">
        <div class="text-center">
          <div class="col-3 d-inline-block">
            <a href="/home" class="btn btn-primary">
                {{ __('配送先一覧') }}
            </a>
          </div>
          <div class="col-3 d-inline-block">
            <a href="/home" class="btn btn-primary">
                {{ __('注文履歴一覧') }}
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-7">
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
                      <span><i class="fas fa-utensils"></i> {{$user->name}} ｜ </span>
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