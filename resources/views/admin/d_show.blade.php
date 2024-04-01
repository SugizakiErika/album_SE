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
            削除日時:{{ $data_diary->deleted_at }}
            
            @foreach($data_diary->diary_images as $diary_image)
            <img src = "{{ asset($diary_image->path) }}" width="200" height="150">
            @endforeach
            @if(!$data_diary->deleted_at == null)
            <a href="/admin/diary/create/{{ $data_diary->id }}">削除取り消し</a>
            @else
            <form action="{{ route('admin.d_delete', ['diary' => $data_diary->id]) }}" id="form_{{ $data_diary->id }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit">削除する</button> 
            </form>
            @endif
            @endforeach
            
            <center><a href="{{ route('admin.index') }}">目次に戻る</a></center>
            
        </body>
</html>