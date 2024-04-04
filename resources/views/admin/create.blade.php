@extends('adminlte::page')
    @section('title', 'お知らせメール作成')
    @section('content_header')
        <h1>お知らせメール作成</h1>
    @stop
        @section('content')
            <form method = "POST" action = "{{ route('admin.store') }}" enctype = "multipart/form-data">
                @csrf
                <label>タイトル</label>
                <input type = "text" name = "admin[title]" size="30" placeholder = "タイトル" value = "{{ old('admin.title') }}"/>
                <p class="start__error" style="color:red">{{ $errors->first('admin.title') }}</p>
                
                <label>内容</label>
                <textarea name = "admin[comment]" rows="5" cols="45" placeholder = "内容を入力してください"/>{{ old('admin.comment') }}</textarea>
                <p class="comment__error" style="color:red">{{ $errors->first('admin.comment') }}</p>
                
                <button type = "submit">送信</button>
            </form>
         @push('css')
        <style type="text/css">

            label, input {
                display: block;
            }
            
        </style>
        @endpush
        @stop