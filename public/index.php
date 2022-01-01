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
            from:'',
            content :'hello word'
        }
        const ws = new WebSocket('ws://127.0.0.1:3001');
        function newUsername() {

            return new Promise(resolve => {
                let username=''
                let promptMessage = "Please enter your name";
                while (!username.trim()) {
                    username = prompt(promptMessage, "");
                    promptMessage = "Name is not valid \nPlease enter a new valide name";
                }
                resolve(username);
            });
        }


        $(window).on('load', () => {

            ws.onopen = async ()=> {
                name = await newUsername();
                $('#userInfo').html('Welcome '+name)
                msg.from = name
                console.log("Connection established!", msg);
                ws.send(JSON.stringify(msg));
            };

            console.log('msg', msg)

            ws.onmessage = function (e) {
                const data = JSON.parse(e.data);
                console.log('new message', data);
                $("#messages").append(
                    "<li>"+
                    (data.from && data.from.trim()
                            ? "<button>"+data.from+"</button> : "
                            :""
                    )
                    + data.content + "</li>")
            }
            ws.onclose = function () {
                alert("Connection closed...");
            };
            const content = $("#msgContent");
            // const btnSubmit = $("#btnSubmit");
            const msgForm = $("#msgForm");
            msgForm.submit(function (event) {
                event.preventDefault();
                msg.content = content.val();
                if (content.val().trim()) {
                    console.log('send message : ', content.val())
                    ws.send(JSON.stringify(msg));
                    $("#messages").append("<li>" + content.val() + "</li>")
                    content.val("")
                }
            });
        });
    </script>
</head>
<body>
<section class="container">
    <h2 id="userInfo">Welcome</h2>
    <ul id="messages" class="bg-dark text-white list-group m-1 p-2" style="height: 70vh"></ul>
    <form id="msgForm" class="d-flex m-1">
        <div id="sendTo">
            <label></label>
            <input type="hidden" />
        </div>
        <div class="form-group mb-3  w-100">
            <input
                    type="text"
                    class="form-control"
                    id="msgContent"
                    name="username"
                    value=""
                    placeholder="tape your username her"
            />
        </div>
        <div>
            <button class="btn btn-primary"  type="submit" id="btnSubmit">Submit</button>
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