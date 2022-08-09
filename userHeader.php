<?php 
     require_once 'connect.php';
     require_once 'functions.php';

     $titleWebsite = 'eHow';

     $idUser    = $_SESSION['id'];
     $row       = getRowFor($connect,'user',$idUser); //$_SESSION['User'];
     $nameUser  = $row['name'];
     $imageUser = $row['image'];

     // for nav-bar categorys
     $categorys = getDataTable($connect,'Category','',-1);
?>

<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Blog</title>

    <!-- Bootstrap core CSS -->
    <link href="CSS/bootstrap.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="CSS/userHeader.css" rel="stylesheet">

    </head>

<body>
<div class="container">
  <header class="blog-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
          <div class="col-4 pt-1">
           <h2>  <a class="link-secondary" href="mainBlog.php"> eHow </a></h2>
          </div>

          <div class="col-4 text-center ">
<!--             Chang the image user. -->
            <a href="#"> <img src= <?php echo "images/".$imageUser?> ; width="60" height="60" class="rounded-circle"></a>
          </div>

          <div class="col-4 d-flex justify-content-end align-items-center">
              <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
             <?php echo $nameUser;  ?>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li>
                  <a class="dropdown-item" href="profile.php?id=<?php echo $idUser ?>">
                    Edite  profile
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="logout.php">
                    log out
                  </a>
                </li>
                <?php
                if ($row['type'] == 'Admin') {                
                  echo "<li>
                      <a class=dropdown-item href=Dashboard/dashboard.php>
                        Dashboard
                      </a>
                    </li>";}
                ?>
                
              </ul>
          </div>

        </div>
  </header>

  <div class="nav-scroller py-1 mb-2">
    <nav class="nav d-flex justify-content-between">
      <?php
          while ($row = mysqli_fetch_assoc($categorys)) {
              $type = $row['type'];
              $id   = $row['id'];
              echo "<a class= p-2 link-secondary href= categoryPages.php?id=$id > $type </a>";
          }
      ?>
    </nav>
  </div>
</div>


<body>  



