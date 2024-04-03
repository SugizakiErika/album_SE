<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
        <x-slot name="header">
            <head>
                <meta charset = "utf-8">
                 <!--jQuery:ajax通信用CDN-->
                <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
                
                <title>日記閲覧画面</title>
            </head>
        </x-slot>
        <body>
            <form method = "POST" action = "{{ route('update.diary', ['diary' => $diary->id]) }}" enctype = "multipart/form-data">
                @csrf
                @method('PUT')
                <input type = "text" name = "diary[start]" value = "{{ old(('diary.start'),$diary->start) }}" readonly>
                <p class="start__error" style="color:red">{{ $errors->first('diary.start') }}</p>
                
                <input type = "text" name = "diary[title]" value = "{{ old(('diary.title'),$diary->title) }}">
                <p class="title__error" style="color:red">{{ $errors->first('diary.title') }}</p>
                
                <input type = "file" name = "files[]" id = "upload_images" accept=".gif, .jpg, .jpeg, .png" class = "form-control" multiple>
                @foreach($errors->get('files') as $message)
                <p class="file__error" style="color:red">{{ $message }}</p>
                @endforeach
                <p class="file__error" style="color:red">{{ $errors->first('files.*') }}</p>
                
                <p>選択した画像</p>
                <div class="file_path">
                </div>
                <p>日記の画像</p>
                @foreach($diary->diary_images as $diary_image)
                <img src = "{{ asset($diary_image->path) }}" width = "200" height = "150">
                @endforeach
                
                <textarea name="diary[comment]" >{{ old(('diary.comment'),$diary->comment) }}</textarea>
                <p class="comment__error" style="color:red">{{ $errors->first('diary.comment') }}</p>
                <button type = "submit">保存</button>
            </form>
            <a href="{{ route('show.diary', ['diary' => $diary->id]) }}">戻る</a>
            
            <script>
                $(function () {
                    $('#upload_images').on('change', function() {
                        
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
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  // CSRFトークンの設定
                            type: "POST",
                            url: "{{ route('create.diary_ajax') }}",
                            data: form,
                            processData: false,
                            contentType: false,
                        }).done(function (result) {
                            //前のアップロードデータを削除
                            $(".img_path").remove();
                            //画像の選択が完了したら画像を表示する
                            $.each(result, function (index, result) {
                                 html = `
                                    <div class="img_path">
                                    <img src="{{ asset('${result}') }}" alt="" width = "200" height = "150">
                                    </div>
                                     `;
                                    $(".file_path").append(html);
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
            </script>
        </body>
    </x-app-layout>
</html>