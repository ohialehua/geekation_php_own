@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 mb-5">
      <div class="card">

        <div class="card-header">
          <div class="row">
            <div class="col-10">
              <p>{{ __('詳細画面') }}</p>
            </div>
            <div class="col-2">
              <a href="/home" class="btn btn-sm btn-primary">
                {{ __('戻る') }}
              </a>
            </div>
          </div>
        </div>

        <div class="card-body">

          <div class="card" style="border-radius: 10%;">
            @if ($post->post_image === null)
              <img src="/storage/no_image.png" width="100%" style="border-radius: 10% 10% 0% 0%;">
            @else
              <img src="{{ asset('storage/store_post_images/'.$post->post_image) }}" width="100%" style="border-radius: 10%;">
            @endif
          </div>

          <div class="row mb-3">
            <label for="body" class="col-md-4 col-form-label text-md-end">{{ __('紹介文') }}</label>

            <div class="card-body border" style="border-radius: 10px;">
              {{$post->body}}
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          {{ __('コメント') }}
        </div>
        <div class="card-body">
          @foreach ($post_comments as $post_comment)
            @if ($post_comment->user_id == $user->id)
              <div class="row my-2">
                <div class="col-1 my-auto">
                  <form method="POST" action="{{ route('user.post_comment.destroy', $post_comment->id) }}">
                  @csrf
                    <button type="submit" class="btn btn-sm btn-danger" title="削除ボタン" style="border-radius: 50%;">
                      {{ __('×') }}
                    </button>
                  </form>
                </div>
                <div class="col-9 border my-auto text-center" style="border-radius: 10px;">
                  <p class="card-text my-1">{{$post_comment->comment}}</p>
                </div>
                <div class="col-2">
                  <div class="card" style="border-radius: 50%;">
                    @if ($user->profile_image)
                      <img src="{{ asset('storage/user_profiles/'.$user->profile_image) }}" width="100%" style="border-radius: 50%;">
                    @else
                      <img src="/storage/no_image.png" width="100%" style="border-radius: 50%;">
                    @endif
                  </div>
                </div>
                <div class="col-4 offset-8">
                  <p>{{date('y/n/d g:i a', strtotime($post_comment->created_at))}}</p>
                </div>
              </div>
            @elseif ($post_comment->user_id)
              <div class="row my-2">
                <label>{{$post_comment->user->name}}</label>
                <div class="col-2">
                  <a href="/user/{{$post_comment->user->id}}" title="{{$post_comment->user->name}}のページを見る">
                    <div class="card" style="border-radius: 50%;">
                    @if ($post_comment->user->profile_image)
                      <img src="{{ asset('storage/user_profiles/'.$post_comment->user->profile_image) }}" width="100%" style="border-radius: 50%;">
                    @else
                      <img src="/storage/no_image.png" width="100%" style="border-radius: 50%;">
                    @endif
                    </div>
                  </a>
                </div>
                <div class="col-9 border my-auto text-center" style="border-radius: 10px;">
                  <p class="card-text my-1">{{$post_comment->comment}}</p>
                </div>
                <p>{{date('y/n/d g:i a', strtotime($post_comment->created_at))}}</p>
              </div>
            @else
              <div class="row my-2">
                <label>{{$post_comment->store->name}}</label>
                <div class="col-2">
                  <a href="/user/store/{{$post_comment->store->id}}" title="{{$post_comment->store->name}}のページを見る">
                    <div class="card" style="border-radius: 50%;">
                    @if ($post_comment->store->profile_image)
                      <img src="{{ asset('storage/store_profiles/'.$post_comment->store->profile_image) }}" width="100%" style="border-radius: 50%;">
                    @else
                      <img src="/storage/no_image.png" width="100%" style="border-radius: 50%;">
                    @endif
                    </div>
                  </a>
                </div>
                <div class="col-9 border my-auto text-center" style="border-radius: 10px;">
                  <p class="card-text my-1">{{$post_comment->comment}}</p>
                </div>
                <p>{{date('y/n/d g:i a', strtotime($post_comment->created_at))}}</p>
              </div>
            @endif
          @endforeach
          <div class="mt-4">
            <form method="POST" action="{{ route('user.post_comment.create')}} ">
            @csrf
              <input id="user_id" name="user_id" type="hidden" value="{{$user->id}}">
              <input id="store_post_id" name="store_post_id" type="hidden" value="{{$post->id}}">
              <div class="row">
                <div class="col-8 offset-2">
                  <textarea id="comment" type="text" class="form-control" name="comment" required autocomplete="body" autofocus placeholder="コメント内容"></textarea>
                </div>
                <div class="col-2">
                  <button type="submit" class="btn btn-sm btn-info my-4">
                    {{ __('送信') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
