<?php

/*
  Not working:
  1 Insert date in database.
  2 File not working the saveed.
  3 PrimraKey between user and post.
  4 projation the signAdmin to don't allow any one, except if the admin allow.
*/

include("functions.php");
include("session.php");

sessionLoging();

$table = 'user';
$nameErr = $passErr = $error = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])){
     // include_once('../Header/connect.php');
     require_once 'connect.php';

     $usName  = $_POST['usName'];
     $password= $_POST['pass'];
     $remember = isset($_POST['remember']);

     if (empty($usName)) {$nameErr = "Name is required";}
     if (empty($password)) {$passErr = "Password is required";}

       // check if no error found. 
    if (empty($nameErr) && empty($passErr)) {

        $password = testInput($password);
        $usName   = testInput($usName);
        //print_r($usName);
        $row = checkAccount($connect,$usName,$password);
        if ($row) {

            $status = $row['status'];
            $type   = $row['type'];

            if ($status == 'Active') {
                $_SESSION[$type] = $usName;
                $_SESSION['id']  = $row['id'];
                $_SESSION['img'] = $row['image'];
                print_r($_SESSION);
                if ($remember == 1){
                    setcookie('uname',$usName,time() + 3600,"/");
                    setcookie('password',$password,time() + 3600,"/");
                }

                if ($type == 'Admin'){
                  // Go to the admin page.
               //   header("Location:Dashboard/dashboard.php") ;
                }else{
                  // Go to the user page.
                 // header("Location:mainBlog.php");
                }
            }else{
              $error = "This account isn't active yet.!!";
            }

        }else{
            $error = "This account not exite!";
        }
    }     
      // $count = mysqli_num_rows($res) ;sign.php?T=AD
  }

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="CSS/logAndSin1.css">

</head>
<body>

<form action="login.php" method="post">
  

  <fieldset>
    <legend> Login </legend>

    <div class="container">
        <lable for="error" style="color:Red"><?php echo $error ?></lable> 

        <input type="text" placeholder="User name" name="usName">
        <lable for="error" style="color:Red"><?php echo $nameErr ?></lable> 

        <input type="password" placeholder="Password" name="pass">
        <lable for="error" style="color:Red"><?php echo $passErr ?></lable> 
                    
        <button type="submit" name="login">Login</button>
        <br>

        <label>
              <input type="checkbox" name="remember"> Remember me
        </label>
        <br>
        <br>
        <label>
              <span > Don't have account? <a href="sign.php">Sign in</a> </span>
        </label>

      </div>

    <div style="background-color:red">
       <span class="psw">Forgot <a href="#">password?</a></span>
    </div>
  </fieldset>

</form>

</body>
</html>
