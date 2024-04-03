@extends('adminlte::page')
@section('title', '日記登録画面')
@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('content')
    <p>Welcome to this beautiful admin panel.</p>

            <center><a href="{{ route('admin.create') }}">お知らせメールの作成</a></center>
            <center><a href="{{ route('admin.d_show') }}">日記一覧</a></center>
@stop       