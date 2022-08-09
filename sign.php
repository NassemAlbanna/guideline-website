
<?php
include("functions.php");
require_once 'connect.php';

$error = '';
$table1 = 'user';
$ty   =  isset($_GET['T']) ? $_GET['T'] : "";

$nameErr = $emailErr = $passErr = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sign'])){

    $name     = $_POST['uname'];
    $mail     = $_POST['mail'];
    $pass     = $_POST['psw'];
    $conPs    = $_POST['coPsw'];
    $gender   = $_POST['gen'];
    $imageDef = "download.jpeg";

    $type     = getTypeAccount();
    $status   = 'Inactive';
    $register = date('Y/m/d');


    if (empty($name)) {
            $nameErr = "Name is required";

        }else {
            $nameFilter = testInput($name);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/",$nameFilter)) {
                $nameErr = "Only letters and white space allowed";
            }
        }

    if (empty($mail)) {
            $emailErr = "Email is required";

        }else {
            $mailFilter = testInput($mail);
            // check if e-mail address is well-formed
            if (!filter_var($mailFilter, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }

    if (!empty($pass) && !empty($conPs)) {
        $pass  = testInput($pass);
        $conPs = testInput($conPs);

        if ($pass != $conPs) {
            $passErr = "No match password.!";
        }
    }else{
            $passErr = "password is require.!";
    }

        // check if no error found. 
    if (empty($nameErr) && empty($emailErr) && empty($passErr)) {

        if ($type == 'Admin') {$status = 'Active';}

       // $found = emailExists($connect,$mail);
        $found   = nameExists($connect,$name);
        if (!$found) {
          // Do the Encrept password.
            $pass = password_hash($pass,PASSWORD_DEFAULT);
            $sqlInsert  = "INSERT INTO user (name,password,email,gender,image,status,type,register_time) 
                            VALUES ('$name','$pass','$mail','$gender','$imageDef','$status','$type','$register')";

            mysqli_query($connect, $sqlInsert) or die("Error in inserting Data");
            mysqli_close($connect);
            header("Location:login.php");
        }else{
            $emailErr = "This User name already exite!";
        }
    }      
}

  
function getTypeAccount(){
    if (isset($_GET['T']) && $_GET['T'] == 'AD') { 
           return 'Admin';

    }else{
        return 'User';
    }
    
}

// if (isset($_POST['signv'])) {
        //     echo "is found" . $_POST['sign'];
        // }else{
        //   echo "Not found" . $_POST['sign'];
        // }
           

// $row    = mysqli_fetch_assoc($result1);

            //$row    = mysqli_fetch_row($result1);
            //print_r($row[1]);

            //mysql_free_result($resource);
            //mysql_close($link);
            //mysqli_close($conn);

?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="CSS/logAndSin1.css">
</head>
<body>


<form action="sign.php?T=<?php echo $ty;?>" method="post">
  
  <fieldset>
    <legend> Sign in </legend>

    <div class="container">
        <!-- <label for="uname"><b>Username</b></label> required-->
        <input type="text" placeholder="Enter Username" name="uname" >
        <lable for="error" style="color:Red"> <?php echo $nameErr?> </lable> 

        <!-- <label for="mail"><b>E-mail</b></label> -->
        <input type="text" placeholder="Enter e-mail" name="mail">
        <lable for="error" style="color:Red"><?php echo $emailErr?></lable> 

        <!-- <label for="psw"><b>Password</b></label> -->
        <input type="password" placeholder="Enter Password" name="psw">
        <input type="password" placeholder="Configer Password" name="coPsw" >
        <lable for="error" style="color:Red"><?php echo $passErr?></lable> 


        <label for="Gender"> <br> <b> Gender </b> <br>  </label>
        <input type="radio" name ="gen" value="f"/> Female |
        <input type="radio" name ="gen" value="m" checked="true" /> Male  <br>
          
        <button type="submit" name="sign">Sign in</button>
          
    </div>

    <div style="background-color:#f1f1f1">
        <span class="psw">Forgot <a href="#">password?</a></span>
    </div>
  </fieldset>
  
</form>

</body>
</html>
