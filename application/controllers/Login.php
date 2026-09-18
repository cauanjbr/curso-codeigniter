<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'session'));
    }

    public function index()
    {
        if ($this->session->userdata('usuario_logado')) {
            redirect('site');
            return;
        }

        $data['titulo'] = 'Login';
        $data['erro'] = FALSE;

        $this->form_validation->set_rules('login', 'Nome ou e-mail', 'required|trim');
        $this->form_validation->set_rules('senha', 'Senha', 'required');
        $this->form_validation->set_message('required', 'O campo {field} é obrigatório.');
        $this->form_validation->set_error_delimiters('<small class="text-danger d-block mt-1">', '</small>');

        if ($this->form_validation->run() === TRUE) {
            $login = $this->input->post('login', TRUE);
            $senha = $this->input->post('senha');
            $usuario = $this->usuarios_model->buscarParaLogin($login);

            if ($usuario && password_verify($senha, $usuario->senha)) {
                $this->session->sess_regenerate(TRUE);
                $this->session->set_userdata('usuario_logado', array(
                    'id' => (int) $usuario->id,
                    'nome' => $usuario->nome,
                    'email' => $usuario->email
                ));

                redirect('site');
                return;
            }

            $data['erro'] = TRUE;
        }

        $this->load->view('login/index', $data);
    }

    public function sair()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
