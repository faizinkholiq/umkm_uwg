<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurnal_laba_rugi_model extends CI_Model {

    public function read()
	{
        $q = $this->db->query("
            ( SELECT 
                transaksi.id,
                produk.id produk_id,
                DATE_FORMAT(transaksi.tanggal, '%d-%m-%Y') tanggal,
                produk.barcode, 
                transaksi.nota, 
                produk.nama_produk sell_produk, 
                transaksi_item.qty sell_qty,  
                ((SELECT 
                    harga FROM tipe_produk_pelanggan 
                    WHERE pelanggan = transaksi.pelanggan 
                        AND produk.id = tipe_produk_pelanggan.produk 
                LIMIT 1) * transaksi_item.qty) sell_harga,
                NULL buy_produk, 
                NULL buy_qty,  
                NULL buy_harga,
                ((SELECT 
                    harga FROM tipe_produk_pelanggan 
                    WHERE pelanggan = transaksi.pelanggan 
                        AND produk.id = tipe_produk_pelanggan.produk 
                LIMIT 1) * transaksi_item.qty) debet,
                0 kredit
                FROM transaksi
                LEFT JOIN transaksi_item ON transaksi.id = transaksi_item.transaksi_id
                LEFT JOIN produk ON transaksi_item.produk_id = produk.id
                WHERE produk.nama_produk IS NOT NULL
                GROUP BY transaksi.id, produk.id
            ) UNION (
                SELECT 
                stok_masuk.id,
                produk.id produk_id,
                DATE_FORMAT(stok_masuk.tanggal, '%d-%m-%Y') tanggal,
                produk.barcode, 
                NULL nota, 
                NULL sell_produk, 
                NULL sell_qty,  
                NULL sell_harga,
                produk.nama_produk buy_produk,
                stok_masuk.jumlah buy_jumlah,
                stok_masuk.harga buy_harga,
                0 debet,
                (stok_masuk.harga * stok_masuk.jumlah) kredit
                FROM stok_masuk
                LEFT JOIN produk ON produk.id = stok_masuk.barcode
                WHERE produk.nama_produk IS NOT NULL
                GROUP BY stok_masuk.id, produk.id
            ) ORDER BY tanggal DESC, id DESC, produk_id ASC
        ");

        return $q->result_array();
    }

}