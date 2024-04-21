@extends('adminlte::page')
    @section('title', '日記閲覧画面')
        @section('content_header')
        @stop
            @section('content')
            <div class="card card-outline card-info">
                <div class="card-body">
                    <label>日記を作成したユーザーに許可されていません</label>
                    <label>フォロー申請を行ってください</label>
                </div>
            </div>
            @push('css')
                <style type="text/css">

                label, input, button, a {
                    display: block;
                }
                    
                </style>
            @endpush
    @stop