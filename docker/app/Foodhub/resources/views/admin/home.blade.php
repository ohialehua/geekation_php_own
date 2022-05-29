@extends('layouts.app_admin')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card mb-5">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif

            {{ __('ログインしました') }}
        </div>
      </div>
      <div class="card">
        <div class="card-header text-center">{{ __('加盟店一覧') }}</div>

        <div class="card-body">
          <table class="table table-light text-center">
            <thead>
              <td>加盟日</td>
              <td>プロフィール</td>
              <td>加盟店名</td>
              <td>ステータス</td>
              <td>詳細</td>
            </thead>
          @foreach ($stores as $store)
            <tr>
              <td>{{date('Y年m月d日', strtotime($store->created_at))}}</td>
              <td>
              @if ($store->profile_image === null)
                <img src="/storage/no_image.png" width="50" height="50" >
              @else
                <img src="{{ asset('storage/store_profiles/'.$store->profile_image) }}" width="50" height="50">
              @endif
              </td>
              <td>{{$store->name}}</td>
              @if($store->is_deleted === 0)
                <td class="text-danger">無効</td>
              @else
                <td class="text-success">有効</td>
              @endif
              <td>
                <a href="store/{{$store->id}}" class="text-dark">表示</a>
              </td>
            </tr>
          @endforeach
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection