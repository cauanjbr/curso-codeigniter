<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model');
		$this->load->helper(array('security', 'url'));
    }

    // Listar usuários
    public function index()
    {
        $data['titulo'] = 'Listar usuário';

        $this->load->view('layout/topo', $data);
        $this->load->view('usuarios/list');
        $this->load->view('layout/rodape');
    }

    // Novo usuário
    public function add()
    {
        $data['titulo'] = 'Cadastrar usuário';

        $this->load->view('layout/topo', $data);
        $this->load->view('usuarios/add');
        $this->load->view('layout/rodape');
    }

    // Editar usuário
    public function edit()
    {
    }

    // Apagar usuários
    public function del()
    {
    }
}
