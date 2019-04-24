import Echo from 'laravel-echo'
window.Pusher =  require('pusher-js');
import Peer from 'simple-peer';

window.Echo = new Echo({
    broadcaster : 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted : false,
    wsHost: window.location.hostname,
    wsPort: 6001
});

(function() {
    var call = document.getElementById("call"),
        drop = document.querySelector("#drop"),
        dataSrc = document.querySelector("#chatRightHead");
    if(call != null) {
        var state = { hasMedia : false, otherUserId : null, stream : null, chat_id: null};
        var peers = {};
        var user = document.head.querySelector('meta[name="user-data"]').content;

        // document.querySelector('#myVideo').srcObject = stream;
        // document.querySelector("#senderVideo");

        function getpermission() {
            try {
                var stream = navigator.mediaDevices.getUserMedia({audio: true, video: true}).then(function(stream) {
                    state.stream  = stream;
                    state.hasMedia = true;
                }).catch(function(error){
                    throw new Error("Unable to fetch stream"); 
                });
            } catch(e) {
                console.log(e)
            }
        }

        function start() {
            Echo.join(`call.${state.chat_id}`).here((users) => {
                //
            })
        }

        call.addEventListener("click", function(){
            sate.chat_id = dataSrc.getAttribute("data-chatid");
            getpermission();
        });

        drop.addEventListener("click", function(){
            Echo.leaveChannel('call' + state.chat_id);
        });
    }
})();