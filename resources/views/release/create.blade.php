@extends('adminlte::page')
    @section('title', 'フォロー申請/許可画面')
        @section('content_header')
            <h1>フォロー申請/許可</h1>
                <meta name="csrf-token" content="{{ csrf_token() }}">
        
                 <!--jQuery:ajax通信用CDN-->
                <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
                <!--jQuery:バリデーション用だがあくまでフロント部分-->
                @section('plugins.jqueryValidate', true)
        @stop
            @section('content')
            <!--自分の合言葉-->
                <label>合言葉</label>
                <p>自分の合言葉を設定してください</p>
                <form method = "POST" action = "{{ route('release.watchword') }}" >
                    @csrf
                    @method('PUT')
                    <input type = "text" name = "release[watchword]" size="50" placeholder = "合言葉を記載してください" value = "{{ Auth::user()->watchword }}">
                    <button id="submit_put" type = "submit" name="watchword">登録</button>
                </form>
            <!--検索-->
                <label>ユーザー検索</label>
                <form method = "POST" action = "" id = "postForm" >
                @csrf
                <input type = "text" name = "username" size="20" placeholder = "ユーザー名"/>
                
                <button id="submit_post" type = "button">検索</button>
                </fomr>
            
            <!--結果-->
                <label>検索結果</label>
                <form method = "POST" action = "" id = "serachForm" >
                @csrf
                    <button id ="submit_serach" type = "button">フォロー申請</button>
                
                <div class="result_username">
                </div>
                </form>
                
            <!--申請中-->
                <label>フォロー状況確認</label>
                @if($release_lists)
                <button type="button" id="delete_button" name="follow">取り消し</button>
                <div class="follow_user">
                    <div class="follow_user_update">
                        @foreach($release_lists as $release_list)
                        <input type="radio" name="m_id" value="{{ $release_list->id }}"/>
                        <p>ユーザー名： {{ $release_list->follow_name }} </p>
                        <p>申請状況：@if( $release_list->request == 1)申請済み @else 未申請 @endif</p>
                        <p>許可状況：@if($release_list->notice == 1)許可済み @else 許可待ち @endif </p>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @include('release.follow-request')
            <script>
            //バリデーションルール設定
                var serachValid = {
                    rules:{
                        username:{
                            required:true,
                            maxlength:100, 
                        }
                    },
                    messages:{
                        username:{
                            required:'ユーザー名を入力してください。',
                            maxlength:'50文字以内で入力してください。',
                        }
                    },
                }
            
            $(function delete_follow(){
                    $("#delete_button").on('click', function(){
                        
                        // 入力する値の取得
                        let followRadio = document.getElementsByName('m_id');
                        let len = followRadio.length;
                        let checkValue = '';

                        for (let i = 0; i < len; i++){
                            if (followRadio.item(i).checked){
                                checkValue = followRadio.item(i).value;
                            }
                        }
                        
                        let input_id = document.getElementsByName('m_id');
                        var url = "/release/watchword/"+checkValue;
                    
                            $.ajax({
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  // CSRFトークンの設定
                                type: "post",
                                url: url,
                                dataType: "text",
                                scriptCharset: "utf-8",
                                data: {'_method': 'DELETE'} 
                            }).done(function (release_lists) {
                                //前のアップロードデータを削除
                            $(".result_name").remove();
                            $(".follow_user_update").remove();
                            //検索結果を表示する
                            $.each(release_lists,function(index,value){
                             if(release_lists[index].request == 1 && release_lists[index].notice == 1){
                                 html = `
                                    <div class="follow_user_update">
                                    <input type="radio" name="m_id" value="${release_lists[index].id}"/>
                                    <p>ユーザー名： ${release_lists[index].follow_name} </p>
                                    <p>申請状況：申請済み</p>
                                    <p>許可状況：許可</p>
                                    </div>
                                     `;
                            }else if(release_lists[index].request == 1 && release_lists[index].notice == 0)
                            {
                                html = `
                                    <div class="follow_user_update">
                                    <input type="radio" name="m_id" value="${release_lists[index].id}"/>
                                    <p>ユーザー名： ${release_lists[index].follow_name} </p>
                                    <p>申請状況：申請中</p>
                                    <p>許可状況：許可待ち</p>
                                    </div>
                                     `;
                            }
                            
                            
                                    $(".follow_user").append(html);
                                    });
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
                $(function a() {
                    $("#submit_post").on('click', function() {
                        
                        //バリデーションを行う
                        $("#postForm").validate(serachValid);
                        //失敗で戻る
                        if (!$("#postForm").valid()) {
                            return false;
                        };
                        
                        // 入力する値の取得
                        var input_name = document.getElementsByName('username');
                        //console.log(input_name[0].value);
                        
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  // CSRFトークンの設定
                            type: "POST",
                            url: "{{ route('release.serach') }}",
                            data: {
                            "name" : input_name[0].value
                            },
                            dataType: "json",
                            scriptCharset: "utf-8",
                        }).done(function (result) {
                            //前のアップロードデータを削除
                            $(".result_name").remove();
                            console.log(result);
                            //検索結果を表示する
                            if(result.length){
                                $.each(result,function(index,value){
                                    html = `
                                        <div class="result_name">
                                        <input type="radio" name ="serach" value = "${result[index].id}">
                                        <p>ユーザー名： ${result[index].name} </p>
                                        <p>合言葉：${result[index].watchword} </p>
                                        </div>
                                        `;
                                        $(".result_username").append(html);
                                });
                            
                            }else{
                                    html = `
                                    <div class="result_name">
                                    <p>検索しましたが対象のユーザーは見つかりませんでした</p>
                                    </div>
                                     `;
                                     $(".result_username").append(html);
                            }
                        }).fail(function (jqXHR, textStatus, errorThrown) {
                                // 通信失敗時の処理
                                alert('ファイルの取得に失敗しました。');
                                console.log("ajax通信に失敗しました");
                                console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
                                console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
                                
                        });
                        
                    });
                })
                
                $(function b() {
                    $("#submit_serach").on('click', function() {
                        
                        // 入力する値の取得
                        let followRadio = document.getElementsByName('serach');
                        let len = followRadio.length;
                        let checkValue = '';

                        for (let i = 0; i < len; i++){
                            if (followRadio.item(i).checked){
                                checkValue = followRadio.item(i).value;
                            }
                        }
                        
                        //var input_id = document.getElementsByName('serach');
                        //console.log(input_id[0].value);
                        //console.log(checkValue);
                        
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  // CSRFトークンの設定
                            type: "POST",
                            url: "{{ route('release.serach_save') }}",
                            data: {
                            "followuserid" : checkValue
                            },
                            dataType: "json",
                            scriptCharset: "utf-8",
                        }).done(function (release_lists) {
                            //前のアップロードデータを削除
                            $(".result_name").remove();
                            $(".follow_user_update").remove();
                            //検索結果を表示する
                            $.each(release_lists,function(index,value){
                             if(release_lists[index].request == 1 && release_lists[index].notice == 1){
                                 html = `
                                    <div class="follow_user_update">
                                    <input type="hidden" name="m_id" value="${release_lists[index].id}"/>
                                    <p>ユーザー名： ${release_lists[index].follow_name} </p>
                                    <p>申請状況：申請済み</p>
                                    <p>許可状況：許可</p>
                                    </div>
                                     `;
                            }else if(release_lists[index].request == 1 && release_lists[index].notice == 0)
                            {
                                html = `
                                    <div class="follow_user_update">
                                    <input type="hidden" name="m_id" value="${release_lists[index].id}"/>
                                    <button type="button" id="delete_button">取り消し</button>
                                    <p>ユーザー名： ${release_lists[index].follow_name} </p>
                                    <p>申請状況：申請中</p>
                                    <p>許可状況：許可待ち</p>
                                    </div>
                                     `;
                            }
                            
                            
                                    $(".follow_user").append(html);
                                    });
                        }).fail(function (jqXHR, textStatus, errorThrown){
                                //通信失敗時の処理
                                alert('ファイルの取得に失敗しました。');
                                console.log("ajax通信に失敗しました");
                                console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
                                console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
                                
                        });
                        
                    });
                })
        </script>
            <style type="text/css">

            label, input {
                display: block;
            }
            
        </style>
        @stop