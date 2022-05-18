@extends('layouts.app_store')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('編集画面') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('store.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('店舗名') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $store->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name_kana" class="col-md-4 col-form-label text-md-end">{{ __('カナ') }}</label>

                            <div class="col-md-6">
                                <input id="name_kana" type="text" class="form-control @error('name_kana') is-invalid @enderror" name="name_kana" value="{{ $store->name_kana }}" required autocomplete="kana" autofocus>

                                @error('name_kana')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="introduction" class="col-md-4 col-form-label text-md-end">{{ __('紹介文') }}</label>

                            <div class="col-md-6">
                                <textarea id="introduction" type="text" class="form-control" name="introduction" value="{{ $store->introduction }}" required autocomplete="introduction" autofocus rows="5">{{$store->introduction}}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="profile_image" class="col-md-4 col-form-label text-md-end text-center">{{ __('プロフィール画像') }}</label>

                            <div class="col-md-6 text-center">
                              <input id="profile_image" type="file" class="form-control" name="profile_image" value="{{ $store->profile_image }}" accept="image/png, image/jpeg" onchange="previewImage(this);">
                              <img src="{{ asset('storage/store_profiles/'.$store->profile_image) }}" id="img" width="100%" class="mt-4">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 text-center">
                                <button type="submit" class="btn btn-secondary">
                                    {{ __('編集') }}
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
