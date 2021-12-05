<div id="tambah_gaji" class="modal fade" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-detail">
		<div class="modal-content">
			<div class="modal-body">
				<div class="widget-box widget-color-blue2">
					<div class="widget-header">
						<h4 class="widget-title lighter smaller">Tambah Data Gaji</h4>
					</div>
					<hr>
					<div class="widget-body">
						<form class="form-horizontal" action="#" id=formku name="formku" style="margin-top: 15px">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label col-md-4">Lembur</label>
											<div class="col-md-12">
												<input type="hidden" id="mode_form" name="mode_form" value="Tambah">
												<input type="hidden" id="id_gaji" name="id_gaji">
												<input type="number" id="lembur" name="lembur" class="form-control" placeholder="Masukan Jam Lembur" >
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label col-md-4">Bonus</label>
											<div class="col-md-12">
												<input type="number" id="bonus" name="bonus" class="form-control" placeholder="Masukan Bonus Gaji">
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label col-md-4">Terlambat</label>
											<div class="col-md-12">
												<input type="number" id="terlambat" name="terlambat" class="form-control" placeholder="Masukan Jam Terlambat">
											</div>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="form-actions fluid">
								<div class="row">
									<div class="col-md-12">
										<button class="btn btn-sm btn-default btn-fill" id="simpan"><i class="fa fa-save"></i> Simpan</button>
										<button class="btn btn-sm btn-danger" id="batal"><i class="fa fa-refresh"></i> Batal</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>