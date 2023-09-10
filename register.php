<?php

require 'config.php';

if(!empty($_POST)){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if($username== '' || $email=='' || $password==''){
        echo "<script>alert('Fill the form data')</script>";
    }else{
        //query prepare
        $sql = "SELECT COUNT(email) AS num FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);

        //bind statement
        $stmt->bindValue(':email',$email);
        //execute statement
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row['num'] > 0){
            echo "<script>alert('This user email already exists')</script>";
        }else{
            $passwordHash = password_hash($password,PASSWORD_BCRYPT);

            $sql = "INSERT INTO users(name,email,password) VALUES (:username,:email,:password)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindValue(':username',$username);
            $stmt->bindValue(':email',$email);
            $stmt->bindValue(':password',$passwordHash);

            $result = $stmt->execute();

            if($result){
                echo "Thanks for your registration!".'<a href="login.php">Login</a>';
            }



        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registation Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">
        <div class="card-body">
            <h1>Register</h1>
            <form action="register.php" method="post">
                <div class="form-group">
                    <label for="username">Name</label>
                    <input type="text" class="form-control" name="username" value="">
                </div>
                <div class="form-group">
                    <label for="username">Email</label>
                    <input type="email" class="form-control" name="email" value="">
                </div>
                <div class="form-group">
                    <label for="username">Password</label>
                    <input type="password" class="form-control" name="password" value="">
                </div><br>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="" value="Register">
                    <a href="login.php">Login</a>
                </div>

            </form>
        </div>
    </div>
    
</body>
</html>