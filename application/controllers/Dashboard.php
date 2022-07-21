<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		}
		$this->load->model('Dashboard_model', 'dashboard');
		$this->user = $this->ion_auth->user()->row();
	}

	public function admin_box()
	{
		$box = [
			[
				'box' 		=> 'light-blue',
				'total' 	=> $this->dashboard->total('level'),
				'title'		=> 'Level',
				'icon'		=> 'graduation-cap'
			],
			[
				'box' 		=> 'olive',
				'total' 	=> $this->dashboard->total('skema'),
				'title'		=> 'Skema',
				'icon'		=> 'building-o'
			],
			[
				'box' 		=> 'yellow-active',
				'total' 	=> $this->dashboard->total('pengajar'),
				'title'		=> 'Pengajar',
				'icon'		=> 'user-secret'
			],
			[
				'box' 		=> 'red',
				'total' 	=> $this->dashboard->total('peserta'),
				'title'		=> 'Peserta',
				'icon'		=> 'user'
			],
		];
		$info_box = json_decode(json_encode($box), FALSE);
		return $info_box;
	}

	public function index()
	{
		$user = $this->user;
		$data = [
			'user' 		=> $user,
			'judul'		=> 'Dashboard',
			'subjudul'	=> 'Data Aplikasi',
		];

		if ($this->ion_auth->is_admin()) {
			$data['info_box'] = $this->admin_box();
		} elseif ($this->ion_auth->in_group('dosen')) {
			$skemalsp = ['skema_lsp' => 'pengajar.klsp_id=skema_lsp.id_klsp'];
			$data['dosen'] = $this->dashboard->get_where('pengajar', 'nip', $user->username, $skemalsp)->row();

			$skema = ['skema' => 'skema_pengajar.skema_id=skema.id_skema'];
			$data['skema'] = $this->dashboard->get_where('skema_pengajar', 'pengajar_id', $data['dosen']->id_pengajar, $skema, ['nama_skema' => 'ASC'])->result();
		} else {
			$join = [
				'skema b' 	=> 'a.skema_id = b.id_skema',
				'level c'	=> 'b.level_id = c.id_level'
			];
			$data['mahasiswa'] = $this->dashboard->get_where('peserta a', 'nim', $user->username, $join)->row();
		}

		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('dashboard');
		$this->load->view('_templates/dashboard/_footer.php');



		// stem

		$a = "terimakasih kepada andi";
		$b = "terimakasih";



		$baru = $this->cosine->similarity($a, $b);
		var_dump($baru);

		echo number_format($baru, floor(3));
		echo '<br>';
	}
}
