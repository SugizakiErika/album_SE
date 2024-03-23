<!DOCTYPE html>
<html lang = "{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
        <x-slot name="header">
            <head>
                <meta charset = "UTF-8">
                <title>問い合わせ</title>
            </head>
        </x-slot>
        <body>
            <p>{{ $name }}様</p>
            <p>お問い合わせありがとうございます。</p>
            <p>問い合わせ内容</p>
            <p>{{ $comment }}</p>
        
        </body>
    </x-app-layout>
</html>