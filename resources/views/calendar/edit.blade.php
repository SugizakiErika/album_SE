<!DOCTYPE html>
<html lang='ja'>
  <head>
    <meta charset='utf-8' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--fullCalendar用CDN-->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script src='fullcalendar/dist/index.global.js'></script>
    <!--jQuery:ajax通信用CDN-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
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
        googleCalendarApiKey: 'GOOGLE_CALENDAR_API_KEY',
        eventSources: [
          {
            googleCalendarId: "japanese__ja@holiday.calendar.google.com", //祝日の予定を取得
            rendering: "background",
            color: "#FF6666",
          },
        ],
        events: "/index",
        //events: [{
        //url:'/Normal_event.php',//データベースの内容を表示する
        //title: 'ひな祭り',
        //start: '2024-03-03',
        //url: '/create'
        //}],
        
        dateClick: function(info) {
        if(window.confirm(info.dateStr + 'の日付で日記を記載しますか？？'))
        {
        let title = prompt('タイトルを入力してください');
        $.ajaxSetup({
        headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        });
        $.ajax({
        type: "post",
        url: "/create",
        dataType: "json",
        scriptCharset: "utf-8",
        data: {
        'date': info.dateStr.format("YYYY-MM-DD"),
        'title':title
        },
          }).done(function (results) {
                    // 通信成功時の処理
                    $('#normal_event').html(results);
                    console.log("URL : " + url);
                    console.log("results : " + results);
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
        //location.href ='/create/'+info.dateStr
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