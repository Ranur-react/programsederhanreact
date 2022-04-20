<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// proses login
$route['login/signin'] = 'login/signin';

// proses registrasi
$route['registrasi'] = 'auth/registrasi';
$route['registrasi/signup-level'] = 'auth/registrasi/signup_level';
$route['registrasi/signup-gudang'] = 'auth/registrasi/signup_gudang';
$route['registrasi/signup'] = 'auth/registrasi/signup';

// proses logout
$route['logout'] = 'auth/logout';

/** Menu Kontak
 * Sub Menu Pemasok
 */
$route['pemasok'] = 'master/pemasok';
$route['pemasok/data'] = 'master/pemasok/data';
$route['pemasok/create'] = 'master/pemasok/create';
$route['pemasok/store'] = 'master/pemasok/store';
$route['pemasok/edit'] = 'master/pemasok/edit';
$route['pemasok/update'] = 'master/pemasok/update';
$route['pemasok/destroy'] = 'master/pemasok/destroy';
/** Sub Menu Pelanggan */
$route['pelanggan'] = 'master/pelanggan';
$route['pelanggan/data'] = 'master/pelanggan/data';
$route['pelanggan/detail/(:num)'] = 'master/pelanggan/detail/$1';

/** Menu Katalog
 * Sub Menu Satuan
 */
$route['satuan'] = 'katalog/satuan';
$route['satuan/data'] = 'katalog/satuan/data';
$route['satuan/create'] = 'katalog/satuan/create';
$route['satuan/store'] = 'katalog/satuan/store';
$route['satuan/edit'] = 'katalog/satuan/edit';
$route['satuan/update'] = 'katalog/satuan/update';
$route['satuan/destroy'] = 'katalog/satuan/destroy';
$route['satuan/satuan_by_nama'] = 'katalog/satuan/satuan_by_nama';
/** Sub Menu Konversi Satuan */
$route['konversi-satuan'] = 'katalog/konversi';
$route['konversi-satuan/data'] = 'katalog/konversi/data';
$route['konversi-satuan/create'] = 'katalog/konversi/create';
$route['konversi-satuan/store'] = 'katalog/konversi/store';
$route['konversi-satuan/edit'] = 'katalog/konversi/edit';
$route['konversi-satuan/update'] = 'katalog/konversi/update';
$route['konversi-satuan/destroy'] = 'katalog/konversi/destroy';
/** Sub Menu Kategori */
$route['kategori'] = 'katalog/kategori';
$route['kategori/data'] = 'katalog/kategori/data';
$route['kategori/create'] = 'katalog/kategori/create';
$route['kategori/store'] = 'katalog/kategori/store';
$route['kategori/edit'] = 'katalog/kategori/edit';
$route['kategori/update'] = 'katalog/kategori/update';
$route['kategori/destroy'] = 'katalog/kategori/destroy';
$route['kategori/kategori_by_nama'] = 'katalog/kategori/kategori_by_nama';
/** Sub Menu Produk */
$route['produk'] = 'katalog/produk';
$route['produk/data'] = 'katalog/produk/data';
$route['produk/create'] = 'katalog/produk/create';
$route['produk/store'] = 'katalog/produk/store';
$route['produk/edit/(:num)'] = 'katalog/produk/edit/$1';
$route['produk/update'] = 'katalog/produk/update';
$route['produk/destroy'] = 'katalog/produk/destroy';
$route['produk/get-satuan'] = 'katalog/produk/get_satuan';
/** Sub Menu Produk 
 * Upload Gambar Produk
 */
$route['produk/data-gambar'] = 'katalog/produk/data_gambar';
$route['produk/create-gambar'] = 'katalog/produk/create_gambar';
$route['produk/store-gambar'] = 'katalog/produk/store_gambar';
$route['produk/destroy-gambar'] = 'katalog/produk/destroy_gambar';
/** Sub Menu Harga Jual */
$route['harga'] = 'katalog/harga';
$route['harga/data'] = 'katalog/harga/data';
$route['harga/rekap/(:num)'] = 'katalog/harga/rekap/$1';
$route['harga/detail'] = 'katalog/harga/detail';
$route['harga/data-harga'] = 'katalog/harga/data_harga';
$route['harga/edit'] = 'katalog/harga/edit';
$route['harga/update'] = 'katalog/harga/update';
/** Sub Menu Stok Produk */
$route['stok-produk'] = 'katalog/stok';
$route['stok-produk/data'] = 'katalog/stok/data';
$route['stok-produk/rekap/(:num)'] = 'katalog/stok/rekap/$1';

/** Menu Pembelian
 * Sub Menu Permintaan
 */
