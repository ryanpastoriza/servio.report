 <footer class="main-footer">
    <div class="pull-right hidden-xs">
    	<?php if (isset($right)): ?>
    		<?= $right ?>
		<?php else: ?>
		    <b>Version</b> 2.3.3
    	<?php endif ?>
    </div>
    <?php if (isset($left)): ?>
    	<?= $left ?>
    <?php else: ?>
    	<strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights

    	reserved.
	<?php endif ?>
  </footer>


<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<?php if ($addScripts): ?>
    <?php foreach ($addScripts as $key => $value): ?>
        <?= $value ?>
    <?php endforeach ?>
<?php endif ?>