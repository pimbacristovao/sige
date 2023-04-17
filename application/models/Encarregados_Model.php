<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Encarregados_Model extends CI_Model 
{
    /*              LISTAR OS REGISTROS DA TABELA ENCARREGADOS             */
    public function listarencarregados(){
        return $this->db->get("encarregados")->result_array();
    }
    /*=====================VERIFICAR ENCARREGADOS=====================*/
	public function verificar_encarregado()
	{
		// verifica se já existe um encarregado com mesmo nome, telemovel e email
		$nome_encarregado = $this->input->post("nome_encarregado");
		$telemovel_encarregado = $this->input->post("telemovel_encarregado");
		$email_encarregado = $this->input->post("email_encarregado");

		// recupera dados da tabela 'encarregados' da base de dados
		$result = $this->db->from('encarregados')										
							// filtra os resultados combinando o campo 'nome_encarregado' com o valor fornecido na variável $nome_encarregado
							->where("nome_encarregado", $nome_encarregado)
							// filtra os resultados combinando o campo 'telemovel_encarregado' com o valor fornecido na variável $telemovel_encarregado
							->where("telemovel_encarregado", $telemovel_encarregado)
							// filtra os resultados combinando o campo 'email_encarregado' com o valor fornecido na variável $email_encarregado
							->where("email_encarregado", $email_encarregado)
							// executa a consulta e obtém o objeto de resultado
							->get();

		// verifica se o número de linhas retornadas pela consulta é diferente de zero, então retorna verdadeiro, caso contrário, retorna falso.
		return $result->num_rows() !== 0 ? true : false; 
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

		// $this->db->select('encarregados.id_encarregado, encarregado_aluno.id_encarregado, aluno.*');
		// $this->db->from('encarregados');
		// $this->db->join('encarregado_aluno', 'encarregado_aluno.id_encarregado = encarregados.id_encarregado');
		// $this->db->join('aluno', 'aluno.id_aluno = encarregado_aluno.id_aluno');
		// $this->db->where('encarregados.id_encarregado', $id);
		// return $this->db->get()->row_array();
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
		$aluno_id = $this->input->post('aluno_encarregado');
		$anolectivo_id = $this->input->post('anolectivo');
        $encarregados = array(
            "nome_encarregado" 	=> $this->input->post('nome_encarregado'),
            "parentesco" => $this->input->post('parentesco'),
            "telemovel_encarregado" => $this->input->post('telemovel_encarregado'),
            "email_encarregado" => $this->input->post('email_encarregado') 
        );
		$this->db->trans_start();							// Inicia uma transação com a base de dados
		$this->db->where('id_encarregado', $id);			// Obtém o dado recebido na variável aluno_id
		$this->db->update("encarregados", $encarregados);	// Atualiza as informações na tbl encarregados usando os dados fornecidos pela variável "encarregados"
		$this->db->where('id_encarregado', $id);			// Seleciona linha(s) da tabela "encarregado_aluno" onde a coluna 'id_encarregado' é igual ao parâmetro $id fornecido
		$this->db->set('id_aluno', $aluno_id);				// Define o valor da coluna 'id_aluno' como sendo o parâmetro $aluno_id
		$this->db->set('anolectivo_id', $anolectivo_id);	// Define o valor da coluna 'anolectivo_id' como sendo o parâmetro $anolectivo_id
		$this->db->update("encarregado_aluno");				// Atualiza a tabela "encarregado_aluno" com os novos valores definidos acima
		$this->db->trans_complete();						// Completa a transacção com a base de dados
		
    }
}