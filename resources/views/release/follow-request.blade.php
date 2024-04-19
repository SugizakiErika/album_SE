    <!--フォロー申請-->
        <label>フォロー申請確認</label>
        <form action = "{{ route('release.watchword') }}" method = "POST">
            @csrf
            @method('PUT')
            @if($follow_lists)
            <button type="submit" id="follow_button" name="follow">保存</button>
            <div class="follow_request">
            @foreach($follow_lists as $follow_list)
                <input type="radio" name ="release[follow_id]" value = "{{ $follow_list->id }}">
                <p>ユーザー名： {{ $follow_list->follow_name }} </p>
                <p>合言葉：{{ $follow_list->watchword}} </p>
                <?php Log::info($follow_list->notice);  ?>
                <input type="radio" name="release[notice]" id="1" value="1" @if($follow_list->notice == 1) checked @endif/>
                <label>許可する</label>
                <input type="radio" name="release[notice]" id="0" value="0" @if($follow_list->notice == 0) checked @endif/>
                <label>許可しない</label>
                <label>日記に反映された際の色を選択してください</label>
                <input type="color" name="release[select_color]" value="{{ $follow_list->select_color }}">
            @endforeach
            </div>
            @endif
        </form>
                
