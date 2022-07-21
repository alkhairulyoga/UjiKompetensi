<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HasilUjianessay extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		}

		$this->load->library(['datatables']); // Load Library Ignited-Datatables
		$this->load->model('Master_model', 'master');
		$this->load->model('Ujian_essay_model', 'ujianessay');

		$this->user = $this->ion_auth->user()->row();
	}

	public function output_json($data, $encode = true)
	{
		if ($encode) $data = json_encode($data);
		$this->output->set_content_type('application/json')->set_output($data);
	}

	public function data()
	{
		$nip_dosen = null;

		if ($this->ion_auth->in_group('dosen')) {
			$nip_dosen = $this->user->username;
		}

		$this->output_json($this->ujianessay->getHasilUjian($nip_dosen), false);
	}

	public function NilaiMhs($id)
	{
		$this->output_json($this->ujianessay->HslUjianById($id, true), false);
	}

	public function index()
	{
		$data = [
			'user' => $this->user,
			'judul'	=> 'Ujian Essay',
			'subjudul' => 'Hasil Ujian Essay',
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('ujian_essay/hasil');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function detail($id)
	{
		$ujianessay = $this->ujianessay->getUjianById($id);
		$nilai = $this->ujianessay->bandingNilai($id);

		$data = [
			'user' => $this->user,
			'judul'	=> 'Ujianessay',
			'subjudul' => 'Detail Hasil Ujianessay',
			'ujianessay'	=> $ujianessay,
			'nilai'	=> $nilai
		];

		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('ujian_essay/detail_hasil');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function cetak($id)
	{
		$this->load->library('Pdf');

		$mhs 	= $this->ujianessay->getIdMahasiswa($this->user->username);
		$hasil 	= $this->ujianessay->HslUjianessay($id, $mhs->id_mahasiswa)->row();
		$ujianessay 	= $this->ujianessay->getUjianById($id);

		$data = [
			'ujianessay' => $ujianessay,
			'hasil' => $hasil,
			'mhs'	=> $mhs
		];

		$this->load->view('ujian_essay/cetak', $data);
	}

	public function cetak_detail($id)
	{
		$this->load->library('Pdf');

		$ujianessay = $this->ujianessay->getUjianById($id);
		$nilai = $this->ujianessay->bandingNilai($id);
		$hasil = $this->ujianessay->HslUjianById($id)->result();

		$data = [
			'ujianessay'	=> $ujianessay,
			'nilai'	=> $nilai,
			'hasil'	=> $hasil
		];

		$this->load->view('ujian_essay/cetak_detail', $data);
	}
}
