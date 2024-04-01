<!DOCTYPE html>
<html lang = "{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
        <x-slot name="header">
            <head>
                <meta charset = "UTF-8">
                <title>お知らせ作成</title>
                </head>
        </x-slot>
        <body>
            <form method = "POST" action = "{{ route('admin.store') }}" enctype = "multipart/form-data">
                @csrf
                <input type = "text" name = "admin[title]" placeholder = "タイトル" value = "{{ old('admin.title') }}"/>
                <p class="start__error" style="color:red">{{ $errors->first('admin.title') }}</p>
                
                <textarea name = "admin[comment]" placeholder = "内容を入力してください"/>{{ old('admin.comment') }}</textarea>
                <p class="comment__error" style="color:red">{{ $errors->first('admin.comment') }}</p>
                
                <button type = "submit">送信</button>
            </form>
            <center><a href="{{ route('admin.index') }}">目次に戻る</a></center>
        </body>
    </x-app-layout>
</html>