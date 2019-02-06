<div class="btn-group">
  <?php foreach ($buttons as $key => $value): ?>
    <?php if (is_array($value['link'])): ?>
      <button <?= $value['attr'] ?> data-toggle="dropdown"><?= $key?></button>
      <ul class="dropdown-menu" role="menu">
        <?php foreach ($value['link'] as $key2 => $value2): ?>
          <li><a href="<?= $value2['link'] ?>" <?= $value2['attr'] ?> ><?= $key2 ?></a></li>
        <?php endforeach ?>
      </ul>
    <?php else: ?>
      <button <?= $value['attr'] ?>><?= $key?></button>
    <?php endif ?>
  <?php endforeach ?>
</div>