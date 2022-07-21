<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Latihan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        } else if (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('dosen')) {
            show_error('Hanya Administrator dan dosen yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $this->load->library(['datatables', 'form_validation']); // Load Library Ignited-Datatables
        $this->load->helper('my'); // Load Library Ignited-Datatables
        $this->load->model('Master_model', 'master');
        $this->load->model('Latihan_model', 'latihan');
        $this->form_validation->set_error_delimiters('', '');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    public function index()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user' => $user,
            'judul'    => 'Latihan',
            'subjudul' => 'Soal Latihan'
        ];

        if ($this->ion_auth->is_admin()) {
            //Jika admin maka tampilkan semua skemalsp
            $data['klsp'] = $this->master->getAllskemalsp();
        } else {
            //Jika bukan maka skemalsp dipilih otomatis sesuai skemalsp dosen
            $data['klsp'] = $this->latihan->getskemalspPengajar($user->username);
        }

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('latihan/data');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function detail($id)
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Latihan',
            'subjudul'  => 'Edit Latihan',
            'latihan'      => $this->latihan->getLatihanById($id),
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('latihan/detail');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function add()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Latihan',
            'subjudul'  => 'Buat Latihan'
        ];

        if ($this->ion_auth->is_admin()) {
            //Jika admin maka tampilkan semua skemalsp
            $data['pengajar'] = $this->latihan->getAllPengajar();
            $data['pengajar'] = $this->latihan->getAllPengajar();
            $data['modul'] = $this->latihan->getAllModul();
        } else {
            //Jika bukan maka skemalsp dipilih otomatis sesuai skemalsp pengajar
            $data['pengajar'] = $this->latihan->getskemalspPengajar($user->username);
            $data['modul'] = $this->latihan->getAllModul($user->username);
        }

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('latihan/add');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function edit($id)
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Latihan',
            'subjudul'  => 'Edit Latihan',
            'latihan'      => $this->latihan->getLatihanById($id),

        ];

        if ($this->ion_auth->is_admin()) {
            //Jika admin maka tampilkan semua skemalsp
            $data['pengajar'] = $this->latihan->getAllPengajar();
            $data['modul'] = $this->latihan->getAllModul();
        } else {
            //Jika bukan maka skemalsp dipilih otomatis sesuai skemalsp dosen
            $data['pengajar'] = $this->latihan->getskemalspPengajar($user->username);
            $data['modul'] = $this->latihan->getAllModul($user->username);
        }

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('latihan/edit');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function data($id = null, $dosen = null)
    {
        $this->output_json($this->latihan->getDataLatihan($id, $dosen), false);
    }

    public function validasi()
    {
        if ($this->ion_auth->is_admin()) {
            $this->form_validation->set_rules('pengajar_id', 'Pengajar', 'required');
        }
        // $this->form_validation->set_rules('latihan', 'Latihan', 'required');
        // $this->form_validation->set_rules('jawaban_a', 'Jawaban A', 'required');
        // $this->form_validation->set_rules('jawaban_b', 'Jawaban B', 'required');
        // $this->form_validation->set_rules('jawaban_c', 'Jawaban C', 'required');
        // $this->form_validation->set_rules('jawaban_d', 'Jawaban D', 'required');
        // $this->form_validation->set_rules('jawaban_e', 'Jawaban E', 'required');
        $this->form_validation->set_rules('jawaban', 'Kunci Jawaban', 'required');
        $this->form_validation->set_rules('bobot', 'Bobot Latihan', 'required|max_length[2]');
    }

    public function file_config()
    {
        $allowed_type     = [
            "image/jpeg", "image/jpg", "image/png", "image/gif",
            "audio/mpeg", "audio/mpg", "audio/mpeg3", "audio/mp3", "audio/x-wav", "audio/wave", "audio/wav",
            "video/mp4", "application/octet-stream"
        ];
        $config['upload_path']      = FCPATH . 'uploads/bank_soal/';
        $config['allowed_types']    = 'jpeg|jpg|png|gif|mpeg|mpg|mpeg3|mp3|wav|wave|mp4';
        $config['encrypt_name']     = TRUE;

        return $this->load->library('upload', $config);
    }

    public function save()
    {
        $method = $this->input->post('method', true);
        $this->validasi();
        $this->file_config();


        if ($this->form_validation->run() === FALSE) {
            $method === 'add' ? $this->add() : $this->edit();
        } else {
            $data = [
                'soal'   => $this->input->post('soal', true),
                'jawaban'   => $this->input->post('jawaban', true),
                'bobot'     => $this->input->post('bobot', true),
            ];

            $abjad = ['a', 'b', 'c', 'd', 'e'];

            // Inputan Opsi
            foreach ($abjad as $abj) {
                $data['opsi_' . $abj]    = $this->input->post('jawaban_' . $abj, true);
            }

            $i = 0;
            foreach ($_FILES as $key => $val) {

                $img_src['upload_path']      = FCPATH . 'uploads/bank_soal/';
                $getlatihan = $this->latihan->getLatihanById($this->input->post('id_soal', true));

                $error = '';
                if ($key === 'file_soal') {
                    if (!empty($_FILES['file_soal']['name'])) {
                        if (!$this->upload->do_upload('file_soal')) {
                            $error = $this->upload->display_errors();
                            show_error($error, 500, 'File Latihan Error');
                            exit();
                        } else {
                            if ($method === 'edit') {
                                if (!unlink($img_src . $getlatihan->file)) {
                                    show_error('Error saat delete gambar <br/>' . var_dump($getlatihan), 500, 'Error Edit Gambar');
                                    exit();
                                }
                            }
                            $data['file'] = $this->upload->data('file_name');
                            $data['tipe_file'] = $this->upload->data('file_type');
                        }
                    }
                } else {
                    $file_abj = 'file_' . $abjad[$i];
                    if (!empty($_FILES[$file_abj]['name'])) {
                        if (!$this->upload->do_upload($key)) {
                            $error = $this->upload->display_errors();
                            show_error($error, 500, 'File Opsi ' . strtoupper($abjad[$i]) . ' Error');
                            exit();
                        } else {
                            if ($method === 'edit') {
                                if (!unlink($img_src . $getlatihan->$file_abj)) {
                                    show_error('Error saat delete gambar', 500, 'Error Edit Gambar');
                                    exit();
                                }
                            }
                            $data[$file_abj] = $this->upload->data('file_name');
                        }
                    }
                    $i++;
                }
            }

            if ($this->ion_auth->is_admin()) {
                $data['modul_id'] = $this->input->post('modul_id', true);
                $pecah = $this->input->post('pengajar_id', true);
                $pecah = explode(':', $pecah);
                $data['pengajar_id'] = $pecah[1];
                $data['klsp_id'] = end($pecah);
            } else {
                $data['pengajar_id'] = $this->input->post('pengajar_id', true);
                $data['klsp_id'] = $this->input->post('klsp_id', true);
                $data['modul_id'] = $this->input->post('modul_id', true);
            }

            if ($method === 'add') {
                //push array
                $data['created_on'] = time();
                $data['updated_on'] = time();
                //insert data
                $this->master->create('soal_modul', $data);
            } else if ($method === 'edit') {
                //push array
                $data['updated_on'] = time();
                //update data
                $id_soal = $this->input->post('id_soal', true);
                $this->master->update('soal_modul', $data, 'id_soal', $id_soal);
            } else {
                show_error('Method tidak diketahui', 404);
            }
            redirect('latihan');
        }
    }

    public function delete()
    {
        $chk = $this->input->post('checked', true);

        // Delete File
        foreach ($chk as $id) {
            $abjad = ['a', 'b', 'c', 'd', 'e'];
            $path = FCPATH . 'uploads/bank_latihan/';
            $latihan = $this->latihan->getLatihanById($id);
            // Hapus File Latihan
            if (!empty($latihan->file)) {
                if (file_exists($path . $latihan->file)) {
                    unlink($path . $latihan->file);
                }
            }
            //Hapus File Opsi
            $i = 0; //index
            foreach ($abjad as $abj) {
                $file_opsi = 'file_' . $abj;
                if (!empty($latihan->$file_opsi)) {
                    if (file_exists($path . $latihan->$file_opsi)) {
                        unlink($path . $latihan->$file_opsi);
                    }
                }
            }
        }

        if (!$chk) {
            $this->output_json(['status' => false]);
        } else {
            if ($this->master->delete('soal_modul', $chk, 'id_soal')) {
                $this->output_json(['status' => true, 'total' => count($chk)]);
            }
        }
    }
}
