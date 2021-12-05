<?php 

if (!defined('BASEPATH'))
	exit('no direct script access allowed');

class Pegawai_m extends CI_Model {

	var $table = 'pegawai';

	private function _get_datatables_query()
	{ 
		$column_search = array('p.nama_pegawai','p.alamat', 'divisi.nama_divisi', 'jabatan.nama_jabatan');
		$column_order = array('p.nama_pegawai', 'p.alamat', 'divisi.nama_divisi', 'jabatan.nama_jabatan',NULL);
		$order = array('p.id_pegawai' => 'desc');
		$this->db->select('p.id_pegawai, p.nama_pegawai, p.alamat, divisi.nama_divisi, jabatan.nama_jabatan');
		$this->db->from('pegawai as p');
		$this->db->join('divisi', 'divisi.id_divisi = p.iddivisi','inner');
		$this->db->join('jabatan', 'jabatan.id_jabatan = p.idjabatan','inner');
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
        	$order = $this->order;
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

     function get_divisi(){ //ambil data kategori dari table kategori
        $hsl=$this->db->get('divisi');
        return $hsl;
    }

    function get_jabatan(){ //ambil data kategori dari table kategori
        $hsl=$this->db->get('jabatan');
        return $hsl;
    }

    function delete($id_pegawai="")
    {
    	if ($id_pegawai) {//cek parameter
    	$this->db->delete("pegawai", array("id_pegawai" => $id_pegawai));}
    }

    function insert($d)
    {
    	$this->db->insert("pegawai", $d);
    }

    function update($id_pegawai = "", $d)
    {
    	$this->db->where('id_pegawai', $id_pegawai);
    	$this->db->update('pegawai', $d);
    }

    function Chek_Data($id_pegawai = "", $nama_pegawai = "")
    {
    	if ($id_pegawai) {
    		$this->db->where("id_pegawai", $id_pegawai);
    	}else{
    		$this->db->where("nama_pegawai", $nama_pegawai);
    	}
    	$query = $this->db->get("pegawai");
    	return $query->num_rows();
    }

    public function getOneById($id_pegawai='')
    {
    	$data=$this->db->get_where('pegawai', array('id_pegawai' => $id_pegawai));

    	return $data->result_array()[0];
    }

} 
