<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset = "UTF-8">
        <title>日記登録画面</title>
    </head>
    <body>
        <form method = "POST" action = "/create" enctype = "multipart/form-data">
            @csrf
            <input type = "text" name = "date" value="{{ $date }}">
            <input type = "file" name = "file[]" class = "form-control">
            <button type = "submit">登録</button>
        </form>
        
        @foreach($diary_images as $diary_image)
        
        <img src = "{{ asset($diary_image->path) }}">
        
        @endforeach
    </body>
</html>