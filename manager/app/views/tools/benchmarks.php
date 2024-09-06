<?php

use App\Classes\Database;
use App\Classes\Layout;

Layout::header();

?>

<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Benchmark Results</h4>
			</div>
			<div class="modal-body" style="box-sizing: border-box; border: 0; white-space: pre; font-family: monospace; height: 480px; overflow-y: scroll; width: 100%;"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="createModal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Create Benchmark</h4>
			</div>
			<div class="modal-body">
				<form id="frm_benchmark" class="validate" method="POST">

					<div class="row">
						<div class="form-group col-md-2">
							<label for="proto">Method</label><br>
							<select class="form-control" id="method" name="method" onchange="$('.data-control').attr('disabled', (!(this.value == 'POST' || this.value == 'PUT')));">
								<option>CONNECT</option>
								<option>DELETE</option>
								<option selected>GET</option>
								<option>HEAD</option>
								<option>OPTIONS</option>
								<option>POST</option>
								<option>PUT</option>
								<option>TRACE</option>
							</select>
						</div>
						<div class="form-group col-md-2">
							<label for="proto">Protocol</label><br>
							<select class="form-control" id="proto" name="proto">
								<option selected>https</option>
								<option>http</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<div class="form-group">
								<label for="requests">Site</label>
								<select name="domain" id="domain" class="form-control" onchange="$('#site_id').val($('option:selected',this).data('site-id'));">
									<option selected value="-1">-- Select --</option>
									<?php foreach ($domains as $domain): ?>
										<option data-site-id="<?= $domain['id']; ?>" value="<?= $domain['name']; ?>"><?= $domain['name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<input type="hidden" name="site_id" id="site_id">
						<div class="form-group col-md-4">
							<div class="form-group">
								<label for="requests">Script</label>
								<input type="text" class="form-control" name="script" id="script" placeholder="e.g. admin/login.php (optional)">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-4">
							<div class="form-group">
								<label for="data_type">Data Type</label>
								<select name="data_type" id="data_type" class="form-control data-control" disabled>
									<option selected value="application/x-www-form-urlencoded">application/x-www-form-urlencoded</option>
									<option value="multipart/form-data; boundary=xyz">multipart/form-data; boundary=xyz</option>
									<option value="application/json">application/json</option>
								</select>
							</div>
						</div>
						<div class="form-group col-md-2">
							<label for="requests">Requests</label>
							<input type="number" class="form-control" name="requests" id="requests" value="500">
						</div>
						<div class="form-group col-md-2">
							<label for="requests">Concurrency</label>
							<input type="number" class="form-control" name="concurrency" id="concurrency" value="10">
						</div>
						<div class="form-group col-md-4">
							<div class="form-group">
								<label for="verbosity">Verbosity</label>
								<select id="verbosity" name="verbosity" class="form-control">
									<option selected value="1">Level 1 (default)</option>
									<option value="2">Level 2</option>
									<option value="3">Level 3</option>
									<option value="4">Level 4</option>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-6">
							<div class="form-group">
								<label for="method">Data</label><br>
								<textarea class="form-control data-control" name="data" id="data" disabled style="height: 120px;" placeholder="email=abc@example.com&password=vpn123"></textarea>
							</div>
						</div>
						<div class="form-group col-md-6">
							<div class="form-group">
								<label for="method">Headers</label><br>
								<textarea class="form-control" id="headers" name="headers" style="height: 120px;" placeholder="Accept-Encoding: gzip
Cookie: PHPSESSID=apdidj3740b54kusfulnm0rolh"></textarea>
							</div>
						</div>
					</div>

				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" onclick="$('#frm_benchmark').submit();">Create</button>
			</div>
		</div>
	</div>
</div>

<script>

	$('#myModal').on('shown.bs.modal', function(event)
	{
		$(this).find('.modal-body').load('/tools/benchmarks/'+$(event.relatedTarget).data('benchmark-id')).css('pre-whitespace', 'pre');
	})

</script>

<div class="header">
	<div>Benchmarks</div>
	<div>
		<div class="btn-group btn-group-flex">
			<button type="button" class="btn btn-sm btn-default" onclick="location.reload();">Refresh</button>
			<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#createModal">Create</button>
		</div>
	</div>
</div>

<div class="body notify">

<div class="row">
	<div class="col-md-12">

			<?php
			if (count($benchmarks) == 0): ?>
				No benchmarks to display.
				<?php else: ?>

					<div class="panel panel-default">
						<table class="table table-striped">
						<tr>
							<th>Created</th>
							<th>Address</th>
							<th>Webserver</th>
							<th>PHP</th>
							<th class="text-center">Requests</th>
							<th class="text-center">Concurrency</th>
							<th class="text-center">RPS</th>
							<th>&nbsp;</th>
						</tr>
						<?php foreach($benchmarks as $benchmark): ?>
							<tr>
								<td><?= gmdate('Y-m-d H:i:s', $benchmark['created']); ?></td>
								<td><?= $benchmark['address']; ?></td>
								<td><?= $benchmark['httpd']; ?></td>
								<td><?= $benchmark['php']; ?></td>
								<td class="text-center"><?= $benchmark['n']; ?></td>
								<td class="text-center"><?= $benchmark['c']; ?></td>
								<td class="text-center">
									<?php if ($benchmark['raw'] == null): ?>
									<i class="fa fa-fw fa-spinner fa-spin"></i>
									<?php else: ?>
									<?= $benchmark['rps']; ?>
									<?php endif ?>
								</td>
								<td>
									<?php if ($benchmark['raw'] == null): ?>
										<div class="btn-group btn-group-flex">
											<button disabled onclick="window.location = '/tools/benchmarks/<?= $benchmark['id']; ?>/delete';" class="btn btn-sm btn-danger"><i class="fa fa-fw fa-trash"></i></button>
											<button disabled data-benchmark-id="<?= $benchmark['id']; ?>" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary"><i class="fa fa-fw fa-chart-bar"></i></button>
										</div>
									</button>
									<?php else: ?>
										<div class="btn-group btn-group-flex">
											<button onclick="window.location = '/tools/benchmarks/<?= $benchmark['id']; ?>/delete';" class="btn btn-sm btn-danger"><i class="fa fa-fw fa-trash"></i></button>
											<button data-benchmark-id="<?= $benchmark['id']; ?>" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary"><i class="fa fa-fw fa-chart-bar"></i></button>
										</div>
									<?php endif ?>
								</td>
							</tr>
							<?php endforeach ?>
						</table>
					</div>
					<?php endif ?>
				</div>
			</div>
		</div>

	</div>

		<?php

		Layout::footer();