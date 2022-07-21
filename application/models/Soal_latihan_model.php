<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Soal_latihan_model extends CI_Model
{

    public function getDataLatihan($id)
    {
        $this->datatables->select('a.id_latihan, a.nama_latihan, b.nama_klsp, a.jumlah_soal, CONCAT(a.tgl_mulai, " <br/> (", a.waktu, " Menit)") as waktu, a.jenis');
        $this->datatables->from('m_latihan a');
        $this->datatables->join('skema_lsp b', 'a.klsp_id = b.id_klsp');
        if ($id !== null) {
            $this->datatables->where('pengajar_id', $id);
        }
        return $this->datatables->generate();
    }

    public function getListLatihan($id, $skema)
    {
        $this->datatables->select("a.id_latihan, e.nama_pengajar, d.nama_skema, a.nama_latihan, b.nama_klsp, a.jumlah_soal, CONCAT(a.tgl_mulai, ' <br/> (', a.waktu, ' Menit)') as waktu,  (SELECT COUNT(id) FROM h_latihan h WHERE h.mahasiswa_id = {$id} AND h.latihan_id = a.id_latihan) AS ada");
        $this->datatables->from('m_latihan a');
        $this->datatables->join('skema_lsp b', 'a.klsp_id = b.id_klsp');
        $this->datatables->join('skema_pengajar c', "a.pengajar_id = c.pengajar_id");
        $this->datatables->join('skema d', 'c.skema_id = d.id_skema');
        $this->datatables->join('pengajar e', 'e.id_pengajar = c.pengajar_id');
        $this->datatables->where('d.id_skema', $skema);
        return $this->datatables->generate();
    }

    public function getLatihanById($id)
    {
        $this->db->select('*');
        $this->db->from('m_latihan a');
        $this->db->join('pengajar b', 'a.pengajar_id=b.id_pengajar');
        $this->db->join('skema_lsp c', 'a.klsp_id=c.id_klsp');
        $this->db->where('id_latihan', $id);
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
        $this->db->from('soal_modul');
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

    public function Hsllatihan($id, $mhs)
    {
        $this->db->select('*, UNIX_TIMESTAMP(tgl_selesai) as waktu_habis');
        $this->db->from('h_latihan');
        $this->db->where('latihan_id', $id);
        $this->db->where('mahasiswa_id', $mhs);
        return $this->db->get();
    }

    public function getSoal($id)
    {
        $latihanmodul = $this->getLatihanById($id);
        $order = $latihanmodul->jenis === "acak" ? 'rand()' : 'id_soal';

        $this->db->select('id_soal, soal, file, tipe_file, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e, jawaban');
        $this->db->from('soal_modul');
        $this->db->where('pengajar_id', $latihanmodul->pengajar_id);
        $this->db->where('klsp_id', $latihanmodul->klsp_id);
        $this->db->order_by($order);
        $this->db->limit($latihanmodul->jumlah_soal);
        return $this->db->get()->result();
    }

    public function ambilSoal($pc_urut_soal1, $pc_urut_soal_arr)
    {
        $this->db->select("*, {$pc_urut_soal1} AS jawaban");
        $this->db->from('soal_modul');
        $this->db->where('id_soal', $pc_urut_soal_arr);
        return $this->db->get()->row();
    }

    public function getJawaban($id_tes)
    {
        $this->db->select('list_jawaban');
        $this->db->from('h_latihan');
        $this->db->where('id', $id_tes);
        return $this->db->get()->row()->list_jawaban;
    }

    public function getHasilLatihan($nip = null)
    {
        $this->datatables->select('b.id_latihan, b.nama_latihan, b.jumlah_soal, CONCAT(b.waktu, " Menit") as waktu, b.tgl_mulai');
        $this->datatables->select('c.nama_klsp, d.nama_pengajar');
        $this->datatables->from('h_latihan a');
        $this->datatables->join('m_latihan b', 'a.latihan_id = b.id_latihan');
        $this->datatables->join('skema_lsp c', 'b.klsp_id = c.id_klsp');
        $this->datatables->join('pengajar d', 'b.pengajar_id = d.id_pengajar');
        $this->datatables->group_by('b.id_latihan');
        if ($nip !== null) {
            $this->datatables->where('d.nip', $nip);
        }
        return $this->datatables->generate();
    }

    public function HslLatihanById($id, $dt = false)
    {
        if ($dt === false) {
            $db = "db";
            $get = "get";
        } else {
            $db = "datatables";
            $get = "generate";
        }

        $this->$db->select('d.id, a.nama, b.nama_skema, c.nama_level, d.jml_benar, d.nilai');
        $this->$db->from('peserta a');
        $this->$db->join('skema b', 'a.skema_id=b.id_skema');
        $this->$db->join('level c', 'b.level_id=c.id_level');
        $this->$db->join('h_latihan d', 'a.id_mahasiswa=d.mahasiswa_id');
        $this->$db->where(['d.latihan_id' => $id]);
        return $this->$db->$get();
    }

    public function bandingNilai($id)
    {
        $this->db->select_min('nilai', 'min_nilai');
        $this->db->select_max('nilai', 'max_nilai');
        $this->db->select_avg('FORMAT(FLOOR(nilai),0)', 'avg_nilai');
        $this->db->where('latihan_id', $id);
        return $this->db->get('h_latihan')->row();
    }
}
