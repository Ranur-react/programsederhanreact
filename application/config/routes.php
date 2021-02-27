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
$route['supplier'] = 'master/supplier';

$route['satuan'] = 'master/satuan';
$route['satuan/create'] = 'master/satuan/create';
$route['satuan/store'] = 'master/satuan/store';
$route['satuan/edit'] = 'master/satuan/edit';
$route['satuan/update'] = 'master/satuan/update';
$route['satuan/destroy'] = 'master/satuan/destroy';
