<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('login_admin')) {
            redirect('admin/login');
        }
    }

    function index()
    {
        $data['active']     = 'dash';
        $data['judul_1']    = 'Dashboard';
        $data['judul_2']    = 'Selamat Datang | Admin';

        $data['page']       = 'v_dashboard';
        $data['menu']       = $this->Menus->generateMenu();
        $data['breadcumbs'] = array(
            array(
                'nama' => 'Dashboard',
                'icon' => 'fa fa-dashboard',
                'url' => 'admin/dashboard'
            ),
        );

        // Ambil tanggal hari ini dalam format MySQL
        $nowDate = date('Y-m-d');


        // Hitung semua jumlah antrian
        $data['total_antrian'] = $this->db->count_all_results('antrian');

        // Ambil tanggal hari ini dalam format MySQL
        $nowDate = date('Y-m-d');

        // Ambil semua daftar antrian
        $data['all_antrian'] = $this->db->where('tgl_antrian_poli', $nowDate)
            ->order_by('no_antrian_poli', 'ASC')
            ->get('antrian_poli')
            ->result();

        // Ambil data antrian poli secara spesifik
        $getPoli = $this->db->get('kategori_poli')->result();
        foreach ($getPoli as $key) {
            $this->db->limit('1');
            $this->db->where('id_poli', $key->id_poli);
            $this->db->where('tgl_antrian_poli', $nowDate);
            $this->db->order_by('no_antrian_poli', 'DESC');
            $antrianpoli = $this->db->get('antrian_poli')->row();

            if ($key->id_poli == 1) {
                $data['poli_umum'] = $antrianpoli ? $antrianpoli->no_antrian_poli : 0;
            } elseif ($key->id_poli == 2) {
                $data['poli_gigi'] = $antrianpoli ? $antrianpoli->no_antrian_poli : 0;
            } elseif ($key->id_poli == 3) {
                $data['poli_kia'] = $antrianpoli ? $antrianpoli->no_antrian_poli : 0;
            }
        }

        $this->load->view('admin/' . $this->session->userdata('theme') . '/v_index', $data);
    }
}
