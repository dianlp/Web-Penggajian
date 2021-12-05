<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view("templates/head.php") ?>
</head>
<body>
    <body>
        <div class="wrapper">
            <?php $this->load->view("templates/sidebar.php") ?>
            <div class="main-panel">
                <!-- Navbar -->
                <?php $this->load->view("templates/navbar.php") ?>
                <!-- End Navbar -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body table-bordered table-responsive">
                                    <table class="table table-hover table-striped" id="myTable">
                                        <thead class="thead-dark">
                                            <tr class="text-center" style="text-align: center;">
                                                <th style="width: 5%">Nomor</th>
                                                <th>Nama Pegawai</th>
                                                <th>Lembur</th>
                                                <th>Bonus</th>
                                                <th>Terlambat</th>
                                                <th style="width: 15%"><button id="tambah" data-target="#tambah_gaji" data-toggle="modal" type="button" class="btn btn-primary btn-fill btn-sm btn-block"><i class="nc-icon nc-simple-add"></i> Tambah</button></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <?php $this->load->view("gaji/form.php") ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view("templates/footer.php") ?>
        </div>
    </body>
    <?php $this->load->view("templates/js.php") ?>

<script type="text/javascript">
    var myTable;
    $(document).ready(function () {

        //dataTables
        myTable = $('#myTable').DataTable({
            "processing": true,
            //mengontrol indikator pemrosesan

            "serverSide": true,
            //kontrol fitur mode pemrosesan sis server dataTables

            "order": [],
            //inisiasi no order

            "lengthMenu": [
            [5, 10, 15, 25, -1],
            [5, 10, 15, 25, "All"]
            ],
            //ubah batas data per halaman 

            "ajax": {
                "url": "<?= base_url('gaji/list_gaji')?>",
                "type": "POST"
            },
            //muat data untuk konten tabel dari sumber ajax

            "columns":[
            {"data": "no"},
            {"data": "nama_pegawai"},
            {"data": "lembur"},
            {"data": "bonus"},
            {"data": "terlambat"},
            {"data": "aksi"},
            ],

            //setting properti inisialisasi definisi kolom 
            "columnDefs": [
            {
                "targets": [0, 5 ],
                //kolom pertama merupakan kolom nomor

                "orderable": false,
                //setting agar tidak bisa di sorting pada tampilan
            },
            ],

        });
        //hapus
        $('body').on('click', '.btn-hapus', function (){
            var id = $(this).attr("data-id");
            //mengambil atribute data-i

            var name = $(this).attr("data-name");
            //mengambil atribute data-name

            //open bootbox
            bootbox.dialog({
                message: "Apakah anda yakin menghapus </br><b>gaji " + name + "</b> ?",
                //pesan pada bootbox

                title: "Konfirmasi Hapus",
                //header bootbox

                buttons: {
                    //setting tombol success
                    success: {
                        label: "Ya",
                        className: "btn-success btn-fill",
                        callback: function() {

                            //menjalankan ajax delete
                            $.ajax({
                                method: 'POST',
                                dataType: 'json',
                                url: '<?= site_url() ?>gaji/do_Hapus',
                                data: {'id_gaji': id},
                                success: function (data){
                                    if (data.success === true) {
                                        toastr.success(data.msgServer);
                                        $('#myTable').dataTable().fnClearTable();
                                    }else{
                                        toastr.warning(data.msgServer);
                                    }
                                },
                                fail: function(e){
                                    toastr.error(e);
                                }
                            });
                        }
                    },

                    //setting tombol batal
                    danger: {
                        label:"Tidak",
                        className: "btn-danger btn-fill"
                    }
                }
            });
        });

        //ubah
        $('body').on('click', '.btn-ubah', function(){
            $.ajax({
                method: 'POST',
                dataType: 'json',
                url: '<?= base_url() ?>gaji/do_Ubah',
                data: {'id_gaji': $(this).attr("data-id")},
                success: function (data) {
                    if (data.success === true) {
                        $('#mode_form').val(data.results.mode_form);
                        $('#id_gaji').val(data.results.id_gaji);
                        $('#lembur').val(data.results.lembur);
                        $('#bonus').val(data.results.bonus);
                        $('#terlambat').val(data.results.terlambat);
                        $('#tambah_gaji').modal('show');
                    }else{
                        toastr.warning(data.msgServer);
                    }
                },
                fail: function(e){
                    toastr.error(e);
                }
            });
        });

        $('#simpan').on('click',function(){
            $.ajax({
                method: 'POST',
                dataType: 'json',
                url: '<?= site_url() ?>gaji/do_Simpan',
                data: $('#formku').serializeArray(),
                success: function (data) {
                    if (data.success === true) {
                        handleClearForm();
                        $('#tambah_gaji').modal('hide');
                        toastr.success(data.msgServer);
                        $('#myTable').dataTable().fnClearTable();
                    } else {
                        toastr.warning(data.msgServer);
                    }
                },
                fail: function(e){
                    toastr.error(e);
                }
            });
            return false;
        });

        $('#batal').on('click', function(){
            handleClearForm();
            $('#tambah_gaji').modal('hide');
        });

        $('#tambah').on('click', function(){
            handleClearForm();
        });

        function handleClearForm(){
            $('#formku').each(function(){
                this.reset();
            });
            $('mode_form').val('Tambah');
        }
    });

</script>
</html>