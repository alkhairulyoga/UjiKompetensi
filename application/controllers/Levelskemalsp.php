<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LevelSkemalsp extends CI_Controller
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
			'judul'	=> 'Level Skema LSP',
			'subjudul' => 'Data Level Skema LSP'
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('relasi/levelskemalsp/data');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function data()
	{
		$this->output_json($this->master->getLevelskemalsp(), false);
	}

	public function getLevelId($id)
	{
		$this->output_json($this->master->getAllLevel($id));
	}

	public function add()
	{
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'judul'		=> 'Tambah Level Skema LSP',
			'subjudul'	=> 'Tambah Data Level Skema LSP',
			'klsp'	=> $this->master->getskemalsp()
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('relasi/levelskemalsp/add');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function edit($id)
	{
		$data = [
			'user' 			=> $this->ion_auth->user()->row(),
			'judul'			=> 'Edit Level Skema LSP',
			'subjudul'		=> 'Edit Data Level Skema LSP',
			'klsp'		=> $this->master->getSkemalspByid($id, true),
			'id_klsp'		=> $id,
			'all_level'	=> $this->master->getAllLevel(),
			'level'		=> $this->master->getLevelByIdskemalsp($id)
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('relasi/levelskemalsp/edit');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function save()
	{
		$method = $this->input->post('method', true);
		$this->form_validation->set_rules('klsp_id', 'Skema LSP', 'required');
		$this->form_validation->set_rules('level_id[]', 'Level', 'required');

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status'	=> false,
				'errors'	=> [
					'klsp_id' => form_error('klsp_id'),
					'level_id[]' => form_error('level_id[]'),
				]
			];
			$this->output_json($data);
		} else {
			$klsp_id 	= $this->input->post('klsp_id', true);
			$level_id = $this->input->post('level_id', true);
			$input = [];
			foreach ($level_id as $key => $val) {
				$input[] = [
					'klsp_id' 	=> $klsp_id,
					'level_id'  	=> $val
				];
			}
			if ($method === 'add') {
				$action = $this->master->create('level_skemalsp', $input, true);
			} else if ($method === 'edit') {
				$id = $this->input->post('klsp_id', true);
				$this->master->delete('level_skemalsp', $id, 'klsp_id');
				$action = $this->master->create('level_skemalsp', $input, true);
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
			if ($this->master->delete('level_skemalsp', $chk, 'klsp_id')) {
				$this->output_json(['status' => true, 'total' => count($chk)]);
			}
		}
	}
}
