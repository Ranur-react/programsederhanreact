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
