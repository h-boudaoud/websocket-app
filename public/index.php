<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
            crossorigin="anonymous"
    />

    <script
            src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"></script>

    <script>
        let name = '';
        let msg = {
            from: '',
            content: 'hello word'
        }

        let messagesDiv = null;
        let msgContentInput = null;
        // let btnReset = null;
        // let btnSubmit = null;
        let msgForm = null;
        let userInfoDiv=null;
        const ws = new WebSocket('ws://127.0.0.1:3001');

        function newUsername() {
            return new Promise(resolve => {
                let username = ''
                let promptMessage = "Please enter your name";
                while (!username.trim()) {
                    username = prompt(promptMessage, "");
                    promptMessage = "Name is not valid \nPlease enter a new valide name";
                }
                resolve(username);
            });
        }


        $(window).on('load', () => {
            messagesDiv = $('#messages');
            msgContentInput = $("#msgContentInput");
            // btnSubmit = $("#btnSubmit");
            // btnReset = $("#btnReset");
            msgForm = $("#msgForm");
            userInfoDiv = $('#userInfo') ;
            const heightDiv = $(window).height() - (msgForm.height() + userInfoDiv.height() + 40);

            messagesDiv.height(heightDiv);
            ws.onopen = async () => {
                name = await newUsername();
                userInfoDiv.html('Welcome ' + name)
                msg.from = name
                console.log("Connection established!", msg);
                ws.send(JSON.stringify(msg));
            };

            console.log('msg', msg)

            ws.onmessage = function (e) {
                const data = JSON.parse(e.data);
                console.log('new message', data);
                messagesDiv.append(
                    "<li>" +
                    (data.from && data.from.trim()
                            ? "<button>" + data.from + "</button> : "
                            : ""
                    )
                    + data.content + "</li>")
            }
            ws.onclose = function () {
                alert("Connection closed...");
            };
            // const btnSubmit = $("#btnSubmit");
            msgForm.submit(function (event) {
                event.preventDefault();
                msg.content = msgContentInput.val();
                if (msgContentInput.val().trim()) {
                    console.log('send message : ', msgContentInput.val())
                    ws.send(JSON.stringify(msg));
                    messagesDiv.prepend("<li>" + msgContentInput.val() + "</li>")
                    msgContentInput.val("")
                }
            });
        });
    </script>
</head>
<body>
<section class="container-fluid">
    <h2 id="userInfo">Welcome</h2>
    <div class="row h-100">
        <div class="col-3 m-0">
            <ul id="users" class="bg-dark bg-gradient text-white list-group overflow-auto  h-100 m-0 p-2"></ul>
        </div>
        <div class="col-9 m-0">
            <ul id="messages" class="bg-dark bg-gradient text-white list-group overflow-auto m-0 p-2"></ul>
        </div>
    </div>

    <form id="msgForm" class="row m-0  fixed-bottom">
        <div id="channel" class="col-3 m-0">
            <input type="hidden"/>
            <label class="btn w-100 bg-info bg-gradient"><strong>All</strong> users</label>
        </div>
        <div class="col-9 d-flex m-0">
            <div class="form-group mb-3 w-100">
                <input
                        type="text"
                        class="form-control"
                        id="msgContentInput"
                        name="username"
                        value=""
                        placeholder="tape your message her"
                />
            </div>
            <div id="sendTo" class="w-25">
                <input type="hidden"/>
                <button class="btn bg-info bg-gradient w-100" type="submit" id="btnSubmit">
                    Send to <strong>All</strong>
                </button>
            </div>
            <div>
                <button class="btn bg-warning bg-gradient" type="reset" id="btnReset">Reset</button>
            </div>
        </div>
    </form>
</section>

<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"
></script>
</body>
</html>