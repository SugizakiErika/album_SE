<!DOCTYPE html>
<html lang = "{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset = "UTF-8">
        <title>日記登録画面</title>
    </head>
    <body>
        <form method = "POST" action = "{{ route('store.diary') }}" enctype = "multipart/form-data">
            @csrf
            <input type = "text" name = "diary[start]" value = "{{ $date }}" readonly>
            <input type = "text" name = "diary[title]" placeholder = "タイトルを入力してください"/>
            <input type = "file" name = "file[]" class = "form-control" multiple>
            <textarea name="diary[comment]" placeholder="コメントを入力してください"></textarea>
            <button type = "submit">登録</button>
        </form>
        
        <!--画像確認用-->
        @foreach($diary_images as $diary_image)
        
        <img src = "{{ asset($diary_image->path) }}" width="200" height="150">
        
        @endforeach
        
        <a href="{{ route('calendar') }}">カレンダーに戻る</a>
    </body>
</html>