<div class="layout-child sidebar">
    <div class="sidebar-top">
        <div class="user-logo">
            <img src={{Auth::user()->avatar}} alt="user image" />
        </div>
        <div class="user-title">
            <p> {{Auth::user()->name}} <span class="status"></span></p>
            <button onclick="document.querySelector('.layout .sidebar').style.display='none'"><i class="material-icons">close</i></button>
        </div>
    </div>
    <div class="sidebar-content">
        <ul>
            <li>
                <a href="/"><i class="material-icons">home</i><span>HOME</span></a>
            </li>
            <li>
                <a href="/chat"><i class="material-icons">chat_bubble_outline</i><span>CHATS</span></a>
            </li>
            <li>
                <a href="/profile/{{Auth::user()->id}}"><i class="material-icons">person_outline</i><span>PROFILE</span></a>
            </li>
            <li>
                <a href="/requests"><i class="material-icons">group_add</i><span>REQUESTS</span></a>
            </li>
            <li>
                <a href="/friends"><i class="material-icons">supervisor_account</i><span>FRIENDS</span></a>
            </li>
            <li>
                <a href="/settings"><i class="material-icons">settings</i><span>SETTINGS</span></a>
            </li>
        </ul>
    </div>
</div>
