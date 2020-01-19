<?php

/**
 * 
 * tableName
 * colExceptionIndex, sekarang cuma bisa 1
 * 
 */

$tableName = "tiket";
$idField = "id_tiket";
$exceptionIndex = array(0, 1, 2);
$menuPilih = true;
$menuHapus = true;

require '../scripts/functions.php';

$selectQueryResult = SelectQuery($tableName);

$fieldNameQuery = "SELECT COLUMN_NAME FROM COLUMNS WHERE TABLE_NAME = '$tableName'";

$getFieldResult = GetFieldName($tableName); //Ngambil dari table infomation_schema.columns yang disediain MySQL

//Ngubah dari banyak array yang isinya cuma 1, jadi cuma 1 array
$i = 0;
while ($fieldNames = mysqli_fetch_array($getFieldResult))
{

    $fieldName[$i++] = $fieldNames[0];
}

if ($menuPilih && $menuHapus)
{
    $aksiCol = 2;
}
elseif ($menuPilih || $menuHapus)
{
    $aksiCol = 1;
}
else
{
    $aksiCol = 0;
}

$tableCol = $i + $aksiCol;

$fieldCount = count($fieldName);

?>

<table border="1">
    <th colspan="<?php echo $tableCol ?>"><?php echo $tableName ?></th>

    <tr>

        <?php
        foreach ($fieldName as $index => $name)
        {
            if (isset($exceptionIndex[0]))
            {
                foreach ($exceptionIndex as $exception)
                {
                    if (!($index == $exception))
                    {
                        ?>
                        <td><?= $name ?></td>
                        <?php
                        break;
                    }
                }
            }
            else
            {
                ?>
                    <td><?= $name ?></td>
                <?php
            }
        }
        ?>
        
        <td colspan="<?= $aksiCol ?>"></td>

    </tr>

    <?php

    while ($tableDatas = mysqli_fetch_array($selectQueryResult)) 
    {
    ?>

    <tr>

    <?php
            for ($i = 0; $i < ($fieldCount); $i++) 
            {
                if (isset($exceptionIndex[0]))
                {
                    foreach ($exceptionIndex as $exception)
                    {
                        if (!($i == $exception))
                        {
                            ?>
                            <td><?= $tableDatas[$i] ?></td>
                            <?php
                            break;
                        }
                    }
                }
                else
                {
                    ?>
                    <td><?= $tableDatas[$i] ?></td>
                    <?php
                }
            }
    ?>

    <?php
    if ($menuPilih)
    {
        ?>
        <td><a href="?pilih=<?php ?>">Pilih</a></td>
        <?php
    }
    ?>

    <?php
    if ($menuHapus)
    {
        ?>
        <td><a href="?hapus="<?php ?>>Hapus</a></td>
        <?php
    }
    ?>

    </tr>

    <?php
    }
    ?>

</table>

<?php

/**
 * PHP 7.3.8
 * 
 * Kode di bawah ini untuk testing
 * Ga tau kenapa, tapi kalo pake foreach sama for
 * Hasilnya beda
 * 
 * Uncomment aja kode di bawah ini
 */

//$selectQueryResult = SelectQuery($tableName);
//$data = mysqli_fetch_array($selectQueryResult);
//echo "For : <br>";
//for ($i = 0; $i < 9; $i++)
//{
//    echo $data[$i] . "<br>";
//}
//echo "<br>Foreach : <br>"; 
//foreach ($data as $detail)
//{
//    echo $detail . "<br>";
//}

?>