<div class="chat-left">
    <div class="chats">
        <ul>
            @if($friends)
                @foreach($friends as $f)
                    <li class="chatlist" data-chatid="{{ $f['pivot']['id'] }}" data-reciver="{{ $f['id'] }}" data-name="{{$f['name']}}" data-avatar="{{$f['avatar']}}">
                        <div class="user-list-avatar">
                            <img src="{{$f['avatar']}}" alt="user img" />
                        </div>
                        <div class="user-list-info">
                            <p>{{$f['name']}}</p>
                        </div>
                    </li>
                @endforeach
            @else
                <li>No Friends</li>
            @endif
        </ul>
    </div>
</div>