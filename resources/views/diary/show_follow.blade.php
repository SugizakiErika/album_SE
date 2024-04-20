@extends('adminlte::page')
    @section('title', '日記閲覧画面')
        @section('content_header')
        @stop
            @section('content')
                <label>日記作成者：{{ $follow_name }}</label>
                <label>タイトル</label>
                <p>{{ $diary->title }}</p>
                <label>内容</label>
                <p>{{ $diary->comment }}</p>
                <label>登録されている画像</label>
                @foreach($diary->diary_images as $diary_image)
                    @if($diary_image->deleted_at == null)
                        <img src = "{{ asset($diary_image->path) }}" width="200" height="150">
                    @endif
                @endforeach
            
                
                </script>
                @push('css')
                    <style type="text/css">

                    label, input, button, a {
                        display: block;
                    }
                    
                    </style>
                @endpush
            @stop