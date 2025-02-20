<?

class Model_dashboard extends CI_Model
{
    public function get_total_pemasukan_per_bulan($bulan, $tahun)
    {
        $this->db->select('SUM(jumlah) as total_pemasukan');
        $this->db->from('pemasukan');
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_total_pengeluaran_per_bulan($bulan, $tahun)
    {
        $this->db->select('SUM(jumlah) as total_pengeluaran');
        $this->db->from('pengeluaran');
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $query = $this->db->get();

        return $query->row();
    }
    public function get_total_pencatatan_per_bulan($bulan, $tahun)
    {
        $this->db->select('SUM(jumlah_susu) as total_pencatatan');
        $this->db->from('pencatatan_susu');
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $query = $this->db->get();

        return $query->row()->total_pencatatan ?? 0;
    }
}
