<div class="content-wrapper" style="margin-top: -400px;">
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-md-12 col-xs-12">

				<div class="box box-success box-solid">
					<div class="box-header with-border">
						<h3 class="box-title"><b><i class="fa fa-briefcase"></i> Upload penjualan</b></h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						</div>
						<!-- /.box-tools -->
					</div>

					<form>
						<div class="box-body">
							<br><br>
							<table class="table">


								<thead>
									<tr>
										<!-- Header -->
										<?php foreach ($fields as $field) : ?>
											<th scope="col"><?= strtoupper($field) ?></th>
										<?php endforeach; ?>
									</tr>
								</thead>

								<!-- Data -->
								<tbody>
									<?php $i = 0;
									foreach ($sheet as $row) : ?>
										<tr class="clickable">

											<?php
											// skip the first row(header row)
											if ($i == 0) {
												$i++;
											} else {
												foreach ($letters as $col) {
													// if any col are empty, give a style color
													$null_col = (!empty($row[$col])) ? "" : " style='background: #fdd835;'";
													echo '<td class="view"' . $null_col . '>' . $row[$col] . '</td>';
												}
											}
											?>

										</tr>
									<?php endforeach; ?>

								</tbody>
							</table>
						</div>
						<div class="box-footer">
							<a href="<?= base_url() ?>penjualan/import" class="btn btn-success"><i class="fa fa-sign-in"></i> Import</a>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /.row -->


	</section>
</div>