<!--使わなくなったやつ-->
<!DOCTYPE html>
<html lang = "{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
        <x-slot name="header">
            <head>
                <meta charset = "UTF-8">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <!--jQuery:ajax通信用CDN-->
                <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
                <title>通常行事登録画面</title>
            </head>
        </x-slot>
        <body>
        
            @foreach($users->normal_events as $normal_event)
            <form action = "{{ route('normalevent.create') }}" enctype = "multipart/form-data" method = "POST" >
                @csrf
                @method('PUT')
                <p>{{ $normal_event->title }}</p>
                <p>{{ $normal_event->start }}</p>
                <input type="hidden" id="ajax_input_id" name="n_event[id]" value="{{ $normal_event->id }}"/>
                
                <select id="ajax_input_notice" name="n_event[notice]">
                    <option value="0" @if(old('n_event.notice')=="0") selected @endif>OFF</option>
                    <option value="1" @if(old('n_event.notice')=="1") selected @endif>ON</option>
                </select>
                <p class="notice__error" style="color:red">{{ $errors->first('n_event.notice') }}</p>
            
                <input type="number" id="ajax_input_day_num" inputmode="numeric" name="n_event[day_num]" value = "{{ old(('n_event.day_num'),$normal_event->pivot->day_num) }}"/>
                <p class="day_num__error" style="color:red">{{ $errors->first('n_event.day_num') }}</p>
                
                <button id="ajax_submit" type = "submit">[登録]</button>
                </form>
            @endforeach
            
        </body>
    </x-app-layout>
</html>