<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model
{
    public function listar()
    {
        $this->db->select('id, nome, email, ativo');
        $this->db->order_by('id', 'DESC');

        return $this->db->get('usuarios')->result();
    }

    public function cadastrar($usuario)
    {
        return $this->db->insert('usuarios', $usuario);
    }
}
