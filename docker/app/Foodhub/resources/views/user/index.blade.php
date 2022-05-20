@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row mt-3">
    <div class="col-lg-9">
      <h2>会員一覧</h2>
      <table class="table table-light">
        <thead>
          <td>プロフィール画像</td>
          <td>ユーザーネーム</td>
          <td>フォロー数</td>
          <td>フォロワー数</td>
          <td></td>
        </thead>
      @foreach ($users as $user)
        <tr>
          <td>
          @if ($user->profile_image_id === null)
            <img src="/storage/no_image.png" width="50" height="50" >
          @else
            <img src="{{ asset('storage/user_profiles/'.$user->profile_image_id) }}" width="50" height="50">
          @endif
          </td>
          <td><a href="{{$user->id}}" class="text-dark">{{$user->name}}</a></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      @endforeach
      </table>
    </div>
    <div class="col-lg-3">
      <table class="table table-light">
        <thead><h4 class="text-center">follows</h4></thead>
        <tbody>
          <tr>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>

      <table class="table table-light">
        <thead><h4 class="text-center">followers</h4></thead>
        <tbody>
          <tr>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
