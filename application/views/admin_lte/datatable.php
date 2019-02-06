<!-- helper -->
<?php if (isset($helper) && $helper): ?>
	<h2>Table Variables</h2>
	<table class="table">
		<tr>
			<th> $tableId </th>
			<td> - id of the table </td>
		</tr>
		<tr>
			<th>$tblVarName</th>
			<td> - name of the variable that stores the datatable object</td>
		</tr>
		<tr>
			<th> $checkbox </th>
			<td> - true/false <br> 
				Adds checkboxes at the beginning of each row in the table.
			</td>
		</tr>
		<tr>
			<th> $tableHeaders </th>
			<td> - array of table header titles </td>
		</tr>
		<tr>
			<th> $tableRows</th>
			<td> - array of table row values<br>
					e.g.<br>
					array(array('value1', 'value2','value3'), ...)
					<br>
					or a blank array for a default of no rows.
			</td>
		</tr>
		<tr>
			<th> $tableOptions </th>
			<td> - array containing the settings for datatable plugin. <br>
					false if not using datatable plugin.
			</td>
		</tr>
		<tr>
			<th> $tblCallBacks </th>
			<td> - array containing the method callbacks of the datatable plugin <br>
				e.g.
				['fnDrawCallback' => "function(){ alert('wata') }"]
			</td>
		</tr>
		<tr>
			<th>$helper</th>
			<td> - true/false <br> 
				show/hide this variable helper.
			</td>
		</tr>
	</table>
<?php endif ?>
<!-- helper -->

