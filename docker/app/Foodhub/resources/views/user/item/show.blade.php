@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row mt-3">
    <div class="col-md-5 mb-4">
      <div class="card" style="border-radius: 10%;">
        @if ($item->image === null)
          <img src="/storage/no_image.png" width="100%" style="border-radius: 10% 10% 0% 0%;">
        @else
          <img src="{{ asset('storage/item_images/'.$item->image) }}" width="100%" style="border-radius: 10%;">
        @endif
      </div>
    </div>

    <div class="col-md-7">
      <div class="card">
        <div class="card-header text-center">
          {{ __('商品情報') }}
        </div>
        <div class="card-body">
          <table class="table">
            <tr>
              <td>店舗名：{{$item->store->name}}</td>
              <td>商品名：{{$item->name}}</td>
              <td>税抜き価格：<p class="d-inline-block" style="background: linear-gradient(transparent 70%, #ffff66 0%);">{{number_format($item->price_before_tax)}}円</p></td>
            </tr>
          </table>
          <p class="text-center">紹介文</p>
          <div class="card-body border" style="border-radius: 10px;">
            {{$item->body}}
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center mt-4">
      <div class="col-md-11 col-lg-8">
        <table class="table table-light">
          <thead><h5 class="text-center">カート内商品</h5></thead>
          <tbody>
            <tr>
              <td>商品名</td>
              <td>単価(税込)</td>
              <td>数量</td>
              <td>小計</td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection