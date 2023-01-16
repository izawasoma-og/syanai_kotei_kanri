@extends('layouts.app')
@section('title', '顧客情報一覧')

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
        <a href="{{route('clientAdd')}}" class="btn btn-dark"><i class="fas fa-user-plus"></i> 新規顧客情報登録</a>
    </div>

    <div class="w-100 mt-5 row g-0">
        <form class="w-50 d-flex" action="" method="GET">
            <div class="col-12">
                <div class="input-group">
                    <input type="text" class="form-control" name="key" placeholder="キーワードを入力" value="{{ $keyword }}">
                    <input type="hidden" name="sort" value="{{ $sort }}">
                    <button class="btn btn-dark" type="submit" id="button-addon2"><i class="fas fa-search"></i> 検索</button>
                </div>
            </div>
        </form>
        <div class="w-50">
            <div class="d-flex justify-content-end">
                {{ $clients->appends(request()->query())->links('components.pagenate.head') }}
            </div>
        </div>
    </div>
    <table class="table table-striped w-100 mx-auto mt-4 table-bordered">
        <tr class="table-dark">
            <th class="col-2">
                # <i class="fas fa-key"></i>　
                <a href="{{route('clientList',['key'=>$keyword,'sort'=>'asc'])}}" class="{{ $up }}"><i class="fas fa-caret-square-up"></i></a>
                <a href="{{route('clientList',['key'=>$keyword,'sort'=>'desc'])}}" class="{{ $down }}" aria-disabled="true"><i class="fas fa-caret-square-down"></i></a>
            </th>
            <th class="col-6">顧客名</th>
            <th class="col-2">操作</th>
        </tr>
        @foreach($clients as $client)
            <tr>
                <td class="col-2 align-middle">{{$client->id}}</td>
                <td class="col-9 align-middle">{{$client->name}}</td>
                <td class="col-1 align-middle text-center"><a href="{{ Route('clientEdit',$client->id) }}" class="btn btn-outline-dark"><i class="fas fa-edit"></i> 編集</a></td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center mt-5">
        {{ $clients->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</div>
<!-- /コンテンツ -->
@endsection

@push('js')
    <script src="{{ asset('js/client/add.js') }}"></script>
@endpush