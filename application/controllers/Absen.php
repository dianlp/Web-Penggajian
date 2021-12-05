<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absen extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('Absen_m');
	}

	public function index()
	{
		// $data['absen']=$this->Absen_m->dataAbsen();
		$jd['judul'] = "Data Absen";

		$this->load->view('absen/index_v', $jd);
	}

	public function list_absen()
	{
		$this->load->model("Absen_m");
		$list = $this->Absen_m->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $absen) {
			$no++;
			$row = array();
			$row['no']='<center>'.$no.'</center>';
			$row['nama_pegawai'] = $absen->nama_pegawai;
			$row['jm_masuk'] = $absen->jm_masuk;
			$row['jm_keluar'] = $absen->jm_keluar;
			$row['izin'] = $absen->izin;

			//add html for action
			// $row['aksi'] = '<a class="btn btn-circle btn-sm btn-warning" href="javascript:void()" title="Ubah" onclick="btn-ubah(' . "'" . $absen->id_absen . "'" . ')"><i class="fa fa-edit"></i></a>

			// <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="btn-hapus(' . "'" . $absen->id_absen . "'" . ')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
			$btn_ubah='<a href="javascript:;" data-id="' . $absen->id_absen . '"data-name="' . $row['nama_pegawai'] . '" class="btn btn-sm btn-warning btn-fill btn-ubah"><i class="fa fa-pencil"></i> Ubah</a>';

			$btn_hapus='<a href="javascript:;" data-id="' . $absen->id_absen. '"data-name="' . $row['nama_pegawai'] . '"class="btn btn-sm btn-danger btn-fill btn-hapus"><i class="fa fa-times"></i> Hapus</a>';

			// $btn_hapus='<a href="javascript:;" data-id="' . $row['id_kasir']. '"data-name="' . $row['nama_pembeli'] . '"class="btn btn-sm btn-danger btn-hapus"><i class="fa fa-times"></i> Hapus</a>';

			$row['aksi']='<center>'.$btn_ubah.'  '.$btn_hapus.'</center>';

			
			
			$data[] = $row;

		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Absen_m->count_all(),
			"recordsFiltered" => $this->Absen_m->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	function do_Hapus()
	{
		$id_absen = ($_POST["id_absen"] != "") ? $_POST["id_absen"] : "";
		//mengambil parameter id

		$this->Absen_m->delete($id_absen);
		//menjalankan fungsi delete pada model

		if ($this->db->trans_status() === false) {
			$return["msgServer"] = "Maaf, Hapus Data absen Gagal.";
			//cek status perintah

			$return["success"] = false;
			//untuk cek status gagal

		} else {
			$return["msgServer"] = "Hapus Data absen Berhasil.";
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

		$id_absen = ($_POST["id_absen"] != "") ? $_POST["id_absen"] : "";

		$d['idpegawai'] = ($_POST["idpegawai"] != "") ? $_POST["idpegawai"] : "";

		$d['jm_masuk'] = ($_POST["jm_masuk"] != "") ? $_POST["jm_masuk"] : "";

		$d['jm_keluar'] = ($_POST["jm_keluar"] != "") ? $_POST["jm_keluar"] : "";

		$d['izin'] = ($_POST["izin"] != "") ? $_POST["izin"] : "";

		if ($mode_form == "Tambah") {
			if ($this->Absen_m->Chek_Data("", $d['idpegawai']) == 0) {

				$this->Absen_m->insert($d);
			} else {
				$error = "Maaf, Data absen Sudah ada. !!!";
			}
		} elseif ($mode_form == "Ubah") {
			if ($this->Absen_m->Chek_Data($id_absen) > 0) {

				$this->Absen_m->update($id_absen, $d);
			} else {
				$error = "Maaf, Data absen Tidak ditemukan. !!!";
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$return["msgServer"] = "Simpan Data absen Gagal. !!!";
			$return["success"] = FALSE;
		} else {
			if ($error != "") {
				$return["msgServer"] = $error;
				$return["success"] = FALSE;
			} else {
				$return["msgServer"] = "Simpan Data absen Berhasil.";
				$return["success"] = TRUE;
			}
		}

		echo json_encode($return);
	}

	function do_Ubah()
	{
		$return = array();
		$id_absen = ($_POST["id_absen"] != "") ? $_POST["id_absen"] : "";
		if ($this->Absen_m->Chek_Data($id_absen) > 0) {
			$item = $this->Absen_m->getOneById($id_absen);
			$item['mode_form'] = 'Ubah';

			$return["success"] = TRUE;
			$return["results"] = $item;
		} else {
			$return["success"] = FALSE;
			$return["msgServer"] = "Maaf, Data absen Tidak Ditemukan.";
		}

		echo json_encode($return);
	}
}
