@extends('layouts.app')
@section('title', '顧客情報追加')

@push('css')
<link rel="stylesheet" href="{{ asset('css/formhelper.css') }}">
@endpush

@section('content')
@php
$reports = old("report");
$i = 0;
@endphp
<!-- コンテンツ -->
<div class="container">
    <div class="col-md-8 mt-5 w-100 mx-auto">
        <div class="card">
            <div class="card-header">日報作成</div>
            <div class="card-body">
                <form method="post" action="reportInsert">
                    @csrf
                    <div class="col-4">
                        @if($errors->first("date") == "")
                            <input type="date" class="form-control" name="date" value="{{ old('date') }}"> 
                        @else
                            <input type="date" class="form-control is-invalid" name="date" value="{{ old('date') }}"> 
                        @endif
                    </div>
                    <table class="table table-striped w-100 mx-auto mt-3 table-bordered">
                        <thead>
                            <tr class="table-dark">
                                <th class="col-1 align-middle text-center">案件No</th>
                                <th class="col-2 align-middle text-center">案件名</th>
                                <th class="col-2 align-middle text-center">顧客名</th>
                                <th class="col-2 align-middle text-center">作業時間</th>
                                <th class="col-3 align-middle text-center">作業内容</th>
                                <th class="col-1 align-middle text-center"></th>
                            </tr>
                        </thead>
                        <tbody id="formTable">
                            @if(old("report","default") == "default")
                                <tr fieldid="0">
                                    <td class="col-1 align-middle text-center">
                                        <input class="form-control inputItem formProjectId" type="text" name="report[0][project_id]" 
                                        value="" oninput="inputE()" onfocus="focusE(this)" onblur="blurE()" formhelpertag="form0" autocomplete="off">
                                    </td>
                                    <td class="col-2 align-middle text-center">
                                        <input class="form-control inputItem formProjectName" type="text" name="report[0][project_name]" 
                                        value="" oninput="inputE()" onfocus="focusE(this)" onblur="blurE()" formhelpertag="form0" autocomplete="off">
                                    </td>
                                    <td class="col-2 align-middle text-center">
                                        <input class="form-control inputItem formClientName" type="text" name="report[0][client_name]" 
                                        value="" oninput="inputE()" onfocus="focusE(this)" onblur="blurE()" formhelpertag="form0" autocomplete="off">
                                    </td>
                                    <td class="col-2 align-middle text-center">
                                        <input type="time" class="form-control inputItem" id="formClientId" name="report[0][working_time]" value="">
                                    </td>
                                    <td class="col-3 align-middle text-center">
                                        <select tag="1" class="form-select selectItem" aria-label="Default select example" name="report[0][operation_id]" onchange="selectBoxChange(this)">
                                            <option value="0" selected>選択してください</option>
                                            @foreach($operations as $operation)
                                                <option value="{{$operation->id}}">{{$operation->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="d-none">
                                            <br>
                                            <input type="text" class="form-control" name="report[0][url]" value="http://dammy" placeholder="本番URLを入力">
                                        </span>
                                    </td>
                                    <td class="col-1 align-middle text-center"></td>
                                </tr>
                            @else
                                @foreach($reports as $key => $report)
                                <tr fieldid="{{$key}}">
                                    <td class="col-1 align-middle text-center has-validation">
                                        @if($errors->first("report." . $i . ".project_id") == "")
                                            <input type="text" class="form-control inputItem formProjectId" name="report[{{$key}}][project_id]" value="{{$report['project_id']}}" oninput="onInput(this)" onfocus="onFocus(this)" onblur="onBlur(this)" autocomplete="off">
                                        @else
                                            <input type="text" class="form-control inputItem formProjectId is-invalid" name="report[{{$key}}][project_id]" value="{{$report['project_id']}}" oninput="onInput(this)" onfocus="onFocus(this)" onblur="onBlur(this)" autocomplete="off">
                                        @endif
                                    </td>
                                    <td class="col-2 align-middle text-center">
                                        @if($errors->first("report." . $i . ".project_name") == "")
                                            <input type="text" class="form-control inputItem formProjectId" name="report[{{$key}}][project_name]" value="{{$report['project_name']}}" oninput="onInput(this)" onfocus="onFocus(this)" onblur="onBlur(this)" autocomplete="off">
                                        @else
                                            <input type="text" class="form-control inputItem formProjectId is-invalid" name="report[{{$key}}][project_name]" value="{{$report['project_name']}}" oninput="onInput(this)" onfocus="onFocus(this)" onblur="onBlur(this)" autocomplete="off">
                                        @endif
                                    </td>
                                    <td class="col-2 align-middle text-center">
                                        @if($errors->first("report." . $i . ".client_name") == "")
                                            <input type="text" class="form-control inputItem formProjectId" name="report[{{$key}}][client_name]" value="{{$report['client_name']}}" oninput="onInput(this)" onfocus="onFocus(this)" onblur="onBlur(this)" autocomplete="off">
                                        @else
                                            <input type="text" class="form-control inputItem formProjectId is-invalid" name="report[{{$key}}][client_name]" value="{{$report['client_name']}}" oninput="onInput(this)" onfocus="onFocus(this)" onblur="onBlur(this)" autocomplete="off">
                                        @endif
                                    </td>
                                    <td class="col-2 align-middle text-center has-validation">
                                        @if($errors->first("report." . $i . ".working_time") == "")
                                            <input type="time" class="form-control inputItem" id="formClientId" name="report[{{$key}}][working_time]" value="{{$report['working_time']}}">
                                        @else
                                            <input type="time" class="form-control inputItem is-invalid" id="formClientId" name="report[{{$key}}][working_time]" value="{{$report['working_time']}}">
                                        @endif
                                    </td>
                                    <td class="col-3 align-middle text-center has-validation">
                                        @if($errors->first("report." . $i . ".operation_id") == "")
                                        <select tag="{{$key}}" class="form-select selectItem" aria-label="Default select example" name="report[{{$key}}][operation_id]" onchange="selectBoxChange(this)">    
                                        @else                    
                                        <select tag="{{$key}}" class="form-select selectItem is-invalid" aria-label="Default select example" name="report[{{$key}}][operation_id]" onchange="selectBoxChange(this)">
                                        @endif
                                            <option value="0">選択してください</option>
                                            @foreach($operations as $operation)
                                                @if($report['operation_id'] == $operation->id)
                                                    <option value="{{$operation->id}}" selected>{{$operation->name}}</option>
                                                @else
                                                    <option value="{{$operation->id}}">{{$operation->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if($report["operation_id"] != 4)
                                            <span class="d-none">
                                                <br>
                                                <input type="text" class="form-control" name="report[{{$key}}][url]" value="http://dammy" placeholder="本番URLを入力">
                                            </span>                                           
                                        @elseif(!$errors->first("report." . $i . ".url") == "")
                                            <span>
                                                <br>
                                                <input type="text" class="form-control is-invalid" name="report[{{$key}}][url]" value="{{ isset($report['url']) ? $report['url'] : 'URLを入力して下さい' }}" placeholder="本番URLを入力">
                                            </span>
                                        @else
                                            <span>
                                                <br>
                                                <input type="text" class="form-control" name="report[{{$key}}][url]" value="{{$report['url']}}" placeholder="本番URLを入力">
                                            </span>
                                        @endif
                                    </td>
                                    <td class="col-1 align-middle text-center">
                                        @if($key != 0)
                                            <button type="button" class="btn btn-danger" deleteId="{{$key}}"><i class="fas fa-minus-circle"></i></button>
                                        @endif
                                    </td>
                                </tr>
                                @php
                                 $i++;
                                @endphp
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <a href="{{route('reportList')}}" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> 日報一覧へ戻る</a>　
                    <button type="submit" class="btn btn-dark" id="formButton"><i class="fas fa-plus-circle"></i> 日報を登録</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- /コンテンツ -->
@endsection

@push('js')
<script src="{{ asset('js/formhelper.js') }}"></script>
<script src="{{ asset('js/report/input.js') }}"></script>
@endpush