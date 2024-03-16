<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset = "UTF-8">
        <title>日記登録画面</title>
    </head>
    <body>
        <form method = "POST" action = "/create" enctype = "multipart/form-data">
            @csrf
            <p>{{ $date }}</p>
            <input type = "file" name = "file[]" class = "form-control" multiple>
            <textarea name="comment" placeholder="コメントを記入してください"></textarea>
            <button type = "submit">登録</button>
        </form>
        
        @foreach($diary_images as $diary_image)
        
        <img src = "{{ asset($diary_image->path) }}">
        
        @endforeach
    </body>
</html>