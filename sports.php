<?php

@include 'config.php';
session_start();
$email=$_SESSION['usermail'];
if(!isset($_SESSION['usermail'])){
    header('location:login_form.php');
 }
$query = "SELECT * FROM Game ";
$result = mysqli_query($conn, $query);
if (isset($_POST['submitt'])) {

    $game=  $_POST['game_name'];
    
    $select2 = " SELECT * FROM Game WHERE game_name = '$game'";
    $result2 = mysqli_query($conn, $select2);
    $select3 = " SELECT * FROM game_attend WHERE game_name = '$game' and email='$email'";
    $result3 = mysqli_query($conn, $select3);
    if (mysqli_num_rows($result2) > 0 && mysqli_num_rows($result3)==0) {
         
         $insert = "INSERT INTO game_attend(email,game_name) VALUES('$email','$game')";
         mysqli_query($conn, $insert);
         $error1[] = 'insert successfully';
     } 
     else{
        $error1[]='Wrong information';
     }
 
 }
 
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="csslog/style.css">
    <title>Game Participation Form</title>
    <style>
        .abc{
            margin-top: 200px;
            margin-left: 900px;
            text-align: center;
            font-size: 40px;
        }
        .form-container {
        flex: 50%;
        margin-left: 350px;
        height: 300px;
        
     }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <script src="https://kit.fontawesome.com/92ae17eca5.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'user_header.php'?>
    <div class="abc">
    <table border="1" cellspacing="10" cellpadding="10">
    <tr>
        <th>Available game</th>
    </tr>
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_assoc($result)) {
    ?>
            <tr>
                <td><?php echo $data['game_name']; ?> </td>
            </tr>
        <?php
        }
    } else { ?>
        <tr>
            <td colspan="3">No data found</td>
        </tr>
    <?php } ?>
   </table>
    </div>
    <div class="form-container">

        <form action="" method="post">
        <h1 class="title">Attend the game</h3>
        <?php
        if (isset($error1)) {
            foreach ($error1 as $error1) {
                echo '<span class="error-msg">' . $error1. '</span>';
            }
        }
        ?>
        
        <input type="text" name="game_name" placeholder="enter game name" class="box" required>
        <input type="submit" value="confirm" class="form-btn" name="submitt">
        </form>

        </div>
    
    <?php include 'footer.php'?>
</body>
</html>