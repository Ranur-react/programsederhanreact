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

//menu master
$route['pengguna'] = 'master/pengguna';
$route['pengguna/create'] = 'master/pengguna/create';
$route['pengguna/store'] = 'master/pengguna/store';
$route['pengguna/edit'] = 'master/pengguna/edit';
$route['pengguna/update'] = 'master/pengguna/update';
$route['pengguna/destroy'] = 'master/pengguna/destroy';
$route['pengguna/status-pengguna/(:num)'] = 'master/pengguna/status_pengguna/$1';
$route['pengguna/generate-api/(:num)'] = 'master/pengguna/generate_api/$1';

$route['supplier'] = 'master/supplier';

$route['satuan'] = 'master/satuan';
$route['satuan/create'] = 'master/satuan/create';
$route['satuan/store'] = 'master/satuan/store';
$route['satuan/edit'] = 'master/satuan/edit';
$route['satuan/update'] = 'master/satuan/update';
$route['satuan/destroy'] = 'master/satuan/destroy';
$route['satuan/satuan_by_nama'] = 'master/satuan/satuan_by_nama';

$route['kategori'] = 'master/kategori';
$route['kategori/create'] = 'master/kategori/create';
$route['kategori/store'] = 'master/kategori/store';
$route['kategori/edit'] = 'master/kategori/edit';
$route['kategori/update'] = 'master/kategori/update';
$route['kategori/destroy'] = 'master/kategori/destroy';
$route['kategori/kategori_by_nama'] = 'master/kategori/kategori_by_nama';

$route['gudang'] = 'master/gudang';
$route['gudang/create'] = 'master/gudang/create';
$route['gudang/store'] = 'master/gudang/store';
$route['gudang/edit'] = 'master/gudang/edit';
$route['gudang/update'] = 'master/gudang/update';
$route['gudang/destroy'] = 'master/gudang/destroy';

$route['barang'] = 'master/barang';
$route['barang/data'] = 'master/barang/data';
$route['barang/create'] = 'master/barang/create';
$route['barang/store'] = 'master/barang/store';
$route['barang/edit/(:num)'] = 'master/barang/edit/$1';
$route['barang/update'] = 'master/barang/update';
$route['barang/destroy'] = 'master/barang/destroy';
$route['barang/get-satuan'] = 'master/barang/get_satuan';

// katalog
$route['harga'] = 'katalog/harga';
$route['harga/data'] = 'katalog/harga/data';
$route['harga/detail'] = 'katalog/harga/detail';
$route['harga/histori/(:num)'] = 'katalog/harga/histori/$1';
$route['harga/data-terima'] = 'katalog/harga/data_terima';
$route['harga/add-satuan'] = 'katalog/harga/add_satuan';
$route['harga/edit-harga'] = 'katalog/harga/edit_harga';
$route['harga/update-harga'] = 'katalog/harga/update_harga';


// menu permintaan
$route['permintaan'] = 'pembelian/permintaan/permintaan';
$route['permintaan/data'] = 'pembelian/permintaan/permintaan/data';
$route['permintaan/create'] = 'pembelian/permintaan/permintaan/create';
$route['permintaan/store'] = 'pembelian/permintaan/permintaan/store';
$route['permintaan/edit/(:num)'] = 'pembelian/permintaan/permintaan/edit/$1';
$route['permintaan/update'] = 'pembelian/permintaan/permintaan/update';
$route['permintaan/detail/(:num)'] = 'pembelian/permintaan/permintaan/detail/$1';
$route['permintaan/info'] = 'pembelian/permintaan/permintaan/info';
$route['permintaan/destroy'] = 'pembelian/permintaan/permintaan/destroy';

$route['permintaan/tmp-create/data'] = 'pembelian/permintaan/tmp_create/data';
$route['permintaan/tmp-create/create'] = 'pembelian/permintaan/tmp_create/create';
$route['permintaan/tmp-create/store'] = 'pembelian/permintaan/tmp_create/store';
$route['permintaan/tmp-create/edit'] = 'pembelian/permintaan/tmp_create/edit';
$route['permintaan/tmp-create/update'] = 'pembelian/permintaan/tmp_create/update';
$route['permintaan/tmp-create/destroy'] = 'pembelian/permintaan/tmp_create/destroy';
$route['permintaan/tmp-create/batal'] = 'pembelian/permintaan/tmp_create/batal';

$route['permintaan/tmp-edit/data'] = 'pembelian/permintaan/tmp_edit/data';
$route['permintaan/tmp-edit/create'] = 'pembelian/permintaan/tmp_edit/create';
$route['permintaan/tmp-edit/store'] = 'pembelian/permintaan/tmp_edit/store';
$route['permintaan/tmp-edit/edit'] = 'pembelian/permintaan/tmp_edit/edit';
$route['permintaan/tmp-edit/update'] = 'pembelian/permintaan/tmp_edit/update';
$route['permintaan/tmp-edit/destroy'] = 'pembelian/permintaan/tmp_edit/destroy';
$route['permintaan/tmp-edit/batal'] = 'pembelian/permintaan/tmp_edit/batal';

