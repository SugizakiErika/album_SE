<!DOCTYPE html>
<html lang = "{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset = "UTF-8">
        <title>問い合わせ</title>
    </head>
    <body>
        <form method = "POST" action = "{{ route('inquiry.store') }}" enctype = "multipart/form-data">
            @csrf
            <input type = "text" name = "inquiry[title]" placeholder = "タイトル"/>
            
            <input type = "text" name = "inquiry[comment]" placeholder = "内容を入力してください"/>
            <input type = "text" name = "inquiry[user_id]" value = "ユーザーID"/>
            <input type="email" name = "inquiry[email]" placeholder="sample@example.com"/>
            <button type = "submit">登録</button>
        </form>
        
        <a href="{{ route('calendar') }}">カレンダーに戻る</a>
    </body>
</html>