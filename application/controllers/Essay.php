<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Essay extends CI_Controller
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
        $this->load->model('Essay_model', 'essay');
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
            'judul'    => 'Soal',
            'subjudul' => 'Bank Soal'
        ];

        if ($this->ion_auth->is_admin()) {
            //Jika admin maka tampilkan semua skemalsp
            $data['skemalsp'] = $this->master->getAllskemalsp();
        } else {
            //Jika bukan maka skemalsp dipilih otomatis sesuai skemalsp dosen
            $data['skemalsp'] = $this->essay->getskemalspPengajar($user->username);
        }

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('essay/data');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function detail($id)
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Soal',
            'subjudul'  => 'Edit Soal',
            'essay'      => $this->essay->getSoalById($id),
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('essay/detail');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function add()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Soal',
            'subjudul'  => 'Buat Soal'
        ];

        if ($this->ion_auth->is_admin()) {
            //Jika admin maka tampilkan semua skemalsp
            $data['pengajar'] = $this->essay->getAllpengajar();
        } else {
            //Jika bukan maka skemalsp dipilih otomatis sesuai skemalsp dosen
            $data['pengajar'] = $this->essay->getskemalspPengajar($user->username);
        }

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('essay/add');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function edit($id)
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Soal',
            'subjudul'  => 'Edit Soal',
            'essay'      => $this->essay->getSoalById($id),
        ];

        if ($this->ion_auth->is_admin()) {
            //Jika admin maka tampilkan semua skemalsp
            $data['pengajar'] = $this->essay->getAllPengajar();
        } else {
            //Jika bukan maka skemalsp dipilih otomatis sesuai skemalsp dosen
            $data['pengajar'] = $this->essay->getskemalspPengajar($user->username);
        }

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('essay/edit');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function data($id = null, $dosen = null)
    {
        $this->output_json($this->essay->getDataEssay($id, $dosen), false);
    }

    public function validasi()
    {
        if ($this->ion_auth->is_admin()) {
            $this->form_validation->set_rules('pengajar_id', 'Pengajar', 'required');
        }
        // $this->form_validation->set_rules('essay', 'Soal', 'required');
        // $this->form_validation->set_rules('jawaban_a', 'Jawaban A', 'required');
        // $this->form_validation->set_rules('jawaban_b', 'Jawaban B', 'required');
        // $this->form_validation->set_rules('jawaban_c', 'Jawaban C', 'required');
        // $this->form_validation->set_rules('jawaban_d', 'Jawaban D', 'required');
        // $this->form_validation->set_rules('jawaban_e', 'Jawaban E', 'required');
        $this->form_validation->set_rules('jawaban', 'Kunci Jawaban', 'required');
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
                'soal'      => $this->input->post('soal', true),
            ];


            // Inputan Opsi
            $data['jawaban']    = $this->input->post('jawaban', true);

            $img_src = FCPATH . 'uploads/bank_soal/';
            $getessay = $this->essay->getSoalById($this->input->post('id_soal', true));

            $error = '';
            if ('file_essay') {
                if (!empty($_FILES['file_essay']['name'])) {
                    if (!$this->upload->do_upload('file_essay')) {
                        $error = $this->upload->display_errors();
                        show_error($error, 500, 'File Soal Error');
                        exit();
                    } else {
                        if ($method === 'edit') {
                            if (!unlink($img_src . $getessay->file)) {
                                show_error('Error saat delete gambar <br/>' . var_dump($getessay), 500, 'Error Edit Gambar');
                                exit();
                            }
                        }
                        $data['file'] = $this->upload->data('file_name');
                        $data['tipe_file'] = $this->upload->data('file_type');
                    }
                }
            } else {
                $file_jawaban = 'file_jabawan';
                if (!empty($_FILES[$file_jawaban]['name'])) {
                    if (!$this->upload->do_upload('file_jawaban')) {
                        $error = $this->upload->display_errors();
                        show_error($error, 500, 'File Jawwaban  Error');
                        exit();
                    } else {
                        if ($method === 'edit') {
                            if (!unlink($img_src . $getessay->$file_jawaban)) {
                                show_error('Error saat delete gambar', 500, 'Error Edit Gambar');
                                exit();
                            }
                        }
                        $data[$file_jawaban] = $this->upload->data('file_name');
                    }
                }
            }

            if ($this->ion_auth->is_admin()) {
                $pecah = $this->input->post('pengajar_id', true);
                $pecah = explode(':', $pecah);
                $data['pengajar_id'] = $pecah[0];
                $data['klsp_id'] = end($pecah);
            } else {
                $data['pengajar_id'] = $this->input->post('pengajar_id', true);
                $data['klsp_id'] = $this->input->post('klsp_id', true);
            }

            if ($method === 'add') {
                //push array
                $data['created_on'] = time();
                $data['updated_on'] = time();
                //insert data
                $this->master->create('tb_essay', $data);
            } else if ($method === 'edit') {
                //push array
                $data['updated_on'] = time();
                //update data
                $id_soal = $this->input->post('id_soal', true);
                $this->master->update('tb_essay', $data, 'id_soal', $id_soal);
            } else {
                show_error('Method tidak diketahui', 404);
            }
            redirect('essay');
        }
    }

    public function delete()
    {
        $chk = $this->input->post('checked', true);

        // Delete File
        foreach ($chk as $id) {
            $abjad = ['a', 'b', 'c', 'd', 'e'];
            $path = FCPATH . 'uploads/bank_soal/';
            $essay = $this->essay->getSoalById($id);
            // Hapus File Soal
            if (!empty($essay->file)) {
                if (file_exists($path . $essay->file)) {
                    unlink($path . $essay->file);
                }
            }
            //Hapus File Opsi
            $i = 0; //index
            foreach ($abjad as $abj) {
                $file_opsi = 'file_' . $abj;
                if (!empty($essay->$file_opsi)) {
                    if (file_exists($path . $essay->$file_opsi)) {
                        unlink($path . $essay->$file_opsi);
                    }
                }
            }
        }

        if (!$chk) {
            $this->output_json(['status' => false]);
        } else {
            if ($this->master->delete('tb_essay', $chk, 'id_soal')) {
                $this->output_json(['status' => true, 'total' => count($chk)]);
            }
        }
    }
}
