<?php
include('../include/koneksi.php');
include("include/akses admin.php");

$email = $_SESSION['email']; // mengambil username dari session yang login

$sql = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email'"); // query memilih entri username pada database
if (mysqli_num_rows($sql) == 0) {
  header("Location:../index admin.php");
  exit(); // tambahkan exit setelah header untuk menghentikan eksekusi skrip
} else {
  $row = mysqli_fetch_assoc($sql);
}

$nama = $row['nama'];
?>
<!-- Setting CSS bagian header/ kop -->
<style type="text/css">
  table.page_header {
    width: 1020px;
    border: none;
    background-color: #FFFFFF;
    border-bottom: solid 1mm #066aab;
    padding: 2mm;
    margin: 0 auto;
    /* Menengahkan header */
  }

  table.page_footer {
    width: 1020px;
    border: none;
    background-color: #066aab;
    border-top: solid 1mm #066aab;
    padding: 2mm;
    margin: 0 auto;
    /* Menengahkan footer */
  }

  h1 {
    color: #000033;
  }

  h2 {
    color: #000055;
  }

  h3 {
    color: #000077;
  }
</style>
<!-- Setting Margin header/ kop -->
<page backtop="14mm" backbottom="14mm" backleft="1mm" backright="10mm">
  <page_header>
    <!-- Setting Header -->
    <table class="page_header">
      <tr>
        <td style="text-align: left;">UNIVERSITAS HALUOLEO</td>
        <td style="text-align: center; padding-left: 30px;">LAPORAN KRITIK DAN SARAN RUANGAN GEDUNG FAKULTAS TEKNIK</td>
        <td style="text-align: right;"><?php echo date('d/m/Y'); ?></td>
      </tr>
    </table>
  </page_header>
  <!-- Setting Footer -->
  <page_footer>
    <table class="page_footer">
      <tr>
        <td style="text-align: left;">Universitas Haluoleo Kendari</td>
        <td style="text-align: center;">Dicetak oleh: <?php echo $nama ?></td>
        <td style="text-align: right;">Halaman [[page_cu]]/[[page_nb]]</td>
      </tr>
    </table>
  </page_footer>
  <!-- Konten -->
  <div style="text-align: center;"> <!-- Menengahkan konten -->
    <table>
      <tr>
        <th rowspan="3"><img src="laporan/logo2.png" style="width:170px;height:70px" /></th>
        <td align="center" style="width: 800px;">
          <font style="font-size: 18px"><br><b>SISTEM RUANGAN GEDUNG UNIVERSITAS HALUOLEO</b></font>
          <br><br>Universitas Haluoleo Kendari | JL. HEA. Mokodompit, Lalolara Kambu 93561
          <br><br>Website : https://uho.ac.id/ | E-mail : info@uho.ac.id
        </td>
      </tr>
    </table>
    <hr><br><br>
    <table class="tabel2" style="width: 80%; margin: 0 auto;"> <!-- Menengahkan dan menyesuaikan lebar tabel -->
      <thead>
        <tr>
          <td style="text-align: center; background: #ddd"><b>No.</b></td>
          <td style="text-align: center; background: #ddd"><b>Kode Ruangan</b></td>
          <td style="text-align: center; background: #ddd"><b>Fasilitas</b></td>
          <td style="text-align: center; background: #ddd"><b>Komentar</b></td>
          <td style="text-align: center; background: #ddd"><b>Tanggal</b></td>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = mysqli_query($koneksi, "SELECT * FROM komentar natural join ruangan ORDER BY id_komentar ASC");
        $i   = 1;
        while ($data = mysqli_fetch_array($sql)) {
        ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $data['kode_ruangan']; ?></td>
            <td><?php echo $data['fasilitas']; ?></td>
            <td><?php echo $data['komentar']; ?></td>
            <td><?php echo $data['tanggal']; ?></td>
          </tr>
        <?php
          $i++;
        }
        ?>
      </tbody>
    </table>
  </div>
</page>
<!-- Memanggil fungsi bawaan HTML2PDF -->
<?php
$content = ob_get_clean();
include 'laporan/html2pdf.class.php';
try {
  $html2pdf = new HTML2PDF('L', 'A4', 'en', false, 'UTF-8', array(10, 10, 4, 10));
  $html2pdf->pdf->SetDisplayMode('fullpage');
  $html2pdf->writeHTML($content);
  $html2pdf->Output('laporan_ruangan.pdf', 'V');
} catch (HTML2PDF_exception $e) {
  echo $e;
  exit;
}
?>
``