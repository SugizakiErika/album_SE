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
            
            @foreach($diary as $diary_my_events)
            <p>{{ $diary_my_events->title }}</p>
            <p>{{ $diary_my_events->start}}</p>
            <p>{{ $diary_my_events->comment }}</p>
            @foreach($diary_my_events->diary_images as $diary)
            <img src = "{{ asset($diary->path) }}" width="200" height="150">
            @endforeach
            @endforeach
        </body>
    </x-app-layout>
</html>