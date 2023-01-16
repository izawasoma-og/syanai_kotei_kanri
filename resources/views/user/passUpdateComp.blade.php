@extends('layouts.app')
@section('title', 'パスワード変更')

@push('css')

@endpush

@section('content')
<!-- コンテンツ -->
<div class="container">
    <div class="col-md-8 mt-5 w-75 mx-auto">
        <div class="card">
            <div class="card-header">メッセージ</div>
            <div class="card-body">
                パスワードを変更しました！<br>
                トップへ戻る場合は<a href="{{ route('home') }}">こちら</a>をクリックしてください。
            </div>
        </div>
    </div>
</div>

<!-- /コンテンツ -->
@endsection

@push('js')
@endpush