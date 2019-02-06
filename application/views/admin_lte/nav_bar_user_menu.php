<li class="dropdown user user-menu">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <img src="<?= $imgSrc ?>" class="user-image" alt="User Image">
    <span class="hidden-xs"><?= $userName ?></span>
  </a>
  <ul class="dropdown-menu">
    <li class="user-header">
      <img src="<?= $imgSrc ?>" class="img-circle" alt="User Image">

      <p>
        <?= $userName ?>
        <!-- <small>Member since Nov. 2012</small> -->
      </p>
    </li>
    <li class="user-body">
      <div class="row">
       <!--  <div class="col-xs-4 text-center">
          <a href="#">Followers</a>
        </div>
        <div class="col-xs-4 text-center">
          <a href="#">Sales</a>
        </div>
        <div class="col-xs-4 text-center">
          <a href="#">Friends</a>
        </div> -->
      </div>
    </li>
    <li class="user-footer">
      <div class="pull-left">
        <?php if (isset($leftBTN) && $leftBTN != false): ?>
            <?= $leftBTN ?>
        <!-- <a href="#" class="btn btn-default btn-flat">Profile</a> -->
        <?php endif ?>
      </div>
      <div class="pull-right">
        <?php if (isset($rightBTN) && $rightBTN != false): ?>
          <?= $rightBTN ?>          
        <?php endif ?>
      </div>
    </li>
  </ul>
</li> 