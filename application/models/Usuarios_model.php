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

    public function buscarPorId($id)
    {
        return $this->db
            ->where('id', $id)
            ->limit(1)
            ->get('usuarios')
            ->row();
    }

    public function buscarParaLogin($login)
    {
        return $this->db
            ->select('id, nome, email, senha, ativo')
            ->where('ativo', 1)
            ->group_start()
                ->where('email', $login)
                ->or_where('nome', $login)
            ->group_end()
            ->limit(1)
            ->get('usuarios')
            ->row();
    }

    public function atualizar($id, $usuario)
    {
        return $this->db
            ->where('id', $id)
            ->update('usuarios', $usuario);
    }

    public function apagar($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete('usuarios');
    }
}
