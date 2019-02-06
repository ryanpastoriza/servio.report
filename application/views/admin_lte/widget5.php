<div class="<?= isset($col_grid) ? $col_grid : "col-sm-12" ?>">
  <div class="box <?= isset($bgColor) ? $bgColor : 'box-default' ?> box-solid <?= isset($collapsed) && $collapsed != false ? 'collapsed-box' : '' ?>">
    <div class="box-header with-border">
      <h3 class="box-title"><?= isset($header) ? $header : "Title Here" ?></h3>

      <div class="box-tools pull-right">
        <?php if (isset($boxOptions) && $boxOptions): ?>
          <?php foreach ($boxOptions as $value): ?>
            <?= $value ?>
          <?php endforeach ?>
        <?php endif ?>
        <?php if (isset($collapsable) && $collapsable != false): ?>
          <button type="button" class="btn btn-box-tool collapsed" data-widget="collapse"><i class="fa  <?= isset($collapsed) && $collapsed != false ? 'fa-plus' : 'fa-minus' ?>"></i>
        <?php endif ?>
        <?php if (isset($removeable) && $removeable != false): ?>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        <?php endif ?>
      </div>
      <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <?= $body ?>
    </div>
    <!-- /.box-body -->
    <?php if (isset($foot) && $foot != false): ?>
      <div class="box-footer">
        <?= $foot ?>
      </div>
    <?php endif ?>

  </div>
  <!-- /.box -->
</div>