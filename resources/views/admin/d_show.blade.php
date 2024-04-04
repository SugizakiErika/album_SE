@extends('adminlte::page')
    @section('title', '日記閲覧画面')
        @section('content_header')
            <h1>個人イベント</h1>
        @stop
            @section('content')
            @foreach($diary as $data_diary)
                <label>ユーザーID : {{ $data_diary->users_id }}</label>
                
                <label>日記ID : {{ $data_diary->id }}</label>
                
                <label>タイトル : {{ $data_diary->title }}</label>
                
                <label>内容</label>
                <p>{{ $data_diary->comment }}</p>
                @if(!($data_diary->deleted_at == null))
                    <label>削除日時 : {{ $data_diary->deleted_at }}</label>
                @endif
            
                @foreach($data_diary->diary_images as $diary_image)
                    <img src = "{{ asset($diary_image->path) }}" width="200" height="150">
                @endforeach
                @if(!$data_diary->deleted_at == null)
                    <a href="/admin/diary/create/{{ $data_diary->id }}">削除取り消し</a>
                @else
                <form action="{{ route('admin.d_delete', ['diary' => $data_diary->id]) }}" id="form_{{ $data_diary->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit">削除する</button> 
                </form>
                @endif
                @endforeach
                <style type="text/css">
            
                label {
                    display: block;
                }
            
                </style>
            @stop