$route['permintaan'] = 'pembelian/permintaan/permintaan';
$route['permintaan/data'] = 'pembelian/permintaan/permintaan/data';
$route['permintaan/create'] = 'pembelian/permintaan/permintaan/create';
$route['permintaan/store'] = 'pembelian/permintaan/permintaan/store';
$route['permintaan/edit/(:num)'] = 'pembelian/permintaan/permintaan/edit/$1';
$route['permintaan/update'] = 'pembelian/permintaan/permintaan/update';
$route['permintaan/detail/(:num)'] = 'pembelian/permintaan/permintaan/detail/$1';
$route['permintaan/view'] = 'pembelian/permintaan/permintaan/view';
$route['permintaan/destroy'] = 'pembelian/permintaan/permintaan/destroy';
$route['permintaan/print/(:num)'] = 'pembelian/permintaan/permintaan/print/$1';
/** Tmp Tambah Permintaan */
$route['permintaan/tmp-create/data'] = 'pembelian/permintaan/tmp_create/data';
$route['permintaan/tmp-create/create'] = 'pembelian/permintaan/tmp_create/create';
$route['permintaan/tmp-create/store'] = 'pembelian/permintaan/tmp_create/store';
$route['permintaan/tmp-create/edit'] = 'pembelian/permintaan/tmp_create/edit';
$route['permintaan/tmp-create/update'] = 'pembelian/permintaan/tmp_create/update';
$route['permintaan/tmp-create/destroy'] = 'pembelian/permintaan/tmp_create/destroy';
$route['permintaan/tmp-create/batal'] = 'pembelian/permintaan/tmp_create/batal';
/** Tmp Edit Permintaan */
$route['permintaan/tmp-edit/data'] = 'pembelian/permintaan/tmp_edit/data';
$route['permintaan/tmp-edit/create'] = 'pembelian/permintaan/tmp_edit/create';
$route['permintaan/tmp-edit/store'] = 'pembelian/permintaan/tmp_edit/store';
$route['permintaan/tmp-edit/edit'] = 'pembelian/permintaan/tmp_edit/edit';
$route['permintaan/tmp-edit/update'] = 'pembelian/permintaan/tmp_edit/update';
$route['permintaan/tmp-edit/destroy'] = 'pembelian/permintaan/tmp_edit/destroy';
$route['permintaan/tmp-edit/batal'] = 'pembelian/permintaan/tmp_edit/batal';

/** Menu Pembelian
 * Sub Menu Penerimaan
 */
$route['penerimaan'] = 'pembelian/penerimaan/penerimaan';
$route['penerimaan/data'] = 'pembelian/penerimaan/penerimaan/data';
$route['penerimaan/create'] = 'pembelian/penerimaan/penerimaan/create';
$route['penerimaan/store'] = 'pembelian/penerimaan/penerimaan/store';
$route['penerimaan/edit/(:num)'] = 'pembelian/penerimaan/penerimaan/edit/$1';
$route['penerimaan/detail/(:num)'] = 'pembelian/penerimaan/penerimaan/detail/$1';
$route['penerimaan/update'] = 'pembelian/penerimaan/penerimaan/update';
$route['penerimaan/view'] = 'pembelian/penerimaan/penerimaan/view';
$route['penerimaan/destroy'] = 'pembelian/penerimaan/penerimaan/destroy';
/** Data Permintaan */
$route['penerimaan/tmp-permintaan'] = 'pembelian/penerimaan/tmp_permintaan';
$route['penerimaan/tmp-permintaan/data'] = 'pembelian/penerimaan/tmp_permintaan/data';
$route['penerimaan/tmp-permintaan/show'] = 'pembelian/penerimaan/tmp_permintaan/show';
// $route['penerimaan/tmp-edit/check-permintaan'] = 'pembelian/penerimaan/tmp_edit/check_permintaan';
/** Tmp Tambah Penerimaan */
$route['penerimaan/tmp-create/data'] = 'pembelian/penerimaan/tmp_create/data';
$route['penerimaan/tmp-create/create'] = 'pembelian/penerimaan/tmp_create/create';
$route['penerimaan/tmp-create/store'] = 'pembelian/penerimaan/tmp_create/store';
$route['penerimaan/tmp-create/edit'] = 'pembelian/penerimaan/tmp_create/edit';
$route['penerimaan/tmp-create/update'] = 'pembelian/penerimaan/tmp_create/update';
$route['penerimaan/tmp-create/destroy'] = 'pembelian/penerimaan/tmp_create/destroy';
$route['penerimaan/tmp-create/batal'] = 'pembelian/penerimaan/tmp_create/batal';
/** Tmp Edit Penerimaan */
$route['penerimaan/tmp-edit/data'] = 'pembelian/penerimaan/tmp_edit/data';
$route['penerimaan/tmp-edit/create'] = 'pembelian/penerimaan/tmp_edit/create';
$route['penerimaan/tmp-edit/store'] = 'pembelian/penerimaan/tmp_edit/store';
$route['penerimaan/tmp-edit/edit'] = 'pembelian/penerimaan/tmp_edit/edit';
$route['penerimaan/tmp-edit/update'] = 'pembelian/penerimaan/tmp_edit/update';
$route['penerimaan/tmp-edit/destroy'] = 'pembelian/penerimaan/tmp_edit/destroy';
// Pelunasan Penerimaan
$route['penerimaan/pelunasan/(:num)'] = 'pembelian/penerimaan/pelunasan/index/$1';
$route['penerimaan/pelunasan/data'] = 'pembelian/penerimaan/pelunasan/data';
$route['penerimaan/pelunasan/create'] = 'pembelian/penerimaan/pelunasan/create';
$route['penerimaan/pelunasan/store'] = 'pembelian/penerimaan/pelunasan/store';
$route['penerimaan/pelunasan/destroy'] = 'pembelian/penerimaan/pelunasan/destroy';

