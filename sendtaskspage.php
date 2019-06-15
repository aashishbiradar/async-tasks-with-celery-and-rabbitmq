<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
    <h1>Send Tasks</h1>
    </div>
    <div>
        <button id="send">Send</button>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
</script>
<script>
    $(document).ready(function(){
        $('#send').off().on('click',function(){
            $.ajax({
                method: "POST",
                url: "/async-tasks-with-celery-and-rabbitmq/sendtasks.php",
                data: {
                    args:{},
                    noOfTasks: 1
                },
                complete : function(res) {
                    console.log(res);
                }
            });
        });
    });
</script>
</html>