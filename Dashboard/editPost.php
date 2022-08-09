
<?php
require_once('../connect.php');
require_once('../session.php');
sessionAdmin();
require_once('../functions.php');


$titleErr = $desErr = $error = "";
$idPost = $idCat = $post = $title = $des = $image = $typeP = '';

//if (isset($_GET['id']) && isset($_GET['idCate'])) {
  $idPost = $_GET['id'];
  $idCat  = $_GET['idCate'];

  $post   = getRowFor($connect,'Posts',$idPost);

  $title  = $post['title'];
  $des    = addslashes($post['description']);
  $image  = $post['image'];

  $typeP  = getRowFor($connect,'Category',$idCat)['type'];
//}
  $urlM     = "editPost.php?id=$idPost&idCate=$idCat";


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])){

    $title  = addslashes($_POST['title']); 
    $desc   = addslashes($_POST['des']);
    $cate   = $_POST['category'];

    $publisher = $_SESSION['id'];

    
    
    
    if(strlen($title) > 100){
        $titleErr = "Only 100 leter's";

    }elseif (strlen($desc) > 1000) {
        $desErr = "Only 1000 leter's";

    }elseif ($cate == '') {
        $error = "You shoud select one of the category filed.!";

    }else{
        $current_date = date('Y/m/d');
        print_r($_FILES);
        $image     = $_FILES['image']['name'];
        $tmp_image = $_FILES['image']['tmp_name'];
        $imageSize = $_FILES['image']['size'];
        if (!empty($image)) {
      
          $imageExt = explode(".", $image);
          $imageExtension = $imageExt[1];

            if($imageExtension == "PNG" || $imageExtension == "png" ||
               $imageExtension == "JPG" || $imageExtension == "jpg" ||
               $imageExtension == "JPEG"|| $imageExtension == "jpeg"){

                $image = rand(0, 100000).rand(0, 100000).rand(0, 100000).time().".".$imageExtension;
              $insertQuery = "UPDATE Posts SET 
                                 title = '$title',
                                 description = '$des', 
                                 image = '$image',
                                 date_Post = '$current_date',
                                 category_id = '$cate'
                                 WHERE id = '$idPost'";

                $row = mysqli_query($connect, $insertQuery) or die("Err Save Post");
                if($row){
                    if(move_uploaded_file($tmp_image,"../images/$image"))
                    {
                        $error = "You are successfully registered";
                        header("Location:../mainBlog.php");
                    }
                    else
                    {
                        $error = "Image is not uploaded";
                    }
                }

            }else{
                $error = "File must be an image";

            }
      }else{
          $insertQuery = "UPDATE Posts SET 
                                 title = '$title',
                                 description = '$des', 
                                 date_Post = '$current_date',
                                 category_id = '$cate'
                                 WHERE id = '$idPost'";

          $row = mysqli_query($connect, $insertQuery) or die("Err Save Post");
          header("Location:../mainBlog.php");
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
        <form action=" <?php echo $urlM;?> " method="post" enctype="multipart/form-data">
          
<!--           <fieldset>
            <legend> Create Post </legend>
 -->
            <div class="container">
                <label class="error"> <?php echo $error?> </label><br/>

                <label>Title:</label><br/>
                <input class="tit" type="text" placeholder="Maxmim leter's 40" name="title" 
                value=" <?php echo $title;?> " required>
                <lable for="error" style="color:Red"><?php echo $titleErr?></lable><br>

                <label>Description:</label><br/>
                <textarea class="desc" name="des" required> <?php echo $des;?> </textarea>
                <lable for="error" style="color:Red"><?php echo $desErr?></lable> <br>

                <div class="form-group">
                  <select name="category" class="form-control form-control-lg" id="country">
                    <?php

                        echo "<option value=$idCat> $typeP </option>";

                        while ($row = mysqli_fetch_assoc($res)) {
                            $type = $row['type'];
                            $id   = $row['id'];
                            if ($id != $idCat) {
                              echo "<option value=$id > $type </option>";
                            }
                        }
                    ?>
                  </select>
                </div>

                <br>
                <label>Post Image:</label><br/>
                <input type="file" name="image" id="imageupload"/><br/><br/>
                            
                <button type="submit" name="create">post</button>
                  
              </div>

<!--           </fieldset>
 -->          
        </form>

    </div>
</div>

</body>
</html>
