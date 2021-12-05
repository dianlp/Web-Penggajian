<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_m extends CI_Model{
	
	public function get_pegawai(){
		$this->db->from('pegawai');
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_absen(){
		$this->db->from('absen');
		$query = $this->db->get();
		return $query->num_rows();
	}
}
