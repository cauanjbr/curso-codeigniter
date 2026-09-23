<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Coloca todos os livros a R$ 40,00.
 *
 * @property CI_DB_query_builder $db
 */
class Migration_Livros_preco_40 extends CI_Migration
{
    public function up()
    {
        $this->db->update('livros', array('preco' => 40.00));
    }

    public function down()
    {
        // Preços que estavam no banco antes desta migration (23/09/2026)
        $precosAnteriores = array(
            1 => 90.00,
            2 => 58.00,
            10 => 35.00
        );

        $this->db->update('livros', array('preco' => 0.00));

        foreach ($precosAnteriores as $id => $preco) {
            $this->db
                ->where('id', $id)
                ->update('livros', array('preco' => $preco));
        }
    }
}
