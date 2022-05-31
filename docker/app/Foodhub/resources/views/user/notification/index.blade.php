@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header text-center">{{ __('通知一覧') }}</div>

        <div class="card-body">
          <table class="table table-light text-center">
            <thead>
              <td></td>
              <td>日付</td>
              <td>内容</td>
            </thead>
          @foreach ($notifications as $notification)
            <tr>
            @if ($notification->checked == false)
              <td class="table-warning">
                <form method="POST" action="{{ route('user.notification.update', $notification->id ) }}">
                @csrf
                  <span class="checked" title="投稿を既読にする">
                    <input id="checked" name="checked" type="hidden" value=1>
                    <button type="submit" class="bg-warning" style="border: none;"><i class="fa fa-check"></i></button>
                  </span>
                </form>
              </td>
            @else
              <td class="table-success">
                <form method="POST" action="{{ route('user.notification.update', $notification->id ) }}">
                @csrf
                  <span class="checked" title="投稿を未読にする">
                    <input id="checked" name="checked" type="hidden" value=0>
                    <button type="submit" class="bg-success text-white" style="border: none;"><i class="fa fa-check"></i></button>
                  </span>
                </form>
              </td>
            @endif
              <td>{{date('Y年m月d日', strtotime($notification->created_at))}}</td>
              <td>
                @if ( $notification->action == 'like')
                  <a href="/user/{{$notification->sender->id}}" class="text-dark">
                    {{$notification->sender->name}}さん
                  </a>
                  にいいねされました
                @elseif ( $notification->action == 'comment')
                  <a href="/user/{{$notification->sender->id}}" class="text-dark">
                    {{$notification->sender->name}}さん
                  </a>
                  が
                  <a href="/user/post/{{$notification->post_comment->user_post_id}}" class="text-dark">
                  あなたの投稿
                  </a>
                  にコメントしました
                @elseif ( $notification->action == 'order')
                  <a href="/user/store/{{$notification->store_id}}" class="text-dark">
                    {{$notification->store->name}}
                  </a>
                  で
                  <a href="/user/order/{{$notification->store_order->order_id}}" class="text-dark">
                  注文した商品
                  </a>
                  が発送されました
                @endif
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