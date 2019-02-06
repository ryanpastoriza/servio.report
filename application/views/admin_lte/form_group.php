<?php foreach ($formInputs as $key => $value): ?>
	<?php 
		$attributes = "";
		$class = " form-control ";
		$value['attribs']['type'] = isset($value['attribs']['type']) ? $value['attribs']['type']: 'text';

		foreach ($value['attribs'] as $key2 => $value2) {
			if ($key2 == 'class') {
				$value2 .= $class.$value2;
			}
				$attributes .= " {$key2} = '{$value2}'";
		}
		if (!isset($value['attribs']['class'])) {
			$attributes .= "class='form-control'";
		}
	 ?>
	<div class="<?= isset($value['col_grid']) && $value['col_grid'] != false ? $value['col_grid'] : col_grid(12) ?> ">
		<div class="form-group">
		<?php if ($key != 'blank'): ?>
		  <label><?= $key ?></label>
		<?php endif ?>
			  <?php if (isset($value['prefix'])): ?>
				  <div class="input-group">
			  	<span class="input-group-addon"><?= $value['prefix'] ?></span>
			  <?php endif ?>
			  <input <?= $attributes ?> >
			  <?php if (isset($value['prefix'])): ?>
		          </div>
			  <?php endif ?>
		</div>
	</div>
<?php endforeach ?>
