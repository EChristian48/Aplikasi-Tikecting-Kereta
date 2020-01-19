<?php

session_start();

require '../scripts/connections.php';
require '../scripts/functions.php';

$FieldNames = [];
$i = 0;
$exception = 5;

$queryResult = GetFieldName('tiket');
while ($Field = mysqli_fetch_array($queryResult))
{
        $FieldNames[$i++] = $Field[0];
}

if (isset($_POST['cari']))
{
    $_SESSION['idTiket'] = $idTiket = $_POST['idTiket'];

    $queryResult = SelectWhereQuery('tiket', "  id_tiket='$idTiket'");

    $tiket = mysqli_fetch_array($queryResult);
}

if (isset($_POST['kirim']))
{
    $file_name = $_FILES['image']['name'];
    $file_tmp =$_FILES['image']['tmp_name'];
    move_uploaded_file($file_tmp,'../images/'. $file_name);

    $queryResult = UpdateQuery('tiket', "bukti_pembayaran='$file_name', status='menunggu konfirmasi'", "id_tiket='$_SESSION[idTiket]'");

    //$queryResult = mysqli_query($con, "UPDATE INTO tiket SET bukti_pembayaran");

    if ($queryResult)
    {
        Alert('Upload File Berhasil, silahkan tunggu konfirmasi');
        Redirect("../beli");
    }
    else
    {
        Alert('Upload gagal, silahkan coba lagi');
        Redirect("../konfirmasi");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="post">
    <table>
        <tr>
            <td>ID Tiket :</td>
            <td><input type="text" name="idTiket"></td>
            <td><input type="submit" name="cari" value="Cari"></td>
        </tr>
    </table>
    </form>
    <?php
    
    if (isset($tiket))
    {
        ?>
    <form method="post" enctype="multipart/form-data">
    <table border="1" >
    <?php
    $length = count($FieldNames);
    $i2 = 0;
    $i3 = 0;
    for ($i = 0; $i < $length; $i++)
    {
        if ($i != $exception)
        {
            ?>
            <tr>
                <td>
                    <?php
                        echo $FieldNames[$i];
                    ?>
                </td>
                <td>
                    <?php
                        if ($tiket[$i] == "")
                        {
                            ?>
                                <input type="file" name="image" >
                            <?php
                        }
                        else
                        {
                            ?>
                                <input name="<?= $FieldNames[$i] ?>" type="text" readonly value="<?= $tiket[$i]; ?>">
                            <?php
                        }
                    ?>
                </td>
            </tr>
            <?php
        }
    }

    ?>
    </table>

    <table>
        <tr>
            <td><input type="submit" value="Kirim" name="kirim"></td>
        </tr>
    </table>
    </form>
</body>
</html>


        <?php
    }
    
    ?>
    