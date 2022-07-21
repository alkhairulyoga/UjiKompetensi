<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ujian_essay_model extends CI_Model
{

    public function getDataEssay($id)
    {
        $this->datatables->select('a.id_essay, a.token, a.nama_essay, b.nama_klsp, a.jumlah_soal, CONCAT(a.tgl_mulai, " <br/> (", a.waktu, " Menit)") as waktu, a.jenis');
        $this->datatables->from('m_essay a');
        $this->datatables->join('skema_lsp b', 'a.klsp_id = b.id_klsp');
        if ($id !== null) {
            $this->datatables->where('pengajar_id', $id);
        }
        return $this->datatables->generate();
    }

    public function getListEssay($id, $skema)
    {
        $this->datatables->select("a.id_essay, e.nama_pengajar, d.nama_skema, a.nama_essay, b.nama_klsp, a.jumlah_soal, CONCAT(a.tgl_mulai, ' <br/> (', a.waktu, ' Menit)') as waktu,  (SELECT COUNT(id) FROM h_essay h WHERE h.mahasiswa_id = {$id} AND h.essay_id = a.id_essay) AS ada");
        $this->datatables->from('m_essay a');
        $this->datatables->join('skema_lsp b', 'a.klsp_id = b.id_klsp');
        $this->datatables->join('skema_pengajar c', "a.pengajar_id = c.pengajar_id");
        $this->datatables->join('skema d', 'c.skema_id = d.id_skema');
        $this->datatables->join('pengajar e', 'e.id_pengajar = c.pengajar_id');
        $this->datatables->where('d.id_skema', $skema);
        return $this->datatables->generate();
    }

    public function getUjianById($id)
    {
        $this->db->select('*');
        $this->db->from('m_essay a');
        $this->db->join('pengajar b', 'a.pengajar_id=b.id_pengajar');
        $this->db->join('skema_lsp c', 'a.klsp_id=c.id_klsp');
        $this->db->where('id_essay', $id);
        return $this->db->get()->row();
    }

    public function getIdPengajar($nip)
    {
        $this->db->select('id_pengajar, nama_pengajar')->from('pengajar')->where('nip', $nip);
        return $this->db->get()->row();
    }

    public function getJumlahSoal($pengajar)
    {
        $this->db->select('COUNT(id_soal) as jml_soal');
        $this->db->from('tb_essay');
        $this->db->where('pengajar_id', $pengajar);
        return $this->db->get()->row();
    }

    public function getIdMahasiswa($nim)
    {
        $this->db->select('*');
        $this->db->from('peserta a');
        $this->db->join('skema b', 'a.skema_id=b.id_skema');
        $this->db->join('level c', 'b.level_id=c.id_level');
        $this->db->where('nim', $nim);
        return $this->db->get()->row();
    }

    public function HslUjian($id, $mhs)
    {
        $this->db->select('*, UNIX_TIMESTAMP(tgl_selesai) as waktu_habis');
        $this->db->from('h_essay');
        $this->db->where('essay_id', $id);
        $this->db->where('mahasiswa_id', $mhs);
        return $this->db->get();
    }

    public function getSoal($id)
    {
        $essay = $this->getUjianById($id);
        $order = $essay->jenis === "acak" ? 'rand()' : 'id_soal';

        $this->db->select('id_soal, soal, file, tipe_file, jawaban');
        $this->db->from('tb_essay');
        $this->db->where('pengajar_id', $essay->pengajar_id);
        $this->db->where('klsp_id', $essay->klsp_id);
        $this->db->order_by($order);
        $this->db->limit($essay->jumlah_soal);
        return $this->db->get()->result();
    }

    public function ambilSoal($pc_urut_soal1, $pc_urut_soal_arr)
    {
        $this->db->select("*, {$pc_urut_soal1} AS jawaban");
        $this->db->from('tb_essay');
        $this->db->where('id_soal', $pc_urut_soal_arr);
        return $this->db->get()->row();
    }

    public function getJawaban($id_tes)
    {
        $this->db->select('list_jawaban');
        $this->db->from('h_essay');
        $this->db->where('id', $id_tes);
        return $this->db->get()->row()->list_jawaban;
    }

    public function getHasilUjian($nip = null)
    {
        $this->datatables->select('b.id_essay, b.nama_essay, b.jumlah_soal, CONCAT(b.waktu, " Menit") as waktu, b.tgl_mulai');
        $this->datatables->select('c.nama_klsp, d.nama_pengajar');
        $this->datatables->from('h_essay a');
        $this->datatables->join('m_essay b', 'a.essay_id = b.id_essay');
        $this->datatables->join('skema_lsp c', 'b.klsp_id = c.id_klsp');
        $this->datatables->join('pengajar d', 'b.pengajar_id = d.id_pengajar');
        $this->datatables->group_by('b.id_essay');
        if ($nip !== null) {
            $this->datatables->where('d.nip', $nip);
        }
        return $this->datatables->generate();
    }

    public function HslUjianById($id, $dt = false)
    {
        if ($dt === false) {
            $db = "db";
            $get = "get";
        } else {
            $db = "datatables";
            $get = "generate";
        }

        $this->$db->select('d.id, a.nama, b.nama_skema, c.nama_level, d.list_jawaban, d.nilai, d.nilai_bobot');
        $this->$db->from('peserta a');
        $this->$db->join('skema b', 'a.skema_id=b.id_skema');
        $this->$db->join('level c', 'b.level_id=c.id_level');
        $this->$db->join('h_essay d', 'a.id_mahasiswa=d.mahasiswa_id');
        $this->$db->where(['d.essay_id' => $id]);
        return $this->$db->$get();
    }

    public function bandingNilai($id)
    {
        $this->db->select_min('nilai', 'min_nilai');
        $this->db->select_max('nilai', 'max_nilai');
        $this->db->select_avg('FORMAT(FLOOR(nilai),0)', 'avg_nilai');
        $this->db->where('essay_id', $id);
        return $this->db->get('h_essay')->row();
    }
}
