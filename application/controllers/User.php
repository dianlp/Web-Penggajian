<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('User_m');
	}

	public function index()
	{
		$data['login']=$this->User_m->dataLogin();
		$data['judul'] = "Profile";

		$this->load->view('user/user_v', $data);
	}

	// function do_Hapus()
	// {
	// 	$id_login = ($_POST["id_login"] != "") ? $_POST["id_login"] : "";
	// 	//mengambil parameter id

	// 	$this->User_m->delete($id_login);
	// 	//menjalankan fungsi delete pada model

	// 	if ($this->db->trans_status() === false) {
	// 		$return["msgServer"] = "Maaf, Hapus Data user Gagal.";
	// 		//cek status perintah

	// 		$return["success"] = false;
	// 		//untuk cek status gagal

	// 	} else {
	// 		$return["msgServer"] = "Hapus Data user Berhasil.";
	// 		//pesan ketika berhasil

	// 		$return["success"] = true;
	// 		//untuk cek status berhasil 
	// 	}

	// 	echo json_encode($return);
	// 	//mengirim notif kepada view
	// }

	function do_Simpan()
	{
		$return = array();
		$error = "";

		$mode_form = ($_POST["mode_form"] != "") ? $_POST["mode_form"] : "";

		$id_login = ($_POST["id_login"] != "") ? $_POST["id_login"] : "";

		$d['nama'] = ($_POST["nama"] != "") ? $_POST["nama"] : "";

		$d['alamat'] = ($_POST["alamat"] != "") ? $_POST["alamat"] : "";

		$d['notlp'] = ($_POST["notlp"] != "") ? $_POST["notlp"] : "";

		$d['email'] = ($_POST["email"] != "") ? $_POST["email"] : "";

		if ($mode_form == "Profile") {
			if ($this->User_m->Chek_Data("", $d['nama']) == 0) {

				$this->User_m->insert($d);
			} else {
				$error = "Maaf, Data user Sudah ada. !!!";
			}
		} elseif ($mode_form == "Profile") {
			if ($this->User_m->Chek_Data($id_login) > 0) {

				$this->User_m->update($id_login, $d);
			} else {
				$error = "Maaf, Data user Tidak ditemukan. !!!";
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$return["msgServer"] = "Simpan Data user Gagal. !!!";
			$return["success"] = FALSE;
		} else {
			if ($error != "") {
				$return["msgServer"] = $error;
				$return["success"] = FALSE;
			} else {
				$return["msgServer"] = "Simpan Data user Berhasil.";
				$return["success"] = TRUE;
			}
		}

		echo json_encode($return);
	}

	function do_Ubah()
	{
		$return = array();
		$id_login = ($_POST["id_login"] != "") ? $_POST["id_login"] : "";
		if ($this->User_m->Chek_Data($id_login) > 0) {
			$item = $this->User_m->getOneById($id_login);
			$item['mode_form'] = 'Profile';

			$return["success"] = TRUE;
			$return["results"] = $item;
		} else {
			$return["success"] = FALSE;
			$return["msgServer"] = "Maaf, Data user Tidak Ditemukan.";
		}

		echo json_encode($return);
	}
}
