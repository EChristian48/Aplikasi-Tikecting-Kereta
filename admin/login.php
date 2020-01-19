<?php

    require '../scripts/functions.php';

    session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];

    $queryResult = SelectWhereQuery('pegawai', "username='$username' AND password='$password'");

    if ($queryResult)
    {
        $validation = mysqli_num_rows($queryResult);

        if ($validation == 1)
        {
            $dataPegawai = mysqli_fetch_array($queryResult);

            $_SESSION['namaPegawai'] = $dataPegawai['nama_pegawai'];
            $_SESSION['level'] = $dataPegawai['id_level'];

            Alert("Berhasil Login, selamat datang $_SESSION[namaPegawai]");
            Redirect("dashboard");
        }
        else
        {
            Alert("Salah username atau password, kamu mau jadi hecker ya");
            Redirect("../admin");
        }
    }
    else
    {
        Alert("Gagal Login, silahkan kontak admin untuk benerin aplikasinya");
    }

?>