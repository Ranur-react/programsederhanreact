<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// proses login
$route['login/signin'] = 'login/signin';

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

$route['gudang'] = 'master/gudang';
$route['gudang/create'] = 'master/gudang/create';
$route['gudang/store'] = 'master/gudang/store';
$route['gudang/edit'] = 'master/gudang/edit';
$route['gudang/update'] = 'master/gudang/update';
$route['gudang/destroy'] = 'master/gudang/destroy';

$route['barang'] = 'master/barang';
