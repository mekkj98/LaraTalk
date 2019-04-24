(function () {
    'use strict';

    function isOverflown(element) {
        return element.scrollHeight > element.clientHeight || element.scrollWidth > element.clientWidth;
    }

    function defaultLayoutSetup() {
        var layoutMainContent = document.querySelector(".layout-default .layout-main-content");
        var layoutSidebar = document.querySelector(".layout .sidebar");
        if(isOverflown(layoutSidebar)) {
            layoutSidebar.style.overflowY = "scroll";
        } else {
            layoutSidebar.style.overflowY = "auto";
        }
        if(layoutMainContent) {
            var layoutHead = document.querySelector(".layout-head").clientHeight;
            var totalHeight = document.clientHeight || document.body.clientHeight;

            var layoutDefault = document.querySelector(".layout-default");

            var layoutMainContent = totalHeight - (layoutHead) + "px";
            if (isOverflown(layoutMainContent)) {
                layoutDefault.style.overflowY = "scroll";
            } else {
                layoutDefault.style.overflowY = "auto";
            }
        }
        return;
    }

    function chatLayoutsetup() {
        if(document.querySelector('.layout-chat .layout-main-content .chat')) { 
            var chatLeft = document.querySelector(".layout-chat .layout-main-content .chat .chat-left");
            var chatRight = document.querySelector(".layout-chat .layout-main-content .chat .chat-right");
            var pageHead = document.querySelector('.layout-head');
            var Curheight = document.body.clientHeight || window.innerHeight || d.documentElement.clientHeight;
            
            chatLeft.style.overflowY = "auto";
            chatLeft.style.height = Curheight - (pageHead.clientHeight + 20) + "px";
            
            if(window.innerWidth > 700) {
                chatRight.style.height = ( Curheight - (pageHead.clientHeight + 20)) + "px";
            } else {
                chatRight.style.height = Curheight + "px";
            }

            var chatRightContext = document.querySelector(".chat-right-context");
            var chatRightHead = document.querySelector(".chat-right-head");
            var chatMessageBox = document.querySelectorAll(".chat-message-box");
            chatRightContext.style.height = chatRight.clientHeight - (chatRightHead.clientHeight + chatMessageBox.clientHeight);
            chatRightContext.style.overflowY = "scroll";
        }
    };

    function sidebar() {
        var sidebarbtn = document.querySelector(".layout .sidebar .sidebar-top .user-title button");
        var sidebar = document.querySelector(".layout .sidebar");
        if(window.innerWidth >= 1301) {
            sidebarbtn.style.display = "none";    
            sidebar.style.display = "block";
            sidebar.style.position = "relative";
            document.querySelector(".layout .content").style.width =(window.innerWidth - 230) + "px";
        } else {
            document.querySelector(".layout .content").style.width = "100%";
            sidebarbtn.style.display = "inline-block";    
            sidebar.style.display = "none";
            sidebar.style.position = "fixed";
        }
    }

    window.onresize = function () {
        defaultLayoutSetup();
        chatLayoutsetup();
        sidebar();
    }
    
    function make_offline () {
        return axios.post('/api/chat/user/logout', {})
        .then((response) => {
            console.log(response);
            return response.data;
        });
    }

    window.onunload = function() {
        if(make_offline().status == "success"){
            return true;
        }
    }
    defaultLayoutSetup();
    chatLayoutsetup();
    sidebar();
})();
