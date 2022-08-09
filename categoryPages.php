<?php 

require_once ('session.php');
require_once ('userHeader.php');
require_once ('functions.php');
sessionUser();

$idCate = $_GET['id'];
$result = getDataTable($connect,'Posts','category_id',$idCate);

 ?>

<!doctype html>
<html lang="en">
  <head>
    
<style>
  .card{
    height: 450px;
  }

  #post-img{
    height: 250px;
  }
  .butt-post  a{
    padding: 7px;
    background-color: gray;
    color:white;
    float: left;
    margin: 10px;
    margin-left: 22%;
    border-radius: 5px;
  }
.butt-post{
  background-color: #f2f2f2;
}
</style>

    <!-- Custom styles for this template -->
    <link href="CSS/mainBlog.css" rel="stylesheet">
    
  </head>
  <body>
    
<main class="container">
  <div class="p-4 p-md-5 mb-4 text-white rounded bg-dark">
    <div class="col-md-6 px-0">
      <h1 class="display-4 fst-italic">Title of a longer featured blog post</h1>      
    </div>
  </div>

  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
       <?php echo getPagePosts($connect,$result); ?>
  </div>


    
</main>

<footer class="blog-footer">
  
</footer>


    
  </body>
</html>
