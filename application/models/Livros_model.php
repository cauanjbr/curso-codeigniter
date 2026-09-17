<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Livros_model extends CI_Model {
    
public function listarLivros()
{
   $query = $this->db->get('livros');
    return $query->result();
}

public function getById($id)
{
    $this->db->select('livros.*, resumo.resumo');
    $this->db->from('livros');
    $this->db->join('resumo', 'livros.ID = resumo.id_livro', 'left');
    $this->db->where('livros.ID', $id);
    $this->db->limit(1);

    $query = $this->db->get();

    return $query->row();
}

}
