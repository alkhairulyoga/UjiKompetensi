<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Praktek_model extends CI_Model
{

    public function getDataPraktek($id, $dosen)
    {
        $this->datatables->select('a.id_soal, a.soal, FROM_UNIXTIME(a.created_on) as created_on, FROM_UNIXTIME(a.updated_on) as updated_on, b.nama_klsp, c.nama_pengajar');
        $this->datatables->from('tb_praktek a');
        $this->datatables->join('skema_lsp b', 'b.id_klsp=a.klsp_id');
        $this->datatables->join('pengajar c', 'c.id_pengajar=a.pengajar_id');
        if ($id !== null && $dosen === null) {
            $this->datatables->where('a.klsp_id', $id);
        } else if ($id !== null && $dosen !== null) {
            $this->datatables->where('a.pengajar_id', $dosen);
        }
        return $this->datatables->generate();
    }

    public function getSoalById($id)
    {
        return $this->db->get_where('tb_praktek', ['id_soal' => $id])->row();
    }

    public function getskemalspPengajar($nip)
    {
        $this->db->select('klsp_id, nama_klsp, id_pengajar, nama_pengajar');
        $this->db->join('skema_lsp', 'klsp_id=id_klsp');
        $this->db->from('pengajar')->where('nip', $nip);
        return $this->db->get()->row();
    }

    public function getAllPengajar()
    {
        $this->db->select('*');
        $this->db->from('pengajar a');
        $this->db->join('skema_lsp b', 'a.klsp_id=b.id_klsp');
        return $this->db->get()->result();
    }
}
