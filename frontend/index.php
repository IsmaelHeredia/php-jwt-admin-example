<?php

include_once "../backend/security.php";

$security = new Security();

$data = $security->checkToken();

if($data != null) {
    header("Location: admin.php");
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport"
	content="width=device-width, initial-scale=1, user-scalable=yes">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<title>Login</title>
	<link href="css/style.css" rel="stylesheet">
	<script src="js/jquery-3.5.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container-fluid">
        <div class="card card-primary login">
        <div class="card-header bg-primary">Login</div>
        <div class="card-body">
            <div class="card-block">
                <form id="formLogin" name="formLogin">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="user" class="form-control" id="user" name="user" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                    </div>
                    <div class="text-center">
                        <p class="lead">
                            <button type="submit" class="btn btn-primary long-button">Login</button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        </div>
	</div>
</body>
<script>

    $(document).on("submit", '#formLogin', function(e){

        e.preventDefault();

        var user = $("input[name='user']").val();
	    var password = $("input[name='password']").val();

        var formLogin = $(this);
        var form_data = JSON.stringify({"user": user, "password" : password});

        $.ajax({
            url: "../backend/login.php",
            type : "POST",
            dataType: 'json',
            contentType: 'application/json',
            processData: false,
            data : form_data,
            success : function(result){
                var status = result.status;
                if(status == 1) {
                    window.location = "admin.php";
                } else {
                    alert("Bad Login");
                }
            },
            error: function(xhr, status, err){
                alert("Bad login");
            }
        });

    });

</script>
</html>