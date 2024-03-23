<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
        <x-slot name="header">
            <head>
                <meta charset = "utf-8">
                <title>日記閲覧画面</title>
            </head>
        </x-slot>
        <body>
            <form method = "POST" action = "/edit/{{ $diary->id }}" enctype = "multipart/form-data">
                @csrf
                @method('PUT')
                <input type = "text" name = "diary[start]" value = "{{ $diary->start }}" readonly>
                <input type = "text" name = "diary[title]" value = "{{ $diary->title }}">
                <input type = "file" name = "file[]" class = "form-control" multiple>
                <img src = "{{ asset($diary->diary_image->path) }}" width="200" height="150">
                <textarea name="diary[comment]" >{{ $diary->comment }}</textarea>
                <button type = "submit">保存</button>
            </form>
            <a href="/show/{{ $diary->id }}">戻る</a>
        </body>
    </x-app-layout>
</html>