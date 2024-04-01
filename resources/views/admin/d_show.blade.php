<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
            <head>
                <meta charset = "utf-8">
                <title>日記閲覧画面</title>
            </head>
        <body>
            @foreach($diary as $data_diary)
            ユーザーID:{{ $data_diary->users_id }}
            日記ID:{{ $data_diary->id }}
            タイトル:{{ $data_diary->title }}
            内容:{{ $data_diary->comment }}
            
            @foreach($data_diary->diary_images as $diary_image)
            <img src = "{{ asset($diary_image->path) }}" width="200" height="150">
            @endforeach
            
            <a href="/admin/diary/create/{{ $data_diary->id }}">編集する</a>
            
            <form action="{{ route('admin.d_delete', ['diary' => $data_diary->id]) }}" id="form_{{ $data_diary->id }}" method="post">
                @csrf
                @method('DELETE')
                <button type="button" onclick="deleteDiary({{ $data_diary->id }})">削除する</button> 
            </form>
            @endforeach
            
            <center><a href="{{ route('admin.index') }}">目次に戻る</a></center>
            <script>
            function deleteDiary(id) {
                'use strict'
                if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                    document.getElementById(`form_${id}`).submit();
                }
            }
            </script>
        </body>
</html>