<!DOCTYPE html>
<html lang = "{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
        <x-slot name="header">
            <head>
                <meta charset = "UTF-8">
                 <!--jQuery:ajax通信用CDN-->
                <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
                
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
                <button id="submit_post" type = "submit">[登録]</button>
            </form>
            
            @foreach($my_events as $my_event)
            
            <?php $my_event->start ="2024-".$my_event->start; ?>
                <input type="hidden" name="m_id" value="{{ $my_event->id }}"/>
                <input type = "text" name = "m_title" value = "{{ $my_event->title }}"/>
                
                <select name="m_category">
                    <option value="birthday" @if($my_event->category == "birthday") selected @endif>の誕生日</option>
                    <option value="anniversary" @if($my_event->category == "anniversary") selected @endif)>記念日</option>
                    <option value="others" @if($my_event->category == "others") selected @endif>その他</option>
                </select>
            
                <input name="m_start" type="date" value="{{ $my_event->start }}"/>
                <input type="text" inputmode="numeric" name="m_day" value ="{{ $my_event->day }}"日前/>
            @endforeach
            <button id="submit_put" type = "submit">[変更]</button>
        
        <script>
                $(function(){
                    $("#submit_put").on('click', function(){
                        // 入力する値の取得
                        var input_id = document.getElementsByName('m_id');
                        var input_title = document.getElementsByName('m_title');
                        var input_category = document.getElementsByName('m_category');
                        var input_start = document.getElementsByName('m_start');
                        var input_day = document.getElementsByName('m_day');
                        
                        for(let i=0; i<input_id.length; i++){
                    
                            $.ajax({
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  // CSRFトークンの設定
                                type: "put",
                                url: "/myevent/update",
                                dataType: "text",
                                scriptCharset: "utf-8",
                                data: {
                                    "ajax_input_id" : input_id[i].value,
                                    "ajax_input_title" : input_title[i].value,
                                    "ajax_input_category" : input_category[i].value,
                                    "ajax_input_start" : input_start[i].value,
                                    "ajax_input_day" : input_day[i].value
                                },
                            }).done(function (results) {
                                // 通信成功時の処理
                                console.log(results);
                                if(i == input_id.length-1){
                                alert('個人行事の登録内容を変更しました');
                                }else{
                                console.log(i);
                                }
                            }).fail(function (jqXHR, textStatus, errorThrown) {
                                // 通信失敗時の処理
                                alert('ファイルの取得に失敗しました。');
                                console.log("ajax通信に失敗しました");
                                console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
                                console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
                                console.log("errorThrown    : " + errorThrown.message); // 例外情報
                            });
                        }
                    });
                })
        </script>
        </body>
    </x-app-layout>
</html>