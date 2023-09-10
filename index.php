<?php

session_start();

require "config.php";

if(empty($_SESSION['user_id']) || empty($_SESSION['logged_in'])){
    echo "<script>alert('Please login to continue');window.location.href='login.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>


<?php
    $pdo_statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
    $pdo_statement->execute();
    $result = $pdo_statement->fetchAll();
?>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <h1>Table Management</h1>
            <div>
                <a href="add.php" class="btn btn-primary">Create New</a>
                <a href="logout.php" class="btn btn-success" style="float:right">Logout</a>
            </div><br>

            <thead>
                <tr>
                    <th width="20%">Title</th>
                    <th width="40%">Description</th>
                    <th width="20%">Created At</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($result){
                        foreach($result as $value){
                ?>
                <tr>
                    <td><?php echo $value['title'] ?></td>
                    <td><?php echo $value['description'] ?></td>
                    <td><?php echo date('d-m-Y',strtotime($value['created_at'])) ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $value['id']?>">Edit</a>
                        <a href="delete.php?id=<?php echo $value['id']?>">Delete</a>
                    </td>
                </tr>
                <?php
                        }
                    }
                ?>
            </tbody>

        </table>
    </div>
</div>
    
</body>
</html>
