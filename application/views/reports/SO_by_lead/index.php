<div class="col-lg-12">
	<div class="box box-default box-solid">
		<div class="box-header with-border">
	  		<h3 class="box-title"><b>Sales Order by Lead Source</b></h3>

		  	<div class="box-tools pull-right">
	    		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	  		</div>
		</div>
		<div class="box-body">
			<div style="margin-bottom:15px;display:flex;align-items: top;">
				<div style="margin-right:25px;">
					<h5 style="font-weight:bold;">SO Status</h5>
					<select class="form-control" style="width:150px;" name="so_status" id="so_status" value="">
						<?php foreach ($data['so_status'] as $key => $value): ?>
							<option value="<?php echo $value->status_c ?>"><?php echo $value->status_c ?></option>
						<?php endforeach ?>
					</select>
				</div>

				<div>
					<h5 style="font-weight:bold;">Date Range</h5>
					<div style="margin-bottom:15px;display:flex;align-items: center;">				
						<span style="color:#aaa;margin-right:5px;">From:</span> <input value="<?php echo $data['sdate'] ?>" class="form-control" type="date" id="startDate" style="margin-right:15px;width:150px;"></input>
						<span style="color:#aaa;margin-right:5px;">To:</span> <input value="<?php echo $data['edate'] ?>" class="form-control" type="date" id="endDate" style="margin-right:15px;width:150px;"></input>
						<a href="" class="btn btn-primary btn-sm" id="setBtn">Set</a>
					</div>
				</div>
			</div>
			
			

			<table id="lead_table" class="table table-striped table-bordered" style="width:100%;font-size:14px;">
	            <thead>
	            	<tr>
	            		<th rowspan="2" ="" ="" ="2">SOURCE OF SALE</th>
	            		<th colspan="2" style="text-align:center">TOTAL</th>

	            		<?php foreach ($data['bm'] as $key => $value): ?>
	            			<th colspan="2" style="text-align:center"><?php echo $value->name ?></th>
	            		<?php endforeach ?>
	            	</tr>
	                <tr>
	                    <th>Value</th>
	                    <th>PCT</th>

	                    <?php foreach ($data['bm'] as $key => $value): ?>
	            			<th>Value</th>
	                    	<th>PCT</th>
	            		<?php endforeach ?>
	                </tr>
	            </thead>
	            <tbody>	            	
	            	<?php foreach ($data['ls'] as $key => $value): ?>
	            		<tr>
	            			<td><?php echo $value->name ?></td>
	            			<td><?php echo $value->value ?></td>
	            			<td><?php echo $value->pct ?>%</td>
	            			<?php foreach ($value->bm as $skey => $svalue): ?>
	            				<td><?php echo $svalue['value']->count ?></td>
	            				<td><?php echo $svalue['pct'] ?>%</td>
	            			<?php endforeach ?>
	            			
	            		</tr>
	            	<?php endforeach ?>
	            	<tr style="background:#ddd;">
	            		<td>TOTAL</td>
	            		<td><?php echo $data['overall'] ?></td>
	            		<td>100%</td>
	            		<?php foreach ($data['total'] as $key => $value): ?>
	            			<section>
	            				<td><?php echo $value ?></td>
	            				<td>100%</td>
	            			</section>
	            		<?php endforeach ?>
	            	</tr>
	            </tbody>
		    </table>
					   
		</div>		
	</div>
</div>























<script>
	
	$(document).ready(function(){
		let val = "<?php echo $data['so_status_c'] ?>";
		$("#so_status").val(val);
	});


	$("#setBtn").click(function(e){
		e.preventDefault();
		let startDate = $("#startDate").val();
		let endDate = $("#endDate").val();

		if(startDate.length > 0 && endDate.length > 0){
			window.location = "so_by_leads?" + 'start_date=' + startDate + "&end_date=" + endDate;
		}
		
	});

	$("#so_status").change(function(e){
		let startDate = $("#startDate").val();
		let endDate = $("#endDate").val();
		window.location = "so_by_leads?" + 'start_date=' + startDate + "&end_date=" + endDate + "&so_status=" + e.target.value;
	});


</script>