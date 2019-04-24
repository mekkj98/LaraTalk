if (axios) {
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    var token = document.head.querySelector('meta[name="csrf-token"]');

    if (token) window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    else console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');

    var acceptRequest = document.querySelectorAll(".accept-request"), // accept option => remove
        addFriend = document.querySelectorAll(".add-friend"), // add option => back request
        removeFriend = document.querySelectorAll(".remove-friend"), // remove option => add option
        backRequest = document.querySelectorAll(".back-request"); // back-request => add option

    var rejectRequest = document.querySelectorAll(".reject-request");

    function accept_friend() {
        acceptRequest = document.querySelectorAll(".accept-request")
        if (acceptRequest) {
            for (var i = 0; i < acceptRequest.length; i++) {
                acceptRequest[i].onclick = function () {
                    var currentuser = Number(this.getAttribute("data-thisuser"));
                    var seconduser = Number(this.getAttribute("data-seconduser"));
                    axios.post('/api/friends/request/accept', {
                        sender: currentuser,
                        reciver: seconduser
                    }).then((response) => {
                        if (response.data.status === "success") {
                            this.className = "remove-friend";
                            this.querySelector("span").innerHTML = "Remove";
                            removeFriend = document.querySelectorAll(".remove-friend");
                            if (this.nextElementSibling)
                                this.parentNode.removeChild(this.nextElementSibling);
                            remove_friend();
                        }
                        console.log(response.data);
                    }).catch((error) => {
                        console.log(error.response.data)
                    });
                };
            }
        }
    };

    function remove_friend() {
        removeFriend = document.querySelectorAll(".remove-friend")
        if (removeFriend) {
            for (var i = 0; i < removeFriend.length; i++) {
                removeFriend[i].onclick = function () {
                    var currentuser = this.getAttribute("data-thisuser");
                    var seconduser = this.getAttribute("data-seconduser");
                    axios.post('/api/friends/request/remove', {
                        sender: currentuser,
                        reciver: seconduser
                    }).then((response) => {
                        if (response.data.status === "success") {
                            this.className = "add-friend";
                            this.querySelector("span").innerHTML = "Add";
                            add_friend();
                        }
                        console.log(response.data);
                    }).catch((error) => {
                        console.log(error.response.data)
                    });
                };
            }
        }
    };

    function add_friend() {
        addFriend = document.querySelectorAll(".add-friend")
        if (addFriend) {
            for (var i = 0; i < addFriend.length; i++) {
                addFriend[i].onclick = function () {
                    var currentuser = Number(this.getAttribute("data-thisuser"));
                    var seconduser = Number(this.getAttribute("data-seconduser"));
                    axios.post('/api/friends/request/add', {
                        sender: currentuser,
                        reciver: seconduser
                    }).then((response) => {
                        if (response.data.status === "success") {
                            this.className = "back-request";
                            this.querySelector("span").innerHTML = "Cancel request";
                            this.querySelector("i").innerHTML = "cancel";
                            back_friend();
                        }
                        console.log(response.data.message);
                    }).catch((error) => {
                        console.error(error.response.data)
                    });
                };
            }
        }
    };



    function back_friend() {
        backRequest = document.querySelectorAll(".back-request")
        if (backRequest) {
            for (var i = 0; i < backRequest.length; i++) {
                backRequest[i].onclick = function () {
                    var currentuser = this.getAttribute("data-thisuser");
                    var seconduser = this.getAttribute("data-seconduser");
                    axios.post('/api/friends/request/take-back', {
                        sender: currentuser,
                        reciver: seconduser
                    }).then((response) => {
                        if (response.data.status === "success") {
                            this.className = "add-friend";
                            this.querySelector("span").innerHTML = "Add";
                            this.querySelector("i").innerHTML = "person_add";
                            add_friend();
                        }
                        console.log(response.data);
                    }).catch((error) => {
                        console.log(error.response.data)
                    });
                };
            }
        }
    };



    function reject_friend() {
        rejectRequest = document.querySelectorAll(".reject-request")
        if (rejectRequest) {
            for (var i = 0; i < rejectRequest.length; i++) {
                rejectRequest[i].onclick = function () {
                    var currentuser = this.getAttribute("data-thisuser");
                    var seconduser = this.getAttribute("data-seconduser");
                    axios.post('/api/friends/request/reject', {
                        sender: currentuser,
                        reciver: seconduser
                    }).then((response) => {
                        if (response.data.status === "success") {
                            this.className = "add-friend";
                            this.querySelector("span").innerHTML = "Add";
                            this.querySelector("i").innerHTML = "person_add";
                            if (this.previousElementSibling)
                                this.parentNode.removeChild(this.previousElementSibling);
                            add_friend();
                        }
                        console.log(response.data);
                    }).catch((error) => {
                        console.log(error.response.data)
                    });
                };
            }
        }
    };

    accept_friend();
    remove_friend();
    add_friend();
    back_friend();
    reject_friend();

    (function settingForm() {
        var submitbtn = document.getElementById('settingSubmit');
        if (submitbtn != null) {
            submitbtn.onclick = function () {
                axios.post('/api/form/setting/update', {
                    hide_email: document.getElementById('hideEmail').value,
                    hide_gender: document.getElementById('hideGender').value
                }).then((response) => {
                    console.log(response.data);
                    if (response.data.status === "success") {
                        window.location.reload();
                    }
                }).catch((error) => {
                    console.log(error.response.data)
                });
            }
        }
    })();
} else {
    console.error("Axios should must be included.");
}
