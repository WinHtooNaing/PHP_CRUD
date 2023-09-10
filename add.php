<?php

require 'config.php';

if(!empty($_POST)){
    

    $targetFile = 'images/'.($_FILES['image']['name']);
    $imageType = pathinfo($targetFile,PATHINFO_EXTENSION);

    if($imageType != 'jpg' && $imageType != 'png' && $imageType != 'jepg'){
        echo "<script>alert('Image must be png or jpg,jpeg')</script>";
    }else{
        move_uploaded_file($_FILES['image']['tmp_name'],$targetFile);

        $sql = "INSERT INTO posts(title,description,image,created_at) VALUES (:title, :description,:image, :created_at)";
    $pdo_statement = $pdo-> prepare($sql);

    $result = $pdo_statement->execute(
        array(':title' => $_POST['title'],':description' => $_POST['description'],':image' => $_FILES['image']['name'],
        ':created_at' => $_POST['created_at'])
    );

    if($result){
        echo "<script>alert('record is added');window.location.href='index.php';</script>";
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
            <h1>Add New Record</h1>
            <form action="add.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="username">Title</label>
                    <input type="text" class="form-control" name="title" value="">
                </div>
                <div class="form-group">
                    <label for="username">Description</label>
                    <textarea class="form-control" name="description"  cols="80" rows="8"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Image</label>
                    <input class="form-control" type="file" name="image" value="" required>
                </div>
                <div class="form-group">
                    <label for="username">Date</label>
                    <input type="date" class="form-control" name="created_at" value="">
                </div><br>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="" value="Create">
                    <a class="btn btn-warning" href="index.php">Back to home</a>
                </div>

            </form>
        </div>
    </div>
    
</body>
</html>