<div class="col-xs-12">
	<div class="clearfix">
		<div class="pull-right tableTools-container"></div>
	</div>

	<!-- div.table-responsive -->

	<!-- div.dataTables_borderWrap -->
	<div class="table-responsive">
		<table id="<?= isset($tableId) && $tableId != false ? $tableId : '' ?>" class="table table-striped table-bordered table-hover" style="width:100%">
			<thead>
				<tr>
				<?php if (isset($checkbox) && $checkbox != false): ?>
					<th class="center">
						<label class="pos-rel">
							<input type="checkbox" class="ace" />
							<span class="lbl"></span>
						</label>
					</th>
				<?php endif ?>
				<?php foreach ($tableHeaders as $key => $value): ?>
					<th><?= $value ?></th>					
				<?php endforeach ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($tableRows as $key => $value): ?>
					<tr>
					<?php if (isset($checkbox) && $checkbox != false): ?>
						<td class="center">
							<label class="pos-rel">
								<input type="checkbox"/>
								<span class="lbl"></span>
							</label>
						</td>
					<?php endif ?>
						<?php foreach ($value as $k2 => $td): ?>
							<td><?= $td ?></td>
						<?php endforeach ?>
					</tr>
					
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
<?php if (isset($tableOptions)): ?>
	<script type="text/javascript">
		var <?= $tblVarName ?>options = <?= json_encode($tableOptions) ?>;

		$(function(){
			<?php if(isset($totalFooter) && $totalFooter ): ?>
				var footer = "<tfoot>";
					<?php $counter = 0; foreach ($tableHeaders as $key => $value): $counter++ ?>
						<?php if($counter == 1): ?>
							footer = footer + "<th>Total</th>";
						<?php else: ?>
							footer = footer + "<th></th>";
						<?php endif ?>
					<?php endforeach ?>
					footer = footer + "</tfoot>";
				$('#<?= $tableId ?>').append(footer);
				<?= $tblVarName ?>options.footerCallback = function( row, data, start, end, display){
											 var api = this.api(), data;
											
											  <?php foreach ($totalFooter as $key => $value): ?>
											  	 total = api
								                .column( <?= $key ?> )
								                .data()
								                .reduce( function (a, b) {
								                	<?php if($value != false): ?>
														b = b.replace("<?= $value ?> ","");
								                	<?php endif ?>
								                    var tot =  intVal(a) + intVal(b);
								                    return number_format(tot);
								                }, 0 );
								                $('#<?= $tableId ?> tfoot th:nth-child(<?= $key + 1 ?>)').html("<?= $value ?> "+total);
											  <?php endforeach ?>

									         

										};
			<?php endif ?>
		if (typeof dataTableScript == 'undefined') {
			var script = document.createElement( 'script' );
				script.type = 'text/javascript';
				script.src = <?= "'".asset_url('plugins/datatables/jquery.dataTables.min.js')."'" ?>;

			var script2 = document.createElement( 'script' );
				script2.type = 'text/javascript';
				script2.src = <?= "'".asset_url('plugins/datatables/dataTables.bootstrap.min.js')."'" ?>;

			var script3 = document.createElement( 'script' );
				script3.type = 'text/javascript';
				script3.src = <?= "'".asset_url('plugins/datatables/extensions/buttons/js/buttons.bootstrap.min.js')."'" ?>;
			var script4 = document.createElement( 'script' );
				script4.type = 'text/javascript';
				script4.src = <?= "'".asset_url('plugins/datatables/extensions/buttons/js/dataTables.buttons.min.js')."'" ?>;
			var script5 = document.createElement( 'script' );
				script5.type = 'text/javascript';
				script5.src = <?= "'".asset_url('plugins/datatables/extensions/buttons/js/buttons.flash.min.js')."'" ?>;
			var script6 = document.createElement( 'script' );
				script6.type = 'text/javascript';
				script6.src = <?= "'".asset_url('plugins/datatables/extensions/buttons/js/buttons.html5.min.js')."'" ?>;
			var script7 = document.createElement( 'script' );
				script7.type = 'text/javascript';
				script7.src = <?= "'".asset_url('plugins/datatables/extensions/buttons/js/buttons.print.min.js')."'" ?>;
			var script8 = document.createElement( 'script' );
				script8.type = 'text/javascript';
				script8.src = <?= "'".asset_url('plugins/datatables/jszip.min.js')."'" ?>;
			var script9 = document.createElement( 'script' );
				script9.type = 'text/javascript';
				script9.src = <?= "'".asset_url('plugins/datatables/pdfmake.min.js')."'" ?>;
			var script10 = document.createElement( 'script' );
				script10.type = 'text/javascript';
				script10.src = <?= "'".asset_url('plugins/datatables/vfs_fonts.js')."'" ?>;




			$('body').prepend("<link rel='stylesheet' href='<?= asset_url('plugins/datatables/dataTables.bootstrap.css') ?>'>");
			$('body').prepend("<link rel='stylesheet' href='<?= asset_url('plugins/dataTables/extensions/buttons/css/buttons.bootstrap.min.css') ?>'>");
			$('body').prepend(script);
			$('body').prepend(script2);
			$('body').prepend(script4);
			$('body').prepend(script3);
			$('body').prepend(script5);
			$('body').prepend(script6);
			$('body').prepend(script7);
			$('body').prepend(script8);
			$('body').prepend(script9);
			$('body').prepend(script10);

			dataTableScript = true;
		}
		

		<?php if( isset($selectionEnabled) && $selectionEnabled ): ?>
			var rows_selected = [];

		 	var selectScript 	= document.createElement( 'script' );
				selectScript.type 	= 'text/javascript';
				selectScript.src 	= <?= "'".asset_url('plugins/datatables/extensions/Select/js/dataTables.select.min.js')."'" ?>;
				$('body').prepend("<link rel='stylesheet' href='<?= asset_url('plugins/dataTables/extensions/Select/css/select.bootstrap.min.css') ?>'>");
				$('body').prepend(selectScript);

			 // <?= $tblVarName ?>options.columnDefs = [{
				// 				         'targets': 0,
				// 				         'searchable': false,
				// 				         'orderable': false,
				// 				         'width': '1%',
				// 				         'className': 'dt-body-center',
				// 				         'render': function (data, type, full, meta){
				// 				             return '<input type="checkbox" name="tbl_cb[]">';
				// 				         }
				// 				      }];
			<?= $tblVarName ?>options.rowCallback = function(row, data, dataIndex){
							         // Get row ID
							         var rowId = data[0];

							         // If row ID is in the list of selected row IDs
							         // if($.inArray(rowId, rows_selected) !== -1){
							            $(row).find('input[type="checkbox"]').val(data[0]);
							            // $(row).addClass('selected');
							         // }
							      }

			// handle clicking of row to check the checkbox

			// $(document).on('click',"#<?= $tableId  ?> tbody > tr",function(){
			// 	if ($(this).hasClass('selected') == true) {
			// 		$(this).find('td:eq(0)').find('[type=checkbox]').prop('checked','checked');
			// 	}else{
			// 		$(this).find('td:eq(0)').find('[type=checkbox]').attr('checked',false);
			// 	}
			// });
			$(function(){
				<?= $tblVarName ?>.on( 'select', function ( e, dt, type, indexes ) {
			        checkSelected();

			        // if ( type === 'row' ) {
			        //     $("#<?= $tableId  ?> tbody > tr.selected").find('[type=checkbox]').prop('checked','checked');
			        // }
			    } );
			    <?= $tblVarName ?>.on( 'deselect', function ( e, dt, type, indexes ) {
			        checkSelected();
			        // if ( type === 'row' ) {
			        //     $("#<?= $tableId  ?> tbody > tr:not(.selected)").find('[type=checkbox]').prop('checked',false);
			        // }
			    } );
			})

			function checkSelected(){
				var allSelected = [];
				var sel = <?= $tblVarName ?>.rows( { selected: true } ).data();

				$(sel).each(function(k,v){
					allSelected.push(v[0]);
				});
				$('input[name=tbl_cb]').val(JSON.stringify(allSelected));
			}


		<?php endif ?>

		<?php if (!isset($tableOptions['dom'])) : ?>
			<?= $tblVarName ?>options.dom = '<".pull-left"f><".col-sm-4"l><?= isset($tableOptions['buttons']) ? '<".pull-right"B>tip' : "tip" ?>';
		<?php endif ?>

		<?php if(isset($tblCallBacks) && $tblCallBacks != false) :?>
			<?php foreach ($tblCallBacks as $key => $value): ?>
				<?= $tblVarName ?>options.<?= $key ?> = <?= $value ?>;
			<?php endforeach ?>
		<?php endif ?>

		<?= $tblVarName ?> = $('#<?= $tableId ?>').DataTable(<?= $tblVarName ?>options);
		<?php 
			if (isset($datepickers) && $datepickers == true) {
				?>
					$('#<?= $tableId ?>').add_date_pickers({dttbl: <?= $tblVarName ?>});
				<?php
			}
		 ?>


		<?php if (isset($tableOptions['buttons'])): ?>
			<?= $tblVarName ?>.buttons().container()
			.parent().addClass('box-info')
		<?php endif ?>
		});
			


	</script>
<?php endif ?>