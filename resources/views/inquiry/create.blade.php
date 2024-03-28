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
                <input type = "text" name = "inquiry[title]" placeholder = "タイトル" value = "{{ old('inquiry.title') }}"/>
                <p class="start__error" style="color:red">{{ $errors->first('inquiry.title') }}</p>
                
                <textarea name = "inquiry[comment]" placeholder = "内容を入力してください"/>{{ old('inquiry.comment') }}</textarea>
                <p class="comment__error" style="color:red">{{ $errors->first('inquiry.comment') }}</p>
                
                <input type = "text" name = "inquiry[user_id]" value = {{ old(('inquiry.user_id'),Auth::user()->name)}}>
                <p class="user_id__error" style="color:red">{{ $errors->first('inquiry.user_id') }}</p>
                
                <input type="email" name = "inquiry[email]" value = {{ old(('inquiry.email'),Auth::user()->email) }}>
                <p class="email__error" style="color:red">{{ $errors->first('inquiry.email') }}</p>
                
                <button type = "submit">送信</button>
            </form>
        </body>
    </x-app-layout>
</html>