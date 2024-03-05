<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script src='fullcalendar/dist/index.global.js'></script>
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
        googleCalendarApiKey: "GOOGLE_CALENDAR_API_KEY",
        eventSources: [
          {
            googleCalendarId: "japanese__ja@holiday.calendar.google.com", //祝日の予定を取得
            rendering: "background",
            color: "#FF6666",
          },
        ],
        events: [{
        //url:'/Normal_event.php',//データベースの内容を表示する
        title: 'ひな祭り',
        start: '2024-03-03',
        url: '/create'
        }],
        
        dateClick: function(info) {
        if(window.confirm(info.dateStr + 'の日付で日記を記載しますか？？'))
        {
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
        data: {'date': info.dateStr},
          }).then((res) => {
          console.log(res);
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