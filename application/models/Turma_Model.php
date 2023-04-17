<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Turma_Model extends CI_Model {

    //  LISTAR OS REGISTROS DA TABELA TURMA
    public function listarturma()
    {        
		$this->db->select('*');													// Seleciona Tudo
		$this->db->from('turma');													// Da tabela Turma
		$this->db->join('classe', 'classe.id_classe  = turma.classe_id');			// Join tbl classe [turma]
		$this->db->join('periodo', 'periodo.id_periodo  = turma.periodo_id');		// Join tbl periodo [turma]
		$this->db->join('turma_sala', 'turma_sala.id_turma  = turma.id_turma');		// Join tbl turma_sala [turma]
		$this->db->join('sala', 'sala.id_sala = turma_sala.id_sala');				// Join tbl sala [turma_sala]
		$this->db->order_by("nome_turma", "asc");									// Ordem
		return $this->db->get()->result_array();								// Retorna uma matriz(array) contendo os resultados da consulta
    }

    //  INSERIR REGISTROS NA TABELA TURMA
    public function novaturma()
    {
		$sala_id = $this->input->post('numero_sala');
        $turma = array(
            "nome_turma" =>$this->input->post('nome_turma'),
			"classe_id"  =>$this->input->post('nome_classe'),
			"periodo_id" =>$this->input->post('nome_periodo')
        );
		$this->db->trans_start(); // Inicia uma transação com a base de dados
		$this->db->insert("turma", $turma); // Insere os dados na tbl turma usando os dados fornecidos pela variável "turma"
		$this->db->insert("turma_sala", array(
			"id_turma" => $this->db->insert_id(), // Obtém o último id inserido na tbl turma
			"id_sala" => $sala_id) // Obtém o dado recebido na variável anolectivo_id
		);
		$this->db->trans_complete(); // Completa a transacção com a base de dados
    }

    public function retorna($id){
        return $this->db->get_where("turma", array(
            "id_turma" => $id
        ))->row_array();
    }

    /* ================= APAGAR REGISTROS NA TABELA TURMA ================= */  
    public function apagarturma($id){
        $this->db->where('id_turma', $id);
        $this->db->delete('turma');
        return TRUE;
    }

    //  ACTUALIZA REGISTROS NA TABELA TURMA
	public function actualizar()
    {
        $id = $this->input->post('id_turma');
		$sala_id = $this->input->post('numero_sala');
		$turma = array(
			"nome_turma" => $this->input->post('nome_turma'),
			"classe_id" => $this->input->post('nome_classe'),
			"periodo_id" => $this->input->post('nome_periodo')
		);
		$this->db->trans_start();				// Inicia uma transação com a base de dados
		$this->db->where('id_turma', $id);		// filtra os resultados combinando o campo 'id_turma' com o valor fornecido na variável $id
		$this->db->update("turma", $turma);		// Atualiza as informações na tbl turma usando os dados fornecidos pela variável "turma"
		$this->db->where('id_turma', $id);		// Seleciona linha(s) da tabela "turma" onde a coluna 'id_turma' é igual ao parâmetro $id fornecido
		$this->db->set('id_sala', $sala_id);	// Define o valor da coluna 'id_sala' como sendo o parâmetro $sala_id
		$this->db->update("turma_sala");		// Atualiza a tabela "turma_sala" com os novos valores definidos acima
		$this->db->trans_complete();			// Completa a transacção com a base de dados		
    }
    /*-------------------------------- SELECT DINAMICO ------------------------------------*/
    function get_sala(){
        $this->db->select('*');
        return $this->db->get('sala')->result();
    }
    function get_classe(){
        $this->db->select('*');
        return $this->db->get('classe')->result();
    }
    function get_periodo(){
        $this->db->select('*');
        return $this->db->get('periodo')->result();
    }
}