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
                <title>日記登録画面</title>
            </head>
        </x-slot>
        <body>
            <form method = "POST" action = "{{ route('store.diary') }}" enctype = "multipart/form-data">
            @csrf
            <input type = "text" name = "diary[start]" value = "{{ $date }}" readonly>
            <p class="start__error" style="color:red">{{ $errors->first('diary.start') }}</p>
            
            <input type = "text" name = "diary[title]" placeholder = "タイトルを入力してください" value = "{{ old('diary.title') }}"/>
            <p class="title__error" style="color:red">{{ $errors->first('diary.title') }}</p>
            
            
            
            <input type = "file" name = "files[]" id = "upload_images" accept=".gif, .jpg, .jpeg, .png" class = "form-control" multiple>
            
            @foreach($errors->get('files') as $message)
            <p class="file__error" style="color:red">{{ $message }}</p>
            @endforeach
            <p class="file__error" style="color:red">{{ $errors->first('files.*') }}</p>
            
            @if (Session::has('file_path'))
            <?php
                $file_path = Session::get('file_path');
                Log::info("blade側".$file_path);
            ?>
            @foreach($file_path as $path)
            <img src="{{asset($path) }}" alt="" width = "200" height = "150">
            @endforeach
            @endif
            <button type="button" id="file_upload_btn" class="">アップロード</button>
            
            <textarea name="diary[comment]" placeholder="コメントを入力してください">{{ old('diary.comment') }}</textarea>
            <p class="comment__error" style="color:red">{{ $errors->first('diary.comment') }}</p>
            
            <button type = "submit">登録</button>
            </form>
            
            <script>
                $(function () {
                    $('#file_upload_btn').on('click', function() {

                        //ajaxでのcsrfトークン送信
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        
                        //フォームデータを作成する
                        var form = new FormData();
                        //アップロードするファイルのデータ取得
                        for(let i=0; i<=4; i++){
                        var fileData = document.getElementById("upload_images").files[i];
                        
                        //フォームデータにアップロードファイルの情報追加
                        form.append('files[]', fileData);
                        }
                        console.log(form.getAll('files'));
                        $.ajax({
                            type: "POST",
                            url: "{{ route('create.diary_ajax') }}",
                            data: form,
                            processData: false,
                            contentType: false,
                        }).done(function (result) {
                            alert('画像をuploadしました');
                            console.log(result);
                            
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
            </script>
        </body>
    </x-app-layout>
</html>