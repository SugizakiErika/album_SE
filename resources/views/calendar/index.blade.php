<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <x-app-layout>
  <x-slot name="header">
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
            start: event['start'],
            color: event['color'],
            url: event['url'],
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
        
          //日付送信用
          dateClick: function(info) {
            if(window.confirm(info.dateStr + 'の日付で日記を記載しますか？？')){
              // /create/?date=2024-03-01
              var url = "{{ route('create.diary') }}";
              location.href = url + '?date=' + info.dateStr;
            }else{
             //何もしない
            }
          },
   
        });
        calendar.render();
      });
  </script>
  </head>
  </x-slot>
    <body>
      <div id='calendar'></div>
    </body>
    </x-app-layout>
</html>
