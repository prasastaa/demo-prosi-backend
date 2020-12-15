<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_Tabel8Publikasi extends CI_Controller
{

    // Fungsi untuk load data dari SP (Kalo bisa load data dan load view nya pisahin sih)
    public function loadView()
    {
        $this->load->database();
        $this->db->query("SET NOCOUNT ON");
        $data['tabel8f1_jurnal'] = $this->db->query("EXEC Tabel8f1_partJurnalMahasiswa")->result_array();
        $data['tabel8f1_seminar'] = $this->db->query("EXEC Tabel8f1_partSeminarMahasiswa")->result_array();
        $data['tabel8f2'] = $this->db->query("EXEC Tabel8f2a_karyaIlmiahMahasiswaCite")->result_array();
        $data['tabel8f3'] = $this->db->query("EXEC Tabel8f3_LuaranPenelitianPKMLainnyaMahasiswa")->result_array();
        $this->db->query("SET NOCOUNT OFF");

        $this->load->view('layout/V_Require');
        $this->load->view('layout/V_Header');
        $this->load->view('pages/kriteria8/V_Tabel8Publikasi', $data);
        $this->load->view('layout/V_Footer');
    }

    // Fungsi untuk mengambil data bukti berdasar 1 ID Penelitian
    public function getBukti($idPenelitian)
    {
        $id = base64_decode($idPenelitian);
        $this->load->model('M_Tabel5Kurikulum');
        $data = $this->M_Tabel5->get_bukti_tabel($id)->result_array();
        echo $this->serveApi($data);
    }

    // Fungsi untuk melakukan unggah bukti
    public function unggahBukti()
    {
        $data = json_decode(file_get_contents("php://input"), TRUE);

        $nama = $data['nama'];
        $jenis = $data['jenis'];
        $deskripsi = $data['deskripsi'];
        // $file = $data['File'];
        // $file_path = $file;
        $idPenelitian = $data['idPenelitian'];

        $this->load->model('M_Tabel5Kurikulum');
        $this->M_Tabel6->test_Post($nama, $jenis, $file, $deskripsi, $idPenelitian);

        // $this->serveApi($file_path);
    }

    public function getrow($id)
    {
        $this->load->model('M_Tabel5Kurikulum');
        $data = $this->M_Tabel6->get_row($id)->row();
        $this->serveApi($data);
    }

    // Fungsi untuk melempar data dalam bentuk JSon
    protected function serveApi($data)
    {
        echo json_encode([
            "status" => true,
            "result" => $data
        ]);
        return;
    }
}
    
    /* End of file C_Tabel6.php */
