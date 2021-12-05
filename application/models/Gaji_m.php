<?php 

if (!defined('BASEPATH'))
	exit('no direct script access allowed');

class Gaji_m extends CI_Model {

	var $table = 'gaji';

	private function _get_datatables_query()
	{ 
		$column_search = array('pegawai.nama_pegawai');
		$column_order = array('pegawai.nama_pegawai',NULL);
		$order = array('g.id_gaji' => 'desc');
		$this->db->select('g.id_gaji, pegawai.nama_pegawai, g.lembur, g.bonus, g.terlambat');
		$this->db->from('gaji as g');
		$this->db->join('pegawai', 'pegawai.id_pegawai = g.idpegawai','inner');
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
        	$this->db->order_by($order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
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

    function delete($id_gaji="")
    {
    	if ($id_gaji) {//cek parameter
    	$this->db->delete("gaji", array("id_gaji" => $id_gaji));}
    }

    function insert($d)
    {
    	$this->db->insert("gaji", $d);
    }

    function update($id_gaji = "", $d)
    {
    	$this->db->where('id_gaji', $id_gaji);
    	$this->db->update('gaji', $d);
    }

    function Chek_Data($id_gaji = "", $idpegawai = "")
    {
    	if ($id_gaji) {
    		$this->db->where("id_gaji", $id_gaji);
    	}else{
    		$this->db->where("idpegawai", $idpegawai);
    	}
    	$query = $this->db->get("gaji");
    	return $query->num_rows();
    }

    public function getOneById($id_gaji='')
    {
    	$data=$this->db->get_where('gaji', array('id_gaji' => $id_gaji));

    	return $data->result_array()[0];
    }

} 
