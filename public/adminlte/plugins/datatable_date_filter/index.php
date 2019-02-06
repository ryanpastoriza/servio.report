<link rel="stylesheet" type="text/css" href="../../adminlte/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../../adminlte/plugins/datatables/jquery.datatables.min.css">
<link rel="stylesheet" type="text/css" href="../../adminlte/plugins/daterangepicker/daterangepicker-bs3.css">


<script src="../../adminlte/plugins/jQuery/jquery-1.11.3.min.js"></script>
<script src="../../adminlte/plugins/datatables/jquery.datatables.min.js"></script>
<script src="../../adminlte/bootstrap/js/bootstrap.min.js"></script>
<script src="daterangefilterinj.js"></script>

<script type="text/javascript">
	$(function(){
		var dd = $('#tbl').DataTable({fnDrawCallback: function(){
		}});
		$('#tbl').add_date_pickers({dttbl: dd});
	})
</script>


<head>
	<title>Datepicker Jquery Plugin</title>
</head>
<body>
	<div class="content">
		<div class="row">
			<div class="col-sm-4">
				<table class="table table-striped table-hover" id="tbl">
					<thead>
						<th>date</th>
						<th>some info</th>
					</thead>
					<tbody>
					<?php 
						for ($i=0; $i < 10; $i++) { 
							?>
							<tr>
								<td><?= date('m/d/Y', strtotime("2017-{$i}-1")) ?></td>
								<td>asdaskjg</td>
							</tr>
							<?php
						}

					 ?>
					</tbody>
				</table>	
			</div>
		</div>
	</div>
</body>