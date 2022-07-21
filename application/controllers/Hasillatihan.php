<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hasillatihan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		}

		$this->load->library(['datatables']); // Load Library Ignited-Datatables
		$this->load->model('Master_model', 'master');
		$this->load->model('soal_latihan_model', 'latihan');

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

		$this->output_json($this->latihan->getHasilLatihan($nip_dosen), false);
	}

	public function NilaiMhs($id)
	{
		$this->output_json($this->latihan->HsllatihanById($id, true), false);
	}

	public function index()
	{
		$data = [
			'user' => $this->user,
			'judul'	=> 'latihan',
			'subjudul' => 'Hasil latihan',
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('latihanmodul/hasil');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function detail($id)
	{
		$latihan = $this->latihan->getLatihanById($id);
		$nilai = $this->latihan->bandingNilai($id);

		$data = [
			'user' => $this->user,
			'judul'	=> 'latihan',
			'subjudul' => 'Detail Hasil latihan',
			'latihan'	=> $latihan,
			'nilai'	=> $nilai
		];

		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('latihanmodul/detail_hasil');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function cetak($id)
	{
		$this->load->library('Pdf');

		$mhs 	= $this->latihan->getIdMahasiswa($this->user->username);
		$hasil 	= $this->latihan->Hsllatihan($id, $mhs->id_mahasiswa)->row();
		$latihan 	= $this->latihan->getlatihanById($id);

		$data = [
			'latihan' => $latihan,
			'hasil' => $hasil,
			'mhs'	=> $mhs
		];

		$this->load->view('latihanmodul/cetak', $data);
	}

	public function cetak_detail($id)
	{
		$this->load->library('Pdf');

		$latihan = $this->latihan->getlatihanById($id);
		$nilai = $this->latihan->bandingNilai($id);
		$hasil = $this->latihan->HsllatihanById($id)->result();

		$data = [
			'latihan'	=> $latihan,
			'nilai'	=> $nilai,
			'hasil'	=> $hasil
		];

		$this->load->view('latihanmodul/cetak_detail', $data);
	}
}
