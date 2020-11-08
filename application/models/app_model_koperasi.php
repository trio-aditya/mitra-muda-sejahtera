<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class App_Model_Koperasi extends CI_Model
{

    public function getAllData($table)
    {
        return $this->db->get($table);
    }

    public function getAllDataLimited($table, $limit, $offset)
    {
        return $this->db->get($table, $limit, $offset);
    }

    public function getSelectedDataLimited($table, $data, $limit, $offset)
    {
        return $this->db->get_where($table, $data, $limit, $offset);
    }

    //select table
    public function getSelectedData($table, $data)
    {
        return $this->db->get_where($table, $data);
    }
    //update table
    function updateData($table, $data, $field_key)
    {
        $this->db->update($table, $data, $field_key);
    }
    function deleteData($table, $data)
    {
        $this->db->delete($table, $data);
    }

    function insertData($table, $data)
    {
        $this->db->insert($table, $data);
    }
    //Query manual
    function manualQuery($q)
    {
        return $this->db->query($q);
    }

    public function nama_level($id)
    {
        $data = $this->db->query("SELECT nama_level FROM user_level WHERE id='$id'");
        $row = $data->num_rows();
        if ($row > 0) {
            foreach ($data->result() as $t) {
                $hasil = $t->jenis_simpanan;
            }
        } else {
            $hasil = '';
        }
        return $hasil;
    }

    public function nama_jenis($id)
    {
        $data = $this->db->query("SELECT * FROM jenis_simpan WHERE id_jenis='$id'");
        $row = $data->num_rows();
        if ($row > 0) {
            foreach ($data->result() as $t) {
                $hasil = $t->jenis_simpanan;
            }
        } else {
            $hasil = '';
        }
        return $hasil;
    }
    public function tgl_tagihan($i, $tgl_now)
    {
        /* tanggal tagihan */
        date_default_timezone_set("Asia/Jakarta");

        $exp        = explode("-", $tgl_now);
        $tgl        = $exp[0];

        //$satubulan = 30 * ($i - 1);
        $satubulan = 30 * ($i);
        $month = date('F');
        $day = $tgl; //date('j');
        $year = date('Y');
        $time = '24:00:00';
        $date = mktime(0, 0, 0, date('m'), $day + $satubulan, $year);
        $date = date("Y-m", $date); //." ".$time;
        $tanggal    = $date . "-" . $tgl;
        return $tanggal;
    }
    //chart simpanan
    public function ChartSimpanan($bln)
    {

        $q = $this->db->query("SELECT month(tgl) as bulan, sum(jumlah) as total FROM simpanan
							WHERE month(tgl)='$bln'
							GROUP BY month(tgl)");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total; //$k['total'];
            }
        } else {
            $hasil = 0;
        }

        //$hasil = $bln;
        return $hasil;
    }
    //chart simpanan
    public function ChartPenarikan($bln)
    {

        $q = $this->db->query("SELECT month(tgl) as bulan, sum(jumlah) as total FROM pengambilan
							WHERE month(tgl)='$bln'
							GROUP BY month(tgl)");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total; //$k['total'];
            }
        } else {
            $hasil = 0;
        }

        //$hasil = $bln;
        return $hasil;
    }

    //chart pinjaman
    public function ChartPinjaman($bln)
    {

        $q = $this->db->query("SELECT month(tgl) as bulan, sum(jumlah) as total FROM pinjaman_header
							WHERE month(tgl)='$bln'
							GROUP BY month(tgl)");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total; //$k['total'];
            }
        } else {
            $hasil = 0;
        }

        //$hasil = $bln;
        return $hasil;
    }

    //chart pinjaman
    public function ChartBayarPinjaman($bln)
    {

        $q = $this->db->query("SELECT month(tgl_bayar) as bulan, sum(jumlah_bayar) as total
							FROM pinjaman_detail
							WHERE month(tgl_bayar)='$bln'
							GROUP BY month(tgl_bayar)");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total; //$k['total'];
            }
        } else {
            $hasil = 0;
        }

        //$hasil = $bln;
        return $hasil;
    }

    //jumlah simpanan
    public function Jumlah_Simpanan($id)
    {
        $q = $this->db->query("SELECT sum(jumlah) as total FROM simpanan WHERE noanggota='$id'");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    //jumlah simpanan per jenis
    public function Jumlah_Simpanan_Jenis($id, $jenis)
    {
        $q = $this->db->query("SELECT sum(jumlah) as total FROM simpanan WHERE id_jenis='$jenis' && noanggota='$id'");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    //jumlah simpanan pokok
    public function Jumlah_Simpanan_Pokok($id)
    {
        $q = $this->db->query("SELECT sum(jumlah) as total FROM simpanan WHERE id_jenis='01' && noanggota='$id'");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    //jumlah simpanan wajib
    public function Jumlah_Simpanan_Wajib($id)
    {
        $q = $this->db->query("SELECT sum(jumlah) as total FROM simpanan WHERE id_jenis='02' && noanggota='$id'");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    //jumlah simpanan sukarela
    public function Jumlah_Simpanan_Sukarela($id)
    {
        $q = $this->db->query("SELECT sum(jumlah) as total FROM simpanan WHERE id_jenis='03' && noanggota='$id'");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    //jumlah simpanan apa saja
    public function Jumlah_Simpanan_Apa_Saja($id)
    {
        $q = $this->db->query("SELECT sum(jumlah) as total FROM simpanan WHERE id_jenis='04' && noanggota='$id'");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    //jumlah simpanan angsuran
    public function Jumlah_Simpanan_Angsuran($id)
    {
        $q = $this->db->query("SELECT sum(jumlah) as total FROM simpanan WHERE id_jenis='05' && noanggota='$id'");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    //jumlah pengambilan
    public function Jumlah_Pengambilan($id)
    {
        $q = $this->db->query("SELECT sum(jumlah) as total FROM pengambilan WHERE noanggota='$id'");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    //jumlah pengambilan per jenis
    public function Jumlah_Pengambilan_Jenis($id, $jenis)
    {
        $q = $this->db->query("SELECT sum(jumlah) as total FROM pengambilan WHERE id_jenis='$jenis' && noanggota='$id'");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    //jumlah pengambilan pokok
    public function Jumlah_Pengambilan_Pokok($id)
    {
        $q = $this->db->query("SELECT sum(jumlah) as total FROM pengambilan WHERE id_jenis='01' && noanggota='$id'");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    //jumlah pengambilan wajib
    public function Jumlah_Pengambilan_Wajib($id)
    {
        $q = $this->db->query("SELECT sum(jumlah) as total FROM pengambilan WHERE id_jenis='02' && noanggota='$id'");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    //jumlah pengambilan sukarela
    public function Jumlah_Pengambilan_Sukarela($id)
    {
        $q = $this->db->query("SELECT sum(jumlah) as total FROM pengambilan WHERE id_jenis='03' && noanggota='$id'");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    //jumlah pengambilan apasaja
    public function Jumlah_Pengambilan_Apa_Saja($id)
    {
        $q = $this->db->query("SELECT sum(jumlah) as total FROM pengambilan WHERE id_jenis='04' && noanggota='$id'");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    //jumlah pengambilan angsuran
    public function Jumlah_Pengambilan_Angsuran($id)
    {
        $q = $this->db->query("SELECT sum(jumlah) as total FROM pengambilan WHERE id_jenis='05' && noanggota='$id'");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }

    public function Jumlah_pembayaran($id)
    {
        $q = $this->db->query("SELECT sum(jumlah_bayar) as total FROM pinjaman_detail
		WHERE id_pinjam='$id' AND jumlah_bayar<>0");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }

    public function shu_ditahan($tgl)
    {
        $tgl_awal = '2013-01-01';
        $tgl_akhir = $tgl; //$this->app_model->tgl_sql($tgl);
        $text = "SELECT sum(bunga) as total FROM pinjaman_detail WHERE tgl_bayar BETWEEN '$tgl_awal' AND '$tgl_akhir' AND jumlah_bayar>0";
        $q = $this->db->query($text);
        $r = $q->num_rows();
        if ($r > 0) {
            foreach ($q->result() as $t) {
                $hasil = $t->total;
            }
        } else {
            $hasil = 0;
        }
        $shu = ($hasil * 25) / 100;

        return $shu;
    }

    public function shu_simpanan($tgl)
    {
        $tgl_awal = '2013-01-01';
        $tgl_akhir = $tgl; //$this->app_model->tgl_sql($tgl);
        $text = "SELECT sum(jumlah) as total FROM simpanan WHERE id_jenis='02' AND tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'";
        $q = $this->db->query($text);
        foreach ($q->result() as $t) {
            $simpanan = $t->total;
        }
        $text = "SELECT sum(jumlah) as total FROM pengambilan WHERE id_jenis='02' AND tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'";
        $q = $this->db->query($text);
        foreach ($q->result() as $t) {
            $pengambilan = $t->total;
        }

        $sisa = $simpanan - $pengambilan;

        $shu = ($sisa * 20) / 100;

        return $shu;
    }

    public function pendapatan_bunga($id, $tgl)
    {
        $tgl_awal = '2013-01-01';
        $tgl_akhir = $tgl;
        $text = "SELECT sum(b.bunga) as total
			FROM pinjaman_header as a
			JOIN pinjaman_detail as b
			ON a.id_pinjam = b.id_pinjam
			WHERE noanggota='$id' AND tgl_bayar BETWEEN '$tgl_awal' AND '$tgl_akhir'";
        $q = $this->db->query($text);
        foreach ($q->result() as $t) {
            $hasil = $t->total;
        }
        return $hasil;
    }


    //jumlah simpanan
    public function sisa_pinjaman($id)
    {
        $q = $this->db->query("select b.noanggota,sum(a.angsuran+a.bunga) as total
			from pinjaman_detail as a
			join pinjaman_header as b
			ON a.id_pinjam=b.id_pinjam
			WHERE jumlah_bayar=0 AND noanggota='$id'
			GROUP BY b.noanggota");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }

    public function cari_nopinjam($id)
    {
        $q = $this->db->query("select *
			from pinjaman_detail as a
			join pinjaman_header as b
			ON a.id_pinjam=b.id_pinjam
			WHERE jumlah_bayar=0 AND noanggota='$id'
			GROUP BY b.noanggota");
        if ($q->num_rows() > 0) {
            //$hasil = array();
            foreach ($q->result() as $k) {
                $hasil = $k->id_pinjam;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    public function cari_lama($id)
    {
        $q = $this->db->query("select *
			from pinjaman_header
			WHERE id_pinjam='$id'");
        if ($q->num_rows() > 0) {
            //$hasil = array();
            foreach ($q->result() as $k) {
                $hasil = $k->lama;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    public function cari_bunga($id)
    {
        $q = $this->db->query("select *
			from pinjaman_header
			WHERE id_pinjam='$id'");
        if ($q->num_rows() > 0) {
            //$hasil = array();
            foreach ($q->result() as $k) {
                $hasil = $k->bunga;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    public function cari_jumlah($id)
    {
        $q = $this->db->query("select *
			from pinjaman_header
			WHERE id_pinjam='$id'");
        if ($q->num_rows() > 0) {
            //$hasil = array();
            foreach ($q->result() as $k) {
                $hasil = $k->jumlah;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }

    public function cicilan_ke($id)
    {
        $q = $this->db->query("select *
			from pinjaman_detail
			WHERE id_pinjam='$id' AND jumlah_bayar=0
			ORDER BY cicilan ASC LIMIT 1");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->cicilan;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }

    public function cicilan_angsuran($id)
    {
        $q = $this->db->query("select *
			from pinjaman_detail
			WHERE id_pinjam='$id' AND jumlah_bayar=0
			ORDER BY cicilan ASC LIMIT 1");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->angsuran + $k->bunga;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }

    //Kode Jenis Otomatis
    public function getMaxKodeJenis()
    {
        $q = $this->db->query("select MAX(id_jenis) as ID from jenis_simpan");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->ID) + 1;
                $kd = sprintf("%02s", $tmp);
            }
        } else {
            $kd = "01";
        }
        return $kd;
    }

    //Kode Anggota Otomatis
    public function getMaxKodeAnggota()
    {
        $q = $this->db->query("select MAX(substr(noanggota,2,3)) as ID from anggota");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $kode = $k->ID; //substr($k->ID,0,1);
                $tmp = ((int) $kode) + 1;
                $kd = "A" . sprintf("%03s", $tmp);
            }
        } else {
            $kd = "A" . "001";
        }
        return $kd;
    }
    //Kode Anggota Otomatis
    public function getMaxKodeSimpanan()
    {
        $q = $this->db->query("select MAX(id_simpanan) as ID from simpanan");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $kode = $k->ID; //substr($k->ID,0,1);
                $tmp = ((int) $kode) + 1;
                $kd = $tmp; //"A".sprintf("%03s", $tmp);
            }
        } else {
            $kd = "1"; //"A"."001";
        }
        return $kd;
    }

    //Kode Anggota Otomatis
    public function getMaxKodePinjaman()
    {
        $q = $this->db->query("select MAX(id_pinjam) as ID from pinjaman_header");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $kode = substr($k->ID, 1, 4);
                $tmp = ((int) $kode) + 1;
                $kd = "P" . sprintf("%04s", $tmp);
            }
        } else {
            $kd = "P0001"; //"A"."001";
        }
        return $kd;
    }

    public function getMaxKodeAmbil()
    {
        $q = $this->db->query("select MAX(id_ambil) as ID from pengambilan");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $kode = $k->ID; //substr($k->ID,0,1);
                $tmp = ((int) $kode) + 1;
                $kd = $tmp; //"A".sprintf("%03s", $tmp);
            }
        } else {
            $kd = "1"; //"A"."001";
        }
        return $kd;
    }

    public function getSaldo($id)
    {
        $text = "SELECT a.noanggota,
						(SELECT SUM(jumlah) FROM simpanan WHERE noanggota='$id') as jml_simpanan,
						(SELECT SUM(jumlah) FROM pengambilan WHERE noanggota='$id') as jml_ambil
						FROM anggota as a
						WHERE a.noanggota='$id'";
        $q = $this->db->query($text);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $simpanan = $k->jml_simpanan; //substr($k->ID,0,1);
                $ambil = $k->jml_ambil;
                $saldo = $simpanan - $ambil;
            }
            $hasil = $saldo;
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    public function getSaldoJenis($id, $jenis)
    {
        $text = "SELECT a.noanggota,
						(SELECT SUM(jumlah) FROM simpanan WHERE id_jenis='$jenis' && noanggota='$id') as jml_simpanan,
						(SELECT SUM(jumlah) FROM pengambilan WHERE id_jenis='$jenis' && noanggota='$id') as jml_ambil
						FROM anggota as a
						WHERE a.noanggota='$id'";
        $q = $this->db->query($text);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $simpanan = $k->jml_simpanan; //substr($k->ID,0,1);
                $ambil = $k->jml_ambil;
                $saldo = $simpanan - $ambil;
            }
            $hasil = $saldo;
        } else {
            $hasil = 0;
        }
        return $hasil;
    }

    public function getSaldo_Simpanan_Pokok($id)
    {
        $text = "SELECT a.noanggota,
						(SELECT SUM(jumlah) FROM simpanan WHERE id_jenis='01' && noanggota='$id') as jml_simpanan,
						(SELECT SUM(jumlah) FROM pengambilan WHERE id_jenis='01' && noanggota='$id') as jml_ambil
						FROM anggota as a
						WHERE a.noanggota='$id'";
        $q = $this->db->query($text);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $simpanan = $k->jml_simpanan; //substr($k->ID,0,1);
                $ambil = $k->jml_ambil;
                $saldo = $simpanan - $ambil;
            }
            $hasil = $saldo;
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    public function getSaldo_Simpanan_Wajib($id)
    {
        $text = "SELECT a.noanggota,
						(SELECT SUM(jumlah) FROM simpanan WHERE id_jenis='02' && noanggota='$id') as jml_simpanan,
						(SELECT SUM(jumlah) FROM pengambilan WHERE id_jenis='02' && noanggota='$id') as jml_ambil
						FROM anggota as a
						WHERE a.noanggota='$id'";
        $q = $this->db->query($text);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $simpanan = $k->jml_simpanan; //substr($k->ID,0,1);
                $ambil = $k->jml_ambil;
                $saldo = $simpanan - $ambil;
            }
            $hasil = $saldo;
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    public function getSaldo_Simpanan_Sukarela($id)
    {
        $text = "SELECT a.noanggota,
						(SELECT SUM(jumlah) FROM simpanan WHERE id_jenis='03' && noanggota='$id') as jml_simpanan,
						(SELECT SUM(jumlah) FROM pengambilan WHERE id_jenis='03' && noanggota='$id') as jml_ambil
						FROM anggota as a
						WHERE a.noanggota='$id'";
        $q = $this->db->query($text);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $simpanan = $k->jml_simpanan; //substr($k->ID,0,1);
                $ambil = $k->jml_ambil;
                $saldo = $simpanan - $ambil;
            }
            $hasil = $saldo;
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    public function getSaldo_Simpanan_Apa_Saja($id)
    {
        $text = "SELECT a.noanggota,
						(SELECT SUM(jumlah) FROM simpanan WHERE id_jenis='04' && noanggota='$id') as jml_simpanan,
						(SELECT SUM(jumlah) FROM pengambilan WHERE id_jenis='04' && noanggota='$id') as jml_ambil
						FROM anggota as a
						WHERE a.noanggota='$id'";
        $q = $this->db->query($text);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $simpanan = $k->jml_simpanan; //substr($k->ID,0,1);
                $ambil = $k->jml_ambil;
                $saldo = $simpanan - $ambil;
            }
            $hasil = $saldo;
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    public function getSaldo_Simpanan_Angsuran($id)
    {
        $text = "SELECT a.noanggota,
						(SELECT SUM(jumlah) FROM simpanan WHERE id_jenis='05' && noanggota='$id') as jml_simpanan,
						(SELECT SUM(jumlah) FROM pengambilan WHERE id_jenis='05' && noanggota='$id') as jml_ambil
						FROM anggota as a
						WHERE a.noanggota='$id'";
        $q = $this->db->query($text);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $simpanan = $k->jml_simpanan; //substr($k->ID,0,1);
                $ambil = $k->jml_ambil;
                $saldo = $simpanan - $ambil;
            }
            $hasil = $saldo;
        } else {
            $hasil = 0;
        }
        return $hasil;
    }

    public function jmlCicilan($id)
    {
        $text = "SELECT sum(jumlah_bayar) as total
						FROM pinjaman_detail
						WHERE id_pinjam='$id'
				GROUP BY id_pinjam";
        $q = $this->db->query($text);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $hasil = $k->total;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }

    //Konversi tanggal
    public function tgl_sql($date)
    {
        $exp = explode('-', $date);
        if (count($exp) == 3) {
            $date = $exp[2] . '-' . $exp[1] . '-' . $exp[0];
        }
        return $date;
    }
    public function tgl_str($date)
    {
        $exp = explode('-', $date);
        if (count($exp) == 3) {
            $date = $exp[2] . '-' . $exp[1] . '-' . $exp[0];
        }
        return $date;
    }
    //query login
    public function getLoginData($usr, $psw)
    {
        $u = $this->db->escape_like_str($usr);
        $p = md5($this->db->escape_like_str($psw));
        $q_cek_login = $this->db->get_where('users_akuntansi', array('user_id' => $u, 'password' => $p));
        if (count($q_cek_login->result()) > 0) {
            foreach ($q_cek_login->result() as $qck) {
                foreach ($q_cek_login->result() as $qad) {
                    $sess_data['logged_in'] = 'yesGetMeLogin';
                    $sess_data['username'] = $qad->user_id;
                    $sess_data['nama_pengguna'] = $qad->namalengkap;
                    $sess_data['level'] = 'admin';
                    $sess_data['akses'] = $qad->level;
                    $this->session->set_userdata($sess_data);
                }
                header('location:' . base_url() . 'index.php/media');
                //$this->load->cont('content');
            }
        } else {
            $q_cek_login = $this->db->get_where('anggota', array('noanggota' => $u, 'pwd' => $p));
            if (count($q_cek_login->result()) > 0) {
                foreach ($q_cek_login->result() as $qad) {
                    $sess_data['logged_in'] = 'yesGetMeLoginAnggota';
                    $sess_data['username'] = $qad->noanggota;
                    $sess_data['nama_pengguna'] = $qad->namaanggota;
                    $sess_data['level'] = 'anggota';
                    $this->session->set_userdata($sess_data);
                }
                header('location:' . base_url() . 'index.php/c_anggota/media');
            } else {
                $this->session->set_flashdata('result_login', '<br>Username atau Password yang anda masukkan salah.');
                //header('location:'.base_url());
                redirect('/koperasi/', 'refresh');
            }
        }
    }

    /* Tanggal dan Jam */
    public function Jam_Now()
    {
        date_default_timezone_set("Asia/Jakarta");
        $jam = date("H:i:s");

        return $jam;
        //echo "$jam WIB";
    }

    public function Hari_Bulan_Indo()
    {
        date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
        $seminggu = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum\'at", "Sabtu");
        $hari = date("w");
        $hari_ini = $seminggu[$hari];

        return $hari_ini;
    }


    public function tgl_now_indo()
    {
        date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
        $tgl = date("Y m d");
        $tanggal = substr($tgl, 8, 2);
        $bulan = $this->app_model->getBulan(substr($tgl, 5, 2));
        $tahun = substr($tgl, 0, 4);
        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }

    public function getBulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }

    /*fungsi terbilang*/
    public function bilang($x)
    {
        $x = abs($x);
        $angka = array(
            "", "satu", "dua", "tiga", "empat", "lima",
            "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"
        );
        $result = "";
        if ($x < 12) {
            $result = " " . $angka[$x];
        } else if ($x < 20) {
            $result = $this->app_model->bilang($x - 10) . " belas";
        } else if ($x < 100) {
            $result = $this->app_model->bilang($x / 10) . " puluh" . $this->app_model->bilang($x % 10);
        } else if ($x < 200) {
            $result = " seratus" . $this->app_model->bilang($x - 100);
        } else if ($x < 1000) {
            $result = $this->app_model->bilang($x / 100) . " ratus" . $this->app_model->bilang($x % 100);
        } else if ($x < 2000) {
            $result = " seribu" . $this->app_model->bilang($x - 1000);
        } else if ($x < 1000000) {
            $result = $this->app_model->bilang($x / 1000) . " ribu" . $this->app_model->bilang($x % 1000);
        } else if ($x < 1000000000) {
            $result = $this->app_model->bilang($x / 1000000) . " juta" . $this->app_model->bilang($x % 1000000);
        } else if ($x < 1000000000000) {
            $result = $this->app_model->bilang($x / 1000000000) . " milyar" . $this->app_model->bilang(fmod($x, 1000000000));
        } else if ($x < 1000000000000000) {
            $result = $this->app_model->bilang($x / 1000000000000) . " trilyun" . $this->app_model->bilang(fmod($x, 1000000000000));
        }
        return $result;
    }
    public function terbilang($x, $style = 4)
    {
        if ($x < 0) {
            $hasil = "minus " . trim($this->app_model->bilang($x));
        } else {
            $hasil = trim($this->app_model->bilang($x));
        }
        switch ($style) {
            case 1:
                $hasil = strtoupper($hasil);
                break;
            case 2:
                $hasil = strtolower($hasil);
                break;
            case 3:
                $hasil = ucwords($hasil);
                break;
            default:
                $hasil = ucfirst($hasil);
                break;
        }
        return $hasil;
    }
    public function Judul()
    {
    }
    public function Nama_Perusahaan()
    {
        $a = $this->db->query("SELECT koperasi FROM profile WHERE id='1'");
        if (count($a->result()) > 0) {
            foreach ($a->result() as $p) {
                $profile = $p->koperasi;
            }
        } else {
            $profile = "";
        }
        return $profile;
    }
    public function Kota()
    {
        $a = $this->db->query("SELECT kota FROM profile WHERE id='1'");
        if (count($a->result()) > 0) {
            foreach ($a->result() as $p) {
                $profile = $p->kota;
            }
        } else {
            $profile = "";
        }
        return $profile;
    }
    public function Alamat()
    {
        $a = $this->db->query("SELECT alamat FROM profile WHERE id='1'");
        if (count($a->result()) > 0) {
            foreach ($a->result() as $p) {
                $profile = $p->alamat;
            }
        } else {
            $profile = "";
        }
        return $profile;
    }
    public function Hp()
    {
        $a = $this->db->query("SELECT hp FROM profile WHERE id='1'");
        if (count($a->result()) > 0) {
            foreach ($a->result() as $p) {
                $profile = $p->hp;
            }
        } else {
            $profile = "";
        }
        return $profile;
    }
    public function Fax()
    {
    }
    public function Email()
    {
    }
    function save_upload($title, $image)
    {
        $data = array(
            'title'     => $title,
            'file_name' => $image
        );
        //$result = $this->db->insert('gallery', $data);
        //return $result;
    }
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
