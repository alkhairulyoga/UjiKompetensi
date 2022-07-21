<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Skema extends CI_Controller
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
			'judul'	=> 'Skema',
			'subjudul' => 'Data Skema'
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('master/skema/data');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function data()
	{
		$this->output_json($this->master->getDataSkema(), false);
	}

	public function add()
	{
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'judul'		=> 'Tambah Skema',
			'subjudul'	=> 'Tambah Data Skema',
			'banyak'	=> $this->input->post('banyak', true),
			'klsp'	=> $this->master->getAllskemalsp(),
			'level'	=> $this->master->getAllLevel()
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('master/skema/add');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function edit()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			redirect('admin/skema');
		} else {
			$skema = $this->master->getSkemaById($chk);
			$data = [
				'user' 		=> $this->ion_auth->user()->row(),
				'judul'		=> 'Edit Skema',
				'subjudul'	=> 'Edit Data Skema',
				'klsp'	=> $this->master->getAllskemalsp(),
				'level'	=> $this->master->getAllLevel(),
				'skema'		=> $skema
			];
			$this->load->view('_templates/dashboard/_header.php', $data);
			$this->load->view('master/skema/edit');
			$this->load->view('_templates/dashboard/_footer.php');
		}
	}

	public function save()
	{
		$rows = count($this->input->post('nama_skema', true));
		$mode = $this->input->post('mode', true);
		for ($i = 1; $i <= $rows; $i++) {
			$nama_skema 	= 'nama_skema[' . $i . ']';
			$klsp_id 	= 'klsp_id[' . $i . ']';
			$level_id 	= 'level_id[' . $i . ']';
			$this->form_validation->set_rules($nama_skema, 'Skema', 'required');
			$this->form_validation->set_rules($klsp_id, 'Level', 'required');
			$this->form_validation->set_rules($level_id, 'Level KKNI', 'required');
			$this->form_validation->set_message('required', '{field} Wajib diisi');

			if ($this->form_validation->run() === FALSE) {
				$error[] = [
					$nama_skema 	=> form_error($nama_skema),
					$klsp_id 	=> form_error($klsp_id),
				];
				$status = FALSE;
			} else {
				if ($mode == 'add') {
					$insert[] = [
						'nama_skema' 	=> $this->input->post($nama_skema, true),
						'klsp_id' 	=> $this->input->post($klsp_id, true),
						'level_id' 	=> $this->input->post($level_id, true)
					];
				} else if ($mode == 'edit') {
					$update[] = array(
						'id_skema'		=> $this->input->post('id_skema[' . $i . ']', true),
						'nama_skema' 	=> $this->input->post($nama_skema, true),
						'klsp_id' 	=> $this->input->post($klsp_id, true),
						'level_id' 	=> $this->input->post($level_id, true)

					);
				}
				$status = TRUE;
			}
		}
		if ($status) {
			if ($mode == 'add') {
				$this->master->create('skema', $insert, true);
				$data['insert']	= $insert;
			} else if ($mode == 'edit') {
				$this->master->update('skema', $update, 'id_skema', null, true);
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
			if ($this->master->delete('skema', $chk, 'id_skema')) {
				$this->output_json(['status' => true, 'total' => count($chk)]);
			}
		}
	}

	public function skema_by_jurusan($id)
	{
		$data = $this->master->getSkemaByLevel($id);
		$this->output_json($data);
	}

	public function load_skema()
	{
		$data = $this->master->getSkema();
		$this->output_json($data);
	}

	public function import($import_data = null)
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'judul'	=> 'Skema',
			'subjudul' => 'Import Skema',
			'jurusan' => $this->master->getAllLevel()
		];
		if ($import_data != null) $data['import'] = $import_data;

		$this->load->view('_templates/dashboard/_header', $data);
		$this->load->view('master/skema/import');
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
			$data = [];
			for ($i = 1; $i < count($sheetData); $i++) {
				$data[] = [
					'skema' => $sheetData[$i][0],
					'jurusan' => $sheetData[$i][1]
				];
			}

			unlink($file);

			$this->import($data);
		}
	}
	public function do_import()
	{
		$input = json_decode($this->input->post('data', true));
		$data = [];
		foreach ($input as $d) {
			$data[] = ['nama_skema' => $d->skema, 'jurusan_id' => $d->jurusan];
		}

		$save = $this->master->create('skema', $data, true);
		if ($save) {
			redirect('skema');
		} else {
			redirect('skema/import');
		}
	}
}
