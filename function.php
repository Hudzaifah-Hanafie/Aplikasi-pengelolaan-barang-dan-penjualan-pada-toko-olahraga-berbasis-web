<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "toko_olahraga");

if (isset($_POST['submitBarangBaru'])) {
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $jumlah_barang = $_POST['jumlah_barang'];

    $allowed_extension = array('png', 'jpg', 'jpeg');
    $nama_file = $_FILES['file']['name'];
    $dot = explode('.', $nama_file);
    $extension = strtolower(end($dot));
    $ukuran = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];

    $image = md5(uniqid($nama_file,true) . time()) . '.' . $extension;

    if (in_array($extension, $allowed_extension) === true) {
        if ($ukuran < 15000000) {
            move_uploaded_file($file_tmp, 'images/'.$image);
            $addToTable = mysqli_query($conn, "INSERT INTO barang (nama_barang, kategori, harga, jumlah_barang, gambar) VALUES ('$nama_barang', '$kategori', '$harga', '$jumlah_barang', '$image')");
            if ($addToTable) {
                header('location:index.php');
            } else {
                header('location:index.php');
            }
        } else {
            echo "
        <script>
            alert('Ukuran file terlalu besar');
            window.location.href='index.php';
        </script>
        ";
        }
    } else {
        echo "
        <script>
            alert('File yg di input harus berekstensi png/jpg/jpeg');
            window.location.href='index.php';
        </script>
        ";
    }
}

if (isset($_POST['updateBarang'])) {
    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $jumlah_barang = $_POST['jumlah_barang'];

    $allowed_extension = array('png', 'jpg', 'jpeg');
    $nama_file = $_FILES['file']['name'];
    $dot = explode('.', $nama_file);
    $extension = strtolower(end($dot));
    $ukuran = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];

    $image = md5(uniqid($nama_file,true) . time()) . '.' . $extension;

    if ($ukuran == 0) {
        $update = mysqli_query($conn, "UPDATE barang SET nama_barang='$nama_barang', kategori='$kategori', harga='$harga', jumlah_barang='$jumlah_barang' WHERE id_barang='$id_barang'");
    
        if ($update) {
            header('location:index.php');
        } else {
            header('location:index.php');
        }
    } else {
        move_uploaded_file($file_tmp, 'images/'.$image);
        $update = mysqli_query($conn, "UPDATE barang SET nama_barang='$nama_barang', kategori='$kategori', harga='$harga', jumlah_barang='$jumlah_barang', gambar='$image' WHERE id_barang='$id_barang'");
    
        if ($update) {
            header('location:index.php');
        } else {
            header('location:index.php');
        }
    }
}

if (isset($_POST['deleteBarang'])) {
    $id_barang = $_POST['id_barang'];

    $gambar = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$id_barang'");
    $get = mysqli_fetch_array($gambar);
    $img = 'images/' . $get['gambar'];
    unlink($img);

    $delete = mysqli_query($conn, "DELETE FROM barang WHERE id_barang='$id_barang'");
    
    if ($delete) {
        header('location:index.php');
    } else {
        header('location:index.php');
    }
}

// Menambah pembelian barang
if(isset($_POST['beliBarang'])) {
    $id_barang = $_POST['id_barang'];
    $jumlah_barang = $_POST['jumlah_barang'];

    $cekStockSekarang = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang = '$id_barang'");
    $ambilDatanya = mysqli_fetch_array($cekStockSekarang);

    $nama_barang = $ambilDatanya['nama_barang'];
    $stockSekarang  = $ambilDatanya['jumlah_barang'];
    $tambahkanStockSekarangDenganJumlahBarang = $stockSekarang + $jumlah_barang;
    $tanggal = date("Y-m-d");
    $addToBeli = mysqli_query($conn, "INSERT INTO pembelian (id_barang, nama_barang, tanggal, jumlah_barang) VALUES ('$id_barang', '$nama_barang', '$tanggal', '$jumlah_barang')");
    $updateStockBeli = mysqli_query($conn, "UPDATE barang SET jumlah_barang='$tambahkanStockSekarangDenganJumlahBarang' WHERE id_barang='$id_barang'");

    if ($updateStockBeli) {
        header('location:pembelian.php');
    } else {
        header('location:pembelian.php');
    }   
}

