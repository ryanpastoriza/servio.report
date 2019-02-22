<div class="col-lg-12">
	<div class="box box-default box-solid">
		<div class="box-header with-border">
	  		<h3 class="box-title"><b>Sales Order by Lead Source</b></h3>

		  	<div class="box-tools pull-right">
	    		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	  		</div>
		</div>
		<div class="box-body">
				
			<div style="margin-bottom:15px;display:flex;align-items: top;" class="row">
				<div style="display:flex;flex-direction:column" class="col-md-4">
					<div style="margin-right:25px;margin-bottom: 10px; display:flex;align-items:center">
						<label style="font-weight:bold;margin-right: 50px;">Dealer: </label>
						<select class="form-control" style="" name="dealer" id="dealer" value="">
							<?php foreach ($data['dealers'] as $key => $value): ?>
								<option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div style="margin-right:25px;margin-bottom: 10px; display:flex;align-items:center">
						<label style="font-weight:bold;margin-right: 47px;">Branch: </label>
						<select class="form-control" style="" name="branch" id="branch" value="">
							<?php foreach ($data['branches'] as $key => $value): ?>
								<option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div style="margin-right:25px;margin-bottom: 10px; display:flex;align-items:center">
						<label style="font-weight:bold;margin-right: 47px;">SO Status: </label>
						<select class="form-control" style="" name="so_status" id="so_status" value="">
							<?php foreach ($data['so_status'] as $key => $value): ?>
								<option value="<?php echo $value->status_c ?>"><?php echo $value->status_c ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div style="display:flex;flex-direction:column;overflow:hidden" class="col-md-4">
					<div style="margin-bottom: 10px; display:flex;">
						<label style="font-weight:bold;margin-right: 32px;">From: </label>
						<input value="<?php echo $data['sdate'] ?>" class="form-control" type="date" id="startDate" style=""></input>
					</div>

					<div style="margin-bottom: 10px; display:flex;align-items:center">
						<label style="font-weight:bold;margin-right: 50px;">To: </label>
						<input value="<?php echo $data['edate'] ?>" class="form-control" type="date" id="endDate" style=""></input>
					</div>
					<a href="" class="btn btn-primary btn-sm" id="setBtn" style="margin-left:69px;">Submit</a>
				</div>
				

				<div>
					<!-- <div style="margin-bottom:15px;display:flex;align-items: center;">				
						<span style="color:#aaa;margin-right:5px;">From:</span> <input value="<?php echo $data['sdate'] ?>" class="form-control" type="date" id="startDate" style="margin-right:15px;width:150px;"></input>
						<span style="color:#aaa;margin-right:5px;">To:</span> <input value="<?php echo $data['edate'] ?>" class="form-control" type="date" id="endDate" style="margin-right:15px;width:150px;"></input>
						<a href="" class="btn btn-primary btn-sm" id="setBtn">Submit</a>
					</div> -->
				</div>

				
			</div>

			
			
			<div class="table-responsive">

			<div id="dt-buttons" class="dt-buttons"><a class="dt-button buttons-excel buttons-html5 btn btn-primary fa fa-download" tabindex="0" aria-controls="lead_table" href="#"><span> Excel</span></a></div>

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
		            			<td><?php echo strtoupper(str_replace('_', ' ', $value->name)) ?></td>
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
		            				<td><?php echo $data['total_bm_pct']->$key ?>%</td>
		            			</section>
		            		<?php endforeach ?>
		            	</tr>
		            </tbody>
			    </table>
			</div>
			
					   
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

		$('title').html("Sales Order By Payment Mode Report");
	});


	$("#setBtn").click(function(e){
		e.preventDefault();
		let startDate = $("#startDate").val();
		let endDate = $("#endDate").val();
		let branch = $("#branch").val();
		let dealer = $("#dealer").val();
		let so_status = $("#so_status").val();

		if(startDate.length > 0 && endDate.length > 0 && branch.length > 0 && dealer.length > 0){
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



	let table = TableExport(document.getElementsByTagName("table"), {
		  headers: true,                      // (Boolean), display table headers (th or td elements) in the <thead>, (default: true)
		  footers: true,                      // (Boolean), display table footers (th or td elements) in the <tfoot>, (default: false)
		  formats: ["xlsx"],    // (String[]), filetype(s) for the export, (default: ['xlsx', 'csv', 'txt'])
		  filename: "SO by Payment Mode <?php echo date('m/d/Y') ?>",                     // (id, String), filename for the downloaded file, (default: 'id')
		  bootstrap: false,                   // (Boolean), style buttons using bootstrap, (default: true)
		  exportButtons: true,                // (Boolean), automatically generate the built-in export buttons for each of the specified formats (default: true)
		  position: "bottom",                 // (top, bottom), position of the caption element relative to table, (default: 'bottom')
		  ignoreRows: null,                   // (Number, Number[]), row indices to exclude from the exported file(s) (default: null)
		  ignoreCols: null,                   // (Number, Number[]), column indices to exclude from the exported file(s) (default: null)
		  trimWhitespace: true,               // (Boolean), remove all leading/trailing newlines, spaces, and tabs from cell text in the exported file(s) (default: false)
		  RTL: false,                         // (Boolean), set direction of the worksheet to right-to-left (default: false)
		  sheetname: 'Sheet 1'                // (id, String), sheet name for the exported spreadsheet, (default: 'id')
		});



	$("#dt-buttons").click(function(e){
		e.preventDefault();
		let btn = document.getElementsByClassName('button-default xlsx')[0];
		btn.click();
	});




</script>