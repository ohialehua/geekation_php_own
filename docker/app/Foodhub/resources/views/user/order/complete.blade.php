@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="row justify-content-center mb-4">
        <div class="col text-center bg-info" style="border-radius: 50%;"><h3 class="mt-3">注文</h3></div>
        <div class="col text-center"><h1 class="mt-3">→</h1></div>
        <div class="col text-center bg-info" style="border-radius: 50%;"><h3 class="mt-3">入力</h3></div>
        <div class="col text-center"><h1 class="mt-3">→</h1></div>
        <div class="col text-center bg-info" style="border-radius: 50%;"><h3 class="mt-3">確認</h3></div>
        <div class="col text-center"><h1 class="mt-3">→</h1></div>
        <div class="col text-center bg-warning" style="border-radius: 50%;"><h3 class="mt-3">完了</h3></div>
      </div>
      <div class="card mb-5">
        <div class="card-header">{{ __('注文した情報の確認') }}</div>
          <div class="card-body">
            <div class="row">
              <div class="col">

              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection
