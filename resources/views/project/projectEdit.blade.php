@extends('layouts.app')
@section('title', '案件情報編集')

@push('css')

@endpush

@php
$projectTypeCheckedId = is_null(old('formProjectType')) ? $project->project_type_id : old('formProjectType');
@endphp

@section('content')
<!-- コンテンツ -->
<div class="container">
    <div class="col-md-8 mt-5 w-75 mx-auto">
        <div class="card">
            <div class="card-header">案件編集</div>
            <div class="card-body">
                <form method="post" action="/projectUpdate">
                    @csrf
                    <div class="mb-3">
                        <label for="formId" class="form-label">ID</label>
                        <input class="form-control" type="text" id="formId" value="{{$project->id}}" disabled>
                        <input class="form-control" type="hidden" id="formId" value="{{$project->id}}" name="id">
                    </div>
                    <div class="mb-3">
                        <label for="formClientId" class="form-label">顧客名　<span class="badge bg-danger">必須</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="formClientId" name="formClientId" value="{{is_null(old('formClientId')) ? $project->client_id : old('formClientId')}}">
                            <span class="input-group-text w-50" id="formClientIdLabel">:</span>
                        </div>
                        <div class="position-absolute w-100" style="padding-right:2rem;" id="dataListContainer">
                            <div class="list-group overflow-scroll w-100" style="max-height:200px" id="dataListWrap">
                                <!-- ここに検索候補が格納されます -->
                            </div>
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
                            @if($projectType->id == $projectTypeCheckedId)
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
                        <input type="text" class="form-control" id="formName" name="formName" value="{{is_null(old('formName')) ? $project->name : old('formName')}}">
                        <div id="formNameError" class="form-text text-danger">
                            @if ($errors->has('formName'))
                                {{$errors->first('formName')}}
                            @endif　
                        </div>
                    </div>
                    <a href="{{route('projectList')}}" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> 案件情報一覧へ戻る</a>　
                    <button type="submit" class="btn btn-dark" id="formButton"><i class="fas fa-plus-circle"></i> 案件情報を編集</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /コンテンツ -->
@endsection

@push('js')
    <script src="{{ asset('js/project/input.js') }}"></script>
@endpush