<div class="<?= isset($col_grid) && $col_grid != false ? $col_grid : "col-sm-12" ?>">
  
  <?php if (isset($in_box) && $in_box): ?>
    
  <div class="box box-solid">
    <?php if (isset($header) && $header != false): ?>
      <div class="box-header with-border">
        <h3 class="box-title"><?= $header ?></h3>
      </div>
    <?php endif ?>
    <!-- /.box-header -->
    <div class="box-body ">
  <?php endif ?>
      <div class="box-group" id="accordion">
        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->

        <?php foreach ($items as $key => $value): ?>
        <div class="panel box box-black">
          <div class="box-header with-border">
            <h4 class="box-title">
              <a data-toggle="collapse" data-parent="accordion" href="#collapse-<?= $key ?>">
                <?= $value['title'] ?>
              </a>
            </h4>
          </div>
          <div id="collapse-<?= $key ?>" class="panel-collapse collapse in">
            <div class="box-body">
              <?= $value['content'] ?>
            </div>
          </div>
        </div>

        <?php endforeach ?>
      </div>
  <?php if (isset($in_box) && $in_box): ?>

    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
    <?php endif ?>
</div>
