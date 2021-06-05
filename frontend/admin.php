<?php

include_once "../backend/security.php";

$id = 0;
$user = "";

$security = new Security();

$data = $security->checkToken();

if($data != null) {
  $id = $data[0];
  $user = $data[1];    
} else {
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Admin</title> 
	<link href="css/style.css" rel="stylesheet">
	<script src="js/jquery-3.5.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    </head>
    <body>
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Administration</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Manage <span class="caret"></span></a>
                  <div class="dropdown-menu" aria-labelledby="categories">
                    <a class="dropdown-item" href="#">Categories</a>
                  </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Statistics</a>
            </li>
          </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="cuenta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo htmlentities($user); ?> <span class="caret"></span></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="cuenta">
                      <a id="logout" name="logout" class="dropdown-item" href="#">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
      </nav>
      <div class="container-fluid" style="margin-top: 50px">
        Welcome <?php echo htmlentities($user); ?>
      </div>
    </body>
    <script>
        $(document).on('click', '#logout', function(e){ 
          $.ajax({
            url: "../backend/logout.php",
            type : "POST",
            dataType: 'json',
            contentType: 'application/json',
            processData: false,
            success : function(result){
                var status = result.status;
                if(status == 1) {
                    window.location = "index.php";
                } else {
                    alert("Bad logout");
                }
            },
            error: function(xhr, status, err){
                alert("Error in logout");
            }
          });
        });
    </script>
</html>
