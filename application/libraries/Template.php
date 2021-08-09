<?php
class Template
{
    protected $_ci;
    function __construct()
    {
        $this->_ci = &get_instance();
    }
    function auth($template, $data = null)
    {
        $data['content'] = $this->_ci->load->view($template, $data, true);
        $this->_ci->parser->parse('layout/auth/extends', $data);
    }
    function dashboard($template, $data = null)
    {
        $data['content'] = $this->_ci->load->view($template, $data, true);
        $this->_ci->parser->parse('layout/extends', $data);
    }
    function modal_form($form, $data)
    {
        $data['body'] = $this->_ci->load->view($form, $data, true);
        $this->_ci->load->view('layout/modal/modal_form', $data);
    }
    function modal_images_form($form, $data)
    {
        $data['body'] = $this->_ci->load->view($form, $data, true);
        $this->_ci->load->view('master/Images/imageUpload', $data);
    }
    function modal_info($form, $data)
    {
        $data['body'] = $this->_ci->load->view($form, $data, true);
        $this->_ci->load->view('layout/modal/modal_info', $data);
    }
    function modal_report($form, $data)
    {
        $data['body'] = $this->_ci->load->view($form, $data, true);
        $this->_ci->load->view('layout/modal/modal_report', $data);
    }
    function laporan($template, $data = null)
    {
        $data['content'] = $this->_ci->load->view($template, $data, true);
        $this->_ci->parser->parse('laporan/layout/index', $data);
    }
}
