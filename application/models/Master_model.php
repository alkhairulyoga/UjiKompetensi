<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_model extends CI_Model
{
    public function __construct()
    {
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }

    public function create($table, $data, $batch = false)
    {
        if ($batch === false) {
            $insert = $this->db->insert($table, $data);
        } else {
            $insert = $this->db->insert_batch($table, $data);
        }
        return $insert;
    }

    public function update($table, $data, $pk, $id = null, $batch = false)
    {
        if ($batch === false) {
            $insert = $this->db->update($table, $data, array($pk => $id));
        } else {
            $insert = $this->db->update_batch($table, $data, $pk);
        }
        return $insert;
    }

    public function delete($table, $data, $pk)
    {
        $this->db->where_in($pk, $data);
        return $this->db->delete($table);
    }

    /**
     * Data Skema
     */

    public function getDataSkema()
    {
        $this->datatables->select('id_skema, nama_skema, id_klsp, nama_klsp,nama_level');
        $this->datatables->from('skema');
        $this->datatables->join('skema_lsp', 'klsp_id=id_klsp');
        $this->datatables->join('level', 'level_id=id_level');
        $this->datatables->add_column('bulk_select', '<div class="text-center"><input type="checkbox" class="check" name="checked[]" value="$1"/></div>', 'id_skema, nama_skema, id_klsp, nama_level,id_level');
        return $this->datatables->generate();
    }
    // public function getDataSkema()
    // {
    //     $this->datatables->select('id_skema, nama_skema, id_klsp, nama_klsp');
    //     $this->datatables->from('skema');
    //     $this->datatables->join('skema_lsp', 'klsp_id=id_klsp');
    //     $this->datatables->add_column('bulk_select', '<div class="text-center"><input type="checkbox" class="check" name="checked[]" value="$1"/></div>', 'id_skema, nama_skema, id_jurusan, nama_level');
    //     return $this->datatables->generate();
    // }

    public function getSkemaById($id)
    {
        $this->db->where_in('id_skema', $id);
        $this->db->order_by('nama_skema');
        $query = $this->db->get('skema')->result();
        return $query;
    }

    /**
     * Data Level
     */

    public function getDataLevel()
    {
        $this->datatables->select('id_level, nama_level');
        $this->datatables->from('level');
        $this->datatables->add_column('bulk_select', '<div class="text-center"><input type="checkbox" class="check" name="checked[]" value="$1"/></div>', 'id_level, nama_level');
        return $this->datatables->generate();
    }

    public function getLevelById($id)
    {
        $this->db->where_in('id_level', $id);
        $this->db->order_by('nama_level');
        $query = $this->db->get('level')->result();
        return $query;
    }


    public function getKlspById($id)
    {
        $this->db->where_in('id_klsp', $id);
        $this->db->order_by('nama_klsp');
        $query = $this->db->get('klsp')->result();
        return $query;
    }

    /**
     * Data Pertemuan
     */

    public function getDataPertemuan()
    {
        $this->datatables->select('a.id_pertemuan,a.pertemuan, b.nama_skema,c.nama_modul,d.nama_pengajar,e.nama_ujian,f.date');
        $this->datatables->from('pertemuan a');
        $this->datatables->join('skema b', 'a.skema_id=b.id_skema');
        $this->datatables->join('modul c', 'a.modul_id=c.id_modul');
        $this->datatables->join('pengajar d', 'a.pengajar_id=d.id_pengajar');
        $this->datatables->join('m_ujian e', 'a.ujian_id=e.id_ujian');
        $this->datatables->join('essay f', 'a.essay_id=f.id_essay');
        return $this->datatables->generate();
    }

    // Absensi
    public function getDataAbsensi()
    {
        $this->datatables->select('a.id_absen,a.keterangan,b.pertemuan, c.nama,d.nama_pengajar,e.nama_skema');
        $this->datatables->from('absensi a');
        $this->datatables->join('pertemuan b', 'a.pertemuan_id=b.id_pertemuan');
        $this->datatables->join('peserta c', 'a.mahasiswa_id=c.id_mahasiswa');
        $this->datatables->join('pengajar d', 'a.pengajar_id=d.id_pengajar');
        $this->datatables->join('skema e', 'a.skema_id=e.id_skema');
        return $this->datatables->generate();
    }



    /**
     * Data Mahasiswa
     */

    public function getDataMahasiswa()
    {
        $this->datatables->select('a.id_mahasiswa, a.nama, a.nim, a.email, b.nama_skema, c.nama_klsp');
        $this->datatables->select('(SELECT COUNT(id) FROM users WHERE username = a.nim) AS ada');
        $this->datatables->from('peserta a');
        $this->datatables->join('skema b', 'a.skema_id=b.id_skema');
        $this->datatables->join('skema_lsp c', 'b.klsp_id=c.id_klsp');
        return $this->datatables->generate();
    }

    public function getMahasiswaById($id)
    {
        $this->db->select('*');
        $this->db->from('peserta');
        $this->db->join('skema', 'skema_id=id_skema');
        $this->db->join('level', 'level_id=id_level');
        $this->db->where(['id_mahasiswa' => $id]);
        return $this->db->get()->row();
    }

    public function getAllPeserta()
    {
        $this->db->select('id_mahasiswa, nama');
        $this->db->from('peserta');
        return $this->db->get()->result();
    }

    public function getAllEssayData()
    {
        $this->db->select('id_essay, date');
        $this->db->from('essay');
        return $this->db->get()->result();
    }

    public function getLevel()
    {
        $this->db->select('id_level, nama_level');
        $this->db->from('skema');
        $this->db->join('level', 'level_id=id_level');
        $this->db->order_by('nama_level', 'ASC');
        $this->db->group_by('id_level');
        $query = $this->db->get();
        return $query->result();
    }

    public function getKLSP()
    {
        $this->db->select('id_klsp, nama_klsp');
        $this->db->from('skema');
        $this->db->join('skema_lsp', 'klsp_id=id_klsp');
        $this->db->order_by('nama_klsp', 'ASC');
        $this->db->group_by('id_klsp');
        $query = $this->db->get();
        return $query->result();
    }

    public function getSkema()
    {
        $this->db->select('id_skema, nama_skema');
        $this->db->from('skema');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllLevel($id = null)
    {
        if ($id === null) {
            $this->db->order_by('nama_level', 'ASC');
            return $this->db->get('level')->result();
        } else {
            $this->db->select('klsp_id');
            $this->db->from('level_skemalsp');
            $this->db->where('klsp_id', $id);
            $klsp = $this->db->get()->result();
            $id_klsp = [];
            foreach ($klsp as $j) {
                $id_klsp[] = $j->klsp_id;
            }
            if ($id_klsp === []) {
                $id_klsp = null;
            }

            $this->db->select('*');
            $this->db->from('level');
            $this->db->where_not_in('id_level', $id_klsp);
            $skemalsp = $this->db->get()->result();
            return $skemalsp;
        }
    }

    public function getSkemaByLevel($id)
    {
        $query = $this->db->get_where('skema', array('level_id' => $id));
        return $query->result();
    }




    /**
     * Data Pengajar
     */

    public function getDataPengajar()
    {
        $this->datatables->select('a.id_pengajar,a.nip, a.nama_pengajar, a.email, a.klsp_id, b.nama_klsp, (SELECT COUNT(id) FROM users WHERE username = a.nip OR email = a.email) AS ada');
        $this->datatables->from('pengajar a');
        $this->datatables->join('skema_lsp b', 'a.klsp_id=b.id_klsp');
        return $this->datatables->generate();
    }

    public function getPengajarById($id)
    {
        $query = $this->db->get_where('pengajar', array('id_pengajar' => $id));
        return $query->row();
    }

    /**
     * Data skemalsp
     */

    public function getDataskemalsp()
    {
        $this->datatables->select('id_klsp, nama_klsp');
        $this->datatables->from('skema_lsp');
        return $this->datatables->generate();
    }

    public function getAllskemalsp()
    {
        return $this->db->get('skema_lsp')->result();
    }

    public function getSkemalspByid($id, $single = false)
    {
        if ($single === false) {
            $this->db->where_in('id_klsp', $id);
            $this->db->order_by('nama_klsp');
            $query = $this->db->get('skema_lsp')->result();
        } else {
            $query = $this->db->get_where('skema_lsp', array('id_klsp' => $id))->row();
        }
        return $query;
    }



    // Data Modul 

    // Untuk memanggil data dari dataabase dan mengirim data ke datatablase(query)

    public function getDataModul()
    {
        $this->datatables->select('a.id_modul,a.nama_modul, b.nama_klsp,c.nama_skema,d.nama_pengajar');
        $this->datatables->from('modul a');
        $this->datatables->join('skema_lsp b', 'a.klsp_id=b.id_klsp');
        $this->datatables->join('skema c', 'a.skema_id=c.id_skema');
        $this->datatables->join('pengajar d', 'a.pengajar_id=d.id_pengajar');
        return $this->datatables->generate();
    }

    public function getModulById($id, $single = false)
    {
        if ($single === false) {
            $this->db->where_in('id_modul', $id);
            $this->db->order_by('nama_modul');
            $query = $this->db->get('modul')->result();
        } else {
            $query = $this->db->get_where('modul', array('id_modul' => $id))->row();
        }
        return $query;
    }

    public function getAllModul()
    {
        $this->db->select('id_modul, nama_modul');
        $this->db->from('modul');
        return $this->db->get()->result();
    }



    /**
     * Data Skema Pengajar
     */

    public function getSkemaPengajar()
    {
        $this->datatables->select('skema_pengajar.id, pengajar.id_pengajar, pengajar.nip, pengajar.nama_pengajar, GROUP_CONCAT(skema.nama_skema) as skema');
        $this->datatables->from('skema_pengajar');
        $this->datatables->join('skema', 'skema_id=id_skema');
        $this->datatables->join('pengajar', 'pengajar_id=id_pengajar');
        $this->datatables->group_by('pengajar.nama_pengajar');
        return $this->datatables->generate();
    }

    public function getAllPengajar($id = null)
    {
        $this->db->select('pengajar_id');
        $this->db->from('skema_pengajar');

        $pengajar = $this->db->get()->result();
        $id_pengajar = [];
        foreach ($pengajar as $d) {
            $id_pengajar[] = $d->pengajar_id;
        }
        if ($id_pengajar === []) {
            $id_pengajar = null;
        }

        $this->db->select('id_pengajar, nip, nama_pengajar');
        $this->db->from('pengajar');
        $this->db->where_not_in('id_pengajar', $id_pengajar);
        return $this->db->get()->result();
    }


    public function getAllSkema()
    {
        $this->db->select('id_skema, nama_skema, nama_level');
        $this->db->from('skema');
        $this->db->join('level', 'level_id=id_level');
        $this->db->order_by('nama_skema');
        return $this->db->get()->result();
    }

    public function getAllSkemaModul()
    {
        $this->db->select('id_skema, nama_skema');
        $this->db->from('skema');
        return $this->db->get()->result();
    }

    public function getSkemaByPengajar($id)
    {
        $this->db->select('skema.id_skema');
        $this->db->from('skema_pengajar');
        $this->db->join('skema', 'skema_pengajar.skema_id=skema.id_skema');
        $this->db->where('pengajar_id', $id);
        $query = $this->db->get()->result();
        return $query;
    }
    /**
     * Data Level skemalsp
     */

    public function getLevelskemalsp()
    {
        $this->datatables->select('level_skemalsp.id, skema_lsp.id_klsp, skema_lsp.nama_klsp, level.id_level, GROUP_CONCAT(level.nama_level) as nama_level');
        $this->datatables->from('level_skemalsp');
        $this->datatables->join('skema_lsp', 'klsp_id=id_klsp');
        $this->datatables->join('level', 'level_id=id_level');
        $this->datatables->group_by('skema_lsp.nama_klsp');
        return $this->datatables->generate();
    }

    public function getskemalsp($id = null)
    {
        $this->db->select('klsp_id');
        $this->db->from('level_skemalsp');
        if ($id !== null) {
            $this->db->where_not_in('klsp_id', [$id]);
        }
        $klsp = $this->db->get()->result();
        $id_klsp = [];
        foreach ($klsp as $d) {
            $id_klsp[] = $d->klsp_id;
        }
        if ($id_klsp === []) {
            $id_klsp = null;
        }

        $this->db->select('id_klsp, nama_klsp');
        $this->db->from('skema_lsp');
        $this->db->where_not_in('id_klsp', $id_klsp);
        return $this->db->get()->result();
    }

    public function getLevelByIdskemalsp($id)
    {
        $this->db->select('level.id_level');
        $this->db->from('level_skemalsp');
        $this->db->join('level', 'level_skemalsp.level_id=level.id_level');
        $this->db->where('klsp_id', $id);
        $query = $this->db->get()->result();
        return $query;
    }


    //upload file 

    public function upload()
    {
        $config['upload_path'] = './upload';
        $config['allowed_types'] = 'jpg|jpeg|png|svg';
        $config['max_size'] = 3000;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file')) {

            $fileData = $this->upload->data();

            $upload = [
                'nama_file' => $fileData['file_name'],
                'tipe_file' => $fileData['file_type'],
                'ukuran_file' => $fileData['file_size'],
            ];

            if ($this->upload_model->insert($upload)) {
                $this->session->set_flashdata('success', '<p>Selamat! Anda berhasil mengunggah file <strong>' . $fileData['file_name'] . '</strong></p>');
            } else {
                $this->session->set_flashdata('error', '<p>Gagal! File ' . $fileData['file_name'] . ' tidak berhasil tersimpan di database anda</p>');
            }

            redirect(base_url('upload'));
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect(base_url('upload'));
        }
    }
}
