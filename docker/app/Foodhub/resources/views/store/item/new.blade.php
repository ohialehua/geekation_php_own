@extends('layouts.app_store')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('商品登録') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('store.item.create') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('商品名') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="body" class="col-md-4 col-form-label text-md-end">{{ __('紹介文') }}</label>

                            <div class="col-md-6">
                                <textarea id="body" type="text" class="form-control" name="body" required autocomplete="body" autofocus rows="5"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="price_before_tax" class="col-md-4 col-form-label text-md-end">{{ __('税抜き価格') }}</label>

                            <div class="col-md-6">
                                <input id="price_before_tax" type="text" class="form-control" name="price_before_tax" required autocomplete="price_before_tax" autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="image" class="col-md-4 col-form-label text-md-end text-center">{{ __('商品画像') }}</label>

                            <div class="col-md-6 text-center">
                              <input id="image" type="file" class="form-control" name="image" accept="image/png, image/jpeg" onchange="previewImage(this);">
                              <img src="{{asset('storage/no_image.png')}}" id="img" width="100%" class="mt-4">
                              <!-- asset('storage/item_images/'.$item->image_id) -->
                            </div>
                        </div>

                        <div class="row mb-3">

                            <div class="col-md-6 text-center">
                              <div class="form-check form-check-inline">
                                <input id="is_active" type="radio" value="0" checked name="is_active" required autocomplete="is_active" autofocus>
                                <label for="is_active" class="form-check-label">販売する</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input id="is_active" type="radio" value="1" class="" name="is_active" required autocomplete="is_active" autofocus>
                                <label for="is_active" class="form-check-label">まだ販売しない</label>
                              </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 text-center">
                                <button type="submit" class="btn btn-success" onclick="return confirm('商品画像の変更はできません。この内容で登録しますか？')">
                                    {{ __('この内容で商品を登録する') }}
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
