@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('編集画面') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('ユーザーネーム') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="introduction" class="col-md-4 col-form-label text-md-end">{{ __('紹介文') }}</label>

                            <div class="col-md-6">
                                <textarea id="introduction" type="text" class="form-control" name="introduction" value="{{ $user->introduction }}" required autocomplete="introduction" autofocus rows="5">{{$user->introduction}}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="profile_image" class="col-md-4 col-form-label text-md-end text-center">{{ __('プロフィール画像') }}</label>

                            <div class="col-md-6 text-center">
                              <input id="profile_image" type="file" class="form-control" name="profile_image" value="{{ $user->profile_image }}" accept="image/png, image/jpeg" onchange="previewImage(this);">
                            @if ($user->profile_image)
                              <img src="{{ asset('storage/user_profiles/'.$user->profile_image) }}" id="img" width="50%" class="mt-4">
                            @else
                              <img src="{{ asset('storage/no_image.png') }}" id="img" width="50%" class="mt-4">
                            @endif
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

                    <div class="border-bottom my-4"></div>

                    @unless($user->full_name && $user->full_name_kana && $user->phone_number)
                    <form method="POST" action="{{ route('user.update', $user->id) }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="full_name" class="col-md-4 col-form-label text-md-end">{{ __('氏名') }}</label>

                            <div class="col-md-6">
                                <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ $user->full_name }}" required autocomplete="full_name" autofocus>

                                @error('full_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="full_name_kana" class="col-md-4 col-form-label text-md-end">{{ __('カナ') }}</label>

                            <div class="col-md-6">
                                <input id="full_name_kana" type="text" class="form-control @error('full_name_kana') is-invalid @enderror" name="full_name_kana" value="{{ $user->full_name_kana }}" required autocomplete="full_name_kana" autofocus>

                                @error('full_name_kana')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-end">{{ __('電話番号') }}</label>

                            <div class="col-md-6">
                                <input id="phone_number" type="tel" class="form-control" name="phone_number" value="{{ $user->phone_number }}" required autocomplete="phone_number" autofocus>

                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 text-center">
                                <button type="submit" class="btn btn-secondary">
                                    {{ __('個人情報の登録') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
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