// penerminaan
$route['penerimaan'] = 'pembelian/penerimaan/penerimaan';
$route['penerimaan/data'] = 'pembelian/penerimaan/penerimaan/data';
$route['penerimaan/create'] = 'pembelian/penerimaan/penerimaan/create';
$route['penerimaan/store'] = 'pembelian/penerimaan/penerimaan/store';
$route['penerimaan/edit/(:num)'] = 'pembelian/penerimaan/penerimaan/edit/$1';
$route['penerimaan/update'] = 'pembelian/penerimaan/penerimaan/update';
$route['penerimaan/detail/(:num)'] = 'pembelian/penerimaan/penerimaan/detail/$1';
$route['penerimaan/info'] = 'pembelian/penerimaan/penerimaan/info';
$route['penerimaan/destroy'] = 'pembelian/penerimaan/penerimaan/destroy';

$route['penerimaan/tmp-create/modal-permintaan'] = 'pembelian/penerimaan/tmp_create';
$route['penerimaan/tmp-create/data-permintaan'] = 'pembelian/penerimaan/tmp_create/data_permintaan';
$route['penerimaan/tmp-create/check-permintaan'] = 'pembelian/penerimaan/tmp_create/check_permintaan';
$route['penerimaan/tmp-create/show-permintaan'] = 'pembelian/penerimaan/tmp_create/show_permintaan';

$route['penerimaan/tmp-create/data'] = 'pembelian/penerimaan/tmp_create/data';
$route['penerimaan/tmp-create/create'] = 'pembelian/penerimaan/tmp_create/create';
$route['penerimaan/tmp-create/store'] = 'pembelian/penerimaan/tmp_create/store';
$route['penerimaan/tmp-create/edit'] = 'pembelian/penerimaan/tmp_create/edit';
$route['penerimaan/tmp-create/update'] = 'pembelian/penerimaan/tmp_create/update';
$route['penerimaan/tmp-create/destroy'] = 'pembelian/penerimaan/tmp_create/destroy';
$route['penerimaan/tmp-create/batal'] = 'pembelian/penerimaan/tmp_create/batal';

$route['penerimaan/tmp-edit/data-supplier'] = 'pembelian/penerimaan/tmp_edit/data_supplier';
$route['penerimaan/tmp-edit/check-permintaan'] = 'pembelian/penerimaan/tmp_edit/check_permintaan';

$route['penerimaan/tmp-edit/data-tmp'] = 'pembelian/penerimaan/tmp_edit/data_tmp';
$route['penerimaan/tmp-edit/create'] = 'pembelian/penerimaan/tmp_edit/create';
$route['penerimaan/tmp-edit/store'] = 'pembelian/penerimaan/tmp_edit/store';
$route['penerimaan/tmp-edit/edit'] = 'pembelian/penerimaan/tmp_edit/edit';
$route['penerimaan/tmp-edit/update'] = 'pembelian/penerimaan/tmp_edit/update';
$route['penerimaan/tmp-edit/destroy'] = 'pembelian/penerimaan/tmp_edit/destroy';

// Pembayaran Penerimaan
$route['pelunasan/detail/(:num)'] = 'pembelian/pelunasan/detail/$1';
$route['pelunasan/data'] = 'pembelian/pelunasan/data';
$route['pelunasan/create'] = 'pembelian/pelunasan/create';
$route['pelunasan/store'] = 'pembelian/pelunasan/store';
$route['pelunasan/destroy'] = 'pembelian/pelunasan/destroy';

// Customer
$route['customer'] = 'master/customer';
$route['customer/data'] = 'master/customer/data';
$route['customer/detail/(:num)'] = 'master/customer/detail/$1';
$route['customer/update'] = 'master/customer/update';

// Pesanan
$route['pesanan'] = 'penjualan/pesanan/pesanan';
$route['pesanan/create'] = 'penjualan/pesanan/pesanan/create';

// Pesanan Tmp Create
$route['pesanan/tmp-create'] = 'penjualan/pesanan/tmp_create';
$route['pesanan/tmp-create/create'] = 'penjualan/pesanan/tmp_create/create';
$route['pesanan/tmp-create/get-penerimaan'] = 'penjualan/pesanan/tmp_create/get_penerimaan';

// Role
$route['roles'] = 'master/roles';
$route['roles/create'] = 'master/roles/create';
$route['roles/store'] = 'master/roles/store';
$route['roles/edit'] = 'master/roles/edit';
$route['roles/update'] = 'master/roles/update';
$route['roles/destroy'] = 'master/roles/destroy';

// Rekening Bank
$route['rekening'] = 'master/rekening';
$route['rekening/sync'] = 'master/rekening/sync';
$route['rekening/create'] = 'master/rekening/create';
$route['rekening/store'] = 'master/rekening/store';
$route['rekening/edit'] = 'master/rekening/edit';
$route['rekening/update'] = 'master/rekening/update';
$route['rekening/destroy'] = 'master/rekening/destroy';
$route['rekening/status/(:num)'] = 'master/rekening/status/$1';

$route['upload'] = 'master/UploadImages';
$route['browse'] = 'master/UploadImages/choseImages';
$route['insert'] = 'master/UploadImages/insertImages';
$route['delete'] = 'master/UploadImages/delteImages';
