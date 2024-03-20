<!DOCTYPE html>
<html lang = "{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset = "UTF-8">
        <title>個人イベント登録画面</title>
    </head>
    <body>
        <form method = "POST" action = "{{ route('store.myevent') }}" enctype = "multipart/form-data">
            @csrf
            <input type = "text" name = "myevent[title]" placeholder = "タイトル"/>
            <select name="myevent[category]">
                <option value="birthday">誕生日</option>
                <option value="anniversary">記念日</option>
                <option value="others">その他</option>
            </select>
            
            <input name="myevent[start]" type="date"/>
            <input type="text" inputmode="numeric" name="myevent[day]" placeholder="何日前">
            <button type = "submit">登録</button>
        </form>
        
        <a href="{{ route('calendar') }}">カレンダーに戻る</a>
    </body>
</html>