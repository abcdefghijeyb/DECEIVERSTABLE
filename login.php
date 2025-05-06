<?php
    session_start();
    if(isset($_SESSION["user"])){
        header('location:index.php');
    }
?>
<?php
            if (isset ($_POST["login"])){
                $email = $_POST["email"];
                $password = $_POST["password"];
                    require_once "database.php";
                    $sql = "SELECT * FROM users WHERE email = '$email'";
                    $result = mysqli_query($conn, $sql);
                    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    if ($user) {
                        if (password_verify($password, $user["password"])){
                            $_SESSION["user"] = "yes";
                           header("Location: index.php");
                           die();
                    }else{
                        echo "<div class='alert alert-danger'>Password does not match </div>";
                    }
                    }else{
                        echo "<div class='alert alert-danger'>Email does not match </div>";
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Page</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">        <link rel="stylesheet" href="style.css">
    
    </head>
<body> 
    <div class="container">
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
</div>  

            <div class="form-group">
                <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
</div>

    <div class="form-btn">
        <input type="submit" value="Login" name="login" class="btn btn-primary"> 
</div>

</form>
        <div><p>Not Registered yet? <a href="registration.php"> Register Here! </a></div>
</div>
</body>
</html>
