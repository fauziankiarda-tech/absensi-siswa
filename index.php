
<?php
session_start();
date_default_timezone_set("Asia/Jakarta");

// Daftar siswa
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

// Pilihan absensi
$pilihan = ["Hadir", "Izin", "Sakit", "Alfa"];

// Proses menyimpan absensi
if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

// Mengambil data
$data = $_SESSION["absensi"] ?? [];

// Menghitung rekap
$hadir = 0;
$izin = 0;
$sakit = 0;
$alfa = 0;

foreach ($data as $status) {

    switch ($status) {
        case "Hadir":
            $hadir++;
            break;

        case "Izin":
            $izin++;
            break;

        case "Sakit":
            $sakit++;
            break;

        case "Alfa":
            $alfa++;
            break;
    }
}

// Membuat tampilan website
echo "<!DOCTYPE html>";
echo "<html lang='id'>";

echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Absensi Siswa</title>";
echo "<link rel='stylesheet' href='style.css'>";
echo "</head>";

echo "<body>";

echo "<div class='container'>";

echo "<h1>DAFTAR ABSENSI SISWA</h1>";
echo "<p class='subtitle'>Sistem Absensi Kelas X RPL 2</p>";

echo "<p>Tanggal: " . date("d-m-Y") . "</p>";

// Pesan berhasil
if (isset($_GET["success"])) {
    echo "<div class='success'>";
    echo "Absensi berhasil disimpan!";
    echo "</div>";
}

// Form absensi
echo "<form method='POST'>";

echo "<div class='table-wrapper'>";
echo "<table>";

echo "<tr>";
echo "<th>No</th>";
echo "<th>Nama Siswa</th>";
echo "<th>Keterangan</th>";
echo "</tr>";

// Menampilkan daftar siswa
foreach ($siswa as $no => $nama) {

    echo "<tr>";

    echo "<td>$no</td>";

    echo "<td>" . htmlspecialchars($nama) . "</td>";

    echo "<td>";

    echo "<select name='status[$no]' required>";

    echo "<option value=''>Pilih Status</option>";

    foreach ($pilihan as $status) {

        $selected = "";

        if (($data[$no] ?? "") == $status) {
            $selected = "selected";
        }

        echo "<option value='$status' $selected>";
        echo $status;
        echo "</option>";
    }

    echo "</select>";

    echo "</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";

echo "<button type='submit'>";
echo "Simpan Absensi";
echo "</button>";

echo "</form>";

// Rekap absensi
echo "<h2>Rekap Absensi</h2>";

echo "<div class='rekap'>";

echo "<div class='hadir'>";
echo "<h3>$hadir</h3>";
echo "<p>Hadir</p>";
echo "</div>";

echo "<div class='izin'>";
echo "<h3>$izin</h3>";
echo "<p>Izin</p>";
echo "</div>";

echo "<div class='sakit'>";
echo "<h3>$sakit</h3>";
echo "<p>Sakit</p>";
echo "</div>";

echo "<div class='alfa'>";
echo "<h3>$alfa</h3>";
echo "<p>Alfa</p>";
echo "</div>";

echo "</div>";

// Footer
echo "<footer>";
echo "Website Absensi Siswa | X RPL 2";
echo "</footer>";

echo "</div>";

echo "</body>";
echo "</html>";
?>
