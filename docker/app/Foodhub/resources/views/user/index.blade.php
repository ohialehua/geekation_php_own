<?php
  use App\Models\Relationship;
  use App\Models\User;
?>
@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row mt-3">
    <div class="col-lg-9">
      <h2>会員一覧</h2>
      <table class="table table-light text-center">
        <thead>
          <td>プロフィール</td>
          <td>ユーザーネーム</td>
          <td>フォロー数</td>
          <td>フォロワー数</td>
          <td></td>
        </thead>
      @foreach ($users as $user)
      <?php
          $following_count = Relationship::where('followed_id', $user->id)->count();
          $follower_count = Relationship::where('follower_id', $user->id)->count();
      ?>
        <tr>
          <td>
          @if ($user->profile_image === null)
            <img src="/storage/no_image.png" width="50" height="50" >
          @else
            <img src="{{ asset('storage/user_profiles/'.$user->profile_image) }}" width="50" height="50">
          @endif
          </td>
          <td><a href="{{$user->id}}" class="text-dark">{{$user->name}}</a></td>
          <td>{{$following_count}}</td>
          <td>{{$follower_count}}</td>
          <td></td>
        </tr>
      @endforeach
      </table>
    </div>
    <div class="col-lg-3 mt-5">
      <table class="table table-light text-center mb-5">
        <thead><h4 class="text-center">follows</h4></thead>
        <tbody>
          @foreach ($following_users as $following_user)
          <?php
            $following = User::find($following_user->follower_id);
          ?>
          <tr>
            <td>
              @if ($following->profile_image === null)
                <img src="/storage/no_image.png" width="50" height="50" >
              @else
                <img src="{{ asset('storage/user_profiles/'.$following->profile_image) }}" width="50" height="50">
              @endif
            </td>
            <td>
              <a href="/user/{{$following->id}}" class="text-dark" title="{{$following->name}}さんのページを見る">
                <h5 class="mt-3">{{$following->name}}</h5>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <table class="table table-light text-center">
        <thead><h4 class="text-center">followers</h4></thead>
        <tbody>
          @foreach ($follower_users as $follower_user)
          <?php
            $follower = User::find($follower_user->followed_id);
          ?>
          <tr>
            <td>
              @if ($follower->profile_image === null)
                <img src="/storage/no_image.png" width="50" height="50" >
              @else
                <img src="{{ asset('storage/user_profiles/'.$follower->profile_image) }}" width="50" height="50">
              @endif
            </td>
            <td>
              <a href="/user/{{$follower->id}}" class="text-dark" title="{{$follower->name}}さんのページを見る">
                <h5 class="mt-3">{{$follower->name}}</h5>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
