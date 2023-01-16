@extends('layouts.app')
@section('title', '顧客情報一覧')

@push('css')
<link rel="stylesheet" href="{{ asset('css/formhelper.css') }}">
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
        <a href="{{route('reportAdd')}}" class="btn btn-dark"><i class="fas fa-folder-plus"></i> 新規日報登録</a>
    </div>
    <div class="w-100 mt-5 row g-0">
        <form class="col-8 d-flex" action="" method="GET">
            <div class="col-6">
                <div class="input-group">
                    <input type="date" class="form-control" name="date_start" value="{{ $date_start }}"> 
                    <span class="input-group-text">~</span>
                    <input type="date" class="form-control" name="date_end" value="{{ $date_end }}"> 
                </div>
            </div>
            <div class="col-6 ms-2">
                <div class="input-group">
                    <input type="text" class="form-control" name="key" placeholder="案件No/案件名/顧客名…で検索" value="{{ $key }}">
                    <button class="btn btn-dark" type="submit" id="button-addon2"><i class="fas fa-search"></i> 検索</button>
                </div>
            </div>
        </form>
        <div class="col-4">
            <div class="d-flex justify-content-end">
                {{ $reports->appends(request()->query())->links('components.pagenate.head') }}
            </div>
        </div>
    </div>
    <table class="table table-striped w-100 mx-auto mt-3 table-bordered">
        <tr class="table-dark">
            <th class="col-1">日付</th>
            <th class="col-1">従業員名</th>
            <th class="col-1">案件No</th>
            <th class="col-2">案件名</th>
            <th class="col-3">顧客名</th>
            <th class="col-1">作業時間</th>
            <th class="col-2">作業内容</th>
            <th class="col-1">操作</th>
        </tr>
        @foreach($reports as $report)
            <tr editId={{ $report->id }} >
                <td class="col-1 align-middle text-center">{{ $report->formated_date }}</td>
                <td class="col-1 align-middle text-center">{{ $report->user_name }}</td>
                <td class="col-1 align-middle text-center position-relative">{{ $report->project_id }}</td>
                <td class="col-2 align-middle text-center">{{ $report->project_name }}</td>
                <td class="col-3 align-middle text-center">{{ $report->clients_name }}</td>
                <td class="col-1 align-middle text-center">{{ $report->formated_working_time }}</td>
                <td class="col-2 align-middle text-center"><span>{{ $report->operations_name }} </span>
                    @if(!is_null($report->url))
                        <a href="{{ $report->url }}">リンク</a>
                    @endif
                </td>
                <td class="col-1 align-middle text-center">
                    <button type="button" class="btn btn-outline-dark" onClick="goEdit(this)"><i class="fas fa-edit"></i> 編集</button>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center mt-5">
        {{ $reports->appends(request()->query())->links('components.pagenate.bottom') }}
    </div>
</div>
<!-- /コンテンツ -->
@endsection

@push('js')
    <script src="{{ asset('js/formhelper.js') }}"></script>
    <script src="{{ asset('js/report/edit.js') }}"></script>
@endpush