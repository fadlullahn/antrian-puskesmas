<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitor extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$nowDate = date('Y-m-d');

		$this->db->limit('1');
		$this->db->where('tgl_antrian', $nowDate);
		$this->db->order_by('no_antrian', 'DESC');
		$antrian = $this->db->get('antrian')->row();
		if ($antrian) {
			$data['no_antrian'] = $antrian->no_antrian;
		} else {
			$data['no_antrian'] = 0;
		}

		if (!empty($this->session->userdata('id_pasien'))) {
			$this->db->limit(1);
			$this->db->order_by('id_antrian_poli', 'DESC');
			$this->db->where('id_pasien', $this->session->userdata('id_pasien'));
			$this->db->where('tgl_antrian_poli', $nowDate);
			$this->db->join('kategori_poli', 'kategori_poli.id_poli=antrian_poli.id_poli');
			$rowdata = $this->db->get('antrian_poli')->row();
			if ($rowdata) {
				$data['antrian_pasien'] = $rowdata->no_antrian_poli;
				$data['nama_poli'] = $rowdata->nama_poli;
				$data['id_antrian_poli'] = $rowdata->id_antrian_poli;
			} else {
				$data['antrian_pasien'] = '-';
				// $data['antrian_pasien']='anda belum mengambil nomor antrian poli';
				$data['nama_poli'] = '-';
				$data['id_antrian_poli'] = "";
			}

			$rowPoli = $this->db->get('kategori_poli')->result();
			$data['getPoli'] = $rowPoli;

			$getPoli = $this->db->get('kategori_poli')->result();
			foreach ($getPoli as $key) {
				$this->db->limit('1');
				$this->db->where('id_poli', $key->id_poli);
				$this->db->where('tgl_antrian_poli', $nowDate);
				$this->db->order_by('no_antrian_poli', 'DESC');
				$antrianpoli = $this->db->get('antrian_poli')->row();

				if ($key->id_poli == 1) {
					if ($antrianpoli) {
						$data['poli_umum'] = $antrianpoli->no_antrian_poli;
					} else {
						$data['poli_umum'] = 0;
					}
				} elseif ($key->id_poli == 2) {
					if ($antrianpoli) {
						$data['poli_gigi'] = $antrianpoli->no_antrian_poli;
					} else {
						$data['poli_gigi'] = 0;
					}
				} elseif ($key->id_poli == 3) {
					if ($antrianpoli) {
						$data['poli_kia'] = $antrianpoli->no_antrian_poli;
					} else {
						$data['poli_kia'] = 0;
					}
				}
			}
		}
		// var_dump($data); die();
		$this->load->view('user/monitor', $data);
	}
}
