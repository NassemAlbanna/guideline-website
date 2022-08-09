<?php 

require_once('session.php');
require_once ('userHeader.php');
require_once ('functions.php');
sessionUser();

$result = getDataTable($connect,'Posts','',-1);
 ?>

<!doctype html>
<html lang="en">
  <head>
    
<style>
  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }
  
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
      <h1 class="display-4 fst-italic">What to look for when buying an artificial christmas tree</h1>
      
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
