@extends('adminlte::page')
@section('title', '問い合わせ一覧')
@section('content_header')
    <h1>問い合わせ一覧</h1>
@stop
    @section('content')
    @foreach($inquiry_lists as $inquiry_list)
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title"><label>タイトル : {{ $inquiry_list->title }}</label></h3>
            </div>
            <div class="card-body">
                <label>内容</label>
                <p>{{ $inquiry_list->comment }}</p>
                <label>問い合わせコード</label>
                <p>{{ $inquiry_list->inquiry_code }}</p>
                <div class="card-footer">
                    <label>問い合わせ者</label>
                    <label>ユーザーID : {{ $inquiry_list->users_id }}&emsp;ユーザー名 : {{ $inquiry_list->user_id }}</label>
                    <label>メールアドレス：{{ $inquiry_list->email }}</label>        
                </div>
            </div>
        </div>
        @endforeach
            @push('css')
            <style type="text/css">
                label{
                    display: block;
                }
            </style>
        @endpush
@stop       