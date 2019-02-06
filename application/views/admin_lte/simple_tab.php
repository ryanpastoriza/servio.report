<div class="<?= isset($col_grid) ? $col_grid : 'col-sm-12' ?>">
  <div class="nav-tabs-custom ">
    <ul class="nav nav-tabs <?= isset($nav_position) ? 'pull-'.$nav_position : ''?>">
      <?php $tabCounter = 0; foreach ($tabs as $key => $value): $tabCounter++ ?>
        <?php if (is_array($value)): ?>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              <?= $key ?> <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <?php $subcounter = 0; foreach ($value as $key2 => $value2): $subcounter++?>
                <?php if ($key2 == 'divider'): ?>
                  <li role="presentation" class="divider"></li>
                <?php else: ?>
                  <li><a data-toggle="tab" tabindex="-1" href="#<?= $tab_id.$tabCounter.$subcounter ?>"><?= $key2 ?></a></li>
                <?php endif ?>
              <?php endforeach ?>
            </ul>
          </li>
        <?php else: ?>
          <li class="<?= $tabCounter == 1 ? 'active' : '' ?>"><a href="#<?= $tab_id.$tabCounter ?>" data-toggle="tab"><?= $key ?></a></li>
        <?php endif ?>
      <?php endforeach ?>
    </ul>
    <div class="tab-content">
      <?php $tabCounter = 0; foreach ($tabs as $key => $value): $tabCounter++ ?>
        <?php if (is_array($value)): ?>
          <?php $subcounter = 0; foreach ($value as $key2 => $value2): $subcounter++ ?>
            <div class="tab-pane" id="<?= $tab_id.$tabCounter.$subcounter ?>">
              <div class="row">
                <?= $value2 ?> 
              </div>
            </div>
          <?php endforeach ?>
        <?php else: ?>
          <div class="tab-pane <?= $tabCounter == 1 ? 'active' : '' ?>" id="<?= $tab_id.$tabCounter ?>">
            <div class="row">
              <?= $value ?> 
            </div>
          </div>
        <?php endif ?>
      <?php endforeach ?>
    </div>
  </div>
</div>