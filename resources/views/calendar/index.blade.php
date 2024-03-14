<!DOCTYPE html>
    <!--各ページに飛べるようにリンクを貼る-->
    <!--通常行事登録画面、個人行事登録画面、問い合わせ、公開者リスト、ユーザー削除、ログイン画面-->
    
    <!--個人行事と通常行事で当月の行事を上に記載する-->
    
    <!--カレンダーの表示：祝日、日本の行事-->
    
    <!--日付クリック時create.blade.phpに飛べるようにする-->
    <!--日付も一緒に送れるようにする-->
<html lang="en">
  <head>
    <meta charset='utf-8' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--jQuery:ajax通信用CDN-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    
    <!--fullCalendar用CDN-->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        //カレンダーに設定するイベントの値リストを作成する
        var array = @json($data,JSON_UNESCAPED_UNICODE);
        var event_vals = [];
        array.forEach(event => {
          event_vals.push({
            title: event['title'],
            start: event['start']
          });
        })
      
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          //initialView: 'dayGridMonth',
          headerToolbar: {
            left: "prevYear,prev,next,nextYear",
            center: "title",
            right: "",
          },
          locale: 'ja',
          editable: true,
          events: event_vals,
        
          dateClick: function(info) {
            if(window.confirm(info.dateStr + 'の日付で日記を記載しますか？？')){
              let title = prompt('タイトルを入力してください');
              $.ajaxSetup({
              headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
              },
              });
        
              $.ajax({
                type: "get",
                url: "/create",
                dataType: "text",
                scriptCharset: "utf-8",
                data: {
                 "date": info.dateStr,
                 "title":title
                },
              }).done(function (results) {
                // 通信成功時の処理
                alert('送信成功');
                location.href ='/create'
              }).fail(function (jqXHR, textStatus, errorThrown) {
                // 通信失敗時の処理
                alert('ファイルの取得に失敗しました。');
                console.log("ajax通信に失敗しました");
                console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
                console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
                console.log("errorThrown    : " + errorThrown.message); // 例外情報
              });
            }else{
             //何もしない
            }
          },
        });
        calendar.render();
      });
  </script>
  </head>
    <body>
      <div id='calendar'></div>
    </body>
</html>