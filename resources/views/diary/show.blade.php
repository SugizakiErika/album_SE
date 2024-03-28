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
            {{ $diary->title }}
            {{ $diary->comment }}
            
            @foreach($diary->diary_images as $diary_image)
            <img src = "{{ asset($diary_image->path) }}" width="200" height="150">
            @endforeach
            
            <a href="/edit/{{ $diary->id }}">編集する</a>
            
            <form action="{{ route('delete.diary', ['diary' => $diary->id]) }}" id="form_{{ $diary->id }}" method="post">
                @csrf
                @method('DELETE')
                <button type="button" onclick="deleteDiary({{ $diary->id }})">削除する</button> 
            </form>
            <script>
            function deleteDiary(id) {
                'use strict'
                if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                    document.getElementById(`form_${id}`).submit();
                }
            }
            </script>
        </body>
    </x-app-layout>
</html>