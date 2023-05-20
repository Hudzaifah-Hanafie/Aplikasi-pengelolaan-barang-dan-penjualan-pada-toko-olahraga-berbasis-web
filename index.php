<?php
require 'function.php';
require 'cekSession.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Data Barang</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .zoomable {
                width: 100px;
            }
            .zoomable:hover{
                transform: scale(2);
                transition: 0.3s ease;
            }
            a{
                text-decoration: none;
                color: black;
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
                        <h1 class="mt-4">Data Barang</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col text-right">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                            <i class="fa-solid fa-file-circle-plus"></i>
                                            Tambah Barang
                                        </button>
                                        <a href="export.php" class="btn btn-info"><i class="fa-solid fa-file-export"></i> Report Data</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                <?php
                                    $ambildatastock = mysqli_query($conn, "SELECT * FROM barang WHERE jumlah_barang < 1");
                                    while($fetch = mysqli_fetch_array($ambildatastock)) {
                                        $barang = $fetch['nama_barang'];
                                    
                                ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Perhatian!</strong> Stock <?= $barang; ?> telah habis.
                                </div>
                                <?php
                                    }
                                ?>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Gambar</th>
                                                <th>Nama Barang</th>
                                                <th>Kategori</th>
                                                <th>Harga</th>
                                                <th>Stock</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $ambilDataBarang = mysqli_query($conn, "SELECT * FROM barang");
                                            $i=1;
                                            while($data=mysqli_fetch_array($ambilDataBarang)){
                                                $gambar = $data['gambar'];
                                                if ($gambar == null) {
                                                    $img = "Foto";
                                                } else {
                                                    $img = "<img src='images/" . $gambar . "' class='zoomable'>";
                                                }
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

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?= $data['id_barang']; ?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Edit Barang</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <form action="" method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type="text" name="nama_barang" value="<?= $data['nama_barang']; ?>" placeholder="Nama Barang" class="form-control">
                                                            <br>
                                                            <input type="text" name="kategori" value="<?= $data['kategori']; ?>" placeholder="Kategori" class="form-control">
                                                            <br>
                                                            <input type="number" name="harga" value="<?= $data['harga']; ?>" placeholder="Harga" class="form-control">
                                                            <br>
                                                            <input type="number" name="jumlah_barang" value="<?= $data['jumlah_barang']; ?>" placeholder="Jumlah Barang" class="form-control">
                                                            <br>
                                                            <input type="file" name="file" class="form control">
                                                            <br>
                                                            <input type="hidden" name="id_barang" value="<?= $data['id_barang']; ?>">
                                                            <button type="submit" class="btn btn-primary" name="updateBarang">Submit</button>
                                                        </div>
                                                    </form>
                                                    
                                                </div>
                                                </div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?= $data['id_barang']; ?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Delete Barang</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <form action="" method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingi menghapus <?= $data['nama_barang']; ?> ?
                                                            <input type="hidden" name="id_barang" value="<?= $data['id_barang']; ?>">
                                                            <br><br>
                                                            <button type="submit" class="btn btn-danger" name="deleteBarang">Hapus</button>
                                                        </div>
                                                    </form>
                                                    
                                                </div>
                                                </div>
                                            </div>

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
