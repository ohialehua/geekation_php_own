@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
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
            @if ($post->post_image_id === null)
              <img src="/storage/no_image.png" width="100%" style="border-radius: 10% 10% 0% 0%;">
            @else
              <img src="{{ asset('storage/store_post_images/'.$post->post_image_id) }}" width="100%" style="border-radius: 10%;">
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
    </div>
</div>
@endsection
