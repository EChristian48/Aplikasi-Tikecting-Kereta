<?php

    require 'connections.php';

    //Sebenernya ini simpan/update, tapi syntaxnya digabung
    //Dicek dulu pake select, kalo udah ada record dengan primary key yang sama
    //maka di-update, kalau belum ada maka di-create
    if (isset($_POST['simpan']))
    {
        $selectWhereQuery = "SELECT * FROM $tableName WHERE $idField='$_POST[$idField]'";
        $selectWhereResult = mysqli_query($con, $selectWhereQuery);

        $resultCount = mysqli_num_rows($selectWhereResult);

        $values = "";
        $fields = "id_tiket, id_penumpang, id_kursi, id_keberangkatan, ";

        //InsertQuery($infoCon, $con, $tableName, ,);



    }

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

<table>
    <form method="post">

    <?php
    $fieldName = mysqli_query($infoCon, $fieldNameQuery);
    $i = 0;
    while ($fieldNameRec = mysqli_fetch_array($fieldName)) { //!!Ganti jadi foreach dan pake $fieldNameArray!!
        foreach ($colExceptionIndex as $index)
        {
            if ($i != $index)
            {
    ?>

        <tr>
            <td><?php echo $fieldNameRec[0] ?> :</td>
            <td><input type="text" name="<?php echo $fieldNameRec[0] ?>" <?php
            ?> ></td>
        </tr>
        
    <?php
    break;
                }
            }
    $i++;
    }
    ?>

    <tr>
        <td><input type="submit" value="Simpan" name="simpan"></td>
        <!-- Load page yang sama jadi keulang, tapi masih ada bekas session -->
        <!-- !!Ganti jadi javascript!! -->
    </tr>

    </form>
</table>