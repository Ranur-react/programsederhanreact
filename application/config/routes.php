<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// proses login
$route['login/signin'] = 'login/signin';

// proses logout
$route['logout'] = 'auth/logout';

$route['gudang'] = 'master/gudang';
$route['gudang/create'] = 'master/gudang/create';
$route['gudang/store'] = 'master/gudang/store';
$route['gudang/edit'] = 'master/gudang/edit';
$route['gudang/update'] = 'master/gudang/update';
