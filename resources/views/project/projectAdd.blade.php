@extends('layouts.app')
@section('title', '新規案件登録')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/formhelper.css') }}">
@endpush

@section('content')
<!-- コンテンツ -->
<div class="container">
    <div class="col-md-8 mt-5 w-75 mx-auto">
        <div class="card">
            <div class="card-header">新規案件登録</div>
            <div class="card-body">
                <form method="post" action="projectInsert">
                    @csrf
                    <div class="mb-3">
                        <label for="formClientId" class="form-label">顧客名　<span class="badge bg-danger">必須</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" formhelpertag="form" id="formClientId" name="formClientId" value="{{old('formClientId')}}"
                            onfocus="focusE(this)" oninput="inputE()" onblur="blurE()" autocomplete="off">
                            <span class="input-group-text" id="formClientIdLabel">:</span>
                            <input type="text" class="form-control" formhelpertag="form" value=""
                            onfocus="focusE(this)" oninput="inputE()" onblur="blurE()" autocomplete="off">
                        </div>
                        <div id="formClientIdError" class="form-text text-danger">
                            @if ($errors->has('formClientId'))
                                {{$errors->first('formClientId')}}
                            @endif　
                        </div>
                    </div>
                    <div class="mb-3">
                        <div>
                            <label for="formProjectType" class="form-label">案件種別　<span class="badge bg-danger">必須</span></label>
                        </div>
                        @foreach($projectTypes as $key => $projectType)
                            @if($key == 0)
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="projectType{{ $projectType->id }}" name="formProjectType" value="{{ $projectType->id }}" checked>
                                    <label for="projectType{{ $projectType->id }}">{{ $projectType->name }}</label>
                                </div>
                            @else
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="projectType{{ $projectType->id }}" name="formProjectType" value="{{ $projectType->id }}">
                                    <label for="projectType{{ $projectType->id }}">{{ $projectType->name }}</label>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <label for="formName" class="form-label">案件名　<span class="badge bg-danger">必須</span></label>
                        <input type="text" class="form-control" id="formName" name="formName" value="{{old('formName')}}">
                        <div id="formNameError" class="form-text text-danger">
                            @if ($errors->has('formName'))
                                {{$errors->first('formName')}}
                            @endif　
                        </div>
                    </div>
                    <a href="{{route('clientList')}}" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> 顧客情報一覧へ戻る</a>　
                    <button type="submit" class="btn btn-dark" id="formButton" disabled><i class="fas fa-plus-circle"></i> 案件を新規追加</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /コンテンツ -->
@endsection

@push('js')
    <script src="{{ asset('js/formhelper.js') }}"></script>
    <script src="{{ asset('js/project/input.js') }}"></script>
@endpush