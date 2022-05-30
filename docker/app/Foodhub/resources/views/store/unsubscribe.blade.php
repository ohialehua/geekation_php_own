@extends('layouts.app_store')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-9 col-lg-5">
      <div class="my-3 text-center">
        <h2>
          退会したらログインできなくなります。<br>
          本当に退会しますか？
        </h2>
      </div>
      <div class="card mb-5">
          <div class="card-body">
            <div class="row">
              <div class="col-6">
                <div class="text-center">
                  <a href="home" class="btn btn-sm btn-primary">マイページに戻る</a>
                </div>
              </div>
              <div class="col-6 text-center">
                <form method="POST" action="{{ route('store.withdraw', $store->id) }}">
                  @csrf
                    <input id="store_id" name="store_id" type="hidden" value="{{$store->id}}">
                    <input id="is_deleted" name="is_deleted" type="hidden" value="0">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('退会する場合は「OK」ボタンを押してください')">
                      {{ __('退会する') }}
                    </button>
                  </form>
              </div>
            </div>
          </div>
    </div>
  </div>
</div>
@endsection
