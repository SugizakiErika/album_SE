//使ってないです
import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";

var calendarEl = document.getElementById("calendar");

let calendar = new Calendar(calendarEl, {
    plugins: [dayGridPlugin],
    plugins: [ interactionPlugin ],
    initialView: "dayGridMonth",
    headerToolbar: {
        left: "prevYear,prev,next,nextYear",
        center: "title",
        right: "",
    },
    //日本語にする
    locale: 'ja',

    //土日の色付け
    //businessHours: true,
    //日付ごとの初期化処理
    //dayCellContent: function(e) {
        //「日」を非表示にする
       // e.dayNumberText = e.dayNumberText.replace('日','');
    //},
    //googleカレンダー祝日なんか出てこない
    googleCalendarApiKey: 'GOOGLE_CALENDAR_API_KEY',
    events: 
    {
            googleCalendarID: 'ja.japanese#holiday@group.v.calendar.google.com',
            display: 'background',
            color: '#fffbf8',
        
        //url:'/Normal_event.php',//データベースの内容を表示する
    },
     dateClick: function(info) {
    alert('Clicked on: ' + info.dateStr);
    alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
    alert('Current view: ' + info.view.type);
    // change the day's background color just for fun
    info.dayEl.style.backgroundColor = 'red';
  }
    
    //イベントの設定
    //events: [{
     //   title: 'ひな祭り',
     //   start: '2024-03-03'
   // }]
    
});
calendar.render();