<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists("breadcrumb")) {
    function breadcrumb($data)
    {
        foreach ($data as $key => $value) {
            if ($key == 'active') :
                $breadcrumb = '<li class="active">' . $value . '</li>';
            elseif ($key == 'parent') :
                $breadcrumb = '<li><a href="#">' . $value . '</a></li>';
            else :
                $breadcrumb = '<li><a href="' . site_url($key) . '">' . $value . '</a></li>';
            endif;
            $result[] = [
                'breadcrumb' => $breadcrumb
            ];
        }
        return $result;
    }
}

if (!function_exists("pageHeader")) {
    function pageHeader($data)
    {
        $result = array_keys($data);
        $return = '<h1>' . $result[0] . ' <small>' . $data[$result[0]] . '</small></h1>';
        return $return;
    }
}
