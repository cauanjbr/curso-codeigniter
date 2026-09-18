<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Atualizar_dados_usuarios extends CI_Migration
{
    public function up()
    {
        $this->db
            ->where('id', 1)
            ->update('usuarios', array(
                'nome' => 'nathan gabriel',
                'email' => 'natan@teste.com'
            ));

        $this->db
            ->where('id', 7)
            ->update('usuarios', array(
                'nome' => 'joao',
                'email' => 'joao@teste.com'
            ));
    }

    public function down()
    {
        $this->db
            ->where('id', 1)
            ->update('usuarios', array(
                'nome' => 'nathan silva',
                'email' => 'natan@teste.com.br'
            ));

        $this->db
            ->where('id', 7)
            ->update('usuarios', array(
                'nome' => 'joao',
                'email' => 'joao@teste.com.br'
            ));
    }
}
