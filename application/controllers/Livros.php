<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Loader          $load
 * @property CI_Input           $input
 * @property CI_Session         $session
 * @property CI_Form_validation $form_validation
 * @property CI_Upload          $upload
 * @property Livros_model       $livros_model
 */
class Livros extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('livros_model');
    }

    public function index()
    {
        $data['titulo'] = 'Lista de livros';
        $data['titulo_pagina'] = 'Crud livros v. 1.0.0';
        $data['livros'] = $this->livros_model->listar();

        // Miniatura da capa na lista (só para arquivos que existem em uploads/livros)
        foreach ($data['livros'] as $livro) {
            $livro->capa_url = NULL;

            if (!empty($livro->img)
                && basename($livro->img) === $livro->img
                && is_file(FCPATH . 'uploads/livros/' . $livro->img)) {
                $livro->capa_url = base_url('uploads/livros/' . rawurlencode($livro->img));
            }
        }

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

        $this->definirRegras();

        if ($this->form_validation->run() === TRUE) {
            $upload = $this->enviarImagem();

            if (!$upload['sucesso']) {
                $data['erro_upload'] = $upload['erro'];
            } else {
                $livro = $this->dadosDoFormulario();
                $livro['img'] = $upload['arquivo'];

                if ($this->livros_model->cadastrar($livro)) {
                    $this->avisar('success', 'Livro cadastrado com sucesso.');
                    redirect('livros');
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
        $livro = $this->buscarLivro($id);

        $data['titulo'] = 'Editar livro';
        $data['titulo_pagina'] = 'Crud livros v. 1.0.0';
        $data['livro'] = $livro;
        $data['erro'] = FALSE;
        $data['erro_upload'] = NULL;

        $this->definirRegras();

        if ($this->form_validation->run() === TRUE) {
            $upload = $this->enviarImagem();

            if (!$upload['sucesso']) {
                $data['erro_upload'] = $upload['erro'];
            } else {
                $dados = $this->dadosDoFormulario();

                if ($upload['arquivo'] !== NULL) {
                    $dados['img'] = $upload['arquivo'];
                }

                if ($this->livros_model->atualizar((int) $livro->id, $dados)) {
                    if ($upload['arquivo'] !== NULL && $upload['arquivo'] !== $livro->img) {
                        $this->apagarImagem($livro->img);
                    }

                    $this->avisar('success', 'Livro atualizado com sucesso.');
                    redirect('livros');
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
        $this->exigirPost('A exclusão precisa ser confirmada pelo formulário.');
        $livro = $this->buscarLivro($id);

        if ($this->livros_model->apagar((int) $livro->id)) {
            $this->apagarImagem($livro->img);
            $this->avisar('success', 'Livro apagado com sucesso.');
        } else {
            $this->avisar('danger', 'Não foi possível apagar o livro. Tente novamente.');
        }

        redirect('livros');
    }

    public function alterarStatus($id = NULL)
    {
        $this->exigirPost('A alteração de status precisa ser enviada pelo formulário.');
        $livro = $this->buscarLivro($id);

        $novoStatus = (int) $livro->ativo === 1 ? 0 : 1;

        if ($this->livros_model->alterarStatus((int) $livro->id, $novoStatus)) {
            $this->avisar('success', $novoStatus === 1 ? 'Livro ativado com sucesso.' : 'Livro desativado com sucesso.');
        } else {
            $this->avisar('danger', 'Não foi possível alterar o status do livro. Tente novamente.');
        }

        redirect('livros');
    }

    /**
     * Valida o id da URL e devolve o livro, ou mostra erro 404.
     */
    private function buscarLivro($id)
    {
        if ($id === NULL || !ctype_digit((string) $id)) {
            show_error('Você precisa informar um livro válido.', 404, 'Livro não encontrado');
        }

        $livro = $this->livros_model->buscarPorId((int) $id);

        if (!$livro) {
            show_error('O livro informado não existe.', 404, 'Livro não encontrado');
        }

        return $livro;
    }

    /**
     * Regras do formulário de livro, usadas no cadastro e na edição.
     * As mensagens comuns vêm de language/portuguese-br/form_validation_lang.php.
     */
    private function definirRegras()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('titulo', 'Título', 'trim|required|min_length[2]|max_length[200]');
        $this->form_validation->set_rules('autor', 'Autor', 'trim|required|min_length[2]|max_length[150]');
        // Aceita 59, 59.9 e 59.90; a regra "decimal" do CodeIgniter recusava valores sem centavos
        $this->form_validation->set_rules('preco', 'Valor', 'trim|required|regex_match[/^\d{1,13}(\.\d{1,2})?$/]');
        $this->form_validation->set_rules('resumo', 'Resumo', 'trim|required');
        $this->form_validation->set_rules('ativo', 'Ativo', 'required|in_list[0,1]');

        $this->form_validation->set_message('regex_match', 'Informe um valor positivo usando ponto, por exemplo: 59 ou 59.90.');
        $this->form_validation->set_message('in_list', 'Selecione uma opção válida para o campo {field}.');
    }

    private function dadosDoFormulario()
    {
        return array(
            'titulo' => $this->input->post('titulo', TRUE),
            'autor' => $this->input->post('autor', TRUE),
            'preco' => $this->input->post('preco', TRUE),
            'resumo' => $this->input->post('resumo', TRUE),
            'ativo' => (int) $this->input->post('ativo')
        );
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
