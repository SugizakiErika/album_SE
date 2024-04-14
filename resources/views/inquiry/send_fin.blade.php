@extends('adminlte::page')
@section('title', '問い合わせ')
@section('content_header')
    <h1>問い合わせ完了</h1>
@stop
@section('content')
        
            <label>{{ $name }}様</label>
            <p>お問い合わせありがとうございます。</p>
            <label>問い合わせ内容</label>
            <p>{{ $comment }}</p>
            <label>問い合わせコード</label>
            <p>{{ $inquiry_code }}</p>
        
@stop