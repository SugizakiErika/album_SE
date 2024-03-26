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
            {{ $normal_event->start }}
            {{ $normal_event->title }}
            {{ $normal_event->explanation }}
            {{ $normal_event->todo }}
            
        </body>
    </x-app-layout>
</html>