@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('新規投稿') }}</div>

        <div class="card-body">
          <form method="POST" action="{{ route('user.post.create') }}" enctype="multipart/form-data">
            @csrf

            <div class="row mb-3">
              <label for="post_image_id" class="col-md-4 col-form-label text-md-end text-center">{{ __('投稿画像') }}</label>

              <div class="col-md-6 text-center">
                <input id="post_image_id" type="file" class="form-control" name="post_image_id" accept="image/png, image/jpeg" required autocomplete="post_image_id" onchange="previewImage(this);">
                <img src="{{asset('storage/no_image.png')}}" id="img" width="50%" class="mt-4">
              </div>
            </div>

            <div class="row mb-3">
              <label for="body" class="col-md-4 col-form-label text-md-end">{{ __('投稿内容') }}</label>

              <div class="col-md-6">
                <textarea id="body" type="text" class="form-control" name="body" required autocomplete="body" autofocus rows="5"></textarea>
              </div>
            </div>

            <div class="row mb-0">
              <div class="col-md-6 offset-md-4 text-center">
                <button type="submit" class="btn btn-primary">
                  {{ __('新規投稿する') }}
                </button>
              </div>
            </div>
          </form>
          <script>
            function previewImage(obj)
            {
              var fileReader = new FileReader();
              fileReader.onload = (function() {
              document.getElementById('img').src = fileReader.result;
              });
              fileReader.readAsDataURL(obj.files[0]);
            }
          </script>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
