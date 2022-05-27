@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row mt-3">
    <div class="col-lg-9 mb-5">
      <h2>加盟店一覧</h2>
      <div class="card-deck row row-cols-2 row-cols-md-3 row-cols-lg-4 row-eq-height">
        @foreach ($stores as $store)
        <a href="{{$store->id}}" class="text-dark">
          <div class="col">
            <div class="card mx-auto mt-4 shadow-lg text-center" style="border-radius: 10%;">
            @if ($store->profile_image === null)
              <img src="/storage/no_image.png" width="100%" style="border-radius: 10% 10% 0% 0%;">
            @else
              <img src="{{ asset('storage/store_profiles/'.$store->profile_image) }}" width="100%" style="border-radius: 10% 10% 0% 0%;">
            @endif
              <div class="card-body">
                <div class="row">
                  <div class="col-12 mx-auto">
                    <p class="card-text"><i class="fas fa-utensils"></i> {{$store->name}}</p>
                    <div class="d-inline-flex">
                      <p class="ml-2"> フォロワー数：○○　｜ </p>
                      <p>★</p>
                    </div>
                  </div>
                </div>
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
