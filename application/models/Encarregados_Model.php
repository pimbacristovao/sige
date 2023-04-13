<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Encarregados_Model extends CI_Model 
{
    /*              LISTAR OS REGISTROS DA TABELA ENCARREGADOS             */
    public function listarencarregados(){
        return $this->db->get("encarregados")->result_array();
    }
    /*=====================INICIO=CRIAR=NOVO=ENCARREGADOS=====================*/
	public function novoencarregados()
	{
		$aluno_id = $this->input->post('aluno_encarregado');
		$anolectivo_id = $this->input->post('anolectivo');
		$encarregado = array(
			"nome_encarregado" => $this->input->post('nome_encarregado'),
			"parentesco" => $this->input->post('parentesco'),
			"telemovel_encarregado" => $this->input->post('telemovel_encarregado'),
			"email_encarregado" => $this->input->post('email_encarregado')
		);
		$this->db->trans_start(); // Inicia uma transação com a base de dados
		$this->db->insert("encarregados", $encarregado); // Insere os dados na tbl encarregados usando os dados fornecidos pela variável "encarregados"
		$this->db->insert("encarregado_aluno", array(
			"id_aluno" => $aluno_id, // Obtém o dado recebido na variável aluno_id
			"id_encarregado" => $this->db->insert_id(), // Obtém o último id inserido na tbl encarregado
			"anolectivo_id" => $anolectivo_id) // Obtém o dado recebido na variável anolectivo_id
		);
		$this->db->trans_complete(); // Completa a transacção com a base de dados
	}
    public function retorna($id)
    {
        return $this->db->get_where("encarregados", array(
            "id_encarregado" => $id
        ))->row_array();
    }
	/*=====================INICIO=APAGAR=ENCARREGADOS=====================*/
        public function apagarencarregados($id)
        {
            $this->db->where('id_encarregado', $id);
            $this->db->delete('encarregados');
            return TRUE;
        }
    /*=====================INICIO=ACTUALIZAR=ENCARREGADOS=====================*/
    public function actualizar()
    {
        $id = $this->input->post('id_encarregado');
        $encarregados = array(
            "aluno_id" 			=> $this->input->post('aluno_encarregado'),
            "anolectivo_id" 	=> $this->input->post('anolectivo'),
            "nome_encarregado" 	=> $this->input->post('nome_encarregado'),
            "parentesco" => $this->input->post('parentesco'),
            "telemovel_encarregado" => $this->input->post('telemovel_encarregado'),
            "email_encarregado" => $this->input->post('email_encarregado') 
        );
        $this->db->where('id_encarregado', $id);
        return $this->db->update('encarregados', $encarregados);
    }
}