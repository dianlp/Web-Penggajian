<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        //load model admin
		$this->load->model('Login_m');
		$this->load->model('Dashboard_m');
	}

	public function index()
	{

		if($this->Login_m->logged_id())
		{

			$data['judul']="DASHBOARD";
			$data['pegawai']=$this->Dashboard_m->get_pegawai();
			$data['absen']=$this->Dashboard_m->get_absen();
			$this->load->view("dashboard", $data);         

		}else{

            //jika session belum terdaftar, maka redirect ke halaman login
			redirect("login");

		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}


