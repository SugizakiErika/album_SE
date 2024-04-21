@extends('adminlte::page')
    @section('title', '日記閲覧画面')
        @section('content_header')
            <h1>日記編集</h1>
        @stop
            @section('content')
            @foreach($diary as $data_diary)
            <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"><label>ユーザーID : {{ $data_diary->users_id }}&emsp;日記ID : {{ $data_diary->id }}</label></h3>
            </div>
            <div class="card-body">
                <label>タイトル : {{ $data_diary->title }}</label>
            
                <label>内容</label>
                <p>{{ $data_diary->comment }}</p>
                @if(!($data_diary->deleted_at == null))
                    <label>削除日時 : {{ $data_diary->deleted_at }}</label>
                @endif
            
                @foreach($data_diary->diary_images as $diary_image)
                    <img src = "{{ asset($diary_image->path) }}" width="200" height="150">
                @endforeach
                <br />
                @if(!$data_diary->deleted_at == null)
                <br />
                    <button class="btn btn-info"><a href="/admin/diary/create/{{ $data_diary->id }}">削除取り消し</a></button>
                @else
                <br />
                <form action="{{ route('admin.d_delete', ['diary' => $data_diary->id]) }}" id="form_{{ $data_diary->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-info" type="submit">削除する</button> 
                </form>
                @endif
                </div>
                @endforeach
                <style type="text/css">
            
                label {
                    display: block;
                }
            
                </style>
            @stop