@extends('layouts.app')
@section('title', '案件情報一覧')

@push('css')
@endpush

@section('content')
<!-- コンテンツ -->
<div class="container">
    @if (session('flashMsg'))
        <div class="alert alert-success mt-3 w-100 mx-auto" role="alert">
            {{session('flashMsg')}}
        </div>
    @endif
    
    <div class="w-100 mx-auto mt-5 text-end">
        <a href="{{route('projectAdd')}}" class="btn btn-dark"><i class="fas fa-folder-plus"></i> 新規案件情報登録</a>
    </div>
    <div class="w-100 mt-5 row g-0">
        <form class="w-50 d-flex" action="" method="GET">
            <div class="col-4">
                <input type="month" class="form-control" name="month" value="{{ $month }}"> 
            </div>
            <div class="col-8 ms-2">
                <div class="input-group">
                    <input type="text" class="form-control" name="key" placeholder="案件No/案件名/顧客名…で検索" value="{{ $key }}">
                    <button class="btn btn-dark" type="submit" id="button-addon2"><i class="fas fa-search"></i> 検索</button>
                </div>
            </div>
        </form>
        <div class="w-50">
            <div class="d-flex justify-content-end">
                {{ $projects->appends(request()->query())->links('components.pagenate.head') }}
            </div>
        </div>
    </div>
    <table class="table table-striped w-100 mx-auto mt-3 table-bordered">
        <tr class="table-dark">
            <th class="col-1">
                # <i class="fas fa-key"></i>　
            </th>
            <th class="col-2">案件名</th>
            <th class="col-2">顧客名</th>
            <th class="col-1">制作・保守</th>
            @foreach($months as $month)
                <th class="col-1">{{$month}}</th>
            @endforeach
            <th class="col-1">全期間累計</th>
            <th class="col-2">操作</th>
        </tr>
        @foreach($projects as $project)
            <tr>
                <td class="col-1 align-middle">{{$project->id}}</td>
                <td class="col-2 align-middle">{{$project->project_name}}</td>
                <td class="col-3 align-middle">{{$project->client_name}}</td>
                <td class="col-1 align-middle">{{$project->type_name}}</td>
                <td class="col-1 align-middle">{{$project->month3}}</td>
                <td class="col-1 align-middle">{{$project->month2}}</td>
                <td class="col-1 align-middle">{{$project->month1}}</td>
                <td class="col-1 align-middle">{{$project->sum}}</td>
                <td class="col-1 align-middle text-center"><a href="{{ Route('projectEdit',$project->id) }}" class="btn btn-outline-dark"><i class="fas fa-edit"></i> 編集</a></td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center mt-5">
        {{ $projects->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</div>
<!-- /コンテンツ -->
@endsection

@push('js')
@endpush