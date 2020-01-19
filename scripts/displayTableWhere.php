<?php

require 'connections.php';

$selectQuery = "SELECT * FROM $tableName WHERE $condition"; //!!Pindahin ke queries.php!!
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
<form action="konfirmasi.php" method="post">
    <th colspan="<?php echo $tableCol ?>"><?php echo $tableName ?></th>

    <tr>

        <td>No.</td>

        <?php
        for ($i = 0; $i < $fieldNum; $i++ ) //!!Ganti jadi foreach dan pake $fieldNameArray!!
        {
            foreach ($colExceptionIndex as $index)
            {

        
            if ($i != $index)
            {
        ?>
        
            <td><?php echo $fieldNameArray[$i] ?></td>
        
        <?php
        break;
            }
        }
        }
        ?>

        <td>Aksi</td>

    </tr>

    <?php
    $i = 0;
    while ($recordDataRec = mysqli_fetch_array($displayResult)) {
    ?>

        <tr>

            <td><?php echo ++$i ?></td>

            <?php
            for ($i = 0; $i < $fieldNum; $i++) {
                foreach ($colExceptionIndex as $index)
                {
                    if ($i != $index)
                    {
            ?>

                <td><?php 
                
                if ($i == 8)
                {
                    ?>
                        <img src="../../images/<?= $recordDataRec[$i] ?>" width="100px">
                    <?php
                }
                else
                {
                    echo $recordDataRec[$i];
                }
                
                ?></td>

            <?php
            break;
                    }
                }
            }
            ?>

            <td><button type="submit" value="<?= $recordDataRec[$idField] ?>" >Konfirmasi</button></td>

        </tr>

    <?php
    }
    ?>
</form>
</table>