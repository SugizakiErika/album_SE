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
                                <select  name="release[notice]">
                                    <option value="1" @if($follow_list->notice == "1") selected @endif>許可する</option>
                                    <option value="0" @if($follow_list->notice == "0") selected @endif>許可しない</option>
                                </select>
                                
                            @endforeach
                        </div>
                    @endif
            </form>
        </div>
    </div>
