<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SkemaPengajar extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		} else if (!$this->ion_auth->is_admin()) {
			show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
		}
		$this->load->library(['datatables', 'form_validation']); // Load Library Ignited-Datatables
		$this->load->model('Master_model', 'master');
		$this->form_validation->set_error_delimiters('', '');
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
			'judul'	=> 'Skema Pengajar',
			'subjudul' => 'Data Skema Pengajar'
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('relasi/skemapengajar/data');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function data()
	{
		$this->output_json($this->master->getSkemaPengajar(), false);
	}

	public function add()
	{
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'judul'		=> 'Tambah Skema Pengajar',
			'subjudul'	=> 'Tambah Data Skema Pengajar',
			'pengajar'		=> $this->master->getAllPengajar(),
			'skema'	    => $this->master->getAllSkema()
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('relasi/skemapengajar/add');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function edit($id)
	{
		$data = [
			'user' 			=> $this->ion_auth->user()->row(),
			'judul'			=> 'Edit Skema Pengajar',
			'subjudul'		=> 'Edit Data Skema Pengajar',
			'pengajar'			=> $this->master->getPengajarById($id),
			'id_pengajar'		=> $id,
			'all_skema'	    => $this->master->getAllSkema(),
			'skema'		    => $this->master->getSkemaByPengajar($id)
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('relasi/skemapengajar/edit');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function save()
	{
		$method = $this->input->post('method', true);
		$this->form_validation->set_rules('pengajar_id', 'Pengajar', 'required');
		$this->form_validation->set_rules('skema_id[]', 'Skema', 'required');

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status'	=> false,
				'errors'	=> [
					'pengajar_id' => form_error('pengajar_id'),
					'skema_id[]' => form_error('skema_id[]'),
				]
			];
			$this->output_json($data);
		} else {
			$pengajar_id = $this->input->post('pengajar_id', true);
			$skema_id = $this->input->post('skema_id', true);
			$input = [];
			foreach ($skema_id as $key => $val) {
				$input[] = [
					'pengajar_id'  => $pengajar_id,
					'skema_id' => $val
				];
			}
			if ($method === 'add') {
				$action = $this->master->create('skema_pengajar', $input, true);
			} else if ($method === 'edit') {
				$id = $this->input->post('pengajar_id', true);
				$this->master->delete('skema_pengajar', $id, 'pengajar_id');
				$action = $this->master->create('skema_pengajar', $input, true);
			}
			$data['status'] = $action ? TRUE : FALSE;
		}
		$this->output_json($data);
	}

	public function delete()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			$this->output_json(['status' => false]);
		} else {
			if ($this->master->delete('skema_pengajar', $chk, 'pengajar_id')) {
				$this->output_json(['status' => true, 'total' => count($chk)]);
			}
		}
	}
}
