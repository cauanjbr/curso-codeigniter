<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Loader    $load
 * @property Livros_model $livros_model
 */
class Catalogo extends CI_Controller
{
    public function index()
    {
        $this->load->helper('url');
        $this->load->model('livros_model');
        $livros = $this->livros_model->listarAtivos();
        $capas = array('php-right-way.jpg', 'php-notes.jpg', 'php-succinctly.jpg');

        foreach ($livros as $livro) {
            $livro->capa_url = base_url('assets/capas/' . $capas[((int) $livro->id - 1) % count($capas)]);
            if (!empty($livro->img)
                && basename($livro->img) === $livro->img
                && preg_match('/\.(jpe?g|png|gif)$/i', $livro->img)
                && is_file(FCPATH . 'uploads/livros/' . $livro->img)) {
                $livro->capa_url = base_url('uploads/livros/' . rawurlencode($livro->img));
            }
        }

        $this->load->view('catalogo/index', array('livros' => $livros));
    }
}
