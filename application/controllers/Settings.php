<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		} else if (!$this->ion_auth->is_admin()) {
			show_error('Hanya Admin yang boleh mengakses halaman ini', 403, 'Akses dilarang');
		}
		$this->load->model('Settings_model', 'settings');
	}

	public function output_json($data, $encode = true)
	{
		if ($encode) $data = json_encode($data);
		$this->output->set_content_type('application/json')->set_output($data);
	}

	public function index()
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'judul'	=> 'Settings',
			'subjudul' => 'Hapus data',
		];

		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('settings');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function truncate()
	{
		$tables = ['h_ujian', 'm_ujian', 'h_essay', 'm_essay', 'h_praktek', 'm_praktek', 'h_latihan', 'm_latihan', 'tb_soal', 'tb_essay', 'tb_praktek', 'soal_modul', 'skema_pengajar', 'pengajar', 'peserta', 'skema', 'level_skemalsp', 'skema_lsp', 'jurusan'];
		$this->settings->truncate($tables);

		$this->output_json(['status' => true]);
	}
}
