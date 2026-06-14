<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/OperatorModel.php';

class OperatorController {
    private $operatorModel;

    private $kelasKapasitas = [
        'Super Executive' => 22,
        'Executive Class' => 30,
        'Patas AC'        => 38,
        'Ekonomi AC'      => 44,
        'Ekonomi Non-AC'  => 50,
    ];

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->operatorModel = new OperatorModel((new Database())->connect());
    }

    private function cekSesi() {
        if (!isset($_SESSION['operator_id'])) {
            header('Location: ' . BASEURL . '/index.php?controller=auth&action=login');
            exit;
        }
    }

    private function validasiJadwal($tanggal, $harga, $bus_id, $jam, $asal, $tujuan) {
        if (empty($tanggal) || strtotime($tanggal) < strtotime(date('Y-m-d')))
            return 'Tanggal keberangkatan tidak valid atau sudah lewat!';
        if ($harga <= 0) return 'Harga harus lebih dari 0!';
        if ($bus_id <= 0) return 'Bus harus dipilih!';
        if (empty($jam)) return 'Jam keberangkatan wajib diisi!';
        if (empty($asal) || empty($tujuan)) return 'Asal dan tujuan wajib diisi!';
        return '';
    }

    public function dashboard() {
        $this->cekSesi();
        $op = $_SESSION['operator_id'];
        $jadwalHariIni            = $this->operatorModel->getJadwalHariIni($op);
        $penumpangTerverifikasi   = $this->operatorModel->getPenumpangTerverifikasi($op);
        $penumpangBelumVerifikasi = $this->operatorModel->getPenumpangBelumVerifikasi($op);
        $busAktif                 = $this->operatorModel->getBusAktif($op);
        $pemesananTerbaru         = $this->operatorModel->getPemesananTerbaru($op, 5);
        require_once __DIR__ . '/../views/operator/operatordashboard.php';
    }

    public function bilList() {
        $this->cekSesi();
        $busList = $this->operatorModel->getAllBus($_SESSION['operator_id']);
        $busEdit = null;
        if (!empty($_GET['edit_id'])) {
            $editId = (int)$_GET['edit_id'];
            foreach ($busList as $b) {
                if ((int)$b['id'] === $editId) { $busEdit = $b; break; }
            }
        }
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        require_once __DIR__ . '/../views/operator/operatorbil.php';
    }

    public function bilAdd() {
        $this->cekSesi();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        $kelas = trim($_POST['kelas_bus'] ?? '');
        $data  = [
            'no_polisi'   => trim($_POST['no_polisi'] ?? ''),
            'kelas_bus'   => $kelas,
            'kapasitas'   => $this->kelasKapasitas[$kelas] ?? 0,
            'status_bus'  => trim($_POST['status_bus'] ?? 'Aktif'),
            'operator_id' => $_SESSION['operator_id'],
        ];
        if (empty($data['no_polisi']) || $data['kapasitas'] === 0) {
            $_SESSION['error'] = 'No polisi wajib diisi dan kelas bus harus dipilih.';
        } elseif ($this->operatorModel->tambahBus($data)) {
            $_SESSION['success'] = 'Bus berhasil ditambahkan.';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan bus.';
        }
        header('Location: ' . BASEURL . '/index.php?controller=operator&action=bilList');
        exit;
    }

    public function bilEdit($id) {
        $this->cekSesi();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        $kelas = trim($_POST['kelas_bus'] ?? '');
        $data  = [
            'no_polisi'  => trim($_POST['no_polisi'] ?? ''),
            'kelas_bus'  => $kelas,
            'kapasitas'  => $this->kelasKapasitas[$kelas] ?? 0,
            'status_bus' => trim($_POST['status_bus'] ?? 'Aktif'),
        ];
        if (empty($data['no_polisi']) || $data['kapasitas'] === 0) {
            $_SESSION['error'] = 'No polisi wajib diisi dan kelas bus harus dipilih.';
        } elseif ($this->operatorModel->updateBus($id, $_SESSION['operator_id'], $data)) {
            $_SESSION['success'] = 'Bus berhasil diupdate.';
        } else {
            $_SESSION['error'] = 'Gagal mengupdate bus.';
        }
        header('Location: ' . BASEURL . '/index.php?controller=operator&action=bilList');
        exit;
    }

    public function bilDelete($id) {
        $this->cekSesi();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->operatorModel->hapusBus($id, $_SESSION['operator_id']);
                $_SESSION['success'] = 'Bus berhasil dihapus.';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Gagal menghapus bus. Pastikan bus tidak sedang digunakan di jadwal manapun.';
            }
            header('Location: ' . BASEURL . '/index.php?controller=operator&action=bilList');
            exit;
        }
        $konfirmasi_pesan    = 'Yakin ingin menghapus bus ini?';
        $konfirmasi_action   = BASEURL . '/index.php?controller=operator&action=bilDelete&id=' . $id;
        $konfirmasi_kembali  = BASEURL . '/index.php?controller=operator&action=bilList';
        $konfirmasi_css_file = 'operator';
        require_once __DIR__ . '/../views/konfirmasi.php';
    }

    public function jadwalList() {
        $this->cekSesi();
        $jadwalList     = $this->operatorModel->getAllJadwal($_SESSION['operator_id']);
        $busListOptions = $this->operatorModel->getBusAktifByOperator($_SESSION['operator_id']);
        $ruteList       = RUTE_ALS;
        $jadwalEdit     = null;
        if (!empty($_GET['edit_id'])) {
            $editId = (int)$_GET['edit_id'];
            foreach ($jadwalList as $j) {
                if ((int)$j['id'] === $editId) { $jadwalEdit = $j; break; }
            }
        }
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        require_once __DIR__ . '/../views/operator/operatorjadwal.php';
    }

    public function jadwalAdd() {
        $this->cekSesi();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        $tanggal       = trim($_POST['tanggal'] ?? '');
        $harga         = (float)($_POST['harga'] ?? 0);
        $bus_id        = (int)($_POST['bus_id'] ?? 0);
        $jam_berangkat = trim($_POST['jam_berangkat'] ?? '');
        $asal          = trim($_POST['asal'] ?? '');
        $tujuan        = trim($_POST['tujuan'] ?? '');
        $pesan         = $this->validasiJadwal($tanggal, $harga, $bus_id, $jam_berangkat, $asal, $tujuan);
        if ($pesan) {
            $_SESSION['error'] = $pesan;
        } else {
            $bus = $this->operatorModel->getBusById($bus_id, $_SESSION['operator_id']);
            $ok  = $this->operatorModel->tambahJadwal([
                'bus_id'         => $bus_id,
                'asal'           => $asal,
                'tujuan'         => $tujuan,
                'tanggal'        => $tanggal,
                'jam_berangkat'  => $jam_berangkat,
                'harga'          => $harga,
                'kursi_tersedia' => $bus ? (int)$bus['kapasitas'] : 0,
                'operator_id'    => $_SESSION['operator_id'],
            ]);
            if ($ok) {
                $_SESSION['success'] = 'Jadwal berhasil ditambahkan.';
            } else {
                $_SESSION['error'] = 'Gagal menambahkan jadwal.';
            }
        }
        header('Location: ' . BASEURL . '/index.php?controller=operator&action=jadwalList');
        exit;
    }

    public function jadwalEdit($id) {
        $this->cekSesi();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        $tanggal       = trim($_POST['tanggal'] ?? '');
        $harga         = (float)($_POST['harga'] ?? 0);
        $bus_id        = (int)($_POST['bus_id'] ?? 0);
        $jam_berangkat = trim($_POST['jam_berangkat'] ?? '');
        $asal          = trim($_POST['asal'] ?? '');
        $tujuan        = trim($_POST['tujuan'] ?? '');
        $pesan         = $this->validasiJadwal($tanggal, $harga, $bus_id, $jam_berangkat, $asal, $tujuan);
        if ($pesan) {
            $_SESSION['error'] = $pesan;
        } else {
            $bus = $this->operatorModel->getBusById($bus_id, $_SESSION['operator_id']);
            $ok  = $this->operatorModel->updateJadwal($id, $_SESSION['operator_id'], [
                'bus_id'         => $bus_id,
                'asal'           => $asal,
                'tujuan'         => $tujuan,
                'tanggal'        => $tanggal,
                'jam_berangkat'  => $jam_berangkat,
                'harga'          => $harga,
                'kursi_tersedia' => $bus ? (int)$bus['kapasitas'] : 0,
            ]);
            if ($ok) {
                $_SESSION['success'] = 'Jadwal berhasil diupdate.';
            } else {
                $_SESSION['error'] = 'Gagal mengupdate jadwal.';
            }
        }
        header('Location: ' . BASEURL . '/index.php?controller=operator&action=jadwalList');
        exit;
    }

    public function jadwalDelete($id) {
        $this->cekSesi();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->operatorModel->hapusJadwal($id, $_SESSION['operator_id']);
                $_SESSION['success'] = 'Jadwal berhasil dihapus.';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Gagal menghapus jadwal. Pastikan jadwal tidak memiliki data pemesanan terkait.';
            }
            header('Location: ' . BASEURL . '/index.php?controller=operator&action=jadwalList');
            exit;
        }
        $konfirmasi_pesan    = 'Yakin ingin menghapus jadwal ini?';
        $konfirmasi_action   = BASEURL . '/index.php?controller=operator&action=jadwalDelete&id=' . $id;
        $konfirmasi_kembali  = BASEURL . '/index.php?controller=operator&action=jadwalList';
        $konfirmasi_css_file = 'operator';
        require_once __DIR__ . '/../views/konfirmasi.php';
    }

    public function pemesananList() {
        $this->cekSesi();
        $pemesananList = $this->operatorModel->getAllPemesanan($_SESSION['operator_id']);
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        require_once __DIR__ . '/../views/operator/operatorpemesanan.php';
    }

    public function pemesananVerifikasi($id) {
        $this->cekSesi();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $this->operatorModel->updateStatusVerifikasi($id, $_SESSION['operator_id'], 'Terverifikasi');
            if ($ok) {
                $_SESSION['success'] = 'Pemesanan berhasil diverifikasi.';
            } else {
                $_SESSION['error'] = 'Gagal memverifikasi pemesanan.';
            }
            header('Location: ' . BASEURL . '/index.php?controller=operator&action=pemesananList');
            exit;
        }
        $konfirmasi_pesan    = 'Yakin ingin memverifikasi pesanan ini?';
        $konfirmasi_action   = BASEURL . '/index.php?controller=operator&action=pemesananVerifikasi&id=' . $id;
        $konfirmasi_kembali  = BASEURL . '/index.php?controller=operator&action=pemesananList';
        $konfirmasi_css_file = 'operator';
        require_once __DIR__ . '/../views/konfirmasi.php';
    }

    public function pemesananTolak($id) {
        $this->cekSesi();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $this->operatorModel->updateStatusVerifikasi($id, $_SESSION['operator_id'], 'Ditolak');
            if ($ok) {
                $_SESSION['success'] = 'Pemesanan berhasil ditolak.';
            } else {
                $_SESSION['error'] = 'Gagal menolak pemesanan.';
            }
            header('Location: ' . BASEURL . '/index.php?controller=operator&action=pemesananList');
            exit;
        }
        $konfirmasi_pesan    = 'Yakin ingin menolak pesanan ini?';
        $konfirmasi_action   = BASEURL . '/index.php?controller=operator&action=pemesananTolak&id=' . $id;
        $konfirmasi_kembali  = BASEURL . '/index.php?controller=operator&action=pemesananList';
        $konfirmasi_css_file = 'operator';
        require_once __DIR__ . '/../views/konfirmasi.php';
    }

    public function profil() {
        $this->cekSesi();
        $operator = $this->operatorModel->getOperatorById($_SESSION['operator_id']);
        if (!$operator) {
            header('Location: ' . BASEURL . '/index.php?controller=operator&action=dashboard');
            exit;
        }
        $success_profil   = $_SESSION['success_profil'] ?? null;
        unset($_SESSION['success_profil']);
        $error_profil     = $_SESSION['error_profil'] ?? null;
        unset($_SESSION['error_profil']);
        $success_password = $_SESSION['success_password'] ?? null;
        unset($_SESSION['success_password']);
        $error_password   = $_SESSION['error_password'] ?? null;
        unset($_SESSION['error_password']);
        require_once __DIR__ . '/../views/operator/operatorProfil.php';
    }

    public function prosesUbahProfil() {
        $this->cekSesi();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/index.php?controller=operator&action=profil');
            exit;
        }
        $nama = trim($_POST['nama'] ?? '');
        if (empty($nama)) {
            $_SESSION['error_profil'] = 'Nama tidak boleh kosong.';
        } elseif ($this->operatorModel->updateProfilOperator($_SESSION['operator_id'], $nama)) {
            $_SESSION['nama_operator']  = $nama;
            $_SESSION['success_profil'] = 'Nama berhasil diperbarui.';
        } else {
            $_SESSION['error_profil'] = 'Gagal memperbarui nama.';
        }
        header('Location: ' . BASEURL . '/index.php?controller=operator&action=profil');
        exit;
    }

    public function prosesGantiPassword() {
        $this->cekSesi();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/index.php?controller=operator&action=profil');
            exit;
        }
        $password_lama = $_POST['password_lama'] ?? '';
        $password_baru = $_POST['password_baru'] ?? '';
        $konfirmasi    = $_POST['konfirmasi_password'] ?? '';
        $hash_lama     = $this->operatorModel->getPasswordOperatorById($_SESSION['operator_id']);
        if (!password_verify($password_lama, $hash_lama)) {
            $_SESSION['error_password'] = 'Password lama tidak sesuai.';
        } elseif (strlen($password_baru) < 8) {
            $_SESSION['error_password'] = 'Password baru minimal 8 karakter.';
        } elseif ($password_baru !== $konfirmasi) {
            $_SESSION['error_password'] = 'Konfirmasi password tidak cocok.';
        } elseif ($this->operatorModel->updatePasswordOperator($_SESSION['operator_id'], $password_baru)) {
            $_SESSION['success_password'] = 'Password berhasil diubah.';
        } else {
            $_SESSION['error_password'] = 'Gagal mengubah password.';
        }
        header('Location: ' . BASEURL . '/index.php?controller=operator&action=profil');
        exit;
    }

    public function login() {
        header('Location: ' . BASEURL . '/index.php?controller=auth&action=login');
        exit;
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASEURL . '/index.php?controller=auth&action=login');
        exit;
    }
}
