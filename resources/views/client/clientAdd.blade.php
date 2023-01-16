@extends('layouts.app')
@section('title', '新規顧客追加')

@push('css')

@endpush

@section('content')
<!-- コンテンツ -->
<div class="container">
    <div class="col-md-8 mt-5 w-75 mx-auto">
        <div class="card">
            <div class="card-header">新規顧客登録</div>
            <div class="card-body">
                <form method="post" action="clientInsert">
                    @csrf
                    <div class="mb-3">
                        <label for="formName" class="form-label">顧客名　<span class="badge bg-danger">必須</span></label>
                        <input type="text" class="form-control" id="formName" name="formName">
                        <div id="formNameError" class="form-text text-danger">
                            @if ($errors->has('formName'))
                                {{$errors->first('formName')}}
                            @endif　
                        </div>
                    </div>
                    <a href="{{route('clientList')}}" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> 顧客情報一覧へ戻る</a>　
                    <button type="submit" class="btn btn-dark" id="formButton" disabled><i class="fas fa-plus-circle"></i> 顧客を新規追加</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /コンテンツ -->
@endsection

@push('js')
    <script src="{{ asset('js/client/input.js') }}"></script>
@endpush