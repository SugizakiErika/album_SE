<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset = "utf-8">
        <title>日記閲覧画面</title>
    </head>
    <body>
        {{ $diary->title }}
        {{ $diary->comment }}
        
        
        <img src = "{{ asset($diary->diary_image->path) }}" width="200" height="150">
        
    </body>
</html>