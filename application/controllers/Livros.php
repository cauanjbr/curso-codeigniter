<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Livros extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('livros_model');
        $this->load->helper(array('url', 'form'));
        $this->load->library('session');

        if (!$this->session->userdata('usuario_logado')) {
            redirect('login');
            exit;
        }
    }

    public function index()
    {
        $data['titulo'] = 'Lista de livros';
        $data['titulo_pagina'] = 'Crud livros v. 1.0.0';
        $data['livros'] = $this->livros_model->listar();
        $data['cadastrado'] = $this->input->get('cadastrado') === '1';
        $data['atualizado'] = $this->input->get('atualizado') === '1';
        $data['apagado'] = $this->input->get('apagado') === '1';
        $data['status_alterado'] = $this->input->get('status_alterado') === '1';
        $data['erro_acao'] = $this->input->get('erro_acao') === '1';

        $this->load->view('layout/topo', $data);
        $this->load->view('livros/index', $data);
        $this->load->view('layout/rodape');
    }

    public function adicionar()
    {
        $data['titulo'] = 'Novo livro';
        $data['titulo_pagina'] = 'Crud livros v. 1.0.0';
        $data['erro'] = FALSE;
        $data['erro_upload'] = NULL;

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('titulo', 'Título', 'required|min_length[2]|max_length[200]|trim');
        $this->form_validation->set_rules('autor', 'Autor', 'required|min_length[2]|max_length[150]|trim');
        $this->form_validation->set_rules('preco', 'Valor', 'required|decimal|greater_than_equal_to[0]|trim');
        $this->form_validation->set_rules('resumo', 'Resumo', 'required|trim');
        $this->form_validation->set_rules('ativo', 'Ativo', 'required|in_list[0,1]');

        $this->form_validation->set_message('required', 'O campo {field} é obrigatório.');
        $this->form_validation->set_message('min_length', 'O campo {field} deve ter pelo menos {param} caracteres.');
        $this->form_validation->set_message('max_length', 'O campo {field} deve ter no máximo {param} caracteres.');
        $this->form_validation->set_message('decimal', 'Informe um valor válido usando ponto, por exemplo: 59.90.');
        $this->form_validation->set_message('greater_than_equal_to', 'O campo {field} não pode ser negativo.');
        $this->form_validation->set_message('in_list', 'Selecione uma opção válida para o campo {field}.');
        $this->form_validation->set_error_delimiters('<small class="text-danger d-block mt-1">', '</small>');

        if ($this->form_validation->run() === TRUE) {
            $upload = $this->enviarImagem();

            if (!$upload['sucesso']) {
                $data['erro_upload'] = $upload['erro'];
            } else {
                $livro = array(
                    'titulo' => $this->input->post('titulo', TRUE),
                    'autor' => $this->input->post('autor', TRUE),
                    'preco' => $this->input->post('preco', TRUE),
                    'resumo' => $this->input->post('resumo', TRUE),
                    'ativo' => (int) $this->input->post('ativo'),
                    'img' => $upload['arquivo']
                );

                if ($this->livros_model->cadastrar($livro)) {
                    redirect('livros?cadastrado=1');
                    return;
                }

                $this->apagarImagem($upload['arquivo']);
                $data['erro'] = TRUE;
            }
        }

        $this->load->view('layout/topo', $data);
        $this->load->view('livros/adicionar', $data);
        $this->load->view('layout/rodape');
    }

    public function editar($id = NULL)
    {
        if ($id === NULL || !ctype_digit((string) $id)) {
            show_error('Você precisa informar um livro válido.', 404, 'Livro não encontrado');
        }

        $livro = $this->livros_model->buscarPorId((int) $id);

        if (!$livro) {
            show_error('O livro informado não existe.', 404, 'Livro não encontrado');
        }

        $data['titulo'] = 'Editar livro';
        $data['titulo_pagina'] = 'Crud livros v. 1.0.0';
        $data['livro'] = $livro;
        $data['erro'] = FALSE;
        $data['erro_upload'] = NULL;

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('titulo', 'Título', 'required|min_length[2]|max_length[200]|trim');
        $this->form_validation->set_rules('autor', 'Autor', 'required|min_length[2]|max_length[150]|trim');
        $this->form_validation->set_rules('preco', 'Valor', 'required|decimal|greater_than_equal_to[0]|trim');
        $this->form_validation->set_rules('resumo', 'Resumo', 'required|trim');
        $this->form_validation->set_rules('ativo', 'Ativo', 'required|in_list[0,1]');

        $this->form_validation->set_message('required', 'O campo {field} é obrigatório.');
        $this->form_validation->set_message('min_length', 'O campo {field} deve ter pelo menos {param} caracteres.');
        $this->form_validation->set_message('max_length', 'O campo {field} deve ter no máximo {param} caracteres.');
        $this->form_validation->set_message('decimal', 'Informe um valor válido usando ponto, por exemplo: 59.90.');
        $this->form_validation->set_message('greater_than_equal_to', 'O campo {field} não pode ser negativo.');
        $this->form_validation->set_message('in_list', 'Selecione uma opção válida para o campo {field}.');
        $this->form_validation->set_error_delimiters('<small class="text-danger d-block mt-1">', '</small>');

        if ($this->form_validation->run() === TRUE) {
            $upload = $this->enviarImagem();

            if (!$upload['sucesso']) {
                $data['erro_upload'] = $upload['erro'];
            } else {
                $dados = array(
                    'titulo' => $this->input->post('titulo', TRUE),
                    'autor' => $this->input->post('autor', TRUE),
                    'preco' => $this->input->post('preco', TRUE),
                    'resumo' => $this->input->post('resumo', TRUE),
                    'ativo' => (int) $this->input->post('ativo')
                );

                if ($upload['arquivo'] !== NULL) {
                    $dados['img'] = $upload['arquivo'];
                }

                if ($this->livros_model->atualizar((int) $id, $dados)) {
                    if ($upload['arquivo'] !== NULL && $upload['arquivo'] !== $livro->img) {
                        $this->apagarImagem($livro->img);
                    }

                    redirect('livros?atualizado=1');
                    return;
                }

                $this->apagarImagem($upload['arquivo']);
                $data['erro'] = TRUE;
            }
        }

        $this->load->view('layout/topo', $data);
        $this->load->view('livros/editar', $data);
        $this->load->view('layout/rodape');
    }

    public function apagar($id = NULL)
    {
        if ($this->input->method() !== 'post') {
            show_error('A exclusão precisa ser confirmada pelo formulário.', 405, 'Método não permitido');
        }

        if ($id === NULL || !ctype_digit((string) $id)) {
            show_error('Você precisa informar um livro válido.', 404, 'Livro não encontrado');
        }

        $livro = $this->livros_model->buscarPorId((int) $id);

        if (!$livro) {
            show_error('O livro informado não existe.', 404, 'Livro não encontrado');
        }

        if ($this->livros_model->apagar((int) $id)) {
            $this->apagarImagem($livro->img);
            redirect('livros?apagado=1');
            return;
        }

        redirect('livros?erro_acao=1');
    }

    public function alterarStatus($id = NULL)
    {
        if ($this->input->method() !== 'post') {
            show_error('A alteração de status precisa ser enviada pelo formulário.', 405, 'Método não permitido');
        }

        if ($id === NULL || !ctype_digit((string) $id)) {
            show_error('Você precisa informar um livro válido.', 404, 'Livro não encontrado');
        }

        $livro = $this->livros_model->buscarPorId((int) $id);

        if (!$livro) {
            show_error('O livro informado não existe.', 404, 'Livro não encontrado');
        }

        $novoStatus = (int) $livro->ativo === 1 ? 0 : 1;

        if ($this->livros_model->alterarStatus((int) $id, $novoStatus)) {
            redirect('livros?status_alterado=1');
            return;
        }

        redirect('livros?erro_acao=1');
    }

    private function enviarImagem()
    {
        if (empty($_FILES['imagem']['name'])) {
            return array('sucesso' => TRUE, 'arquivo' => NULL, 'erro' => NULL);
        }

        $diretorio = FCPATH . 'uploads/livros/';

        if (!is_dir($diretorio) && !mkdir($diretorio, 0755, TRUE)) {
            return array(
                'sucesso' => FALSE,
                'arquivo' => NULL,
                'erro' => 'Não foi possível preparar a pasta das imagens.'
            );
        }

        $config = array(
            'upload_path' => $diretorio,
            'allowed_types' => 'jpg|jpeg|png|gif',
            'max_size' => 2048,
            'max_width' => 3000,
            'max_height' => 3000,
            'encrypt_name' => TRUE,
            'file_ext_tolower' => TRUE,
            'remove_spaces' => TRUE,
            'detect_mime' => TRUE
        );

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('imagem')) {
            return array(
                'sucesso' => FALSE,
                'arquivo' => NULL,
                'erro' => strip_tags($this->upload->display_errors('', ''))
            );
        }

        $arquivo = $this->upload->data();

        return array(
            'sucesso' => TRUE,
            'arquivo' => $arquivo['file_name'],
            'erro' => NULL
        );
    }

    private function apagarImagem($arquivo)
    {
        if (empty($arquivo) || basename($arquivo) !== $arquivo) {
            return;
        }

        $caminho = FCPATH . 'uploads/livros/' . $arquivo;

        if (is_file($caminho)) {
            unlink($caminho);
        }
    }
}
