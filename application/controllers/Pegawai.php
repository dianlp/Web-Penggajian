<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('Pegawai_m');
	}

	public function index()
	{
		// $data['pegawai']=$this->Pegawai_m->dataPegawai();
		$jd['judul'] = "Data Pegawai";
		$jd['divisi']=$this->Pegawai_m->get_divisi();
		$jd['jabatan']=$this->Pegawai_m->get_jabatan();

		$this->load->view('pegawai/index_v', $jd);
	}

	public function list_pegawai()
	{
		$this->load->model("Pegawai_m");
		$list = $this->Pegawai_m->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pegawai) {
			$no++;
			$row = array();
			$row['no']='<center>'.$no.'</center>';
			$row['nama_pegawai'] = $pegawai->nama_pegawai;
			$row['alamat'] = $pegawai->alamat;
			$row['nama_divisi'] = $pegawai->nama_divisi;
			$row['nama_jabatan'] = $pegawai->nama_jabatan;

			//add html for action
			// $row['aksi'] = '<a class="btn btn-circle btn-sm btn-warning" href="javascript:void()" title="Ubah" onclick="btn-ubah(' . "'" . $pegawai->id_pegawai . "'" . ')"><i class="fa fa-edit"></i></a>

			// <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="btn-hapus(' . "'" . $pegawai->id_pegawai . "'" . ')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
			$btn_ubah='<a href="javascript:;" data-id="' . $pegawai->id_pegawai . '"data-name="' . $row['nama_pegawai'] . '" class="btn btn-sm btn-warning btn-fill btn-ubah"><i class="fa fa-pencil"></i> Ubah</a>';

			$btn_hapus='<a href="javascript:;" data-id="' . $pegawai->id_pegawai. '"data-name="' . $row['nama_pegawai'] . '"class="btn btn-sm btn-danger btn-fill btn-hapus"><i class="fa fa-times"></i> Hapus</a>';

			// $btn_hapus='<a href="javascript:;" data-id="' . $row['id_kasir']. '"data-name="' . $row['nama_pembeli'] . '"class="btn btn-sm btn-danger btn-hapus"><i class="fa fa-times"></i> Hapus</a>';

			$row['aksi']='<center>'.$btn_ubah.'  '.$btn_hapus.'</center>';
			
			$data[] = $row;

		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Pegawai_m->count_all(),
			"recordsFiltered" => $this->Pegawai_m->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	function do_Hapus()
	{
		$id_pegawai = ($_POST["id_pegawai"] != "") ? $_POST["id_pegawai"] : "";
		//mengambil parameter id

		$this->Pegawai_m->delete($id_pegawai);
		//menjalankan fungsi delete pada model

		if ($this->db->trans_status() === false) {
			$return["msgServer"] = "Maaf, Hapus Data pegawai Gagal.";
			//cek status perintah

			$return["success"] = false;
			//untuk cek status gagal

		} else {
			$return["msgServer"] = "Hapus Data pegawai Berhasil.";
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

		$id_pegawai = ($_POST["id_pegawai"] != "") ? $_POST["id_pegawai"] : "";

		$d['nama_pegawai'] = ($_POST["nama_pegawai"] != "") ? $_POST["nama_pegawai"] : "";

		$d['alamat'] = ($_POST["alamat"] != "") ? $_POST["alamat"] : "";

		$d['iddivisi'] = ($_POST["iddivisi"] != "") ? $_POST["iddivisi"] : "";

		$d['idjabatan'] = ($_POST["idjabatan"] != "") ? $_POST["idjabatan"] : "";

		if ($mode_form == "Tambah") {
			if ($this->Pegawai_m->Chek_Data("", $d['nama_pegawai']) == 0) {

				$this->Pegawai_m->insert($d);
			} else {
				$error = "Maaf, Data pegawai Sudah ada. !!!";
			}
		} elseif ($mode_form == "Ubah") {
			if ($this->Pegawai_m->Chek_Data($id_pegawai) > 0) {

				$this->Pegawai_m->update($id_pegawai, $d);
			} else {
				$error = "Maaf, Data pegawai Tidak ditemukan. !!!";
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$return["msgServer"] = "Simpan Data pegawai Gagal. !!!";
			$return["success"] = FALSE;
		} else {
			if ($error != "") {
				$return["msgServer"] = $error;
				$return["success"] = FALSE;
			} else {
				$return["msgServer"] = "Simpan Data pegawai Berhasil.";
				$return["success"] = TRUE;
			}
		}

		echo json_encode($return);
	}

	function do_Ubah()
	{
		$return = array();
		$id_pegawai = ($_POST["id_pegawai"] != "") ? $_POST["id_pegawai"] : "";
		if ($this->Pegawai_m->Chek_Data($id_pegawai) > 0) {
			$item = $this->Pegawai_m->getOneById($id_pegawai);
			$item['mode_form'] = 'Ubah';

			$return["success"] = TRUE;
			$return["results"] = $item;
		} else {
			$return["success"] = FALSE;
			$return["msgServer"] = "Maaf, Data pegawai Tidak Ditemukan.";
		}

		echo json_encode($return);
	}
}
