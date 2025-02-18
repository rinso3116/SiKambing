<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_laporan');
    }

    private function set_output($data)
    {
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function index()
    {
        $data['navbar'] = 'laporan';
        $data['title'] = 'FIlter Laporan - SiKambing';
        $this->load->view('laporan/laporan_view', $data);
    }
    public function getLaporan()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $jenis_laporan = $this->input->post('jenis_laporan');

        $data = $this->Laporan_model->getFilteredLaporan($start_date, $end_date, $jenis_laporan);
        echo json_encode($data);
    }


    public function export_excel()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $jenis_laporan = $this->input->get('jenis_laporan');

        $this->load->model('Model_laporan');

        if ($jenis_laporan == "pencatatan") {
            $data['laporan'] = $this->Model_laporan->get_pencatatan($start_date, $end_date);
            $filename = "Laporan_Pencatatan_Susu_" . date('Ymd') . ".xls";
        } elseif ($jenis_laporan == "penjualan") {
            $data['laporan'] = $this->Model_laporan->get_penjualan($start_date, $end_date);
            $filename = "Laporan_Penjualan_Susu_" . date('Ymd') . ".xls";
        } elseif ($jenis_laporan == "pengeluaran") {
            $data['laporan'] = $this->Model_laporan->get_pengeluaran($start_date, $end_date);
            $filename = "Laporan_Pengeluaran_" . date('Ymd') . ".xls";
        } else {
            echo "Jenis laporan tidak valid!";
            return;
        }

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $this->load->view("laporan/export_excel", $data);
    }
}
