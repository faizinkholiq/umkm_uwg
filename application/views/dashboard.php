<?php 
$role = $this->session->userdata('role'); 
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <?php $this->load->view('partials/head'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php $this->load->view('includes/nav'); ?>

  <?php $this->load->view('includes/aside'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 text-dark"><?=($role!=1)? 'Dashboard' : 'Welcome Super Admin' ?></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


    <!-- /.content-header -->

    <?php if($role != 1): ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4 col-sm-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3 id="transaksi_hari">0</h3>
                <p>Transaksi Hari Ini</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <a href="<?php echo site_url('laporan_penjualan') ?>" class="small-box-footer">
                More Info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 id="transaksi_terakhir">0</h3>
                <p>Produk Transaksi Terakhir</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-bill"></i>
              </div>
              <a href="<?php echo site_url('laporan_penjualan') ?>" class="small-box-footer">
                More Info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3 id="stok_hari">0</h3>
                <p>Stok Masuk Hari Ini</p>
              </div>
              <div class="icon">
                <i class="fas fa-archive"></i>
              </div>
              <a href="<?php echo site_url('laporan_stok_masuk') ?>" class="small-box-footer">
                More Info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <div class="col-12 row">
            <h1 class="mt-2 mb-3 h2 text-dark col-md-6">Grafik</h1>
            <div class="col-md-6 pull-right" style="gap: 10px; display: flex; align-items: center;">
              <form id="form-filter" style="display: contents;">
                <select name="tahun" id="select-tahun" class="form-control" style="width:150px">
                    <?php
                      $year = !empty($_GET["tahun"])? $_GET["tahun"] : date("Y");
                      for($i=2020; $i<=date("Y"); $i++){
                        $selected = ($i == $year)? "selected" : "";
                        echo "<option $selected value='$i'>$i</option>";
                      }
                    ?>
                </select>
                <select name="bulan" id="select-bulan" class="form-control" style="width:200px">
                    <?php
                      $bulan = [
                        "Januari",
                        "Februari",
                        "Maret",
                        "April",
                        "Mei",
                        "Juni",
                        "Juli",
                        "Agustus",
                        "September",
                        "Oktober",
                        "November",
                        "Desember"
                      ];

                      $month = !empty($_GET["bulan"])? $_GET["bulan"] : date("m");
                      for($i=1; $i<=12; $i++){
                        $val = str_pad($i, 2, '0', STR_PAD_LEFT);
                        $selected = ($val == $month)? "selected" : "";
                        echo "<option $selected value='$val'>".$bulan[$i-1]."</option>";
                      }
                    ?>
                </select>
                <select name="hari" id="select-hari" class="form-control" style="width:150px">
                    <option value="all">All</option>
                    <?php
                      $day = !empty($_GET["hari"])? $_GET["hari"] : date("d");
                      for($i=1; $i<=31; $i++){
                        $val = str_pad($i, 2, '0', STR_PAD_LEFT);
                        $selected = ($val == $day)? "selected" : "";
                        echo "<option $selected value='$val'>$val</option>";
                      }
                    ?>
                </select>
                <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
              </form>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Produk Terlaris</h3>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="produkTerlaris" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Stok Produk</h3>
              </div>
              <div class="card-body">
                <div class="chart" style="height: 250px;max-height: 250px; overflow-y: scroll;">
                  <ul class="list-group" id="stok_produk"></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Penjualan Bulan Ini</h3> 
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="bulanIni" style="min-height: 250px; height: 450px; max-height: 450px; max-width: 100%"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <?php endif; ?>
  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<?php $this->load->view('includes/footer'); ?>

<?php $this->load->view('partials/footer'); ?>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/chart.js/Chart.min.js') ?>"></script>
<script>
  var transaksi_hariUrl = '<?php echo site_url('transaksi/transaksi_hari') ?>';
  var transaksi_terakhirUrl = '<?php echo site_url('transaksi/transaksi_terakhir') ?>';
  var stok_hariUrl = '<?php echo site_url('stok_masuk/stok_hari') ?>';
  var produk_terlarisUrl = '<?php echo site_url('produk/produk_terlaris') ?>';
  var data_stokUrl = '<?php echo site_url('produk/data_stok') ?>';
  var penjualan_bulanUrl = '<?php echo site_url('transaksi/penjualan_bulan') ?>';
  var year = '<?php echo !empty($_GET["tahun"])? $_GET["tahun"] : date("Y"); ?>';
  var month = '<?php echo !empty($_GET["bulan"])? $_GET["bulan"] : date("m"); ?>';
  var day = '<?php echo !empty($_GET["hari"])? $_GET["hari"] : date("d"); ?>';
</script>
<script src="<?php echo base_url('assets/js/unminify/dashboard.js') ?>"></script>
</body>
</html>
