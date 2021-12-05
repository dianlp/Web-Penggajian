<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gaji extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('Gaji_m');
	}

	public function index()
	{
		// $data['gaji']=$this->Gaji_m->datagaji();
		$jd['judul'] = "Data Gaji";

		$this->load->view('gaji/index_v', $jd);
	}

	public function list_gaji()
	{
		$this->load->model("Gaji_m");
		$list = $this->Gaji_m->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $gaji) {
			$no++;
			$row = array();
			$row['no']='<center>'.$no.'</center>';
			$row['nama_pegawai'] = $gaji->nama_pegawai;
			$row['lembur'] = $gaji->lembur;
			$row['bonus'] = $gaji->bonus;
			$row['terlambat'] = $gaji->terlambat;

			//add html for action
			// $row['aksi'] = '<a class="btn btn-circle btn-sm btn-warning" href="javascript:void()" title="Ubah" onclick="btn-ubah(' . "'" . $gaji->id_gaji . "'" . ')"><i class="fa fa-edit"></i></a>

			// <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="btn-hapus(' . "'" . $gaji->id_gaji . "'" . ')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
			$btn_ubah='<a href="javascript:;" data-id="' . $gaji->id_gaji . '"data-name="' . $row['nama_pegawai'] . '" class="btn btn-sm btn-warning btn-fill btn-ubah"><i class="fa fa-pencil"></i> Ubah</a>';

			$btn_hapus='<a href="javascript:;" data-id="' . $gaji->id_gaji. '"data-name="' . $row['nama_pegawai'] . '"class="btn btn-sm btn-danger btn-fill btn-hapus"><i class="fa fa-times"></i> Hapus</a>';

			// $btn_hapus='<a href="javascript:;" data-id="' . $row['id_kasir']. '"data-name="' . $row['nama_pembeli'] . '"class="btn btn-sm btn-danger btn-hapus"><i class="fa fa-times"></i> Hapus</a>';

			$row['aksi']='<center>'.$btn_ubah.'  '.$btn_hapus.'</center>';

			
			
			$data[] = $row;

		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Gaji_m->count_all(),
			"recordsFiltered" => $this->Gaji_m->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	function do_Hapus()
	{
		$id_gaji = ($_POST["id_gaji"] != "") ? $_POST["id_gaji"] : "";
		//mengambil parameter id

		$this->Gaji_m->delete($id_gaji);
		//menjalankan fungsi delete pada model

		if ($this->db->trans_status() === false) {
			$return["msgServer"] = "Maaf, Hapus Data gaji Gagal.";
			//cek status perintah

			$return["success"] = false;
			//untuk cek status gagal

		} else {
			$return["msgServer"] = "Hapus Data gaji Berhasil.";
			//pesan ketika berhasil

			$return["success"] = true;
			//untuk cek status berhasil 
		}

		echo json_encode($return);
		//mengirim notif kepada view
	}

	function do_Simpan()
	{
		$return = array();
		$error = "";

		$mode_form = ($_POST["mode_form"] != "") ? $_POST["mode_form"] : "";

		$id_gaji = ($_POST["id_gaji"] != "") ? $_POST["id_gaji"] : "";

		$d['idpegawai'] = ($_POST["idpegawai"] != "") ? $_POST["idpegawai"] : "";

		$d['lembur'] = ($_POST["lembur"] != "") ? $_POST["lembur"] : "";

		$d['bonus'] = ($_POST["bonus"] != "") ? $_POST["bonus"] : "";

		$d['terlambat'] = ($_POST["terlambat"] != "") ? $_POST["terlambat"] : "";

		if ($mode_form == "Tambah") {
			if ($this->Gaji_m->Chek_Data("", $d['idpegawai']) == 0) {

				$this->Gaji_m->insert($d);
			} else {
				$error = "Maaf, Data gaji Sudah ada. !!!";
			}
		} elseif ($mode_form == "Ubah") {
			if ($this->Gaji_m->Chek_Data($id_gaji) > 0) {

				$this->Gaji_m->update($id_gaji, $d);
			} else {
				$error = "Maaf, Data gaji Tidak ditemukan. !!!";
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$return["msgServer"] = "Simpan Data gaji Gagal. !!!";
			$return["success"] = FALSE;
		} else {
			if ($error != "") {
				$return["msgServer"] = $error;
				$return["success"] = FALSE;
			} else {
				$return["msgServer"] = "Simpan Data gaji Berhasil.";
				$return["success"] = TRUE;
			}
		}

		echo json_encode($return);
	}

	function do_Ubah()
	{
		$return = array();
		$id_gaji = ($_POST["id_gaji"] != "") ? $_POST["id_gaji"] : "";
		if ($this->Gaji_m->Chek_Data($id_gaji) > 0) {
			$item = $this->Gaji_m->getOneById($id_gaji);
			$item['mode_form'] = 'Ubah';

			$return["success"] = TRUE;
			$return["results"] = $item;
		} else {
			$return["success"] = FALSE;
			$return["msgServer"] = "Maaf, Data gaji Tidak Ditemukan.";
		}

		echo json_encode($return);
	}
}
