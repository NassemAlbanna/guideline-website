
<?php
require_once('../connect.php');
require_once('../session.php');
sessionAdmin();
require_once('../functions.php');


$titleErr = $desErr = $error = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])){

    $title  = addslashes($_POST['title']); 
    $desc   = addslashes($_POST['des']);
    $cate   = $_POST['category'];

    $publisher = $_SESSION['id'];

    //print_r($_FILES);
    $image     = $_FILES["fileToUpload"]["name"];
    $tmp_image = $_FILES["fileToUpload"]["tmp_name"];
    $imageSize = $_FILES["fileToUpload"]["size"];

    //$image = "getty2.jpeg";
    //$imageSize = 1000;

    if(strlen($title) > 100){
        $titleErr = "Only 100 leter's";

    }elseif (strlen($desc) > 1000) {
        $desErr = "Only 1000 leter's";

    }elseif ($cate == '') {
        $error = "You shoud select one of the category filed.!";

    }else if($image == ""){
        $error = "Please upload your image";

    }
    else if($imageSize > 1048576){
        $error = "Image size must be less than 1 mb";

    }else{


        $imageExt = explode(".", $image);
        $imageExtension = $imageExt[1];
        $current_date = date('Y/m/d');

        if($imageExtension == "PNG" || $imageExtension == "png" ||
           $imageExtension == "JPG" || $imageExtension == "jpg" ||
           $imageExtension == "JPEG"|| $imageExtension == "jpeg"){

        $image = rand(0, 100000).rand(0, 100000).rand(0, 100000).time().".".$imageExtension;

            $insertQuery = "INSERT INTO Posts(title, description, image,date_Post, publisher_id, category_id)
                VALUES ('$title','$desc','$image','$current_date','$publisher','$cate')";

            $row = mysqli_query($connect, $insertQuery) or die("Err Save Post");
            if($row){
                if(move_uploaded_file($tmp_image,"../images/$image"))
                {
                    $error = "You are successfully registered";
                    header("Location:dashboard.php");
                }
                else
                {
                    $error = "Image is not uploaded";
                }
            }

        }else{
            $error = "File must be an image";

        }

    }   

}

    $sqlInsert  = "SELECT * FROM Category";
    $res        = mysqli_query($connect, $sqlInsert);
    //mysqli_close($connect);

?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../CSS/createPost.css">
</head>
<body>

<div id="wrapper">
    <div id="formDiv">
        <form action="createPost.php" method="post" enctype="multipart/form-data">
          
<!--           <fieldset>
            <legend> Create Post </legend>
 -->
            <div class="container">
                <label class="error"> <?php echo $error?> </label><br/>

                <label>Title:</label><br/>
                <input class="tit" type="text" placeholder="Maxmim leter's 100" name="title" required>
                <lable for="error" style="color:Red"><?php echo $titleErr?></lable><br> 

                <label>Description:</label><br/>
                 <textarea class="desc" rows="4" cols="50" name="des" required> </textarea>
                 <lable for="error" style="color:Red"><?php echo $desErr?></lable> <br>

                <div class="form-group">
                  <select name="category" class="form-control form-control-lg" id="country">
                    <option value="">Category</option>
                    <?php
                        while ($row = mysqli_fetch_assoc($res)) {
                            $type = $row['type'];
                            $id   = $row['id'];
                            echo "<option value=$id > $type </option>";
                        }
                    ?>
                  </select>
                </div>

                <br>
                <label>Post Image:</label><br/>
                <input type="file" name="fileToUpload" id="fileToUpload">
                <br/><br/>
                            
                <button type="submit" name="create">post</button>
                  
              </div>

<!--           </fieldset>
 -->          
        </form>

    </div>
</div>

</body>
</html>
