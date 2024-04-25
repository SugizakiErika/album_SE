    <!--フォロー申請-->
    <div class="card card-outline card-info">
        <div class="card-body">
            <label>フォロー申請確認</label>
            <form action = "{{ route('release.watchword') }}" method = "POST">
                @csrf
                @method('PUT')
                    @if($follow_lists)
                        <button class="btn btn-info" type="submit" id="follow_button" name="follow">保存</button>
                        <div class="follow_request">
                            @foreach($follow_lists as $follow_list)
                                <p></p><input type="radio" name ="release[follow_id]" value = "{{ $follow_list->id }}" required>
                                <p class="start__error" style="color:red">{{ $errors->first('release.follow_id') }}</p>
                                <label>ユーザー名： {{ $follow_list->follow_name }} &emsp;
                                合言葉：{{ $follow_list->watchword}} </label></p>
                                <input type="radio" name="release[notice]" id="1" value="1" @if($follow_list->notice == 1) checked @endif required/>
                                <label>許可する</label>
                                <input type="radio" name="release[notice]" id="0" value="0" @if($follow_list->notice == 0) checked @endif required/>
                                <label>許可しない</label>
                                <p class="start__error" style="color:red">{{ $errors->first('release.notice') }}</p>
                            @endforeach
                        </div>
                    @endif
            </form>
        </div>
    </div>
