<?php
    include('../../include/koneksi.php');
    include("include/akses koordinator.php"); 
   
    $cek=$koneksi->query("select * from prodi where id_fakultas='".$_POST["fakul"]."'");
    while($data_fakul=mysqli_fetch_array($cek)){
   
    ?>
        <option value="<?php echo $data_fakul["id_prodi"] ?>"><?php echo $data_fakul["prodi"] ?></option><br>
   
    <?php
    }
    ?>