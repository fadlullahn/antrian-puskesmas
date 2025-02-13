<?php
defined('BASEPATH') or exit('No direct script access allowed');
include('Super.php');

class Antrian_poli_gigi extends Super
{

    function __construct()
    {
        parent::__construct();
        $this->language       = 'english';
        $this->tema           = "flexigrid";
        $this->tabel          = "antrian_poli";
        $this->active_id_menu = "Antrian poli gigi";
        $this->nama_view      = "Antrian poli gigi";
        $this->status         = true;
        $this->field_tambah   = array();
        $this->field_edit     = array();
        $this->field_tampil   = array('id_poli', 'id_pasien', 'tgl_antrian_poli', 'no_antrian_poli');
        $this->folder_upload  = 'assets/uploads/files';
        $this->add            = true;
        $this->edit           = false;
        $this->delete         = false;
        $this->crud;
    }

    function index()
    {
        $data = [];
        if ($this->crud->getState() == "add")
            redirect(base_url('admin/Antrian_poli/addAntrianPoli'));

        $this->crud->set_relation('id_pasien', 'pasien', 'nama');
        $this->crud->set_relation('id_poli', 'kategori_poli', 'nama_poli');

        $this->crud->display_as('id_poli', 'Poli');
        $this->crud->display_as('id_pasien', 'Nama Pasien');

        $data = array_merge($data, $this->generateBreadcumbs());
        $data = array_merge($data, $this->generateData());
        $this->generate();
        $data['output'] = $this->crud->render();
        $this->load->view('admin/' . $this->session->userdata('theme') . '/v_index_poli_gigi', $data);
    }

    private function generateBreadcumbs()
    {
        $data['breadcumbs'] = array(
            array(
                'nama' => 'Dashboard',
                'icon' => 'fa fa-dashboard',
                'url' => 'admin/dashboard'
            ),
            array(
                'nama' => 'Admin',
                'icon' => 'fa fa-users',
                'url' => 'admin/useradmin'
            ),
        );
        return $data;
    }

    public function addAntrianPoli()
    {
        $data = [];
        $data = array_merge($data, $this->generateBreadcumbs());
        $data = array_merge($data, $this->generateData());
        $this->generate();

        $rowPoli = $this->db->get('kategori_poli')->result();
        $data['getPoli'] = $rowPoli;
        // var_dump($rowPoli); exit();

        $rowPasien = $this->db->get('pasien')->result();
        $data['getPasien'] = $rowPasien;

        $data['page'] = 'v_antrian_poli';
        $data['output'] = $this->crud->render();
        $this->load->view('admin/' . $this->session->userdata('theme') . '/v_index', $data);
    }

    public function getNoAntrian()
    {
        $id_poli = $this->input->post('id_poli');
        $tanggal = date("Y-m-d");

        $this->db->where('antrian_poli.id_poli', $id_poli);
        $this->db->where('antrian_poli.tgl_antrian_poli', $tanggal);
        $sql = $this->db->get('antrian_poli');
        $getPoli = $sql->num_rows(); //cek jumlah row

        if ($getPoli == 0) { //kondisi jika belum ada yg daftar perhari
            $this->db->where('id_poli', $id_poli);
            $sql2 = $this->db->get('kategori_poli');
            $rowPoli = $sql2->row();
            $no = 1;
            $kode = $rowPoli->kode_poli;
            $noAntrian = $kode . $no;
            $maks = $rowPoli->jumlah_maksimal;
        } else {
            //kondisi jika sudah ada data per hari
            $this->db->limit(1);
            $this->db->order_by('no_antrian_poli', "DESC");
            $this->db->where('antrian_poli.id_poli', $id_poli);
            $this->db->where('antrian_poli.tgl_antrian_poli', $tanggal);
            $sql = $this->db->get('antrian_poli');
            $rowNo = $sql->row();


            $this->db->where('id_poli', $id_poli);
            $sql2 = $this->db->get('kategori_poli');
            $rowPoli = $sql2->row();
            $kode = $rowPoli->kode_poli;
            $no = $rowNo->no_antrian_poli + 1;
            $maks = $rowPoli->jumlah_maksimal;

            // var_dump($rowNo); exit();
            $noAntrian = $kode . $no;
        }

        $hasil = array("no_hasil" => $noAntrian, "no" => $no, "maks" => $maks);
        echo json_encode($hasil);
    }
}
