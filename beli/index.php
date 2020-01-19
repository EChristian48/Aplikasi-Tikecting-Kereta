<?php

$currentDate = date("Y/m/d");
//$url = "$_SERVER[REQUEST_URI]";

$tableName = "keberangkatan";
$idField = "id_keberangkatan";
//$colExceptionIndex = array(0);
$colExceptionIndex = array(69);

include '../scripts/displayTable.php';
require '../scripts/connections.php';
require '../scripts/functions.php';

//$tableName = "tiket";
//$colExceptionIndex = array(0, 3, 5, 6, 9, 10);

//include '../scripts/inputTable.php';

if (isset($_GET['pilih']))
{
    $idFieldVal = $_GET['pilih'];

    $queryResult = SelectWhereQuery($tableName, "$idField='$idFieldVal'");

    $Keberangkatan = mysqli_fetch_array($queryResult);

    $idKeberangkatan = $Keberangkatan['id_keberangkatan'];
    $harga = $Keberangkatan['harga'];
}

if (isset($_POST['pesan']))
{
    $values = array(
        $_POST['keberangkatan'],
        $_POST['namaPenumpang'], 
        $_POST['noIdentitas'], 
        $_POST['kursi'],
        $currentDate,
        'unconfirmed');
        
    $fields = array(
        'id_keberangkatan',
        'nama_penumpang',
        'no_identitas', 
        'id_kursi',
        'tanggal_registrasi',
        'status');


    $queryResult = InsertQuery("tiket", $values, $fields);
    
    if ($queryResult)
    {
        Alert('Tiket berhasil dipesan, silahkan konfirmasi pembayaran');
        //Redirect($url);
        Redirect('../beli');
    }
    else
    {
        Alert('Tiket gagal dipesan, silahkan coba lagi');
    }

}

if (isset($_POST['konfirmasi']))
{
    Redirect('../konfirmasi');
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
    <table>
        <form method="post">
        <tr>
            <td>Keberangkatan :</td>
            <td><input type="text" name="keberangkatan" value="<?php if (isset($idKeberangkatan)) echo $idKeberangkatan;  ?>" readonly></td>
        </tr>
        <tr>
            <td>Nama Penumpang :</td>
            <td><input type="text" name="namaPenumpang" ></td>
        </tr>
        <tr>
            <td>Nomor Identitas :</td>
            <td><input type="text" name="noIdentitas"></td>
        </tr>
        <tr>
            <td>Kursi :</td>
            <td><select name="kursi">

                <option disabled selected>Pilih Kursi</option>

                <?php
                
                    $queryResult = SelectQuery("kursi");


                    while ($kursi = mysqli_fetch_array($queryResult))
                    {
                        ?>
                        
                        <option value="<?= $kursi['id_kursi'] ?>"><?= $kursi['nama_kursi'] ?></option>

                        <?php
                    }

                ?>

            </select></td>
        </tr>
        <tr>
            <td>Harga :</td>
            <td><input type="text" name="harga" value="<?php if (isset($harga)) echo $harga; ?>" readonly></td>
        </tr>
        </table>
        <table>
        <tr>
            <td><input type="submit" value="Pesan Tiket" name="pesan" ></td>
            <td><input type="submit" value="Konfirmasi Pembayaran" name="konfirmasi" ></td>
        </tr>
        </form>
    </table>
</body>
</html>