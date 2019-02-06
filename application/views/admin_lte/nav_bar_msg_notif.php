<li class="dropdown messages-menu">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-envelope-o"></i>
    <span class="label label-success"><?= $unreadTotal != 0 ? $unreadTotal : "" ?></span>
  </a>
  <ul class="dropdown-menu">
    <li class="header">You have <?= $unreadTotal ?> messages</li>
    <li>
      <!-- inner menu: contains the actual data -->
      <ul class="menu">
        <?php if (isset($messages) && $messages) : ?>
          <?php foreach ($messages as $key => $value): ?>
            <li><!-- start message -->
              <a href="<?= $value['link'] ?>">
                <!-- <div class="pull-left"> -->
                  <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->
                <!-- </div> -->
                <h4>
                  <?= $value['subject'] ?>
                  <!-- <small><i class="fa fa-clock-o"></i> 5 mins</small> -->
                </h4>
                <p><?= $value['contentPrev'] ?></p>
              </a>
            </li>
          <?php endforeach ?>
          
        <?php endif ?>
        <!-- end message -->
      </ul>
    </li>
    <li class="footer"><a href="<?= $seeAllLink ?>">See All Messages</a></li>
  </ul>
</li>