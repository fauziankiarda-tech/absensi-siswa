
<?php
session_start();

// Daftar nama siswa
$siswa = [
    1 => "Sabri",
    2 => "Aisyah",
    3 => "Amalia",
    4 => "Nanda",
    5 => "Ardhan",
    6 => "Aulia",
    7 => "Clarisa",
    8 => "Dapa",
    9 => "Dzaki Satya",
    10 => "Galih chyo"
];

// Menyimpan absensi
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pilihan = ["Hadir", "Izin", "Sakit", "Alfa"];
    $absensi = [];

    foreach ($siswa as $no => $nama) {
        $status = $_POST["status"][$no] ?? "";

        if (in_array($status, $pilihan, true)) {
            $absensi[$no] = $status;
        } else {
            $absensi[$no] = "";
        }
    }

    $_SESSION["absensi"] = $absensi;
    $_SESSION["tanggal"] = date("Y-m-d");

    header("Location: index.php?success=1");
    exit;
}

// Mengambil data absensi
$data = $_SESSION["absensi"] ?? [];

// Menghitung rekap
$hadir = 0;
$izin = 0;
$sakit = 0;
$alfa = 0;

foreach ($data as $status) {
    if ($status == "Hadir") {
        $hadir++;
    } elseif ($status == "Izin") {
        $izin++;
    } elseif ($status == "Sakit") {
        $sakit++;
    } elseif ($status == "Alfa") {
        $alfa++;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Absensi Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>DAFTAR ABSENSI SISWA</h1>
    <p class="subtitle">Sistem Absensi Kelas X RPL</p>

    <p>
        Tanggal:
        <?php echo date("d-m-Y"); ?>
    </p>

    <?php if (isset($_GET["success"])): ?>
        <div class="success">
            Absensi berhasil disimpan!
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="table-wrapper">
        <table>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Keterangan</th>
            </tr>

            <?php foreach ($siswa as $no => $nama): ?>

            <tr>
                <td><?php echo $no; ?></td>

                <td>
                    <?php echo htmlspecialchars($nama); ?>
                </td>

                <td>
                    <select name="status[<?php echo $no; ?>]"
                            required>

                        <option value="">Pilih Status</option>

                        <?php
                        $pilihan = [
                            "Hadir",
                            "Izin",
                            "Sakit",
                            "Alfa"
                        ];

                        foreach ($pilihan as $status):
                        ?>

                        <option value="<?php echo $status; ?>"
                            <?php
                            if (($data[$no] ?? "") == $status) {
                                echo "selected";
                            }
                            ?>
                        >
                            <?php echo $status; ?>
                        </option>

                        <?php endforeach; ?>

                    </select>
                </td>
            </tr>

            <?php endforeach; ?>

        </table>
        </div>

        <button type="submit">
            Simpan Absensi
        </button>

    </form>

    <h2>Rekap Absensi</h2>

    <div class="rekap">
        <div class="hadir">
            <h3><?php echo $hadir; ?></h3>
            <p>Hadir</p>
        </div>

        <div class="izin">
            <h3><?php echo $izin; ?></h3>
            <p>Izin</p>
        </div>

        <div class="sakit">
            <h3><?php echo $sakit; ?></h3>
            <p>Sakit</p>
        </div>

        <div class="alfa">
            <h3><?php echo $alfa; ?></h3>
            <p>Alfa</p>
        </div>
    </div>

    <footer>
        Website Absensi Siswa | X RPL 2
    </footer>

</div>

</body>
</html>
