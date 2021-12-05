<div id="tambah_absen" class="modal fade" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-detail">
		<div class="modal-content">
			<div class="modal-body">
				<div class="widget-box widget-color-blue2">
					<div class="widget-header">
						<h4 class="widget-title lighter smaller">Detail Data Absen</h4>
					</div>
					<hr>
					<div class="widget-body">
						<form class="form-horizontal" action="#" id=formku name="formku" style="margin-top: 15px">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label col-md-4">ID Pegawai</label>
											<div class="col-md-12">
												<input type="hidden" id="mode_form" name="mode_form" value="Tambah">
												<input type="hidden" id="id_absen" name="id_absen">
												<input type="text" id="idpegawai" name="idpegawai" class="form-control" placeholder="Masukan ID Pegawai" >
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label col-md-4">Jam Masuk</label>
											<div class="col-md-12">
												<input type="time" id="jm_masuk" name="jm_masuk" class="form-control" placeholder="Masukan Jam Masuk">
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label col-md-4">Jam Keluar</label>
											<div class="col-md-12">
												<input type="time" id="jm_keluar" name="jm_keluar" class="form-control" placeholder="Masukan Jam Keluar">
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label col-md-4">Izin</label>
											<div class="col-md-12">
												<input type="number" id="izin" name="izin" class="form-control" placeholder="Masukan Izin">
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