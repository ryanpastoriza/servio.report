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
					<h5 style="font-weight:bold;">Dealer</h5>
					<select class="form-control" style="width:150px;" name="dealer" id="dealer" value="">
						<?php foreach ($data['dealers'] as $key => $value): ?>
							<option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
						<?php endforeach ?>
					</select>
				</div>

				<div style="margin-right:25px;">
					<h5 style="font-weight:bold;">Branch</h5>
					<select class="form-control" style="width:150px;" name="branch" id="branch" value="">
						<?php foreach ($data['branches'] as $key => $value): ?>
							<option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
						<?php endforeach ?>
					</select>
				</div>

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
			
			

			<table id="lead_table" class="table table-striped table-bordered table-hover" style="width:100%;font-size:14px;">
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
	            	<?php foreach ($data['pm'] as $key => $value): ?>
	            		<tr>
	            			<td><?php echo $value->name ?></td>
	            			<td><?php echo $value->total ?></td>
	            			<td><?php echo $value->pct ?>%</td>
	            			<?php foreach ($value->bm as $skey => $svalue): ?>
	            				<td><?php echo $svalue['count'] ?></td>
	            				<td><?php echo $svalue['pct'] ?>%</td>
	            			<?php endforeach ?>
	            			
	            		</tr>
	            	<?php endforeach ?>
	            	<tr style="background:#ddd;">
	            		<td>TOTAL</td>
	            		<td><?php echo $data['total_pm'] ?></td>
	            		<td>100%</td>
	            		<?php foreach ($data['total_bm'] as $key => $value): ?>
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
		let branch = "<?php echo $data['bbranch'] ?>";
		let dealer = "<?php echo $data['ddealer'] ?>";
		$("#so_status").val(val);
		$("#branch").val(branch);
		$("#dealer").val(dealer);
	});


	$("#setBtn").click(function(e){
		e.preventDefault();
		let startDate = $("#startDate").val();
		let endDate = $("#endDate").val();
		let branch = $("#branch").val();
		let dealer = $("#dealer").val();
		let so_status = $("#so_status").val();

		if(startDate.length > 0 && endDate.length > 0){
			window.location = "so_by_payment?" + 'start_date=' + startDate + "&end_date=" + endDate + "&so_status=" + so_status + "&branch=" + branch + "&dealer=" + dealer;
		}
		
	});

	$("#so_status").change(function(e){
		let startDate = $("#startDate").val();
		let endDate = $("#endDate").val();
		let branch = $("#branch").val();
		let dealer = $("#dealer").val();
		window.location = "so_by_payment?" + 'start_date=' + startDate + "&end_date=" + endDate + "&so_status=" + e.target.value + "&branch=" + branch + "&dealer=" + dealer;
	});


	$("#branch").change(function(e){
		let startDate = $("#startDate").val();
		let endDate = $("#endDate").val();
		let so_status = $("#so_status").val();
		let dealer = $("#dealer").val();
		window.location = "so_by_payment?" + 'start_date=' + startDate + "&end_date=" + endDate + "&so_status=" + so_status + "&branch=" + e.target.value + "&dealer=" + dealer;
	});

	$("#dealer").change(function(e){
		let startDate = $("#startDate").val();
		let endDate = $("#endDate").val();
		let so_status = $("#so_status").val();
		let branch = $("#branch").val();
		window.location = "so_by_payment?" + 'start_date=' + startDate + "&end_date=" + endDate + "&so_status=" + so_status + "&branch=" + branch + "&dealer=" + e.target.value;
	});

</script>