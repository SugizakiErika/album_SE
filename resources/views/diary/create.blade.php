<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>日記登録画面</title>
    </head>
    <body>
        <form method = "POST" action = "/create" enctype = "multipart/form-data">
            @csrf
            <input type = "file" name = "file[]" class = "form-control">
            <button type = "submit">登録</button>
        </form>
        
    </body>
</html>