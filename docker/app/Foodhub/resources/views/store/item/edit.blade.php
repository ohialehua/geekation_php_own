@extends('layouts.app_store')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('編集画面') }}</div>

                <div class="card-body">
                  <div class="col offset-10">
                    <form method="POST" action="{{ route('store.item.destroy', $item->id) }}">
                      @csrf
                      <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？')">
                        {{ __('削除') }}
                      </button>
                    </form>
                  </div>
                    <form method="POST" action="{{ route('store.item.update', $item->id) }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-3 text-center">
                              <img src="{{ asset('storage/item_images/'.$item->image) }}" id="img" width="100%" class="mt-4">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('商品名') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $item->name }}" required autocomplete="name" autofocus>

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
                                <textarea id="body" type="text" class="form-control" name="body" value="{{ $item->body }}" required autocomplete="introduction" autofocus rows="5">{{$item->body}}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="price_before_tax" class="col-md-4 col-form-label text-md-end">{{ __('税抜き価格') }}</label>

                            <div class="col-md-6">
                                <input id="price_before_tax" type="text" class="form-control" name="price_before_tax" value="{{ $item->price_before_tax }}" required autocomplete="price_before_tax" autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">

                            <div class="text-center">
                              <div class="form-check form-check-inline">
                                <input id="is_active" type="radio" value="0" name="is_active" required autocomplete="is_active" autofocus @if ($item->is_active === 0)checked @endif>
                                <label for="is_active" class="form-check-label">販売</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input id="is_active" type="radio" value="1" class="" name="is_active" required autocomplete="is_active" autofocus @if ($item->is_active === 1)checked @endif>
                                <label for="is_active" class="form-check-label">販売停止</label>
                              </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="text-center">
                              <div class="col-3 d-inline-block">
                                <button type="submit" class="btn btn-secondary">
                                    {{ __('編集') }}
                                </button>
                              </div>
                              <div class="col-3 d-inline-block">
                                <a href="/store/home" class="btn btn-primary">
                                    {{ __('戻る') }}
                                </a>
                              </div>
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
