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
            <form method = "POST" action = "{{ route('inquiry.store') }}" enctype = "multipart/form-data">
                @csrf
                <input type = "text" name = "inquiry[title]" placeholder = "タイトル"/>
            
                <input type = "text" name = "inquiry[comment]" placeholder = "内容を入力してください"/>
                <input type = "text" name = "inquiry[user_id]" value = {{ Auth::user()->name}}>
                <input type="email" name = "inquiry[email]" value = {{ Auth::user()->email }}>
                <button type = "submit">送信</button>
            </form>
        </body>
    </x-app-layout>
</html>