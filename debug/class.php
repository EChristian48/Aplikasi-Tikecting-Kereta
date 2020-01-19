<?php

/**
 * 
 * tableName
 * colExceptionIndex
 * 
 */

$tableName = "tiket";
$colExceptionIndex = [];

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

$tableCol = $i;
$fieldCount = count($fieldName);

?>

<table border="1">
    <th colspan="<?php echo $tableCol ?>"><?php echo $tableName ?></th>

    <tr>

        <?php
        foreach ($fieldName as $index => $name)
        {
        ?>
        
            <td><?= $name ?></td>
        
        <?php   
        }
        ?>

    </tr>

    <?php

    while ($tableDatas = mysqli_fetch_array($selectQueryResult)) {
    ?>

        <tr>

            <?php
            for ($i = 0; $i < ($fieldCount); $i++) 
            {
            ?>

                <td><?= $tableDatas[$i] ?></td>

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