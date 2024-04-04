@extends('adminlte::page')
    @section('title', '個人イベント登録画面')
        @section('content_header')
            <h1>個人イベント</h1>
                <meta name="csrf-token" content="{{ csrf_token() }}">
        
                 <!--jQuery:ajax通信用CDN-->
                <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
                <!--jQuery:バリデーション用だがあくまでフロント部分-->
                @section('plugins.jqueryValidate', true)
        @stop
            @section('content')
            <!--登録-->
            <form method = "POST" action = "{{ route('store.myevent') }}" enctype = "multipart/form-data">
                @csrf
                <label>タイトル</label>
                <input type = "text" name = "myevent[title]" size="20" placeholder = "タイトル" value = "{{ old('myevent.title') }}"/>
                <p class="title__error" style="color:red">{{ $errors->first('myevent.title') }}</p>
                
                <label>カテゴリー</label>
                <select name="myevent[category]">
                    <option value="birthday" @if(old('myevent.category')=="birthday") selected @endif>の誕生日</option>
                    <option value="anniversary" @if(old('myevent.category')=="anniversary") selected @endif>記念日</option>
                    <option value="others" @if(old('myevent.category')=="others") selected @endif>その他</option>
                </select>
                <p class="category__error" style="color:red">{{ $errors->first('myevent.category') }}</p>
                
                <label>年月日</label>
                <input name="myevent[start]" type="date" value = "{{ old('myevent.start') }}"/>
                <p class="start__error" style="color:red">{{ $errors->first('myevent.start') }}</p>
                
                <label>何日前に通知しますか？</label>
                <input type="number" inputmode="numeric" name="myevent[day]" value = "{{ old(('myevent.day'),5) }}"日前>
                <p class="day__error" style="color:red">{{ $errors->first('myevent.day') }}</p>
                
                <button id="submit_post" type = "submit">[登録]</button>
            </form>
            
            <!--変更-->
            <h3>登録内容</h3>
            @if(!($my_events->isEmpty()))
            <form method = "POST" action = "" id = "postForm" enctype = "multipart/form-data">
                @csrf
            @foreach($my_events as $my_event)
            
            <?php
                //今年の何年
                $now_year = \Carbon\Carbon::now()->format('Y');
                $my_event->start =$now_year.'-'.$my_event->start;
            ?>
                <input type="hidden" name="m_id" value="{{ $my_event->id }}"/>
                
                <label>タイトル</label>
                <input type = "text" name = "m_title" size="20" value = "{{ $my_event->title }}" />
                
                <label>カテゴリー</label>
                <select name="m_category">
                    <option value="birthday" @if($my_event->category == "birthday") selected @endif>の誕生日</option>
                    <option value="anniversary" @if($my_event->category == "anniversary") selected @endif)>記念日</option>
                    <option value="others" @if($my_event->category == "others") selected @endif>その他</option>
                </select>
                
                <label>年月日</label>
                <input name="m_start" type="date" value="{{ $my_event->start }}"/>
                
                <label>何日前に通知しますか？</label>
                <input type="number" inputmode="numeric" name="m_day" value ="{{ $my_event->day }}"日前 />
                
                <button type="button" id="delete_button">削除する</button>

            @endforeach
            <button id="sub_put" type = "button">[変更]</button>
            </form>
            @endif
            <script>
                //バリデーションルール設定
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
                $(function a(){
                    $("#delete_button").on('click', function(){
                    
                        let input_id = document.getElementsByName('m_id');
                        var url = "/myevent/create/"+input_id[0].value;
                    
                            $.ajax({
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  // CSRFトークンの設定
                                type: "post",
                                url: url,
                                dataType: "text",
                                scriptCharset: "utf-8",
                                data: {'_method': 'DELETE'} 
                            }).done(function () {
                                // 通信成功時の処理(formの2重になる解決策がこれしか思い浮かばなかった...)
                                location.href = "{{ route('create.myevent') }}";
                                alert('個人行事の登録内容を削除しました');
                            }).fail(function (jqXHR, textStatus, errorThrown) {
                                // 通信失敗時の処理
                                alert('ファイルの取得に失敗しました。');
                                console.log("ajax通信に失敗しました");
                                console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
                                console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
                                console.log("errorThrown    : " + errorThrown.message); // 例外情報
                            });
                    });
                    })
                    $(function b(){
                    $("#sub_put").on('click', function(){
                        //バリデーションを行う
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
            <style type="text/css">

            label, input {
                display: block;
            }
            
        </style>
        @stop