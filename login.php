<?php

require 'config.php';
session_start();

if(!empty($_POST)){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);

        //bind statement
        $stmt->bindValue(':email',$email);
        //execute statement
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(empty($user)){
            echo "<script>alert('fail')</script>";
            
        }else{
            $validPassword = password_verify($password,$user['password']);

            if($validPassword){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['logged_in'] = time();

                header('Location: index.php');
                exit();

            }else{
                echo "<script>alert('incorrect password')</script>";
            }

        }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="card">
        <div class="card-body">
            <h1>Login</h1>
            <form action="login.php" method="post">
                
                <div class="form-group">
                    <label for="username">Email</label>
                    <input type="email" class="form-control" name="email" value="" require>
                </div>
                <div class="form-group">
                    <label for="username">Password</label>
                    <input type="password" class="form-control" name="password" value="" require>
                </div><br>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="" value="Login">
                    <a href="register.php">register</a>
                </div>

            </form>
        </div>
    </div>

    
</body>
</html>