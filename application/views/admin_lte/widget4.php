<div class="<?= isset($col_grid) ? $col_grid : "col-sm-12" ?>">
  <?= isset($formData) && $formData != false ? $formData['form_open'] : "" ?>
  <div class="box <?= isset($bgColor) ? $bgColor : 'box-default' ?> <?= isset($collapsable) && $collapsable != false ? 'collapsed-box' : '' ?>">
    <div class="box-header with-border">
      <h3 class="box-title">
        <?php if (isset($icon)): ?>
          <i class="<?= $icon ?>"></i>
        <?php endif ?>
        <?= $header ?>
      </h3>

      <div class="box-tools pull-right">
      
        <?php if (isset($collapsable) && $collapsable): ?>
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
        <?php endif ?>
        <?php if (isset($removeable) && $removeable ): ?>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        <?php endif ?>
        </button>
      </div>
      <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <?= $body ?>
    </div>
    <!-- /.box-body -->
    <?php if (isset($foot)): ?>
    <div class="box-footer">
      <?= $foot ?>
    </div>
    <?php endif ?>

  </div>
  <?= isset($formData) && $formData != false ? "</form>" : "" ?>
  <!-- /.box -->
</div>
<?php if (isset($formData['ajaxform'])): ?>
  <script type="text/javascript">
    var formOptions = {};
    <?php foreach ($formData['ajaxform'] as $key => $value): ?>
        formOptions.<?= $key ?> = <?= $value; ?>;
    <?php endforeach ?>

    $("#<?= $formID ?>").ajaxForm(formOptions);
  </script>
<?php endif ?>