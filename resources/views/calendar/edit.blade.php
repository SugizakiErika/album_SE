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
          initialView: 'dayGridMonth',
        headerToolbar: {
        left: "prevYear,prev,next,nextYear",
        center: "title",
        right: "",
        },
        locale: 'ja',
    events: 
    {

        
        //url:'/Normal_event.php',//データベースの内容を表示する
    },
    dateClick: function(info) {
    alert('Clicked on: ' + info.dateStr);
    //alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
    //alert('Current view: ' + info.view.type);
    // change the day's background color just for fun
    info.dayEl.style.backgroundColor = 'red';
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