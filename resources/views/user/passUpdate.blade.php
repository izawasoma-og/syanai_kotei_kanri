@extends('layouts.app')
@section('title', 'パスワード変更')

@push('css')

@endpush

@section('content')
<!-- コンテンツ -->
<div class="container">
    <div class="col-md-8 mt-5 w-75 mx-auto">
        <div class="card">
            <div class="card-header">パスワード変更</div>
            <div class="card-body">
                <form method="post" action="/passUpdate">
                    @csrf
                    <div class="mb-3">
                        <label for="newPass" class="form-label">新しいパスワード　<span class="badge bg-danger">必須</span></label>
                        <input type="password" class="form-control" id="newPass" name="newPass" value="">
                        <div class="form-text">8文字以上の半角英数字で設定してください。</div>
                    </div>
                    <div class="mb-1">
                        <label for="confirmPass" class="form-label">確認用パスワード　<span class="badge bg-danger">必須</span></label>
                        <input type="password" class="form-control" id="confirmPass" name="newPass_confirmation" value="">
                    </div>
                    <div id="formNameError" class="form-text text-danger mb-3">
                        @if ($errors->has('newPass'))
                            {{$errors->first('newPass')}}
                        @endif　
                    </div>
                    <div class="modal" tabindex="-1" id="confirmModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <p class="modal-title">警告</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal('confirmModal')"></button>
                                </div>
                                <div class="modal-body">
                                 <p>パスワードを変更した場合、前回のパスワードでログインできなくなりますが、よろしいですか？</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal('confirmModal')">いいえ</button>
                                    <button type="submit" class="btn btn-primary">はい</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-dark" id="formButton" onclick="openModal('confirmModal')"><i class="fas fa-wrench"></i> パスワードを変更する</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- /コンテンツ -->
@endsection

@push('js')
<script src="{{ asset('js/modal.js') }}"></script>
@endpush