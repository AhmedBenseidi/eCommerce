    <!-- start navBar -->
    <nav class="navbar bg-light">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">
    <img class="Avater-img img-thumbnail logo" style="width: 70px; height: 70px;" src="layout/images/one.png">
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
       
          <li class="nav-item">
            <a class="nav-link" href="categories.php">  <?php echo lang('CATEGORIES')?> </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="items.php">  <?php echo lang('ITEMS')?> </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="mebers.php">  <?php echo lang('MEBERS')?> </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="commenter.php">  <?php echo lang('COMMENTER')?> </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="order.php">  Order </a>
          </li>
       



          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo $_SESSION['Username']?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
              <li><a class="dropdown-item" href="../index.php" target="blank" ><i class="fa fa-eye"> </i> Visit Shop</a></li>
              <li><a class="dropdown-item" href="mebers.php?do=Edit&UserID=<?php echo $_SESSION['ID'];?>"><i class="fa fa-user-pen"> </i> <?php echo lang('EDITPROFILE');?></a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="logout.php"><i class="fa fa-right-from-bracket "></i> <?php echo lang('LOGINOUT');?></a></li>
            </ul>
          </li>
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
