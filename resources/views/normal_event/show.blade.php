@extends('adminlte::page')
    @section('title', '日記閲覧画面')
        @section('content_header')
            <h1>日記閲覧</h1>
        @stop
        @section('content')
        <div class="card card-outline card-info">
            <div class="card-body">
                <label>タイトル : {{ $normal_event->title }}</label>
                <label>日付 : {{ $normal_event->start }}</label>
            
                <label>説明</label>
                <p>{{ $normal_event->explanation }}</p>
                <label>すること</label>
                <p>{{ $normal_event->todo }}</p>
            </div>
        </div>
        <style type="text/css">
            
        label, p {
                display: block;
                }
        </style>
    @stop