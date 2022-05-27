<!-- ★ -->
<?php use App\Models\StoreOrder; ?>

@extends('layouts.app_store')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('フォロワー一覧') }}</div>
          <div class="card-body">
            <table class="table table-light text-center">
              <thead>
                <td>プロフィール</td>
                <td>ユーザーネーム</td>
                <td>当店の利用回数</td>
                <td>最新の注文日時</td>
              </thead>
              @foreach ($markers as $marker)
              <!-- ★ここで使用 -->
                <?php
                  $store_orders = StoreOrder::where('store_id', $store->id)->where('user_id', $marker->user->id);
                  $last_day = $store_orders->latest()->first();
                ?>

                <tr>
                  <td>
                  @if ($marker->user->profile_image === null)
                    <img src="/storage/no_image.png" width="50" height="50" >
                  @else
                    <img src="{{ asset('storage/user_profiles/'.$marker->user->profile_image) }}" width="50" height="50">
                  @endif
                  </td>
                  <td><h5 class="mt-3">{{$marker->user->name}}</h5></td>
                  <td>
                    <h5 class="mt-3">
                      {{$store_orders->count()}} 回
                    </h5>
                  </td>
                  <td>
                    <a href="/store/store_order/{{$last_day->id}}" class="text-dark">
                      <h5 class="mt-3" title="この注文履歴を見る">
                        {{date('Y年n月d日', strtotime( $last_day->created_at ))}}
                      </h5>
                    </a>
                  </td>
                </tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