// Pesanan
$route['pesanan'] = 'penjualan/pesanan/pesanan';
$route['pesanan/data'] = 'penjualan/pesanan/pesanan/data';
$route['pesanan/create'] = 'penjualan/pesanan/pesanan/create';
$route['pesanan/store'] = 'penjualan/pesanan/pesanan/store';
$route['pesanan/detail'] = 'penjualan/pesanan/pesanan/detail';
$route['pesanan/confirm'] = 'penjualan/pesanan/pesanan/confirm';
$route['pesanan/batal'] = 'penjualan/pesanan/pesanan/batal';
$route['pesanan/invoice/(:num)'] = 'penjualan/pesanan/pesanan/invoice/$1';

// Pesanan Tmp Create
$route['pesanan/tmp-create'] = 'penjualan/pesanan/tmp_create';
$route['pesanan/tmp-create/create'] = 'penjualan/pesanan/tmp_create/create';
$route['pesanan/tmp-create/get-penerimaan'] = 'penjualan/pesanan/tmp_create/get_penerimaan';
$route['pesanan/tmp-create/get-harga'] = 'penjualan/pesanan/tmp_create/get_harga';
$route['pesanan/tmp-create/store'] = 'penjualan/pesanan/tmp_create/store';
$route['pesanan/tmp-create/destroy'] = 'penjualan/pesanan/tmp_create/destroy';
$route['pesanan/tmp-create/get-alamat'] = 'penjualan/pesanan/tmp_create/get_alamat';
$route['pesanan/tmp-create/get-bank'] = 'penjualan/pesanan/tmp_create/get_bank';

// Pembayaran
$route['pembayaran/confirm'] = 'penjualan/pembayaran/confirm';
$route['pembayaran/store'] = 'penjualan/pembayaran/store';
$route['pembayaran/detail'] = 'penjualan/pembayaran/detail';
$route['pembayaran/approve'] = 'penjualan/pembayaran/approve';
$route['pembayaran/batal'] = 'penjualan/pembayaran/batal';

// Pengiriman
$route['pengiriman'] = 'penjualan/pengiriman';
$route['pengiriman/data'] = 'penjualan/pengiriman/data';
$route['pengiriman/create'] = 'penjualan/pengiriman/create';
$route['pengiriman/store'] = 'penjualan/pengiriman/store';
$route['pengiriman/terima'] = 'penjualan/pengiriman/terima';
$route['pengiriman/storeterima'] = 'penjualan/pengiriman/storeterima';

$route['upload'] = 'master/UploadImages';
$route['browse'] = 'master/UploadImages/choseImages';
$route['insert'] = 'master/UploadImages/insertImages';
$route['delete'] = 'master/UploadImages/delteImages';

/** Menu Pengaturan
 * Sub Menu Pengguna
 */
$route['pengguna'] = 'master/pengguna';
$route['pengguna/data'] = 'master/pengguna/data';
$route['pengguna/create'] = 'master/pengguna/create';
$route['pengguna/get_gudang'] = 'master/pengguna/get_gudang';
$route['pengguna/store'] = 'master/pengguna/store';
$route['pengguna/edit'] = 'master/pengguna/edit';
$route['pengguna/update'] = 'master/pengguna/update';
$route['pengguna/destroy'] = 'master/pengguna/destroy';
$route['pengguna/status-pengguna'] = 'master/pengguna/status_pengguna';
$route['pengguna/generate-api'] = 'master/pengguna/generate_api';
/** Sub Menu Hak Akses */
$route['roles'] = 'master/roles';
$route['roles/data'] = 'master/roles/data';
$route['roles/create'] = 'master/roles/create';
$route['roles/store'] = 'master/roles/store';
$route['roles/edit'] = 'master/roles/edit';
$route['roles/update'] = 'master/roles/update';
$route['roles/destroy'] = 'master/roles/destroy';
/** Sub Menu Rekening */
$route['rekening'] = 'master/rekening';
$route['rekening/data'] = 'master/rekening/data';
$route['rekening/create'] = 'master/rekening/create';
$route['rekening/store'] = 'master/rekening/store';
$route['rekening/edit'] = 'master/rekening/edit';
$route['rekening/update'] = 'master/rekening/update';
$route['rekening/destroy'] = 'master/rekening/destroy';
$route['rekening/status/(:num)'] = 'master/rekening/status/$1';
/** Sub Menu Gudang */
$route['gudang'] = 'master/gudang';
$route['gudang/data'] = 'master/gudang/data';
$route['gudang/create'] = 'master/gudang/create';
$route['gudang/store'] = 'master/gudang/store';
$route['gudang/edit'] = 'master/gudang/edit';
$route['gudang/update'] = 'master/gudang/update';
$route['gudang/destroy'] = 'master/gudang/destroy';
