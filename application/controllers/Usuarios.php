<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Loader          $load
 * @property CI_Input           $input
 * @property CI_Session         $session
 * @property CI_Form_validation $form_validation
 * @property Usuarios_model     $usuarios_model
 */
class Usuarios extends MY_Controller
{
    // Listar usuários
    public function index()
    {
        $data['titulo'] = 'USUÁRIOS CADASTRADOS';
        $data['usuarios'] = $this->usuarios_model->listar();
        $data['usuario_logado_id'] = $this->usuarioLogado['id'];

        $this->load->view('layout/topo', $data);
        $this->load->view('usuarios/list', $data);
        $this->load->view('layout/rodape');
    }

    // Novo usuário
    public function add()
    {
        $data['titulo'] = 'CADASTRO DE USUÁRIOS';
        $data['erro'] = FALSE;

        $this->load->library('form_validation');

        $this->form_validation->set_rules('nome', 'Nome', 'trim|required|min_length[3]|max_length[45]');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|is_unique[usuarios.email]');
        $this->form_validation->set_rules('senha', 'Senha', 'required|min_length[3]|max_length[72]');
        $this->form_validation->set_rules('repita_senha', 'Repita Senha', 'required|matches[senha]');

        $this->form_validation->set_message('is_unique', 'Este {field} já está cadastrado.');
        $this->form_validation->set_message('matches', 'As senhas precisam ser iguais.');

        if ($this->form_validation->run() === TRUE) {
            $usuario = array(
                'nome' => $this->input->post('nome', TRUE),
                'email' => $this->input->post('email', TRUE),
                'senha' => password_hash($this->input->post('senha'), PASSWORD_DEFAULT),
                'ativo' => 1
            );

            if ($this->usuarios_model->cadastrar($usuario)) {
                $this->avisar('success', 'Usuário cadastrado com sucesso.');
                redirect('usuarios/add');
                return;
            }

            $data['erro'] = TRUE;
        }

        $this->load->view('layout/topo', $data);
        $this->load->view('usuarios/add', $data);
        $this->load->view('layout/rodape');
    }

    // Editar usuário
    public function edit($id = NULL)
    {
        $usuario = $this->buscarUsuario($id);

        $data['titulo'] = 'EDITAR USUÁRIO';
        $data['usuario'] = $usuario;
        $data['erro'] = FALSE;

        $this->load->library('form_validation');

        $regraEmail = 'trim|required|valid_email';
        if ($this->input->post('email') !== NULL && trim($this->input->post('email')) !== $usuario->email) {
            $regraEmail .= '|is_unique[usuarios.email]';
        }

        $this->form_validation->set_rules('nome', 'Nome', 'trim|required|min_length[3]|max_length[45]');
        $this->form_validation->set_rules('email', 'E-mail', $regraEmail);

        // Senha é opcional na edição: só valida se o campo foi preenchido
        $trocarSenha = (string) $this->input->post('nova_senha') !== '';
        if ($trocarSenha) {
            $this->form_validation->set_rules('nova_senha', 'Nova senha', 'required|min_length[3]|max_length[72]');
            $this->form_validation->set_rules('repita_nova_senha', 'Repita a nova senha', 'required|matches[nova_senha]');
        }

        $this->form_validation->set_message('is_unique', 'Este {field} já está cadastrado.');
        $this->form_validation->set_message('matches', 'As senhas precisam ser iguais.');

        if ($this->form_validation->run() === TRUE) {
            $dados = array(
                'nome' => $this->input->post('nome', TRUE),
                'email' => $this->input->post('email', TRUE)
            );

            if ($trocarSenha) {
                $dados['senha'] = password_hash($this->input->post('nova_senha'), PASSWORD_DEFAULT);
            }

            if ($this->usuarios_model->atualizar((int) $usuario->id, $dados)) {
                $this->avisar('success', 'Usuário atualizado com sucesso.');
                redirect('usuarios');
                return;
            }

            $data['erro'] = TRUE;
        }

        $this->load->view('layout/topo', $data);
        $this->load->view('usuarios/edit', $data);
        $this->load->view('layout/rodape');
    }

    // Ativar ou desativar usuário
    public function status($id = NULL)
    {
        $this->exigirPost('A alteração de status precisa ser enviada pelo formulário.');
        $usuario = $this->buscarUsuario($id);

        if ((int) $usuario->id === $this->usuarioLogado['id']) {
            $this->avisar('danger', 'Não é possível desativar a conta que está conectada.');
            redirect('usuarios');
            return;
        }

        $novoStatus = (int) $usuario->ativo === 1 ? 0 : 1;

        if ($this->usuarios_model->alterarStatus((int) $usuario->id, $novoStatus)) {
            $this->avisar('success', $novoStatus === 1 ? 'Usuário ativado com sucesso.' : 'Usuário desativado com sucesso.');
        } else {
            $this->avisar('danger', 'Não foi possível alterar o status do usuário. Tente novamente.');
        }

        redirect('usuarios');
    }

    // Apagar usuário
    public function del($id = NULL)
    {
        $this->exigirPost('A exclusão precisa ser confirmada pelo formulário.');
        $usuario = $this->buscarUsuario($id);

        if ((int) $usuario->id === $this->usuarioLogado['id']) {
            $this->avisar('danger', 'Não é possível apagar a conta que está conectada.');
            redirect('usuarios');
            return;
        }

        if ($this->usuarios_model->apagar((int) $usuario->id)) {
            $this->avisar('success', 'Usuário apagado com sucesso.');
        } else {
            $this->avisar('danger', 'Não foi possível apagar o usuário. Tente novamente.');
        }

        redirect('usuarios');
    }

    /**
     * Valida o id da URL e devolve o usuário, ou mostra erro 404.
     */
    private function buscarUsuario($id)
    {
        if ($id === NULL || !ctype_digit((string) $id)) {
            show_error('Você precisa informar um usuário válido.', 404, 'Usuário não encontrado');
        }

        $usuario = $this->usuarios_model->buscarPorId((int) $id);

        if (!$usuario) {
            show_error('O usuário informado não existe.', 404, 'Usuário não encontrado');
        }

        return $usuario;
    }
}
