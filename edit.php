<?php

require 'config.php';

if(!empty($_POST)){
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $created_at = $_POST['created_at'];
    $id = $_POST['id'];

    if($_FILES){
        $targetFile = 'images/'.($_FILES['image']['name']);
        $imageName = $_FILES['image']['name'];
        $imageType = pathinfo($targetFile,PATHINFO_EXTENSION);

        if($imageType != 'jpg' && $imageType != 'png' && $imageType != 'jpeg'){
            echo "<script>alert('Image must be png or jpg,jpeg')</script>";
        }else{
            move_uploaded_file($_FILES['image']['tmp_name'],$targetFile);

            $pdo_statement = $pdo->prepare("UPDATE posts SET title='$title', description='$desc',
            image='$imageName',created_at='$created_at' WHERE id='$id'");
            $result = $pdo_statement->execute();
        }
    }else{
    $pdo_statement = $pdo->prepare("UPDATE posts SET title='$title', description='$desc', created_at='$created_at' WHERE id='$id'");
    $result = $pdo_statement->execute();

    }    
    if($result){
        echo "<script>alert('record is updated');window.location.href='index.php';</script>";
        };
}

$pdo_statement = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$pdo_statement->execute();
$result = $pdo_statement->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">
        <div class="card-body">
            <h1>Edit Record</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
                <div class="form-group">
                    <label for="username">Title</label>
                    <input type="text" class="form-control" name="title" value="<?php echo $result[0]['title'] ?>">
                </div>
                <div class="form-group">
                    <label for="username">Description</label>
                    <textarea class="form-control" name="description"  cols="80" rows="8"><?php echo $result[0]['description'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="">Image</label><br>
                    <img src="images/<?php echo $result[0]['image'] ?>" width="150" height="100" ><br><br>
                    <input class="form-control" type="file" name="image" value="images/<?php echo $result[0]['image'] ?>" >
                </div>
                <div class="form-group">
                    <label for="username">Date</label>
                    <input type="date" class="form-control" name="created_at" value="<?php echo date('Y-m-d',strtotime( $result[0]['created_at'])) ?>">
                </div><br>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="" value="Update">
                    <a class="btn btn-warning" href="index.php">Back to home</a>
                </div>

            </form>
        </div>
    </div>
    
</body>
</html>