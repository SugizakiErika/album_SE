<!DOCTYPE html>
<html lang = "{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
        <x-slot name="header">
            <head>
                <meta charset = "UTF-8">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <!--jQuery:ajax通信用CDN-->
                <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
                <title>通常行事登録画面</title>
                <script>
            $(function(){
                $('#ajax_submit').on('click', function(){
                
                    // 入力する値の取得
                    var input_id = document.getElementById('ajax_input_id');
                    var input_notice = document.getElementById('ajax_input_notice');
                    var input_day_num = document.getElementById('ajax_input_day_num');
                    
                    
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  // CSRFトークンの設定
                        type: "post",
                        url: "/normalevent/create",
                        dataType: "text",
                        scriptCharset: "utf-8",
                        data: {
                            "ajax_input_id" : input_id.value,
                            "ajax_input_notice" : input_notice.value,
                            "ajax_input_day_num" : input_day_num.value
                        },
                    }).done(function (results) {
                        // 通信成功時の処理
                        alert('送信成功');
                    }).fail(function (jqXHR, textStatus, errorThrown) {
                        // 通信失敗時の処理
                        alert('ファイルの取得に失敗しました。');
                        console.log("ajax通信に失敗しました");
                        console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
                        console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
                        console.log("errorThrown    : " + errorThrown.message); // 例外情報
                        console.log("URL            : " + url);
                    });
                });
            })
            
        </script>
            </head>
        </x-slot>
        <body>
        
            @foreach($users->normal_events as $normal_event)
            
                <p>{{ $normal_event->title }}</p>
                <p>{{ $normal_event->start }}</p>
                <input type="text" id="ajax_input_id" name="n_event[id]" value="{{ $normal_event->id }}"/>
                
                <select id="ajax_input_notice" name="n_event[notice]">
                    <option value="0">OFF</option>
                    <option value="1">ON</option>
                </select>
            
                <input type="number" id="ajax_input_day_num" inputmode="numeric" name="n_event[day_num]" value = "{{ $normal_event->pivot->day_num }}"/>
                
                
                <button id="ajax_submit" type = "submit">[登録]</button>
                
            @endforeach
            
        </body>
    </x-app-layout>
</html>