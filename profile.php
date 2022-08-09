<?php

require_once 'session.php';
require_once 'functions.php';
require_once 'connect.php';
sessionProfile();

$error = $errorImg = '';
$id    = $_SESSION['id'];
$row   = getRowFor($connect,'User',$id);

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {

	if (isset($_POST['update'])) {

		$name = $_POST['fName'];
		$pass = $_POST['newPass'];
		$conP = $_POST['conPass'];

		if (!empty($name) && !empty($pass) &&  !empty($conP)) {
			// Gets the image info from the user after upload.
			$image     = $_FILES["fileToUpload"]["name"] ;
	    	$tmp_image = $_FILES["fileToUpload"]["tmp_name"];
	    	$imageSize = $_FILES["fileToUpload"]["size"];

			//for saveing the image from user
			if (!empty($image)) {
				
		    	// Split the name image and the image format. 
				$imageExt = explode(".", $image);
	        	$imageExtension = $imageExt[1];

	        	// Check if the format of the image is correct.
				if($imageExtension == "PNG" || $imageExtension == "png" ||
	               $imageExtension == "JPG" || $imageExtension == "jpg" ||
	               $imageExtension == "JPEG"|| $imageExtension == "jpeg"){

	               // Generate new name for the image.	
	               $image = rand(0, 100000).rand(0, 100000).rand(0, 100000).time().".".$imageExtension;

	           	   // Updata the database for the new image uploaded.
	               $insertQuery = "UPDATE user SET image='$image' WHERE id=$id";
				   $row = mysqli_query($connect, $insertQuery) or die("Err update photo");

				   if($row){
		                if(move_uploaded_file($tmp_image,"images/$image")){
		                    $errorImg = "You are successfully uploded.!!";
		                    $_SESSION['img'] = $image;

		                }else{
		                    $errorImg = "Image is not uploaded";
		                }
	            	}						
				}
			}


			if ($pass == $conP) {
	        	  $pass = password_hash($pass,PASSWORD_DEFAULT);
	        	  $sql = "UPDATE user SET name='$name', password='$pass' WHERE id=$id";
	        	  $row  = mysqli_query($connect, $sql); 

				  if ($row) {
				  	$type = $row['type'];
				  	$_SESSION[$type] = $name;
					backHome();
				  }
				   
			}else{
				  $error = "Password does not match.!";
			}

		}else{
			$error = "Some filed is missing.!";
		}
	}elseif (isset($_POST['cancel'])) {
			backHome();
	}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <title>account setting</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<!-- 	<link href="CSS/bootstrap.css" rel="stylesheet">-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
<div class="container">
<div class="row gutters">
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
<div class="card h-100">
	<div class="card-body">
		<div class="account-settings">
			<div class="user-profile">
				<div class="user-avatar">
					<img src=<?php echo "images/".$row['image']?> ; alt="Maxwell Admin">
				</div>
				<h5 class="user-name">  <?php echo $row['name']; ?> </h5>
				<h6 class="user-email"> <?php echo $row['email'];?></h6>
			</div>
		</div>
	</div>
</div>
</div>
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
<div class="card h-100">

	<form action="profile.php?id=<?php echo $id;?>" method="post" enctype="multipart/form-data">

		<div class="card-body">
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<h6 class="mb-2 text-primary">Personal Details</h6>
			</div>

			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="fullName">Full Name</label>
					<input type="text" name = "fName" class="form-control" id="fullName" placeholder="Enter full name" value="<?php echo $row['name']; ?>">
				</div>
			</div>

			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="eMail">Email</label>
					<input type="email" name = "email" class="form-control" id="eMail" placeholder="Enter email" value="<?php echo $row['email']; ?>" >
				</div>
			</div>
			
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="website">New Password:</label>
					<input type="password" name = "newPass" class="form-control" id="website">
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="website">Confirm Password:</label>
					<input type="password" name = "conPass" class="form-control" id="website" >
				</div>
			</div>
		</div>
		
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="text-right">
					<button type="submit" id="submit" name="cancel" class="btn btn-secondary">Cancel</button>
					<button type="submit" id="submit" name="update" class="btn btn-primary">Update</button>
				</div>
			</div>
		</div>
			<label style="color: red"><?php echo $error . " " . $errorImg; ?></label><br><br>
			<label>Change photo:</label><br>
			<input type="file" name="fileToUpload" id="fileToUpload"> 
	</div>
	</form>
	
</div>
</div>
</div>
</div>

<style type="text/css">
body {
    margin: 0;
    padding-top: 40px;
    color: #2e323c;
    background: #f5f6fa;
    position: relative;
    height: 100%;
}
.account-settings .user-profile {
    margin: 0 0 1rem 0;
    padding-bottom: 1rem;
    text-align: center;
}
.account-settings .user-profile .user-avatar {
    margin: 0 0 1rem 0;
}
.account-settings .user-profile .user-avatar img {
    width: 90px;
    height: 90px;
    -webkit-border-radius: 100px;
    -moz-border-radius: 100px;
    border-radius: 100px;
}
.account-settings .user-profile h5.user-name {
    margin: 0 0 0.5rem 0;
}
.account-settings .user-profile h6.user-email {
    margin: 0;
    font-size: 0.8rem;
    font-weight: 400;
    color: #9fa8b9;
}
.account-settings .about {
    margin: 2rem 0 0 0;
    text-align: center;
}
.account-settings .about button {
    margin: 0 0 15px 0;
    color: #007ae1;
}
.account-settings .about p {
    font-size: 0.825rem;
}
.form-control {
    border: 1px solid #cfd1d8;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;
    font-size: .825rem;
    background: #ffffff;
    color: #2e323c;
}

.card {
    background: #ffffff;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border: 0;
    margin-bottom: 1rem;
}


</style>

<script type="text/javascript">

</script>
</body>
</html>