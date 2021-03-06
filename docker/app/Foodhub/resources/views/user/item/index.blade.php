@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row mt-3">
    <div class="col-lg-9 mb-5">
      <h2>商品一覧</h2>
      <div class="card-deck row row-cols-2 row-cols-md-3 row-cols-lg-4 row-eq-height">
        @foreach ($items as $item)
        <a href="{{$item->id}}" class="text-dark" title="この商品を見る">
          <div class="col">
            <div class="card mx-auto mt-4 shadow-lg text-center" style="border-radius: 10%;">
            @if ($item->image === null)
              <img src="/storage/no_image.png" width="100%" style="border-radius: 10% 10% 0% 0%;">
            @else
              <img src="{{ asset('storage/item_images/'.$item->image) }}" width="100%" height="244px" style="border-radius: 10% 10% 0% 0%;">
            @endif
              <div class="card-body">
                <div class="row">
                  <div class="col-12 mx-auto my-2">
                    <p class="card-text"><i class="fas fa-utensils"></i> {{ Str::limit("{$item->store->name}：{$item->name}", 23, '...') }}</p>
                  </div>
                  <div class="col-8">
                    <p class="card-text"> 説明：{{ Str::limit($item->body, 8, '...') }}</p>
                  </div>
                  <div class="col-3">
                    <h5 class="text-success" title="累計購入数"><i class="fa fa-gifts">{{$item->sales_figures}}</i></h5>
                  </div>
                </div>
                <div class="card bg-warning" title="税抜き価格">¥ {{number_format($item->price_before_tax)}}</div>
              </div>
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
    <div class="col-lg-3">
      <table class="table table-light">
        <thead><h4 class="text-center">お気に入り店舗</h4></thead>
        <tbody>
          @foreach ($markers as $marker)
            <tr>
              <td>
                @if ($marker->store->profile_image === null)
                  <img src="/storage/no_image.png" width="100%" style="border-radius: 10% 10% 0% 0%;">
                @else
                  <img src="{{ asset('storage/store_profiles/'.$marker->store->profile_image) }}" width="50px" height="50px">
                @endif
              </td>
              <td><a href="/user/store/{{$marker->store->id}}" class="text-dark"><h5 class="mt-3">{{$marker->store->name}}</h5></a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
