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
        $data['titulo'] = 'USUÁRIOS CADASTRADOS';
        $data['usuarios'] = $this->usuarios_model->listar();

        $this->load->view('layout/topo', $data);
        $this->load->view('usuarios/list', $data);
        $this->load->view('layout/rodape');
    }

    // Novo usuário
    public function add()
    {
        $data['titulo'] = 'CADASTRO DE USUÁRIOS';
        $data['sucesso'] = $this->input->get('sucesso') === '1';
        $data['erro'] = FALSE;

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nome', 'Nome', 'required|min_length[3]|max_length[45]|trim');
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email|is_unique[usuarios.email]|trim');
        $this->form_validation->set_rules('senha', 'Senha', 'required|min_length[3]|max_length[72]');
        $this->form_validation->set_rules('repita_senha', 'Repita Senha', 'required|matches[senha]');

        $this->form_validation->set_message('required', 'O campo {field} é obrigatório.');
        $this->form_validation->set_message('min_length', 'O campo {field} deve ter pelo menos {param} caracteres.');
        $this->form_validation->set_message('max_length', 'O campo {field} deve ter no máximo {param} caracteres.');
        $this->form_validation->set_message('valid_email', 'Informe um e-mail válido.');
        $this->form_validation->set_message('is_unique', 'Este {field} já está cadastrado.');
        $this->form_validation->set_message('matches', 'As senhas precisam ser iguais.');
        $this->form_validation->set_error_delimiters('<small class="text-danger d-block mt-1">', '</small>');

        if ($this->form_validation->run() === TRUE) {
            $usuario = array(
                'nome' => $this->input->post('nome', TRUE),
                'email' => $this->input->post('email', TRUE),
                'senha' => password_hash($this->input->post('senha'), PASSWORD_DEFAULT),
                'ativo' => 1
            );

            if ($this->usuarios_model->cadastrar($usuario)) {
                redirect('usuarios/add?sucesso=1');
                return;
            }

            $data['erro'] = TRUE;
        }

        $this->load->view('layout/topo', $data);
        $this->load->view('usuarios/add', $data);
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
