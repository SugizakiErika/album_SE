<!DOCTYPE html>
<html lang = "{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset = "UTF-8">
        <title>問い合わせ</title>
    </head>
    <body>
        <p>{{ $name }}様</p>
        <p>お問い合わせありがとうございます。</p>
        <p>問い合わせ内容</p>
        <p>{{ $comment }}</p>
        
        <a href="{{ route('calendar') }}">カレンダーに戻る</a>
    </body>
</html>