// Menambah penjualan barang
if(isset($_POST['jualBarang'])) {
    $id_barang = $_POST['id_barang'];
    $jumlah_barang = $_POST['jumlah_barang'];

    $cekStockSekarang = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang = '$id_barang'");
    $ambilDatanya = mysqli_fetch_array($cekStockSekarang);

    $nama_barang = $ambilDatanya['nama_barang'];
    $stockSekarang  = $ambilDatanya['jumlah_barang'];
    $tanggal = date("Y-m-d");
    if($stockSekarang >= $jumlah_barang) {
        $kurangkanStockSekarangDenganJumlahBarang = $stockSekarang - $jumlah_barang;

        $addToJual = mysqli_query($conn, "INSERT INTO penjualan (id_barang, nama_barang, tanggal, jumlah_barang) VALUES ('$id_barang', '$nama_barang', '$tanggal', '$jumlah_barang')");
        $updateStockBeli = mysqli_query($conn, "UPDATE barang SET jumlah_barang='$kurangkanStockSekarangDenganJumlahBarang' WHERE id_barang='$id_barang'");

        if ($updateStockBeli) {
            header('location:penjualan.php');
        } else {
            header('location:penjualan.php');
        }
    } else {
        echo "
        <script>
            alert('Stock saat ini tidak mencukupi');
            window.location.href='penjualan.php';
        </script>
        ";
    }  
}

if (isset($_POST['updateBeli'])) {
    $id_pembelian = $_POST['id_pembelian'];
    $nama_barang = $_POST['nama_barang'];
    $tanggal = $_POST['tanggal'];
    $jumlah_barang = $_POST['jumlah_barang'];

    $update = mysqli_query($conn, "UPDATE pembelian SET nama_barang='$nama_barang', tanggal='$tanggal', jumlah_barang='$jumlah_barang' WHERE id_pembelian='$id_pembelian'");

    if ($update) {
        header('location:index.php');
    } else {
        header('location:index.php');
    }
}

if (isset($_POST['deleteBeli'])) {
    $id_pembelian = $_POST['id_pembelian'];

    $delete = mysqli_query($conn, "DELETE FROM pembelian WHERE id_pembelian='$id_pembelian'");
    
    if ($delete) {
        header('location:index.php');
    } else {
        header('location:index.php');
    }
}

if (isset($_POST['updateJual'])) {
    $id_penjualan = $_POST['id_penjualan'];
    $nama_barang = $_POST['nama_barang'];
    $tanggal = $_POST['tanggal'];
    $jumlah_barang = $_POST['jumlah_barang'];

    $updateJual = mysqli_query($conn, "UPDATE penjualan SET nama_barang='$nama_barang', tanggal='$tanggal', jumlah_barang='$jumlah_barang' WHERE id_penjualan='$id_penjualan'");

    if ($updateJual) {
        header('location:index.php');
    } else {
        header('location:index.php');
    }
}

if (isset($_POST['deleteJual'])) {
    $id_penjualan = $_POST['id_penjualan'];

    $delete = mysqli_query($conn, "DELETE FROM penjualan WHERE id_penjualan='$id_penjualan'");
    
    if ($delete) {
        header('location:index.php');
    } else {
        header('location:index.php');
    }
}

if(isset($_POST['submitAdminBaru'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];

    $password = md5($password);

    $queryInsertAdmin = mysqli_query($conn, "INSERT INTO admin (username, password, email, no_hp) VALUES ('$username', '$password', '$email', '$no_hp')");

    if($queryInsertAdmin) {
        header('location:admin.php');
    } else {
        header('location:admin.php');
    }
}

if(isset($_POST['updateAdmin'])) {
    $id_admin = $_POST['id_admin'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];

    $username = md5($username);
    $password = md5($password);

    $queryUpdateAdmin = mysqli_query($conn, "UPDATE admin SET username='$username', password='$password', email='$email', no_hp='$no_hp' WHERE id_admin='$id_admin'");
    if($queryUpdateAdmin) {
        header('location:admin.php');
    } else {
        header('location:admin.php');
    }
}

if(isset($_POST['deleteAdmin'])) {
    $id_admin = $_POST['id_admin'];
    $queryDeleteAdmin = mysqli_query($conn, "DELETE FROM admin WHERE id_admin='$id_admin'");
    if($queryDeleteAdmin) {
        header('location:admin.php');
    } else {
        header('location:admin.php');
    }
}

?>