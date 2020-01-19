<?php

    require 'connections.php';
    
    session_start();

    if (isset($_SESSION['tableName']) && isset($_SESSION['idField']))  //Cek udah ada data atau belum di session saat ini, kalo ada pake yang itu
    {
        $tableName = $_SESSION['tableName']; //Sama kaya line 20-21
        $idField = $_SESSION['idField'];
    }


    if (isset($_POST['tampilkan'])) //Cek juga line 71
    {
        $_SESSION['tableName'] = $_POST['tableName']; //Biar kalo pake $_GET ga kehapus datanya dan langsung update datanya
        $_SESSION['idField'] = $_POST['idField']; //Biar kalo pake $_GET ga kehapus datanya dan langsung update datanya

        $tableName = $_SESSION['tableName']; //Biar gampang aksesnya, ga ribet nulis
        $idField = $_SESSION['idField']; //Biar gampang aksesnya, ga ribet nulis
    }

    //Sebenernya ini simpan/update, tapi syntaxnya digabung
    //Dicek dulu pake select, kalo udah ada record dengan primary key yang sama
    //maka di-update, kalau belum ada maka di-create
    if (isset($_POST['simpan']))
    {
        $selectWhereQuery = "SELECT * FROM $tableName WHERE $idField='$_POST[$idField]'";
        $selectWhereResult = mysqli_query($con, $selectWhereQuery);

        $resultCount = mysqli_num_rows($selectWhereResult);

        if ($resultCount == 0)
        {
            $createQuery = "INSERT INTO $tableName VALUES ()";
        }
    }

    if (isset($_GET['hapus']))
    {

    }
    elseif ($_GET['aksi'] == 'edit')
    {
        $id = $_GET['id'];

        $selectWhereQuery = "SELECT * FROM $tableName WHERE $idField='$id'";
        $selectWhereResult = mysqli_query($con, $selectWhereQuery);

        $editData = mysqli_fetch_array($selectWhereResult);
    }

?>

<form method="post">
<table>
    <tr>
        <td>Nama Tabel :</td>
        <td><input type="text" name="tableName"></td>
    </tr>
    <tr>
        <td>Primary Key :</td>
        <td><input type="text" name="idField"></td>
        <td><input type="submit" value="Tampilkan" name="tampilkan"></td>
    </tr>
</table>
</form>

<?php
if (isset($tableName) && isset($idField)) //Kalau belum di-set ini yang di bawah ga akan muncul
{
?>

<?php

$selectQuery = "SELECT * FROM $tableName"; //!!Pindahin ke queries.php!!
$fieldNameQuery = "SELECT COLUMN_NAME FROM COLUMNS WHERE TABLE_NAME = '$tableName'"; //!!Pindahin ke queries.php!!    

$displayResult = mysqli_query($con, $selectQuery); //Query result dari select semua data tabel

$fieldNum = mysqli_num_fields($displayResult); //!!Ga perlu, bisa pake foreach!!
$fieldName = mysqli_query($infoCon, $fieldNameQuery); //Ngambil dari table infomation_schema.columns yang disediain MySQL

$tableCol = $fieldNum + 2; //Karena ditambah aksi yang punya 2 kolom

//Ngubah dari banyak array yang isinya cuma 1, jadi cuma 1 array
$i = 0;
while ($fieldNameRec = mysqli_fetch_array($fieldName))
{

    $fieldNameArray[$i++] = $fieldNameRec[0];
}

?>

<table border="1">
    <th colspan="<?php echo $tableCol ?>"><?php echo $tableName ?></th>

    <tr>

        <?php
        for ($i = 0; $i < $fieldNum; $i++ ) //!!Ganti jadi foreach dan pake $fieldNameArray!!
        {
        ?>
        
            <td><?php echo $fieldNameArray[$i] ?></td>
        
        <?php
        }
        ?>
            <td colspan="2" >Aksi</td>
    </tr>

    <?php
    while ($recordDataRec = mysqli_fetch_array($displayResult)) {
    ?>

        <tr>

            <?php
            for ($i = 0; $i < $fieldNum; $i++) {
            ?>

                <td><?php echo $recordDataRec[$i] ?></td>

            <?php
            }
            ?>

            <td><a href="?aksi=edit&id=<?php echo $recordDataRec[$idField] ?>">Edit</a></td>
            <td><a href="?aksi=hapus&id=<?php echo $recordDataRec[$idField] ?>">Hapus</a></td>

        </tr>

    <?php
    }
    ?>

</table>

<table>
    <form method="post">

    <?php
    $fieldName = mysqli_query($infoCon, $fieldNameQuery);
    $i = 0;
    while ($fieldNameRec = mysqli_fetch_array($fieldName)) { //!!Ganti jadi foreach dan pake $fieldNameArray!!
    ?>

        <tr>
            <td><?php echo $fieldNameRec[0] ?> :</td>
            <td><input type="text" name="<?php echo $fieldNameRec[0] ?>" <?php
            
            if ($_GET['aksi'] == 'edit')
            {
                echo "value=". $editData[$i];
            }

            ?> ></td>
        </tr>
        
    <?php
    $i++;
    }
    ?>

    <tr>
        <td><input type="submit" value="Simpan/Update" name="simpan"></td>
        <!-- Load page yang sama jadi keulang, tapi masih ada bekas session -->
        <!-- !!Ganti jadi javascript!! -->
        <td><a href="crud.php">Reset</a></td> 
    </tr>

    </form>
</table>

<?php
}
?>