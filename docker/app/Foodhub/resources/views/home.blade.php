@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('管理人より') }}</div>

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
      @if ($user->profile_image === null)
        <img src="/storage/no_image.png" width="100" height="100" >
      @else
        <img src="{{ asset('storage/user_profiles/'.$user->profile_image) }}" width="100" height="100">
      @endif
      </div>
      <div class="col-4 d-inline-block">
        <ul>
          <a href="user/edit/{{$user->id}}" class="btn btn-sm btn-secondary mb-2">編集</a>
        </ul>
      </div>
      <div class="col text-right"><h6>フォロー数：{{$following_count}}　|　フォロワー数：{{$follower_count}}</h6></div>
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
            <a href="/user/delivery/index" class="btn btn-primary">
                {{ __('配送先一覧') }}
            </a>
          </div>
          <div class="col-3 d-inline-block">
            <a href="/user/order/index" class="btn btn-primary">
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
      <a href="user/post/new" class="btn btn-sm btn-primary">新規投稿</a>
      </div>
      <div class="card-deck row row-cols-2 row-cols-md-3 row-eq-height">
        @foreach ($posts as $post)
        <a href="/user/post/{{$post->id}}" class="text-dark" title="この投稿を見る">
          <div class="col">
            <div class="card mx-auto mt-4 shadow-lg text-center" style="border-radius: 10%;">
            @if ($post->post_image === null)
              <img src="/storage/no_image.png" width="100%" style="border-radius: 10% 10% 0% 0%;">
            @else
              <img src="{{ asset('storage/user_post_images/'.$post->post_image) }}" width="100%" height="244px" style="border-radius: 10% 10% 0% 0%;">
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