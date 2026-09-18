<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		//recursos usados pelas páginas de livros
		$this->load->model('livros_model', 'livros');
		$this->load->helper(array('funcoes', 'url'));
	}

	public function index()
	{
		$data['titulo'] = 'Página principal';

		$this->load->view('layout/topo', $data);
		$this->load->view('site/conteudo', $data);
		$this->load->view('layout/rodape');
	}
	

	public function livros()	
	{
		//titulo
		$data['titulo'] = 'Lista de Livros';
		//carrega dados do banco de dados
		$data['livros'] = $this->livros->listarLivros();

		$this->load->view('layout/topo', $data);
		$this->load->view('livros/index', $data);
		$this->load->view('layout/rodape');


	}

	public function info($id = NULL)
	{
		if ($id === NULL || !ctype_digit((string) $id)) {
			show_error('Você precisa passar uma ID existente', 404, 'Livro não encontrado');
		}

		//buscar somente o livro que possui o ID informado
		$query = $this->livros->getById((int) $id);

		if ($query === NULL) {
			show_error('Você precisa passar uma ID existente', 404, 'Livro não encontrado');
		}

		$data['titulo'] = $query->NOME_LIVRO;
		$data['info'] = $query;

		$this->load->view('layout/topo', $data);
		$this->load->view('livros/info', $data);
		$this->load->view('layout/rodape');
	}

	public function formulario()
	{
		$data['titulo'] = 'Aula Helper Form';

		//carregar o helper de formulários do CodeIgniter
		$this->load->helper('form');

		$this->load->view('layout/topo', $data);
		$this->load->view('formulario/index', $data);
		$this->load->view('layout/rodape');
	}

	public function enviar()
	{
		if ($this->input->method() !== 'post') {
			redirect('site/formulario');
		}

		$dados = array(
			'email' => $this->input->post('email', TRUE),
			'senha' => $this->input->post('senha', TRUE),
			'submit' => $this->input->post('submit', TRUE)
		);

		echo '<pre>';
		print_r($dados);
		echo '</pre>';
	}

	public function validar()
	{
		$data['titulo'] = 'Biblioteca Form_validation';
		$data['sucesso'] = FALSE;

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('nome', 'Nome', 'required|min_length[3]|max_length[8]|trim');
		$this->form_validation->set_rules('email', 'E-mail', 'required|valid_email|trim');
		$this->form_validation->set_rules('codigo', 'Código', 'required|numeric|trim');
		$this->form_validation->set_rules('senha', 'Senha', 'required|min_length[3]|max_length[8]');
		$this->form_validation->set_rules('repita_senha', 'Repita Senha', 'required|matches[senha]');

		$this->form_validation->set_message('required', 'O campo {field} é obrigatório.');
		$this->form_validation->set_message('min_length', 'O campo {field} deve ter pelo menos {param} caracteres.');
		$this->form_validation->set_message('max_length', 'O campo {field} deve ter no máximo {param} caracteres.');
		$this->form_validation->set_message('valid_email', 'Informe um e-mail válido.');
		$this->form_validation->set_message('numeric', 'O campo {field} deve conter somente números.');
		$this->form_validation->set_message('matches', 'As senhas precisam ser iguais.');
		$this->form_validation->set_error_delimiters('<small class="text-danger d-block mt-1">', '</small>');

		if ($this->form_validation->run() === TRUE) {
			$data['sucesso'] = TRUE;
		}

		$this->load->view('layout/topo', $data);
		$this->load->view('formulario/validar', $data);
		$this->load->view('layout/rodape');
	}
}
