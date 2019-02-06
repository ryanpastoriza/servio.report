<?php if (isset($cssPlugins) && $cssPlugins != false): ?>
  <?php foreach ($cssPlugins as $key => $value): ?>
    <link rel="stylesheet" type="text/css" href="<?= $value ?>">
  <?php endforeach ?>
<?php endif ?>

<div class="content-wrapper">
   <section class="content-header">
    <?php if ($contentHeader): ?>
      <h1>
        <?= is_string($contentHeader) ? $contentHeader : ucfirst(str_replace("_", " ", $this->uri->segment($this->uri->total_segments()))) ?>
        <small>Control panel</small>
      </h1>
    <?php endif ?>
    <?php if (!isset($breadCrumbs) || $breadCrumbs != false): ?>
      <ol class="breadcrumb">
      <?php foreach ($this->uri->segment_array() as $key => $value): ?>

        <li class="<?= $value == $this->uri->segment($this->uri->total_segments()) ? "active" : "" ?>"><?= ucfirst(str_replace("_", " ", $value)) ?></li>

      <?php endforeach ?>
      </ol>
    </section>
    <?php endif ?>
    <section class="content">
          <div class="row">
            <?php if ($content): ?>
              <?php if (is_string($content)): ?>
                  <?= $content ?>
              <?php else: ?>
                <?php foreach ($content as $key => $value): ?>
                  <!-- <div class="row"> -->
                    <?= $value ?>
                  <!-- </div> -->
                <?php endforeach ?>
              <?php endif ?>
            <?php endif ?>
          </div>
    </section>
</div>