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
            
            <img src = "{{ asset($diary->diary_image->path) }}" width="200" height="150">
            
            <a href="/edit/{{ $diary->id }}">編集する</a>
        </body>
    </x-app-layout>
</html>