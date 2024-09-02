<header class="page-header">
	<h2>Permintaan Sarana & Prasarana</h2>
</header>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-table"></i> Perbaikan Sarana & Prasarana</h5>
			</header>
			<div class="panel-body">
				<div id="" class="panel-group">
				<?php
					$query = mysql_query("select id_unit, nama from unit where aktif = 1");
					while($data = mysql_fetch_array($query)){
				?>
					<div class="panel panel-accordion panel-accordion-primary">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#<?=$data['id_unit']?>" aria-expanded="false">
									<i></i> <?=$data['nama']?>
									<span style="float: right;">8</span>
								</a>
							</h4>
						</div>
						<div id="<?=$data['id_unit']?>" class="accordion-body collapse" aria-expanded="false" style="height: 0px;">
							<div class="panel-body">
								ini
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</section>
	</div>
<div>

<script>
	
</script>