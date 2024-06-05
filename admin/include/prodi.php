<?php
    include('../../include/koneksi.php');
    include("include/akses admin.php"); 
   
    $q=mysqli_query($koneksi, "select * from prodi where id_fakultas='".$_POST["fakul"]."'");
    while($data_fakul=mysqli_fetch_array($q)){
   
    ?>
        <option value="<?php echo $data_fakul["id_prodi"] ?>"><?php echo $data_fakul["prodi"] ?></option><br>
   
    <?php
    }
    ?>