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
          @if($user->id == $post->user_id)
            <div class="col offset-10">
              <form method="POST" action="{{ route('user.post.destroy', $post->id) }}">
              @csrf
                <button type="submit" class="btn btn-sm btn-danger mb-2" onclick="return confirm('本当に削除しますか？')">
                  {{ __('削除') }}
                </button>
              </form>
            </div>
          @endif

            <div class="card" style="border-radius: 10%;">
            @if ($post->post_image === null)
              <img src="/storage/no_image.png" width="100%" style="border-radius: 10% 10% 0% 0%;">
            @else
              <img src="{{ asset('storage/user_post_images/'.$post->post_image) }}" width="100%" style="border-radius: 10%;">
            @endif
            </div>

            <div class="row my-3">
              <label for="body" class="col-form-label text-center">{{ __('紹介文') }}</label>

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
            <div class="row">
              <div class="col-2">
                <p class="card-text">sss</p>
              </div>
              <div class="col-10 border" style="border-radius: 10px;">
                <p class="card-text"> ppp</p>
              </div>
            </div>
            <div class="mt-4">
              <form method="POST" action="{{ route('user.post_comment.create')}} ">
              @csrf
                <input id="user_id" name="user_id" type="hidden" value="{{$user->id}}">
                <input id="user_post_id" name="user_post_id" type="hidden" value="{{$post->id}}">
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
</div>
@endsection
