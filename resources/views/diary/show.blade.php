@extends('adminlte::page')
    @section('title', '日記閲覧画面')
        @section('content_header')
        @stop
            @section('content')
        <div class="card card-outline card-info">
            <div class="card-body">
                <label>タイトル</label>
                <p>{{ $diary->title }}</p>
                <label>内容</label>
                <p>{{ $diary->comment }}</p>
                <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="far fa-bookmark"></i></span>
                        <div class="info-box-content">
                <label>登録されている画像</label>
                @foreach($diary->diary_images as $diary_image)
                    @if($diary_image->deleted_at == null)
                        <img src = "{{ asset($diary_image->path) }}" width="200" height="150">
                    @endif
                @endforeach
            </div>
                    </div>
                <button class="btn btn-info"><a href="/edit/{{ $diary->id }}">編集する</a></button>&emsp;
            
                <form action="{{ route('delete.diary', ['diary' => $diary->id]) }}" id="form_{{ $diary->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <br />
                    <button class="btn btn-info" type="button" onclick="deleteDiary({{ $diary->id }})">削除する</button> 
                </form>
                </div>
        </div>
                <script>
                    function deleteDiary(id) {
                        'use strict'
                        if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                            document.getElementById(`form_${id}`).submit();
                        }
                    }
                </script>
                @push('css')
                    <style type="text/css">

                    label, input, a {
                        display: block;
                    }
                    
                    </style>
                @endpush
            @stop