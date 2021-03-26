<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// proses login
$route['login/signin'] = 'login/signin';

// proses registrasi
$route['registrasi'] = 'auth/registrasi';

// proses logout
$route['logout'] = 'auth/logout';

//menu master

$route['pengguna'] = 'master/pengguna';
$route['pengguna/create'] = 'master/pengguna/create';
$route['pengguna/store'] = 'master/pengguna/store';
$route['pengguna/edit'] = 'master/pengguna/edit';
$route['pengguna/update'] = 'master/pengguna/update';
$route['pengguna/destroy'] = 'master/pengguna/destroy';

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
