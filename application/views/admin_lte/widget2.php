 <div class="<?= isset($col_grid) ? $col_grid : "col-sm-12" ?>">
    <div class="info-box <?= $bgColor ?>">
      <span class="info-box-icon"><i class="<?= $icon ?>"></i></span>

      <div class="info-box-content">
        <span class="info-box-text"><?= $header ?></span>
        <span class="info-box-number"><?= $body ?></span>

        <div class="progress">
          <div class="progress-bar" style="width:<?= isset($progress) ? $progress : "100"  ?>%"></div>
        </div>
            <span class="progress-description">
              <?= $foot ?>
            </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>