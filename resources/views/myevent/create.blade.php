<!DOCTYPE html>
<html lang = "{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
        <x-slot name="header">
            <head>
                <meta charset = "UTF-8">
                <title>個人イベント登録画面</title>
            </head>
        </x-slot>
        <body>
            <form method = "POST" action = "{{ route('store.myevent') }}" enctype = "multipart/form-data">
                @csrf
                <input type = "text" name = "myevent[title]" placeholder = "タイトル"/>
                
                <select name="myevent[category]">
                    <option value="birthday">の誕生日</option>
                    <option value="anniversary">記念日</option>
                    <option value="others">その他</option>
                </select>
            
                <input name="myevent[start]" type="date"/>
                <input type="text" inputmode="numeric" name="myevent[day]" placeholder="何日前">
                <button type = "submit">[登録]</button>
            </form>
            
            <!--個人行事一覧-->
            @foreach($my_events as $my_event)
            
            <?php
               $my_event->start =str_replace('-','月',$my_event->start);
            ?>
            
            {{ $my_event->title }}
            {{ $my_event->category }}
            {{ $my_event->start }}日
            {{ $my_event->day }}日前
                        
            <a href="/myevent/edit/{{ $my_event->id }}">編集する</a>
            
            @endforeach
            
        </body>
    </x-app-layout>
</html>