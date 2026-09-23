<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_DB_forge         $dbforge
 */
class Migration_Adicionar_imagem_livros extends CI_Migration
{
    public function up()
    {
        if (!$this->db->field_exists('img', 'livros')) {
            $this->dbforge->add_column('livros', array(
                'img' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => TRUE,
                    'after' => 'ativo'
                )
            ));
        }
    }

    public function down()
    {
        if ($this->db->field_exists('img', 'livros')) {
            $this->dbforge->drop_column('livros', 'img');
        }
    }
}
