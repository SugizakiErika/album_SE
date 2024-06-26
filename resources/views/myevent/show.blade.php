@extends('adminlte::page')
    @section('title', '個人イベント内容確認画面')
        @section('content_header')
            <h1>個人イベントの説明</h1>
        @stop
        @section('content')
        <div class="card card-outline card-info">
            <div class="card-body">
                <label>タイトル</label>
                <p>{{ $my_event->title }} 
                <?php 
                    $mycategory = $my_event->category;
                ?>
                @if($mycategory == "birthday")
                    の誕生日
                @elseif($mycategory == "anniversary")
                    記念日
                @elseif($mycategory == "others")
                    その他
                @endif
                </p>
                <label>日付</label>
                <p>{{ $my_event->start }}</p>
            </div>
        </div>
            
        <h3>{{ $my_event->start }}の去年以降の投稿↓</h3>
        @foreach($diary as $diary_my_events)
            <div class="card card-outline card-info">
                <div class="card-body">
                    <label>タイトル</label>
                    <p>{{ $diary_my_events->title }}</p>
                    <label>日付</label>
                    <p>{{ $diary_my_events->start}}</p>
                    <label>内容</label>
                    <p>{{ $diary_my_events->comment }}</p>
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="far fa-bookmark"></i></span>
                            <div class="info-box-content">
                            <label>画像</label>
                                <div class="file_path">
                                    @foreach($diary_my_events->diary_images as $diary)
                                        <img src = "{{ asset($diary->path) }}" width="200" height="150">
                                    @endforeach
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        @endforeach
            <style type="text/css">
                .file_path {
                    display: flex;
                }
                label, p {
                    display: block;
                }
            
            </style>
        @stop