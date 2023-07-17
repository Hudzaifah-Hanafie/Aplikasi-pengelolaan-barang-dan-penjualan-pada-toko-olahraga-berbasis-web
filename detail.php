<?php
require 'function.php';
require 'cekSession.php';

$id_barang = $_GET['id'];
$get = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$id_barang'");
$fetch = mysqli_fetch_assoc($get);
$nama_barang = $fetch['nama_barang'];
$kategori = $fetch['kategori'];
$harga = $fetch['harga'];
$jumlah_barang = $fetch['jumlah_barang'];
$gambar = $fetch['gambar'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Detail Barang</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .zoomable {
                width: 70px;
            }
            .zoomable:hover{
                transform: scale(2);
                transition: 0.3s ease;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
            <a class="navbar-brand" href="index.php">Toko Olahraga</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-archive"></i></div>
                                Data Barang
                            </a>
                            <a class="nav-link" href="penjualan.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                                Penjualan
                            </a>
                            <a class="nav-link" href="pembelian.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-handshake"></i></div>
                                Pembelian
                            </a>
                            <a class="nav-link" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-user-circle"></i></div>
                                Kelola Admin
                            </a>
                            <a class="nav-link" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Riwayat Transaksi</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <?= $nama_barang; ?>
                                <?php 
                                    if ($gambar == null) {
                                        $img = "Foto";
                                    } else {
                                        $img = "<img src='images/" . $gambar . "' class='zoomable'>";
                                    }
                                    echo $img; 
                                ?>
                            </div>
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-md-3">Kategori</div>
                                    <div class="col-md-9">: <?= $kategori; ?></div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-3">Harga</div>
                                    <div class="col-md-9">: <?= $harga; ?></div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-3">Jumlah Barang</div>
                                    <div class="col-md-9">: <?= $jumlah_barang; ?></div>
                                </div>

                                <br><br><hr>
                                
                                <h3>Pembelian</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTablePembelian" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Jumlah Barang</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $i=1;
                                            $ambildatapembelian = mysqli_query($conn, "SELECT * FROM pembelian WHERE id_barang='$id_barang'");
                                            while($fetch = mysqli_fetch_array($ambildatapembelian)) {
                                                $tanggal = $fetch['tanggal'];
                                                $jumlah_barang = $fetch['jumlah_barang'];
                                            ?>

                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $tanggal; ?></td>
                                                <td><?= $jumlah_barang; ?></td>
                                            </tr>

                                            <?php 
                                            $i++;
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>

                                <br><br><hr>

                                <h3>Penjualan</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTablePenjualan" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Jumlah Barang</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $i=1;
                                            $ambildatapenjualan = mysqli_query($conn, "SELECT * FROM penjualan WHERE id_barang='$id_barang'");
                                            while($fetch = mysqli_fetch_array($ambildatapenjualan)) {
                                                $tanggal = $fetch['tanggal'];
                                                $jumlah_barang = $fetch['jumlah_barang'];
                                            ?>

                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $tanggal; ?></td>
                                                <td><?= $jumlah_barang; ?></td>
                                            </tr>

                                            <?php 
                                            $i++;
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Tambah Barang</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="text" name="nama_barang" placeholder="Nama Barang" class="form-control">
                    <br>
                    <input type="text" name="kategori" placeholder="Kategori" class="form-control">
                    <br>
                    <input type="number" name="harga" placeholder="Harga" class="form-control">
                    <br>
                    <input type="number" name="jumlah_barang" placeholder="Stock" class="form-control">
                    <br>
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button type="submit" class="btn btn-primary" name="submitBarangBaru">Submit</button>
                </div>
            </form>
            
        </div>
        </div>
    </div>

</html>
