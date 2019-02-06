<!-- TODO:
  i active ang li kung naa sa insakto nga uri -->

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <?php if ($userPanel): ?>
        <div class="user-panel">
        <?php if (isset($userPanel['userImage'])): ?>
          <div class="pull-left image">
            <img src="<?= $userPanel['userImage'] ?>" class="img-circle" alt="User Image">
          </div>
        <?php endif ?>
          <div class="pull-left info">
            <p><?= $userPanel['userName'] ?></p>
            <a href="#"><i class="text-green"> <?= isset($userPanel['userInfo']) ? $userPanel['userInfo'] : "" ?> </i></a>
            <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
          </div>
        </div>
      <?php endif ?>
      <!-- search form -->
      <?php if ($searchBar): ?>
        <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                  </button>
                </span>
          </div>
        </form>
      <?php endif ?>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <?php foreach ($options as $key => $value): ?>
          <?php if (is_array($value['link'])): ksort($value['link'])?>
            <li class="treeview <?= in_array(current_url(), $value['link']) ? 'active' : '' ?>">
              <a href="#">
              <i class="<?= in_array(current_url(), $value['link']) ? 'text-white' : 'text-blue' ?> <?= $value['icon'] ?>"></i>
                <span><?= $key ?></span>
               <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <?php foreach ($value['link'] as $key2 => $value2): ?>
                    <li class="<?=  current_url() == $value2 ? 'active' : '' ?>"><a href="<?= $value2 ?>"><i class="fa fa-circle-o"></i><span><?= ucfirst($key2) ?></span></a></li>
                <?php endforeach ?>
              </ul>
            </li>
          <?php else: $linkSegments = explode('/',$value['link']); ?>
            <li class="<?= $linkSegments[count($linkSegments) - 1] == $this->uri->segment($this->uri->total_segments()) ? 'active' : ''?>">

              <a href="<?= $value['link'] ?>" <?= isset($value['attr']) ? $value['attr']: "" ?> > <i class="<?= $linkSegments[count($linkSegments) - 1] == $this->uri->segment($this->uri->total_segments()) ? 'text-white' : 'text-blue'?> <?= $value['icon'] ?>"></i> <span><?= ucfirst($key) ?></span></a>
            </li>
          <?php endif ?>
        <?php endforeach ?>
      </ul>
    </section>
    <!-- /.sidebar -->
</aside>