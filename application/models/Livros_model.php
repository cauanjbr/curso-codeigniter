<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 */
class Livros_model extends CI_Model
{
    public function listar()
    {
        return $this->db
            ->select('id, titulo, autor, preco, resumo, ativo, img')
            ->order_by('id', 'ASC')
            ->get('livros')
            ->result();
    }

    public function listarAtivos()
    {
        return $this->db
            ->select('id, titulo, autor, preco, resumo, img')
            ->where('ativo', 1)
            ->order_by('id', 'ASC')
            ->get('livros')
            ->result();
    }

    public function cadastrar($livro)
    {
        return $this->db->insert('livros', $livro);
    }

    public function buscarPorId($id)
    {
        return $this->db
            ->where('id', $id)
            ->limit(1)
            ->get('livros')
            ->row();
    }

    public function atualizar($id, $livro)
    {
        return $this->db
            ->where('id', $id)
            ->update('livros', $livro);
    }

    public function apagar($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete('livros');
    }

    public function alterarStatus($id, $ativo)
    {
        return $this->db
            ->where('id', $id)
            ->update('livros', array('ativo' => (int) $ativo));
    }
}
