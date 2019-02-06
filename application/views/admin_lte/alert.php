<div class="alert <?= isset($bgColor) && $bgColor != false ? $bgColor : 'alert-default' ?> <?= isset($closeBtn) && $closeBtn == true ? 'alert-dismissible' : '' ?>">
<?php if (isset($closeBtn) && $closeBtn == true): ?>
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<?php endif ?>
	<h4><i class="icon <?= isset($icon) && $icon !=false ? $icon : '' ?>"></i> <?= isset($header) && $header != false ? $header : "" ?></h4>
	<?= isset($body) && $body != false ? $body : '' ?>
</div>