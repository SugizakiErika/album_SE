<!DOCTYPE html>
<html lang = "{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
        <x-slot name="header">
            <head>
                <meta charset = "UTF-8">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <!--jQuery:ajax通信用CDN-->
                <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
                <!--jQuery:バリデーション用だがあくまでフロント部分-->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
                <title>通常行事登録画面</title>
            </head>
        </x-slot>
        <body>
            <button id="submit_put" type = "submit">[変更]</button>
            <form method = "POST" action = "" id = "postForm" enctype = "multipart/form-data">
            @foreach($users->normal_events as $normal_event)
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p>{{ $normal_event->title }}</p>
                        <p>{{ $normal_event->start }}</p>
                
                        <input type="hidden" name="n_id" value="{{ $normal_event->id }}"/>
                
                        <select  name="n_notice">
                         <option value="0" @if($normal_event->pivot->notice == "0") selected @endif>OFF</option>
                        <option value="1" @if($normal_event->pivot->notice == "1") selected @endif>ON</option>
                        </select>
            
                        <input type="number" inputmode="numeric" name="n_day_num" value = "{{ $normal_event->pivot->day_num }}"/>
                    </div>
                </div>
                </div>
            </div>
            @endforeach
            </form>
            <script>
                var nromaleventValid = {
                    rules:{
                        n_notice:{
                            required:true,
                        },
                        n_day_num:{
                            required:true,
                            digits:true,
                        }
                    },
                    messages:{
                        n_notice:{
                            required:'通知を選択してください。',
                        },
                        n_day_num:{
                            required:'タイトルを入力してください。',
                            digits:'0以上の整数を入力してください。'
                        }
                    },
                }
                
                
                $(function(){
                    $("#submit_put").on('click', function(){
                        $("#postForm").validate(nromaleventValid);
                            //失敗で戻る
                        if (!$("#postForm").valid()) {
                            return false;
                        };
                    
                        // 入力する値の取得
                        var input_id = document.getElementsByName('n_id');
                        var input_notice = document.getElementsByName('n_notice');
                        var input_day_num = document.getElementsByName('n_day_num');
                        
                        for(let i=0; i<input_id.length; i++){
                    
                            $.ajax({
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  // CSRFトークンの設定
                                type: "put",
                                url: "{{ route('update.normalevent') }}",
                                dataType: "text",
                                scriptCharset: "utf-8",
                                data: {
                                    "ajax_input_id" : input_id[i].value,
                                    "ajax_input_notice" : input_notice[i].value,
                                    "ajax_input_day_num" : input_day_num[i].value
                                },
                            }).done(function (results) {
                                // 通信成功時の処理
                                console.log(results);
                                if(i == input_id.length-1){
                                alert('通常行事の登録内容を変更しました');
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