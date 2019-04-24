(function () {
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    var token = document.head.querySelector('meta[name="csrf-token"]');

    if (token) window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    else console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');

    function timeSince(date) {

        var seconds = Math.floor((new Date() - date) / 1000);

        var interval = Math.floor(seconds / 31536000);

        if (interval > 1) {
            return interval + " years";
        }
        interval = Math.floor(seconds / 2592000);
        if (interval > 1) {
            return interval + " months";
        }
        interval = Math.floor(seconds / 86400);
        if (interval > 1) {
            return interval + " days";
        }
        interval = Math.floor(seconds / 3600);
        if (interval > 1) {
            return interval + " hours";
        }
        interval = Math.floor(seconds / 60);
        if (interval > 1) {
            return interval + " minutes";
        }
        return Math.floor(seconds) + " seconds";
    }

    var thisUser = JSON.parse(document.head.querySelector('meta[name="user-data"]').content), reciver = null;
    var chatList = document.querySelectorAll(".chatlist");
    var curnameele = document.getElementById("curname");
    var curavatarele = document.getElementById('curavatar');
    var chatRightContext = document.querySelector(".chat-right-context");
    var chat_id = null;
    var curavatar = null;
    var curname = null;

    function pushinChat(messages) {
        chatRightContext.querySelector("ul").innerHTML = "";
        for (var i = 0; i < messages.length; i++) {
            var x = null;
            if (messages[i]['from'] == thisUser['id']) {
                var x = `<li class="send">
                <div class="user-list-avatar">
                    <img src="${ thisUser['avatar'] }" alt="user img" />
                </div>
                <div class="user-list-info">
                    <p>${messages[i].message}</p>
                    <p><i class="material-icons">query_builder</i><span>${timeSince(messages[i].on)}</span></p>
                </div>
            </li>`;
            } else {
                var x = `<li class="recived">
                <div class="user-list-avatar">
                    <img src="${curavatar}" alt="user img" />
                </div>
                <div class="user-list-info">
                    <p>${messages[i].message}</p>
                    <p><i class="material-icons">query_builder</i><span>${timeSince(messages[i].on)}</span></p>
                </div>
            </li>`;
            }
            chatRightContext.querySelector("ul").innerHTML += x.trim();
        }
        chatRightContext.scrollTop = chatRightContext.scrollHeight;
    }
    
    function chatListClicked() {
        for (var i = 0; i < chatList.length; i++) {
            chatList[i].onclick = function () {
                chatRightContext.querySelector("ul").innerHTML = "";
                if(window.innerWidth < 700) {
                    document.querySelector(".chat-right").style.display = "flex";
                }
                for (var j = 0; j < chatList.length; j++) {
                    chatList[j].classList.remove('active');
                }
                this.classList.add('active');

                var pre_chat_id = chat_id;

                chat_id = this.getAttribute("data-chatid");
                listen(chat_id, pre_chat_id);
                reciver = this.getAttribute("data-reciver");
                curname = this.getAttribute("data-name");
                curavatar = this.getAttribute("data-avatar");
  
                curavatarele.src = curavatar;
                curnameele.innerText = curname;

                var chatRightHead = document.querySelector("#chatRightHead");
                // chatRightHead.setAttribute("data-second", this.getAttribute("data-second"));
                chatRightHead.setAttribute("data-chatid", chat_id);
                chatRightHead.setAttribute("data-reciver", reciver);
                
                axios.post('/api/chat/message', { chat_id: chat_id }).then((response) => {
                    if (response.data.status === "success") {
                        var messages = JSON.parse(response.data['data']['message']);
                        if (messages !== null) {
                            pushinChat(messages);
                        } else {
                            var x = `<li class="send">
                                    <div class="user-list-avatar">
                                        <img src="assets/images/avatar.png" alt="user img" />
                                    </div>
                                    <div class="user-list-info">
                                        <p>No Chat Yet</p>
                                    </div>
                                </li>`;
                            chatRightContext.querySelector("ul").innerHTML = x.trim();
                        }
                    } else {
                        console.error(response.data);
                    }
                }).catch((error) => {
                    console.log(error)
                });
            }
        }
    };

    function on_submit_message() {
        var text = document.getElementById("textMessage");
        if(text.value == "") return false;
        var message = {
            from : thisUser['id'],
            message : text.value,
            type : 'text',
            on : Date.now()
        };

        axios.post('/api/chat/message', { chat_id: chat_id }).then((response) => {
            if (response.data.status === "success") {
                var messages = JSON.parse(response.data['data']['message']);
                if(messages == null) {
                    messages = [];
                }
                messages.push(message);
                axios.post('/api/chat/message/submit', { 
                    chat_id: chat_id, 
                    message : messages , 
                    sender : thisUser['id'],
                    reciver :  reciver
                }).then((res) => {
                    if (res.data.status === "success") { console.log('message sent successfully');} else {console.error("Unable to send message");}
                });
                for(var  i = 0; i < chatList.length; i++) {
                    var ul = chatList[0].parentElement;
                    if(chatList[i].getAttribute("data-chatid") == chat_id) {
                        var newNode = chatList[i];
                        ul.removeChild(chatList[i]);
                        ul.insertBefore(newNode,ul.childNodes[0]);
                        document.querySelector(".chat-left").scrollTop = 0;
                    }
                }
                pushinChat(messages);
            }
        });
        text.value = "";
    }

    function listen(chatid, pre_chat_id) {
        if(pre_chat_id !== null) {
            Echo.leaveChannel('chat' + pre_chat_id);
        }
        Echo.channel('chat' + chatid).listen('NewMessage', function(e){
            pushinChat(JSON.parse(e.messages));
        });
    }


    if (document.querySelectorAll(".chatlist")[0] != null) {
        chatListClicked();
        if(window.innerWidth > 700) {
            document.querySelectorAll(".chatlist")[0].click();
        } else {
            document.getElementById('clschatwhilesmall').onclick = function() {
                document.querySelector(".chat-right").style.display = "none";    
                console.log("adad");
            }
        }
        document.getElementById('send').onclick = function(){
            on_submit_message();
        }
    } else {
        if(document.querySelector(".chat-right") != null)
            document.querySelector(".chat-right").style.display = "none";    
    }
    
    window.onunload = function() {
        if(chat_id !== null && document.querySelectorAll(".chatlist")[0] != null) {
            Echo.leaveChannel('chat' + chat_id);
        }
    }
})();