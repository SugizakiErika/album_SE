<!DOCTYPE html>
<html lang = "{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
        <x-slot name="header">
            <head>
                <meta charset = "UTF-8">
                <title>日記登録画面</title>
            </head>
        </x-slot>
        <body>
            <form method = "POST" action = "{{ route('store.diary') }}" enctype = "multipart/form-data">
            @csrf
            <input type = "text" name = "diary[start]" value = "{{ $date }}" readonly>
            <p class="start__error" style="color:red">{{ $errors->first('diary.start') }}</p>
            
            <input type = "text" name = "diary[title]" placeholder = "タイトルを入力してください" value = "{{ old('diary.title') }}"/>
            <p class="title__error" style="color:red">{{ $errors->first('diary.title') }}</p>
            
            
            
            <input type = "file" name = "files[]" multiple accept=".gif, .jpg, .jpeg, .png" class = "form-control" >
            @foreach($errors->get('files') as $message)
            <p class="file__error" style="color:red">{{ $message }}</p>
            @endforeach
            <p class="file__error" style="color:red">{{ $errors->first('files.*') }}</p>
            
            <textarea name="diary[comment]" placeholder="コメントを入力してください">{{ old('diary.comment') }}</textarea>
            <p class="comment__error" style="color:red">{{ $errors->first('diary.comment') }}</p>
            
            <button type = "submit">登録</button>
            </form>
        </body>
    </x-app-layout>
</html>