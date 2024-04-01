<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
        <x-slot name="header">
            <head>
                <meta charset = "utf-8">
                <title>日記閲覧画面</title>
            </head>
        </x-slot>
        <body>
            <form action = "{{ route('admin.d_update', ['diary' => $diary->id]) }}" method = "POST" enctype = "multipart/form-data">
                @csrf
                @method('PUT')
                <input type = "text" name = "diary[id]" value = "{{ $diary->id }}">
                
                <input type = "text" name = "diary[start]" value = "{{ old(('diary.start'),$diary->start) }}">
                <p class="start__error" style="color:red">{{ $errors->first('diary.start') }}</p>
                
                <input type = "text" name = "diary[title]" value = "{{ old(('diary.title'),$diary->title) }}">
                <p class="title__error" style="color:red">{{ $errors->first('diary.title') }}</p>
                
                <input type = "file" name = "files[]" multiple accept=".gif, .jpg, .jpeg, .png" class = "form-control" >
                @foreach($errors->get('files') as $message)
                <p class="file__error" style="color:red">{{ $message }}</p>
                @endforeach
                <p class="file__error" style="color:red">{{ $errors->first('files.*') }}</p>
                
                @foreach($diary->diary_images as $diary_image)
                <img src = "{{ asset($diary_image->path) }}" width = "200" height = "150">
                @endforeach
                
                <textarea name="diary[comment]" >{{ old(('diary.comment'),$diary->comment) }}</textarea>
                <p class="comment__error" style="color:red">{{ $errors->first('diary.comment') }}</p>
                <button type = "submit">保存</button>
            </form>
            <a href="{{ route('admin.d_show') }}">戻る</a>
            
            <center><a href="{{ route('admin.index') }}">目次に戻る</a></center>
        </body>
    </x-app-layout>
</html>