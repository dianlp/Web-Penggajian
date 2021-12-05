<?php 

if (!defined('BASEPATH'))
	exit('no direct script access allowed');

class User_m extends CI_Model {

  public function dataLogin()
  {
    $data=$this->db->get('login');

    return $data->result_array();
  }

  function insert($d)
  {
    $this->db->insert("login", $d);
  }

  function update($id_login = "", $d)
  {
    $this->db->where('id_login', $id_login);
    $this->db->update('login', $d);
  }

  function Chek_Data($id_login = "", $nama = "")
  {
    if ($id_login) {
      $this->db->where("id_login", $id_login);
    }else{
      $this->db->where("nama", $nama);
    }
    $query = $this->db->get("login");
    return $query->num_rows();
  }

  public function getOneById($id_login='')
  {
    $data=$this->db->get_where('login', array('id_login' => $id_login));

    return $data->result_array()[0];
  }

} 
