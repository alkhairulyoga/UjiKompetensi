<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HasilUjianpraktek extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		}

		$this->load->library(['datatables']); // Load Library Ignited-Datatables
		$this->load->model('Master_model', 'master');
		$this->load->model('Ujian_praktek_model', 'ujianpraktek');

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

		$this->output_json($this->ujianpraktek->getHasilUjian($nip_dosen), false);
	}

	public function NilaiMhs($id)
	{
		$this->output_json($this->ujianpraktek->HslUjianById($id, true), false);
	}

	public function index()
	{
		$data = [
			'user' => $this->user,
			'judul'	=> 'Ujian praktek',
			'subjudul' => 'Hasil Ujian praktek',
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('ujian_praktek/hasil');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function detail($id)
	{
		$ujianpraktek = $this->ujianpraktek->getUjianById($id);
		$nilai = $this->ujianpraktek->bandingNilai($id);

		$data = [
			'user' => $this->user,
			'judul'	=> 'Ujianpraktek',
			'subjudul' => 'Detail Hasil Ujianpraktek',
			'ujianpraktek'	=> $ujianpraktek,
			'nilai'	=> $nilai
		];

		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('ujian_praktek/detail_hasil');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function cetak($id)
	{
		$this->load->library('Pdf');

		$mhs 	= $this->ujianpraktek->getIdMahasiswa($this->user->username);
		$hasil 	= $this->ujianpraktek->HslUjianpraktek($id, $mhs->id_mahasiswa)->row();
		$ujianpraktek 	= $this->ujianpraktek->getUjianById($id);

		$data = [
			'ujianpraktek' => $ujianpraktek,
			'hasil' => $hasil,
			'mhs'	=> $mhs
		];

		$this->load->view('ujian_praktek/cetak', $data);
	}

	public function cetak_detail($id)
	{
		$this->load->library('Pdf');

		$ujianpraktek = $this->ujianpraktek->getUjianById($id);
		$nilai = $this->ujianpraktek->bandingNilai($id);
		$hasil = $this->ujianpraktek->HslUjianById($id)->result();

		$data = [
			'ujianpraktek'	=> $ujianpraktek,
			'nilai'	=> $nilai,
			'hasil'	=> $hasil
		];

		$this->load->view('ujian_praktek/cetak_detail', $data);
	}
}
