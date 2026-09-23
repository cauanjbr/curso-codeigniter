<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base dos controllers do painel: só deixa passar quem está logado
 * e com a conta ainda ativa no banco.
 *
 * @property CI_Loader      $load
 * @property CI_Input       $input
 * @property CI_Session     $session
 * @property Usuarios_model $usuarios_model
 */
class MY_Controller extends CI_Controller
{
    /**
     * Usuário logado: id, nome e email.
     *
     * @var array
     */
    protected $usuarioLogado;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->helper(array('url', 'form'));
        $this->load->library('session');

        $sessao = $this->session->userdata('usuario_logado');
        $usuario = $sessao ? $this->usuarios_model->buscarPorId((int) $sessao['id']) : NULL;

        // Conta apagada ou desativada depois do login perde o acesso na hora
        if (!$usuario || (int) $usuario->ativo !== 1) {
            $this->session->unset_userdata('usuario_logado');
            redirect('login');
        }

        // Mantém nome e e-mail da sessão iguais aos do banco
        $this->usuarioLogado = array(
            'id' => (int) $usuario->id,
            'nome' => $usuario->nome,
            'email' => $usuario->email
        );
        $this->session->set_userdata('usuario_logado', $this->usuarioLogado);
    }

    /**
     * Guarda uma mensagem para exibir na próxima página (layout/aviso).
     *
     * @param string $tipo     success ou danger
     * @param string $mensagem
     */
    protected function avisar($tipo, $mensagem)
    {
        $this->session->set_flashdata('aviso', array(
            'tipo' => $tipo,
            'mensagem' => $mensagem
        ));
    }

    /**
     * Bloqueia ações destrutivas feitas por link (GET).
     *
     * @param string $mensagem
     */
    protected function exigirPost($mensagem)
    {
        if ($this->input->method() !== 'post') {
            show_error($mensagem, 405, 'Método não permitido');
        }
    }
}
