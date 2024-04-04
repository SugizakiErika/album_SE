@extends('adminlte::page')
    @section('title', '問い合わせ')
        @section('content_header')
            <h1>問い合わせ</h1>
        @stop
        @section('content')
            <form method = "POST" action = "{{ route('inquiry.store') }}" enctype = "multipart/form-data">
                @csrf
                <label>タイトル</label>
                <input type = "text" name = "inquiry[title]" size="30" placeholder = "タイトル" value = "{{ old('inquiry.title') }}"/>
                <p class="start__error" style="color:red">{{ $errors->first('inquiry.title') }}</p>
                
                <label>内容</label>
                <p>なるべく詳細に記載をお願いいたします。</p>
                <textarea name = "inquiry[comment]" rows="5" cols="45" placeholder = "お困りごとを入力してください"/>{{ old('inquiry.comment') }}</textarea>
                <p class="comment__error" style="color:red">{{ $errors->first('inquiry.comment') }}</p>
                
                <label>ユーザーID</label>
                <input type = "text" name = "inquiry[user_id]" value = {{ old(('inquiry.user_id'),Auth::user()->name)}}>
                <p class="user_id__error" style="color:red">{{ $errors->first('inquiry.user_id') }}</p>
                
                <label>メールアドレス</label>
                <input type="email" name = "inquiry[email]" size="30" value = {{ old(('inquiry.email'),Auth::user()->email) }}>
                <p class="email__error" style="color:red">{{ $errors->first('inquiry.email') }}</p>
                
                <button type = "submit">送信</button>
            </form>
            @push('css')
            <style type="text/css">

                label, input {
                    display: block;
                }
            </style>
            @endpush
        @stop