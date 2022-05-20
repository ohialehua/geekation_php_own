@extends('layouts.app')

@section('content')
<div class="container">
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
    </div>

    <div class="col-lg-7">
      <div class="col-8 d-inline-block">
        <h2>投稿一覧</h2>
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