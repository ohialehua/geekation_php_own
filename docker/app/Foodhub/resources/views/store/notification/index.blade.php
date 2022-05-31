@extends('layouts.app_store')

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
                <form method="POST" action="{{ route('store.notification.update', $notification->id ) }}">
                @csrf
                  <span class="checked" title="投稿を既読にする">
                    <input id="checked" name="checked" type="hidden" value=1>
                    <button type="submit" class="bg-warning" style="border: none;"><i class="fa fa-check"></i></button>
                  </span>
                </form>
              </td>
            @else
              <td class="table-success">
                <form method="POST" action="{{ route('store.notification.update', $notification->id ) }}">
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
                    {{$notification->user->name}}さんにいいねされました
                @elseif ( $notification->action == 'comment')
                    {{$notification->user->name}}さん
                  が
                  <a href="/store/post/{{$notification->post_comment->store_post_id}}" class="text-dark">
                  あなたの投稿
                  </a>
                  にコメントしました
                @elseif ( $notification->action == 'order')
                  {{$notification->user->name}}さんから
                  <a href="/store/store_order/{{$notification->store_order_id}}" class="text-dark">
                  注文
                  </a>
                  を受け付けました。
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