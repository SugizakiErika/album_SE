<!DOCTYPE html>
<html>
<head>
    <title>FullCalendar in Laravel</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!--各ページに飛べるようにリンクを貼る-->
    <!--通常行事登録画面、個人行事登録画面、問い合わせ、公開者リスト、ユーザー削除、ログイン画面-->
    
    <!--個人行事と通常行事で当月の行事を上に記載する-->
    
    <!--カレンダーの表示：祝日、日本の行事-->
    <div id='calendar'></div>
    
    <!--日付クリック時create.blade.phpに飛べるようにする-->
    <!--日付も一緒に送れるようにする-->

</body>
</html>