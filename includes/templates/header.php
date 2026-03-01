<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
      <?php
      getTitle();
      ?>
    </title>
    <link rel="stylesheet" href="<?php echo $css;?>all.min.css" />
    <link rel="stylesheet" href="<?php echo $css;?>bootstrap.css" />
    <link rel="stylesheet" href="<?php echo $css;?>mainStyle.css" />
  </head>
  <body>
    <!-- START UPPER BAR -->
    <div class="upper-bar">
      <div class="container">
        <?php
        if(isset($_SESSION['User'])){
          if(checkUserStatus($_SESSION['User']) == 1){
            ?>
                <a href="profile.php">
                  <img class="Avater-img img-thumbnail" src="img.png" alt="">
                </a>
                    <span class="fa-pull-right" > 
                      Sorey Your Account 
                      <strong> <?php echo $_SESSION['User']?> </strong> 
                      IS not Activeted Please 
                      <a href="logout.php"> LOGOUT </a>  </span>
            <?php
          }else{
            ?>
              <a href="profile.php">
                <?php
                $stmtGetUser  = $connect->prepare("SELECT * FROM users WHERE Username = ?");
                $stmtGetUser -> execute(array($_SESSION['User']));
                $userInfo = $stmtGetUser ->fetch();
                ?>
              <img class="Avater-img img-thumbnail" src="admin/uploades/itemsImages/<?php echo $userInfo['Avater'] ?>">
              </a>
            <?php
          ?>
          <div class=" fa-pull-right">
          <a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo $_SESSION['User']?>
            </a>
            <ul class="dropdown-menu drop-right" aria-labelledby="offcanvasNavbarDropdown">
              <li><a class="dropdown-item" href="editeprofile.php"><i class="fa fa-user-pen"> </i> <?php echo lang('EDITPROFILE');?></a></li>
              <li><a class="dropdown-item" href="#"><i class="fa fa-gears"> </i> <?php echo lang('SETTING');?></a></li>
              <li><a class="dropdown-item" href="newad.php"><i class="fa fa-tag"> </i> Creat New Item </a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="logout.php"><i class="fa fa-right-from-bracket "></i> <?php echo lang('LOGINOUT');?></a></li>
            </ul>
          </div>
          <?php
          }
        }else{
        ?>
        <span class="date" >
          <script>
            var date_of_day = new Date();
            document.write(date_of_day);
          </script>
        </span>
        <span class="fa-pull-right" > 
          <a href="login.php"> <i class="fa fa-right-to-bracket "></i> LOGIN</a> | 
          <a href="singup.php"> <i class="fa fa-user-plus "></i> SINGUP</a> </span>
        <?php } ?>
      </div>
    </div>
    <!--  END UPPER BAR -->
        <!-- start navBar -->
        <nav class="navbar bg-light">
  <div class="container">
    <a class="navbar-brand" href="index.php">
    <img class="Avater-img img-thumbnail"style="width: 70px; height: 70px;" src="admin/layout/images/one.png">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
      <i class="fa fa-bars"></i>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><?php echo lang('HOME')?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
        <?php
        foreach(getCat() as $cat){
          ?>
          <li class="nav-item">
            <a class="nav-link" href="categories.php?pageid=<?php echo $cat['ID']?>"> <?php echo $cat['Name']?> </a>
          </li>
          <?php
      }
        ?>
        </ul>
        <form action="search.php"  class="d-flex" role="search">
          <input class="form-control me-2" type="search" name="word" placeholder="Search" aria-label="Search">
          <button class="btn btn-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </div>
</nav>
    <!-- start navBar -->
