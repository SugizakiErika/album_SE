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
            <div class="card card-outline card-info">
                <div class="card-body">
                    <label>合言葉</label>
                    <p>自分の合言葉を設定してください</p>
                    <form method = "POST" action = "{{ route('release.watchword') }}" >
                        @csrf
                        @method('PUT')
                        <input type = "text" name = "release[watchword]" size="50" placeholder = "合言葉を記載してください" value = "{{ Auth::user()->watchword }}" required>
                        <h3></h3>
                        <button class="btn btn-info" id="submit_put" type = "submit" name="watchword">登録</button>
                    </form>
                </div>
            </div>
            <!--検索-->
            <div class="card card-outline card-info">
                <div class="card-body">
                    <label>ユーザー検索</label>
                    <form method = "POST" action = "" id = "postForm" >
                        @csrf
                        <input type = "text" name = "username" size="20" placeholder = "ユーザー名"/>&emsp;<button class="btn btn-info" id="submit_post" type = "button">検索</button>
                    </fomr>
                </div>
            </div>
                
            
            <!--結果-->
            <div class="card card-outline card-info">
                <div class="card-body">
                    <label>検索結果</label>
                    <form method = "POST" action = "" id = "serachForm" >
                        @csrf
                        <br />
                        <button class="btn btn-info" id ="submit_serach" type = "button">フォロー申請</button>
                
                        <div class="result_username"></div>
                    </form>
                </div>
            </div>
                
            <!--申請中-->
            <div class="card card-outline card-info">
                <div class="card-body">
                  <label>フォロー状況確認</label>
                    @if($release_lists)
                        <br />
                        <button class="btn btn-info" type="button" id="delete_button" name="follow">申請取り消し</button>
                        <div class="follow_user">
                            <div class="follow_user_update">
                                @foreach($release_lists as $release_list)
                                    <p></p><input type="radio" name="m_id" value="{{ $release_list->id }}" required>
                                    <label>ユーザー名： {{ $release_list->follow_name }} &emsp;
                                    申請状況：@if( $release_list->request == 1)申請済み @else 未申請 @endif &emsp;
                                    許可状況：@if($release_list->notice == 1)許可済み @else 許可待ち @endif </label></p>
                                @endforeach
                            </div>
                        </div>
                    @endif
                
                </div>
            </div>
            
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
                        //失敗で戻る
                        if (!checkValue) {
                           alert('申請取り消しをする方を選択してください。'); 
                            return false;
                        };
                        
                        let input_id = document.getElementsByName('m_id');
                        var url = "/release/watchword/"+checkValue;
                    
                            $.ajax({
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  // CSRFトークンの設定
                                type: "post",
                                url: url,
                                dataType: "text",
                                scriptCharset: "utf-8",
                                data: {'_method': 'DELETE'} 
                            }).done(function (result) {
                                //前のアップロードデータを削除
                            $(".result_name").remove();
                            $(".follow_user_update").remove();
                            if(result.length){
                            //検索結果を表示する
                            $.each(result,function(index,value){
                             if(result[index].request == 1 && result[index].notice == 1){
                                 html = `
                                    <div class="follow_user_update">
                                    <p><input type="radio" name="m_id" value="${result[index].id}" required>
                                    <label>ユーザー名： ${result[index].follow_name}
                                    申請状況：申請済み&emsp;
                                    許可状況：許可</label></p>
                                    </div>
                                     `;
                            }else if(result[index].request == 1 && result[index].notice == 0)
                            {
                                html = `
                                    <div class="follow_user_update">
                                    <p><input type="radio" name="m_id" value="${result[index].id}" required>
                                    <label>ユーザー名： ${result[index].follow_name} &emsp;
                                    申請状況：申請中 &emsp;
                                    許可状況：許可待ち</label></p>
                                    </div>
                                     `;
                            }
                            $(".follow_user").append(html);
                                    });
                            }else{
                            }
                            
                            
                                    
                            }).fail(function (jqXHR, textStatus, errorThrown) {
                                // 通信失敗時の処理
                                alert('申請取り消しをする方を選択してください。');
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
                                        <p><input type="radio" name ="serach" value = "${result[index].id}">
                                        <label>ユーザー名： ${result[index].name} &emsp;
                                        合言葉：${result[index].watchword} </label></p>
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
                                    <p><input type="radio" name="m_id" value="${release_lists[index].id}"/>
                                    <label>ユーザー名： ${release_lists[index].follow_name} &emsp;
                                    申請状況：申請済み &emsp;
                                    許可状況：許可</label></p>
                                    </div>
                                     `;
                            }else if(release_lists[index].request == 1 && release_lists[index].notice == 0)
                            {
                                html = `
                                    <div class="follow_user_update">
                                    <p><input type="radio" name="m_id" value="${release_lists[index].id}"/>
                                    <label>ユーザー名： ${release_lists[index].follow_name} &emsp;
                                    申請状況：申請済み &emsp;
                                    許可状況：許可待ち</label></p>
                                    </div>
                                     `;
                            }
                                    $(".follow_user").append(html);
                                    });
                        }).fail(function (jqXHR, textStatus, errorThrown){
                                //通信失敗時の処理
                                alert('申請する方を選択してください。');
                                console.log("ajax通信に失敗しました");
                                console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
                                console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
                                
                        });
                        
                    });
                })
        </script>
        <style type="text/css">
            input[type="radio"]{
            position: relative;
            top: 2px;
            }
        </style>

        @stop