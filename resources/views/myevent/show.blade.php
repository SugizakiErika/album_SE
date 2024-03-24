<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
        <x-slot name="header">
            <head>
                <meta charset = "utf-8">
                <title>個人行事内容確認画面</title>
            </head>
        </x-slot>
        <body>
            <p>{{ $my_event->id }}</p>
            <p>{{ $my_event->title }}</p>
            <p>{{ $my_event->start }}</p>
            <p>{{ $my_event->category }}</p>
            
            @foreach($diaries as $diary_my_event)
            <p>{{ $diary_my_event->title }}</p>
            <p>{{ $diary_my_event->start}}</p>
            <p>{{ $diary_my_event->comment }}</p>
            <img src = "{{ asset($diary_my_event->diary_image->path) }}" width="200" height="150">
            @endforeach
        </body>
    </x-app-layout>
</html>