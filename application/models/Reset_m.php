<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reset_m extends CI_Model {


	public function __construct()
	{
		parent::__construct();
		
	}

    function Getuser($id_login="id_login") {
        $this->db->select('*');
        $this->db->from('login');
        $this->db->where($id_login);
        $data=$this->db->get();
        return $data;
    }

	
	
   

}