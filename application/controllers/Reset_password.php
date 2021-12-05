<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_password extends CI_Controller {


	public function index()
	{
		$data['judul']="Setting Profile";
		
		$this->load->view('user/setting_v', $data);
	}

	function check_account(){

		$old_password=md5($this->input->post('opassword'));
		$username='admin';
		$cek=$this->Reset_m->Getuser(array('password' => $old_password,'username'=>$username));
		if($cek->num_rows()>=1){
			echo json_encode(false);
			// jika cek user bernilai lebih dari sama dengan 1 (ada data) maka kirimkan nilai false
		} else{
			echo json_encode(true);
		}
	}

}