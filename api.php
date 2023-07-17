<?php

$conn = mysqli_connect("localhost", "root", "", "toko_olahraga");

// Mengambil data barang dari database dan ditampilkan
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $query = "SELECT * FROM barang";
    $result = mysqli_query($conn, $query);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            array_push($data, $row);
        }
    }

    header('Content-Type: application/json');
    echo json_encode($data);
    
    mysqli_close($conn);
}

// Menyisipkan data barang ke database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = file_get_contents('php://input');
    $data = json_decode($body, true);
    
    $query = "INSERT INTO barang (nama_barang, kategori, harga, jumlah_barang) VALUES ('".$data['nama_barang']."', '".$data['kategori']."', '".$data['harga']."', '".$data['jumlah_barang']."')";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }
    
    header('Content-Type: application/json');
    echo json_encode(array('message' => 'Data berhasil ditambahkan'));
}

// Mengubah data barang yang ada di database
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    $body = file_get_contents('php://input');
    $data = json_decode($body, true);
    
    $query = "UPDATE barang SET nama_barang='".$data['nama_barang']."', kategori='".$data['kategori']."', harga='".$data['harga']."', jumlah_barang='".$data['jumlah_barang']."' 
              WHERE id_barang='".$data['id_barang']."'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }
    
    header('Content-Type: application/json');
    echo json_encode(array('message' => 'Data berhasil diperbarui'));
}

// Menghapus data barang dari database
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    $body = file_get_contents('php://input');
    $data = json_decode($body, true);
    
    $query = "DELETE FROM barang WHERE id_barang='".$data['id_barang']."'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }
    
    header('Content-Type: application/json');
    echo json_encode(array('message' => 'Data berhasil dihapus'));
}

function cari($keyword) {
    global $conn;
	$query = mysqli_query($conn, "SELECT * FROM barang WHERE nama_barang LIKE '%$keyword%' OR kategori LIKE '%$keyword%' OR harga LIKE '%$keyword%' OR jumlah_barang LIKE '%$keyword%'");
	return $query;
}

if (isset($_POST['submitBarangBaru'])) {
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $jumlah_barang = $_POST['jumlah_barang'];

    $addToTable = mysqli_query($conn, "INSERT INTO barang (nama_barang, kategori, harga, jumlah_barang) VALUES ('$nama_barang', '$kategori', '$harga', '$jumlah_barang')");
    if ($addToTable) {
        header('location:index.php');
    } else {
        header('location:index.php');
    }
}

if (isset($_POST['updateBarang'])) {
    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $jumlah_barang = $_POST['jumlah_barang'];

    $update = mysqli_query($conn, "UPDATE barang SET nama_barang='$nama_barang', kategori='$kategori', harga='$harga', jumlah_barang='$jumlah_barang' WHERE id_barang='$id_barang'");

    if ($update) {
        header('location:index.php');
    } else {
        header('location:index.php');
    }
}

if (isset($_POST['deleteBarang'])) {
    $id_barang = $_POST['id_barang'];

    $delete = mysqli_query($conn, "DELETE FROM barang WHERE id_barang='$id_barang'");
    
    if ($delete) {
        header('location:index.php');
    } else {
        header('location:index.php');
    }
}

$ambilDataBarang = mysqli_query($conn, "SELECT * FROM barang");
$i=1;
while($data=mysqli_fetch_array($ambilDataBarang)){
    ?>
    <tr>
        <td><?= $i ?></td>
        <td><?= $img ?></td>
        <td><strong><a href="detail.php?id=<?= $data['id_barang']; ?>"><?= $data['nama_barang']; ?></a></strong></td>
        <td><?= $data['kategori']; ?></td>
        <td><?= $data['harga']; ?></td>
        <td><?= $data['jumlah_barang']; ?></td>
        <td>
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $data['id_barang']; ?>">
                <i class="fa-solid fa-pen-to-square"></i>
                Edit
            </button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $data['id_barang']; ?>">
                <i class="fa-solid fa-trash"></i>
                Delete
            </button>
        </td>
    </tr>
<?php
    $i++;
}

