<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class Skemalsp extends CI_Controller
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
			'judul'	=> 'Skema LSP',
			'subjudul' => 'Data Skema LSP'
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('master/skemalsp/data');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function data()
	{
		$this->output_json($this->master->getDataSkemalsp(), false);
	}

	public function add()
	{
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'judul'		=> 'Tambah Skema LSP',
			'subjudul'	=> 'Tambah Data Skema LSP',
			'banyak'	=> $this->input->post('banyak', true)
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('master/skemalsp/add');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function edit()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			redirect('skemalsp');
		} else {
			$skemalsp = $this->master->getSkemalspById($chk);
			$data = [
				'user' 		=> $this->ion_auth->user()->row(),
				'judul'		=> 'Edit Skema Lsp',
				'subjudul'	=> 'Edit Data Skema Lsp',
				'skemalsp'	=> $skemalsp
			];
			$this->load->view('_templates/dashboard/_header.php', $data);
			$this->load->view('master/skemalsp/edit');
			$this->load->view('_templates/dashboard/_footer.php');
		}
	}

	public function save()
	{
		$rows = count($this->input->post('nama_klsp', true));
		$mode = $this->input->post('mode', true);
		for ($i = 1; $i <= $rows; $i++) {
			$nama_klsp = 'nama_klsp[' . $i . ']';
			$this->form_validation->set_rules($nama_klsp, 'Skema Lsp', 'required');
			$this->form_validation->set_message('required', '{field} Wajib diisi');

			if ($this->form_validation->run() === FALSE) {
				$error[] = [
					$nama_klsp => form_error($nama_klsp)
				];
				$status = FALSE;
			} else {
				if ($mode == 'add') {
					$insert[] = [
						'nama_klsp' => $this->input->post($nama_klsp, true)
					];
				} else if ($mode == 'edit') {
					$update[] = array(
						'id_klsp'	=> $this->input->post('id_klsp[' . $i . ']', true),
						'nama_klsp' 	=> $this->input->post($nama_klsp, true)
					);
				}
				$status = TRUE;
			}
		}
		if ($status) {
			if ($mode == 'add') {
				$this->master->create('skema_lsp', $insert, true);
				$data['insert']	= $insert;
			} else if ($mode == 'edit') {
				$this->master->update('skema_lsp', $update, 'id_klsp', null, true);
				$data['update'] = $update;
			}
		} else {
			if (isset($error)) {
				$data['errors'] = $error;
			}
		}
		$data['status'] = $status;
		$this->output_json($data);
	}

	public function delete()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			$this->output_json(['status' => false]);
		} else {
			if ($this->master->delete('skema_lsp', $chk, 'id_klsp')) {
				$this->output_json(['status' => true, 'total' => count($chk)]);
			}
		}
	}

	public function import($import_data = null)
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'judul'	=> 'Skema LSP',
			'subjudul' => 'Import Skema LSP'
		];
		if ($import_data != null) $data['import'] = $import_data;

		$this->load->view('_templates/dashboard/_header', $data);
		$this->load->view('master/skemalsp/import');
		$this->load->view('_templates/dashboard/_footer');
	}

	public function preview()
	{
		$config['upload_path']		= './uploads/import/';
		$config['allowed_types']	= 'xls|xlsx|csv';
		$config['max_size']			= 2048;
		$config['encrypt_name']		= true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('upload_file')) {
			$error = $this->upload->display_errors();
			echo $error;
			die;
		} else {
			$file = $this->upload->data('full_path');
			$ext = $this->upload->data('file_ext');

			switch ($ext) {
				case '.xlsx':
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
					break;
				case '.xls':
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
					break;
				case '.csv':
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
					break;
				default:
					echo "unknown file ext";
					die;
			}

			$spreadsheet = $reader->load($file);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();
			$skemalsp = [];
			for ($i = 1; $i < count($sheetData); $i++) {
				if ($sheetData[$i][0] != null) {
					$skemalsp[] = $sheetData[$i][0];
				}
			}

			unlink($file);

			$this->import($skemalsp);
		}
	}
	public function do_import()
	{
		$data = json_decode($this->input->post('skemalsp', true));
		$jurusan = [];
		foreach ($data as $j) {
			$jurusan[] = ['nama_skemalsp' => $j];
		}

		$save = $this->master->create('skemalsp', $jurusan, true);
		if ($save) {
			redirect('skemalsp');
		} else {
			redirect('skemalsp/import');
		}
	}
}
