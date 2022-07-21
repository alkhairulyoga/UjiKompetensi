<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Modul extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }
        $this->load->library(['datatables', 'form_validation']); // Load Library Ignited-Datatables
        $this->load->helper('my'); // Load Library Ignited-Datatables
        $this->load->model('Master_model', 'master');
        $this->load->model('Modul_model', 'modul');
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
            'judul'    => 'Modul',
            'subjudul' => 'Bank Modul'
        ];

        if ($this->ion_auth->is_admin()) {
            //Jika admin maka tampilkan semua skemalsp
            $data['skemalsp'] = $this->master->getAllskemalsp();
        } else {
            //Jika bukan maka skemalsp dipilih otomatis sesuai skemalsp dosen
            $data['skemalsp'] = $this->modul->getskemalspPengajar($user->username);
        }

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('modul/data');
        $this->load->view('_templates/dashboard/_footer.php');
    }


    public function list_json()
    {

        $list = $this->modul->getDataModul($this->mhs->id_mahasiswa, $this->mhs->skema_id);

        $this->output_json($list, false);
    }

    public function list()
    {

        $user = $this->ion_auth->user()->row();

        $data = [
            'user'         => $user,
            'judul'        => 'Modul',
            'subjudul'    => 'List Modul',
            'mhs'         => $this->modul->getIdMahasiswa($user->username),
        ];
        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('modul/list');
        $this->load->view('_templates/dashboard/_footer.php');

        // $this->load->view('_frontend/header.php', $data);
        // $this->load->view('ujian/list');
        // $this->load->view('_frontend/footer.php');
    }

    public function detail($id)
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Modul',
            'subjudul'  => 'Edit Modul',
            'modul'      => $this->modul->getModulById($id),
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('modul/detail');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function add()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Modul',
            'subjudul'  => 'Buat Modul'
        ];

        if ($this->ion_auth->is_admin()) {
            //Jika admin maka tampilkan semua skemalsp
            $data['pengajar'] = $this->modul->getAllPengajar();
        } else {
            //Jika bukan maka skemalsp dipilih otomatis sesuai skemalsp dosen
            $data['pengajar'] = $this->modul->getskemalspPengajar($user->username);
        }

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('modul/add');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function edit($id)
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Modul',
            'subjudul'  => 'Edit Modul',
            'modul'      => $this->modul->getModulById($id),
        ];

        if ($this->ion_auth->is_admin()) {
            //Jika admin maka tampilkan semua skemalsp
            $data['pengajar'] = $this->modul->getAllPengajar();
        } else {
            //Jika bukan maka skemalsp dipilih otomatis sesuai skemalsp dosen
            $data['pengajar'] = $this->modul->getskemalspPengajar($user->username);
        }

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('modul/edit');
        $this->load->view('_templates/dashboard/_footer.php');
    }



    public function data($id = null, $dosen = null)
    {
        $this->output_json($this->modul->getDataModul($id, $dosen), false);
    }

    public function validasi()
    {
        if ($this->ion_auth->is_admin()) {
            $this->form_validation->set_rules('pengajar_id', 'Pengajar', 'required');
        }
        // $this->form_validation->set_rules('modul', 'Modul', 'required');
        // $this->form_validation->set_rules('jawaban_a', 'Jawaban A', 'required');
        // $this->form_validation->set_rules('jawaban_b', 'Jawaban B', 'required');
        // $this->form_validation->set_rules('jawaban_c', 'Jawaban C', 'required');
        // $this->form_validation->set_rules('jawaban_d', 'Jawaban D', 'required');
        // $this->form_validation->set_rules('jawaban_e', 'Jawaban E', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
    }

    public function file_config()
    {
        $allowed_type     = [
            "image/jpeg", "image/jpg", "image/png", "image/gif,image/pdf",
            "audio/mpeg", "audio/mpg", "audio/mpeg3", "audio/mp3", "audio/x-wav", "audio/wave", "audio/wav",
            "video/mp4", "application/octet-stream"
        ];
        $config['upload_path']      = FCPATH . 'uploads/bank_soal/';
        $config['allowed_types']    = 'jpeg|jpg|png|gif|mpeg|mpg|mpeg3|mp3|wav|wave|mp4|pdf';
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
                'modul'      => $this->input->post('modul', true),
            ];


            // Inputan Opsi
            $data['deskripsi']    = $this->input->post('deskripsi', true);

            $img_src = FCPATH . 'uploads/bank_soal/';
            $getpraktek = $this->modul->getModulById($this->input->post('id_modul', true));

            $error = '';
            if ('file_modul') {
                if (!empty($_FILES['file_modul']['name'])) {
                    if (!$this->upload->do_upload('file_modul')) {
                        $error = $this->upload->display_errors();
                        show_error($error, 500, 'File Modul Error');
                        exit();
                    } else {
                        if ($method === 'edit') {
                            if (!unlink($img_src . $getpraktek->file)) {
                                show_error('Error saat delete gambar <br/>' . var_dump($getpraktek), 500, 'Error Edit Gambar');
                                exit();
                            }
                        }
                        $data['file'] = $this->upload->data('file_name');
                        $data['tipe_file'] = $this->upload->data('file_type');
                    }
                }
            } else {
                $file_jawaban = 'file_jawaban';
                if (!empty($_FILES[$file_jawaban]['name'])) {
                    if (!$this->upload->do_upload('file_jawaban')) {
                        $error = $this->upload->display_errors();
                        show_error($error, 500, 'File Jawwaban  Error');
                        exit();
                    } else {
                        if ($method === 'edit') {
                            if (!unlink($img_src . $getpraktek->$file_jawaban)) {
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
                $this->master->create('tb_modul', $data);
            } else if ($method === 'edit') {
                //push array
                $data['updated_on'] = time();
                //update data
                $id_modul = $this->input->post('id_modul', true);
                $this->master->update('tb_modul', $data, 'id_modul', $id_modul);
            } else {
                show_error('Method tidak diketahui', 404);
            }
            redirect('modul');
        }
    }
    public function delete()
    {
        $chk = $this->input->post('checked', true);

        // Delete File
        foreach ($chk as $id) {
            $abjad = ['a', 'b', 'c', 'd', 'e'];
            $path = FCPATH . 'uploads/bank_soal/';
            $modul = $this->modul->getModulById($id);
            // Hapus File Modul
            if (!empty($modul->file)) {
                if (file_exists($path . $modul->file)) {
                    unlink($path . $modul->file);
                }
            }
            //Hapus File Opsi
            $i = 0; //index
            foreach ($abjad as $abj) {
                $file_opsi = 'file_' . $abj;
                if (!empty($modul->$file_opsi)) {
                    if (file_exists($path . $modul->$file_opsi)) {
                        unlink($path . $modul->$file_opsi);
                    }
                }
            }
        }

        if (!$chk) {
            $this->output_json(['status' => false]);
        } else {
            if ($this->master->delete('tb_modul', $chk, 'id_modul')) {
                $this->output_json(['status' => true, 'total' => count($chk)]);
            }
        }
    }
}
