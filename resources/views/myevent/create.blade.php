<!DOCTYPE html>
<html lang = "{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
        <x-slot name="header">
            <head>
                <meta charset = "UTF-8">
                 <!--jQuery:ajax通信用CDN-->
                <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
                <!--jQuery:バリデーション用だがあくまでフロント部分-->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
                <title>個人イベント登録画面</title>
            </head>
        </x-slot>
        <body>
            <!--登録-->
            <form method = "POST" action = "{{ route('store.myevent') }}" enctype = "multipart/form-data">
                @csrf
                <input type = "text" name = "myevent[title]" placeholder = "タイトル" value = "{{ old('myevent.title') }}"/>
                <p class="title__error" style="color:red">{{ $errors->first('myevent.title') }}</p>
                
                <select name="myevent[category]">
                    <option value="birthday" @if(old('myevent.category')=="birthday") selected @endif>の誕生日</option>
                    <option value="anniversary" @if(old('myevent.category')=="anniversary") selected @endif>記念日</option>
                    <option value="others" @if(old('myevent.category')=="others") selected @endif>その他</option>
                </select>
                <p class="category__error" style="color:red">{{ $errors->first('myevent.category') }}</p>
            
                <input name="myevent[start]" type="date"/>
                <p class="start__error" style="color:red">{{ $errors->first('myevent.start') }}</p>
                
                <input type="number" inputmode="numeric" name="myevent[day]" value = "5">
                <p class="day__error" style="color:red">{{ $errors->first('myevent.day') }}</p>
                
                <button id="submit_post" type = "submit">[登録]</button>
            </form>
            
            <!--変更-->
            <form method = "POST" action = "" id = "postForm" enctype = "multipart/form-data">
            @foreach($my_events as $my_event)
            
            <?php $my_event->start ="2024-".$my_event->start;?>
                <input type="hidden" name="m_id" value="{{ $my_event->id }}"/>
                <input type = "text" class = "form-control" name = "m_title" value = "{{ $my_event->title }}" />
                
                <select name="m_category">
                    <option value="birthday" @if($my_event->category == "birthday") selected @endif>の誕生日</option>
                    <option value="anniversary" @if($my_event->category == "anniversary") selected @endif)>記念日</option>
                    <option value="others" @if($my_event->category == "others") selected @endif>その他</option>
                </select>
                
                <input name="m_start" type="date" value="{{ $my_event->start }}"/>
                <input type="number" inputmode="numeric" name="m_day" value ="{{ $my_event->day }}"日前 />
                
                
                <form method="post" action="{{ route('delete.myevent', ['my_event' => $my_event->id]) }}" id="form_{{ $my_event->id }}" >
                @csrf
                @method('DELETE')
                <button type="button" onclick="deleteMyevent({{ $my_event->id }})">削除する</button> 
                </form>
                <script>
                function deleteMyevent(id) {
                    'use strict'
                    if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                        document.getElementById(`form_${id}`).submit();
                    }
                }
                </script>
            @endforeach
            <button id="submit_put" type = "submit">[変更]</button>
            </form>
            <script>
                var myeventValid = {
                    rules:{
                        m_title:{
                            required:true,
                            maxlength:10, //10文字以内
                        },
                        m_category:{
                            required:true,
                        },
                        m_start:{
                            required:true,
                            dateISO:true, //日付判定
                        },
                        m_day:{
                            required:true,
                            digits:true, //0以上の整数
                        }
                    },
                    messages:{
                        m_title:{
                            required:'タイトルを入力してください。',
                            maxlength:'10文字以内で入力してください。',
                        },
                        m_category:{
                            required:'カテゴリーを選択してください。',
                        },
                        m_start:{
                            required:'日付を選択してください。',
                            dateISO:'日付を入力してください。',
                        },
                        m_day:{
                            required:'タイトルを入力してください。',
                            digits:'0以上の整数を入力してください。'
                        }
                    },
                }
                        
                
                    
                //ajax通信を行う
                $(function(){
                    $("#submit_put").on('click', function(){
                    
                        $("#postForm").validate(myeventValid);
                        //失敗で戻る
                        if (!$("#postForm").valid()) {
                            return false;
                        };
                        
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
                                url: "{{ route('update.myevent')}}",
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