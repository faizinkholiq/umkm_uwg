-- Update Pelanggan
ALTER TABLE `pelanggan` DROP `keterangan`;
ALTER TABLE `pelanggan` ADD `tipe` TINYINT(1) NULL AFTER `telepon`;
CREATE TABLE `umkm_db`.`tipe_pelanggan` ( `id` INT NOT NULL AUTO_INCREMENT , `nama` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
INSERT INTO `tipe_pelanggan` (`id`, `nama`) VALUES (NULL, 'Konsumen'), (NULL, 'Reseller'), (NULL, 'Agen'), (NULL, 'Dropshiper'), (NULL, 'Distributor')

-- Tipe Produk
ALTER TABLE `produk` DROP `harga`;
CREATE TABLE `umkm_db`.`tipe_produk_pelanggan` ( `id` INT NOT NULL AUTO_INCREMENT , `produk` INT NOT NULL , `tipe` TINYINT(1) NOT NULL , `harga` DOUBLE NOT NULL , `diskon` DOUBLE NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

-- Transaksi
ALTER TABLE `transaksi` DROP `diskon`;
ALTER TABLE `transaksi` DROP `barcode`;
ALTER TABLE `transaksi` DROP `qty`;
CREATE TABLE `umkm_db`.`transaksi_item` ( `id` INT NOT NULL AUTO_INCREMENT , `transaksi_id` INT NOT NULL , `produk_id` INT NOT NULL , `qty` INT(5) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

-- Utang Piutang
CREATE TABLE `umkm_db`.`transaksi_utang` ( `id` INT NOT NULL AUTO_INCREMENT , `transaksi_id` INT NOT NULL , `hutang` DOUBLE NOT NULL , `status` ENUM('Lunas','Belum Lunas') NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `umkm_db`.`transaksi_cicilan` ( `id` INT NOT NULL AUTO_INCREMENT , `utang_id` INT NOT NULL, `tanggal` DATETIME NOT NULL , `trans_terakhir` DOUBLE NOT NULL , `sisa` DOUBLE NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

-- Role Pengguna
CREATE TABLE `umkm_db`.`role_pengguna` ( `id` INT NOT NULL AUTO_INCREMENT , `nama` VARCHAR(20) NOT NULL , `deskripsi` TEXT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
INSERT INTO `role_pengguna` (`id`, `nama`, `deskripsi`) VALUES ('1', 'Admin', 'Memiliki hak akses untuk mengelola seluruh pengguna toko'), ('2', 'Admin Toko', 'Hanya memiliki akses untuk toko yang terkait'), ('3', 'Kasir', 'Hanya memiliki hak akses untuk mengelola transaksi di toko yang terkait')
-- Toko
ALTER TABLE `pengguna` ADD `toko_id` INT NULL;
ALTER TABLE `pelanggan` ADD `toko_id` INT NULL;
ALTER TABLE `produk` ADD `toko_id` INT NULL;
ALTER TABLE `stok_keluar` ADD `toko_id` INT NULL;
ALTER TABLE `stok_masuk` ADD `toko_id` INT NULL;
ALTER TABLE `supplier` ADD `toko_id` INT NULL;
ALTER TABLE `tipe_produk_pelanggan` ADD `toko_id` INT NULL;
ALTER TABLE `transaksi` ADD `toko_id` INT NULL;
ALTER TABLE `transaksi_cicilan` ADD `toko_id` INT NULL;
ALTER TABLE `transaksi_item` ADD `toko_id` INT NULL;
ALTER TABLE `transaksi_utang` ADD `toko_id` INT NULL;

-- Ongkir
ALTER TABLE `transaksi` ADD `ongkir` DOUBLE NULL AFTER `jumlah_uang`;

-- Harga Stok Masuk
ALTER TABLE `stok_masuk` ADD `harga` DOUBLE NULL AFTER `jumlah`;
