<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Loader    $load
 * @property CI_Session   $session
 * @property Livros_model $livros_model
 */
class Catalogo extends CI_Controller
{
    public function index()
    {
        $this->load->helper('url');
        $this->load->library('session');
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

        $gratuitos = 0;
        foreach ($livros as $livro) {
            $livro->gratuito = (float) $livro->preco <= 0;
            $livro->preco_formatado = $livro->gratuito
                ? 'Grátis'
                : 'R$ ' . number_format((float) $livro->preco, 2, ',', '.');
            $gratuitos += $livro->gratuito ? 1 : 0;
        }

        $this->load->view('catalogo/index', array(
            'livros' => $livros,
            'total_gratuitos' => $gratuitos,
            'total_pagos' => count($livros) - $gratuitos,
            'logado' => (bool) $this->session->userdata('usuario_logado')
        ));
    }
}
