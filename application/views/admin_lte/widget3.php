<div class="<?= isset($col_grid) ? $col_grid : "col-sm-12" ?>">
  <!-- small box -->
  <div class="small-box <?= $bgColor ?>">
    <div class="inner">
      <h3><?= $body ?></h3>
      <p><?= $header ?></p>
    </div>
    <div class="icon">
      <?php if (isset($imgIcon)): ?>
        <img src="<?= $imgIcon ?>" height="100px" width="100px">
      <?php else: ?>
        <i class="<?= $icon ?>"></i>
      <?php endif ?>
    </div>
    <?php if (isset($moreLink)): ?>
      <a href="<?= $moreLink ?>" class="small-box-footer">
        More info <i class="fa fa-arrow-circle-right"></i>
      </a>
    <?php endif ?>
  </div>
</div>