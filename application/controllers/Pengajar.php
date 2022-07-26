<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengajar extends CI_Controller
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
			'judul'	=> 'Pengajar',
			'subjudul' => 'Data Pengajar'
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('master/pengajar/data');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function data()
	{
		$this->output_json($this->master->getDataPengajar(), false);
	}

	public function add()
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'judul'	=> 'Tambah Pengajar',
			'subjudul' => 'Tambah Data Pengajar',
			'klsp'	=> $this->master->getAllskemalsp(),

		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('master/pengajar/add');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function edit($id)
	{
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'judul'		=> 'Edit Pengajar',
			'subjudul'	=> 'Edit Data Pengajar',
			'klsp'	=> $this->master->getAllskemalsp(),
			'data' 		=> $this->master->getPengajarById($id)
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('master/pengajar/edit');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function save()
	{
		$method 	= $this->input->post('method', true);
		$id_pengajar 	= $this->input->post('id_pengajar', true);
		$nip 		= $this->input->post('nip', true);
		$nama_pengajar = $this->input->post('nama_pengajar', true);
		$email 		= $this->input->post('email', true);
		$klsp 	= $this->input->post('klsp', true);
		if ($method == 'add') {
			$u_nip = '|is_unique[pengajar.nip]';
			$u_email = '|is_unique[pengajar.email]';
		} else {
			$dbdata 	= $this->master->getPengajarById($id_pengajar);
			$u_nip		= $dbdata->nip === $nip ? "" : "|is_unique[pengajar.nip]";
			$u_email	= $dbdata->email === $email ? "" : "|is_unique[pengajar.email]";
		}
		$this->form_validation->set_rules('nip', 'NIP', 'required|numeric|trim|min_length[8]|max_length[100]' . $u_nip);
		$this->form_validation->set_rules('nama_pengajar', 'Nama Pengajar', 'required|trim|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email' . $u_email);
		$this->form_validation->set_rules('klsp', 'Skema Lsp', 'required');

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status'	=> false,
				'errors'	=> [
					'nip' => form_error('nip'),
					'nama_pengajar' => form_error('nama_pengajar'),
					'email' => form_error('email'),
					'klsp' => form_error('klsp'),
				]
			];
			$this->output_json($data);
		} else {
			$input = [
				'nip'			=> $nip,
				'nama_pengajar' 	=> $nama_pengajar,
				'email' 		=> $email,
				'klsp_id' 	=> $klsp
			];
			if ($method === 'add') {
				$action = $this->master->create('pengajar', $input);
			} else if ($method === 'edit') {
				$action = $this->master->update('pengajar', $input, 'id_pengajar', $id_pengajar);
			}

			if ($action) {
				$this->output_json(['status' => true]);
			} else {
				$this->output_json(['status' => false]);
			}
		}
	}

	public function delete()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			$this->output_json(['status' => false]);
		} else {
			if ($this->master->delete('pengajar', $chk, 'id_pengajar')) {
				$this->output_json(['status' => true, 'total' => count($chk)]);
			}
		}
	}

	public function create_user()
	{
		$id = $this->input->get('id', true);
		$data = $this->master->getPengajarById($id);
		$nama = explode(' ', $data->nama_pengajar);
		$first_name = $nama[0];
		$last_name = end($nama);

		$username = $data->nip;
		$password = $data->nip;
		$email = $data->email;
		$additional_data = [
			'first_name'	=> $first_name,
			'last_name'		=> $last_name
		];
		$group = array('2'); // Sets user to pengajar.

		if ($this->ion_auth->username_check($username)) {
			$data = [
				'status' => false,
				'msg'	 => 'Username tidak tersedia (sudah digunakan).'
			];
		} else if ($this->ion_auth->email_check($email)) {
			$data = [
				'status' => false,
				'msg'	 => 'Email tidak tersedia (sudah digunakan).'
			];
		} else {
			$this->ion_auth->register($username, $password, $email, $additional_data, $group);
			$data = [
				'status'	=> true,
				'msg'	 => 'User berhasil dibuat. NIP digunakan sebagai password pada saat login.'
			];
		}
		$this->output_json($data);
	}

	public function import($import_data = null)
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'judul'	=> 'Pengajar',
			'subjudul' => 'Import Data Pengajar',
			'klsp' => $this->master->getAllskemalsp()
		];
		if ($import_data != null) $data['import'] = $import_data;

		$this->load->view('_templates/dashboard/_header', $data);
		$this->load->view('master/pengajar/import');
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
					'nip' => $sheetData[$i][0],
					'nama_pengajar' => $sheetData[$i][1],
					'email' => $sheetData[$i][2],
					'klsp_id' => $sheetData[$i][3]
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
			$data[] = [
				'nip' => $d->nip,
				'nama_pengajar' => $d->nama_pengajar,
				'email' => $d->email,
				'klsp_id' => $d->klsp_id
			];
		}

		$save = $this->master->create('pengajar', $data, true);
		if ($save) {
			redirect('pengajar');
		} else {
			redirect('pengajar/import');
		}
	}
}
