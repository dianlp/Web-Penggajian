<?php 

if (!defined('BASEPATH'))
	exit('no direct script access allowed');

class Absen_m extends CI_Model {

	var $table = 'absen';

	private function _get_datatables_query()
	{ 
		$column_search = array('pegawai.nama_pegawai');
		$column_order = array('pegawai.nama_pegawai', 'a.jm_masuk', 'a.jm_keluar', 'a.izin', NULL);
		$order = array('a.id_absen' => 'desc');
		$this->db->select('a.id_absen, pegawai.nama_pegawai, a.jm_masuk, a.jm_keluar, a.izin');
		$this->db->from('absen as a');
		$this->db->join('pegawai', 'pegawai.id_pegawai = a.idpegawai','inner');
		$i = 0;

		foreach ($column_search as $item) 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                	$this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($column_search) - 1 == $i) //last loop
                $this->db->group_end(); 
            }

            $i++;
        }
        if(isset($_POST['order'])) // here order processing
        {
        	$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
        	/*$order = $this->order;*/
        	$this->db->order_by(key($order), $order[key($order)]);
        }
    }


    function get_datatables()
    {

    	$this->_get_datatables_query();
    	if($_POST['length'] != -1)
    		$this->db->limit($_POST['length'], $_POST['start']);
    	$query = $this->db->get();
    	return $query->result();
    }

    function count_filtered()
    {
    	$this->_get_datatables_query();
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function count_all()
    {
    	$this->db->from($this->table);
    	return $this->db->count_all_results();
    }

    function delete($id_absen="")
    {
    	if ($id_absen) {//cek parameter
    	$this->db->delete("absen", array("id_absen" => $id_absen));}
    }

    function insert($d)
    {
    	$this->db->insert("absen", $d);
    }

    function update($id_absen = "", $d)
    {
    	$this->db->where('id_absen', $id_absen);
    	$this->db->update('absen', $d);
    }

    function Chek_Data($id_absen = "", $idpegawai = "")
    {
    	if ($id_absen) {
    		$this->db->where("id_absen", $id_absen);
    	}else{
    		$this->db->where("idpegawai", $idpegawai);
    	}
    	$query = $this->db->get("absen");
    	return $query->num_rows();
    }

    public function getOneById($id_absen='')
    {
    	$data=$this->db->get_where('absen', array('id_absen' => $id_absen));

    	return $data->result_array()[0];
    }

} 
