
<?php


function emailExists($conn,$mal){
    // Check if the E-mail is exit in the database.
        return helperExists($conn,'email',$mal);}

function nameExists($conn,$nam){
    // Check if the User name is exit in the database.
    return helperExists($conn,'name',$nam);}

function helperExists($conn,$col,$val){
	   $sqlCheck    = "SELECT * FROM user WHERE $col='$val'";
     $result2     = mysqli_query($conn, $sqlCheck);
     $row         = mysqli_fetch_assoc($result2);
     return $row;}

function checkAccount($conn,$nameU,$passU){
      // Do the encrept password oprition. 
      $sql    = "SELECT * FROM user WHERE name='$nameU'";
      $result = mysqli_query($conn,$sql) or die("Login Error");
      $row    = mysqli_fetch_assoc($result);
      mysqli_close($conn);
      
      if (isset($row) && password_verify($passU,$row['password'])){
      	    return $row;
      }else{
      	return false;
      }}

function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;}

function getRowFor($conn,$table, $id){
    $query  = "SELECT * FROM $table WHERE id=$id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);}

function getDataTable($conn,$table,$col,$val){

  $query  = "SELECT * FROM $table WHERE $col= $val";
  if ($val == -1) {
      $query  = "SELECT * FROM $table";
  }
  $result = mysqli_query($conn, $query) or die("Error in get the row's");

  return $result;} 

function getPagePosts($conn, $result){

  //$result = getDataTable($conn,'Posts','',-1);
  $po = '';

   while ($row = mysqli_fetch_assoc($result)){
        $id    = $row['id'];
        $image = "images/" . $row['image'];
        $title = $row['title'];
        $pub   = $row['publisher_id'];
        $url   = "detailsPage.php?id=$id";

        $idPub = $row['publisher_id'];
        $pub   = getRowFor($conn,'user',$idPub)['name'];

        $idCat = $row['category_id'];
        $cate  = getRowFor($conn,'Category',$idCat)['type'];

        $urlM  = "Dashboard/editPost.php?id=$id&idCate=$idCat";

        $po   .= "<div class= col>
                    <div class=card shadow-sm>
                      <img src= $image alt=Sandwich id = post-img>
                        <div class=card-body>
                          <h6 class =catagory-text>$cate<h6>
                          <a href= $url <p class=card-text> $title </p></a> 
              
                          <h6 class = publisher-text>By: $pub <h6>                          
                        </div>";
                        if ($idPub ==  $_SESSION['id']) {
                          $po   .="<div class = butt-post> 
                                    <a href = $urlM >Modilfile</a>
                                    <a href = Dashboard/deletePost.php?id=$id >Delete</a>
                                  </div>";
                        }
                        
        $po   .=    "</div>
                </div>";
    }
    return $po;}

function getPage2Posts($conn){

 $result = getDataTable($conn,'Posts','',-1);
  $po = '';

   while ($row = mysqli_fetch_assoc($result)){

        $id    = $row['id'];
        $title = $row['title'];
        $des   = $row['description'];
        $image = "../images/" . $row['image'];
        //$url   = "../detailsPage.php?id=$id";

        $idPub = $row['publisher_id'];
        $pub   = getRowFor($conn,'user',$idPub)['name'];

        $idCat = $row['category_id'];
        $cate  = getRowFor($conn,'Category',$idCat)['type'];
        
        $urlM  = "editPost.php?id=$id&idCate=$idCat";

        $po   .= "<div class=cart-item d-md-flex justify-content-between><span class=remove-item>
                    <i class=fa fa-times></i></span>

                      <div class=px-3 my-3>
                        <a class=cart-item-product href = ../detailsPage.php?id=$id>
                          <div class=cart-item-product-thumb><img src= $image alt=Product></div>
                          <div class=cart-item-product-info>
                              <h4 class=cart-item-product-title> $title </h4>
                              <div class=text-lg text-body font-weight-medium pb-1>$cate</div><span>By: <span class=text-success font-weight-medium>$pub</span></span>
                          </div>
                        </a>
                      </div>";
                       
                        if($idPub == $_SESSION['id']){
                          $po .= "<div class = butt-post> 
                              <a class = butt1 href = $urlM >Modilfile</a>
                              <a class = butt2 href = deletePost.php?id=$id >Delete</a>
                          </div>";
                        }
                      
              $po .= "</div>";
    }
    return $po;}




 ?>


  

  
