<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Muser extends CI_Controller
{

    public $mhs, $user;

    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }
        $this->load->library(['datatables', 'form_validation']); // Load Library Ignited-Datatables
        $this->load->helper('my');
        $this->load->model('Master_model', 'master');
        $this->load->model('Soal_model', 'soal');
        $this->load->model('Modul_user_Model', 'muser');
        $this->form_validation->set_error_delimiters('', '');

        $this->user = $this->ion_auth->user()->row();
        $this->mhs     = $this->muser->getIdMahasiswa($this->user->username);
    }

    public function akses_dosen()
    {
        if (!$this->ion_auth->in_group('dosen')) {
            show_error('Halaman ini khusus untuk dosen untuk membuat Test Online, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
    }

    public function akses_mahasiswa()
    {
        if (!$this->ion_auth->in_group('mahasiswa')) {
            show_error('Halaman ini khusus untuk mahasiswa mengikuti muser, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    public function json($id = null)
    {
        $this->akses_dosen();

        $this->output_json($this->muser->getDataModul($id), false);
    }

    public function index()
    {
        $this->akses_dosen();
        $user = $this->ion_auth->user()->row();
        $data = [
            'user' => $user,
            'judul'    => 'Modul',
            'subjudul' => 'Data Modul',
            'dosen' => $this->muser->getIdPengajar($user->username),
        ];
        $this->load->view('_frontend/header.php', $data);
        $this->load->view('muser/list.php');
        $this->load->view('_frontend/footer.php');

        // $this->load->view('_frontend/layout.php', $data);
    }


    public function add()
    {
        $this->akses_dosen();

        $user = $this->ion_auth->user()->row();

        $data = [
            'user'         => $user,
            'judul'        => 'Ujian',
            'subjudul'    => 'Tambah Ujian',
            'skemalsp'    => $this->soal->getskemalspPengajar($user->username),
            'dosen'        => $this->ujian->getIdPengajar($user->username),
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('ujian/add');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function edit($id)
    {
        $this->akses_dosen();

        $user = $this->ion_auth->user()->row();

        $data = [
            'user'         => $user,
            'judul'        => 'Ujian',
            'subjudul'    => 'Edit Ujian',
            'skemalsp'    => $this->soal->getskemalspPengajar($user->username),
            'dosen'        => $this->ujian->getIdPengajar($user->username),
            'ujian'        => $this->ujian->getUjianById($id),
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('ujian/edit');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function convert_tgl($tgl)
    {
        $this->akses_dosen();
        return date('Y-m-d H:i:s', strtotime($tgl));
    }

    public function validasi()
    {
        $this->akses_dosen();

        $user     = $this->ion_auth->user()->row();
        $dosen     = $this->ujian->getIdPengajar($user->username);
        $jml     = $this->ujian->getJumlahSoal($dosen->id_dosen)->jml_soal;
        $jml_a     = $jml + 1; // Jika tidak mengerti, silahkan baca user_guide codeigniter tentang form_validation pada bagian less_than

        $this->form_validation->set_rules('nama_ujian', 'Nama Ujian', 'required|alpha_numeric_spaces|max_length[50]');
        $this->form_validation->set_rules('jumlah_soal', 'Jumlah Soal', "required|integer|less_than[{$jml_a}]|greater_than[0]", ['less_than' => "Soal tidak cukup, anda hanya punya {$jml} soal"]);
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('tgl_selesai', 'Tanggal Selesai', 'required');
        $this->form_validation->set_rules('waktu', 'Waktu', 'required|integer|max_length[4]|greater_than[0]');
        $this->form_validation->set_rules('jenis', 'Acak Soal', 'required|in_list[acak,urut]');
    }

    public function save()
    {
        $this->validasi();
        $this->load->helper('string');

        $method         = $this->input->post('method', true);
        $dosen_id         = $this->input->post('dosen_id', true);
        $skemalsp_id         = $this->input->post('skemalsp_id', true);
        $nama_ujian     = $this->input->post('nama_ujian', true);
        $jumlah_soal     = $this->input->post('jumlah_soal', true);
        $tgl_mulai         = $this->convert_tgl($this->input->post('tgl_mulai',     true));
        $tgl_selesai    = $this->convert_tgl($this->input->post('tgl_selesai', true));
        $waktu            = $this->input->post('waktu', true);
        $jenis            = $this->input->post('jenis', true);
        $token             = strtoupper(random_string('alpha', 5));

        if ($this->form_validation->run() === FALSE) {
            $data['status'] = false;
            $data['errors'] = [
                'nama_ujian'     => form_error('nama_ujian'),
                'jumlah_soal'     => form_error('jumlah_soal'),
                'tgl_mulai'     => form_error('tgl_mulai'),
                'tgl_selesai'     => form_error('tgl_selesai'),
                'waktu'         => form_error('waktu'),
                'jenis'         => form_error('jenis'),
            ];
        } else {
            $input = [
                'nama_ujian'     => $nama_ujian,
                'jumlah_soal'     => $jumlah_soal,
                'tgl_mulai'     => $tgl_mulai,
                'terlambat'     => $tgl_selesai,
                'waktu'         => $waktu,
                'jenis'         => $jenis,
            ];
            if ($method === 'add') {
                $input['dosen_id']    = $dosen_id;
                $input['skemalsp_id'] = $skemalsp_id;
                $input['token']        = $token;
                $action = $this->master->create('m_ujian', $input);
            } else if ($method === 'edit') {
                $id_ujian = $this->input->post('id_ujian', true);
                $action = $this->master->update('m_ujian', $input, 'id_ujian', $id_ujian);
            }
            $data['status'] = $action ? TRUE : FALSE;
        }
        $this->output_json($data);
    }

    public function delete()
    {
        $this->akses_dosen();
        $chk = $this->input->post('checked', true);
        if (!$chk) {
            $this->output_json(['status' => false]);
        } else {
            if ($this->master->delete('m_ujian', $chk, 'id_ujian')) {
                $this->output_json(['status' => true, 'total' => count($chk)]);
            }
        }
    }

    public function refresh_token($id)
    {
        $this->load->helper('string');
        $data['token'] = strtoupper(random_string('alpha', 5));
        $refresh = $this->master->update('m_ujian', $data, 'id_ujian', $id);
        $data['status'] = $refresh ? TRUE : FALSE;
        $this->output_json($data);
    }

    /**
     * BAGIAN MAHASISWA
     */

    public function list_json()
    {
        $this->akses_mahasiswa();

        $list = $this->ujian->getListUjian($this->mhs->id_mahasiswa, $this->mhs->skema_id);
        $this->output_json($list, false);
    }

    public function list()
    {
        $this->akses_mahasiswa();

        $user = $this->ion_auth->user()->row();

        $data = [
            'user'         => $user,
            'judul'        => 'Ujian',
            'subjudul'    => 'List Ujian',
            'mhs'         => $this->ujian->getIdMahasiswa($user->username),
        ];
        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('ujian/list');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function token($id)
    {
        $this->akses_mahasiswa();
        $user = $this->ion_auth->user()->row();

        $data = [
            'user'         => $user,
            'judul'        => 'Ujian',
            'subjudul'    => 'Token Ujian',
            'mhs'         => $this->ujian->getIdMahasiswa($user->username),
            'ujian'        => $this->ujian->getUjianById($id),
            'encrypted_id' => urlencode($this->encryption->encrypt($id))
        ];
        $this->load->view('_templates/topnav/_header.php', $data);
        $this->load->view('ujian/token');
        $this->load->view('_templates/topnav/_footer.php');
    }

    public function cektoken()
    {
        $id = $this->input->post('id_ujian', true);
        $token = $this->input->post('token', true);
        $cek = $this->ujian->getUjianById($id);

        $data['status'] = $token === $cek->token ? TRUE : FALSE;
        $this->output_json($data);
    }

    public function encrypt()
    {
        $id = $this->input->post('id', true);
        $key = urlencode($this->encryption->encrypt($id));
        // $decrypted = $this->encryption->decrypt(rawurldecode($key));
        $this->output_json(['key' => $key]);
    }



    public function simpan_satu()
    {
        // Decrypt Id
        $id_tes = $this->input->post('id', true);
        $id_tes = $this->encryption->decrypt($id_tes);

        $input     = $this->input->post(null, true);
        $list_jawaban     = "";
        for ($i = 1; $i < $input['jml_soal']; $i++) {
            $_tjawab     = "opsi_" . $i;
            $_tidsoal     = "id_soal_" . $i;
            $_ragu         = "rg_" . $i;
            $jawaban_     = empty($input[$_tjawab]) ? "" : $input[$_tjawab];
            $list_jawaban    .= "" . $input[$_tidsoal] . ":" . $jawaban_ . ":" . $input[$_ragu] . ",";
        }
        $list_jawaban    = substr($list_jawaban, 0, -1);
        $d_simpan = [
            'list_jawaban' => $list_jawaban
        ];

        // Simpan jawaban
        $this->master->update('h_ujian', $d_simpan, 'id', $id_tes);
        $this->output_json(['status' => true]);
    }

    public function simpan_akhir()
    {
        // Decrypt Id
        $id_tes = $this->input->post('id', true);
        $id_tes = $this->encryption->decrypt($id_tes);

        // Get Jawaban
        $list_jawaban = $this->ujian->getJawaban($id_tes);

        // Pecah Jawaban
        $pc_jawaban = explode(",", $list_jawaban);

        $jumlah_benar     = 0;
        $jumlah_salah     = 0;
        $jumlah_ragu      = 0;
        $nilai_bobot     = 0;
        $total_bobot    = 0;
        $jumlah_soal    = sizeof($pc_jawaban);

        foreach ($pc_jawaban as $jwb) {
            $pc_dt         = explode(":", $jwb);
            $id_soal     = $pc_dt[0];
            $jawaban     = $pc_dt[1];
            $ragu         = $pc_dt[2];

            $cek_jwb     = $this->soal->getSoalById($id_soal);
            $total_bobot = $total_bobot + $cek_jwb->bobot;

            $jawaban == $cek_jwb->jawaban ? $jumlah_benar++ : $jumlah_salah++;
        }

        $nilai = ($jumlah_benar / $jumlah_soal)  * 100;
        $nilai_bobot = ($total_bobot / $jumlah_soal)  * 100;

        $d_update = [
            'jml_benar'        => $jumlah_benar,
            'nilai'            => number_format(floor($nilai), 0),
            'nilai_bobot'    => number_format(floor($nilai_bobot), 0),
            'status'        => 'N'
        ];

        $this->master->update('h_ujian', $d_update, 'id', $id_tes);
        $this->output_json(['status' => TRUE, 'data' => $d_update, 'id' => $id_tes]);
    }
}
