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
                  <div class="col-9">
                    <p class="card-text"><i class="fas fa-utensils"></i> {{ Str::limit($store->name, 15, '...') }}</p>
                  </div>
                  <div class="col-1">
                    <h5 class="text-warning" title="フォロワー数"><i class="fa fa-star">{{$store->markers->count()}}</i></h5>
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
