@extends('adminlte::page')
@section('title', '問い合わせ一覧')
@section('content_header')
    <h1>問い合わせ一覧</h1>
@stop
    @section('content')
    @foreach($inquiry_lists as $inquiry_list)
            <label>タイトル : {{ $inquiry_list->title }}</label>
            <label>内容</label>
            <p>{{ $inquiry_list->comment }}</p>
            
            <label>問い合わせコード</label>
            <p>{{ $inquiry_list->inquiry_code }}</p>
            <label>ユーザーID : {{ $inquiry_list->users_id }}</label>
            <label>ユーザー名 : {{ $inquiry_list->user_id }}</label>
            <label>メールアドレス</label>        
            <p>{{ $inquiry_list->email }}</p>
        @endforeach
            @push('css')
            <style type="text/css">
                label, input {
                    display: block;
                }
            </style>
        @endpush
@stop       