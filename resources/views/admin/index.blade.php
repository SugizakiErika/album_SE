<!DOCTYPE html>
<html lang = "{{ str_replace('_', '-', app()->getLocale()) }}">
    
            <head>
                <meta charset = "UTF-8">
                <title>日記登録画面</title>
            </head>
        <body>
            <center><a href="{{ route('admin.create') }}">お知らせメールの作成</a></center>
            <center><a href="{{ route('admin.d_show') }}">日記一覧</a></center>
        </body>
</html>