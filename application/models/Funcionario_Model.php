<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funcionario_Model extends CI_Model
{
    //  LISTAR OS REGISTROS DA TABELA FUNCIONARIO
    public function listarfuncionario()
    {
        return $this->db->get("funcionario")->result_array();
    }
    //  INSERIR REGISTROS NA TABELA FUNCIONARIO
    public function novofuncionario()
    {
        $funcionario = array
        (
			"nome_funcionario" => $this->input->post("nome_funcionario"),
			"genero_funcionario" => $this->input->post("genero_funcionario"),
			"nascimento_funcionario" => $this->input->post("nascimento_funcionario"),
			"bi_funcionario" => $this->input->post("bi_funcionario"),
			"provincia" => $this->input->post("naturalidade"),
			"nivel_acesso" => $this->input->post("nivel_acesso"),
			"endereco_funcionario" => $this->input->post("endereco_funcionario"),
			"telemovel_funcionario" => $this->input->post("telemovel_funcionario"),
			"email_funcionario" => $this->input->post("email_funcionario")
		);
        $this->db->insert("funcionario", $funcionario);
    }
    //  RETORANA DADOS DA TABELA FUNCIONARIOS
    public function retorna_funcionario($id)
    {    
        return $this->db->get_where("funcionario", array(
            "id_funcionario" => $id
            ))->row_array();
        }
    //  APAGAR REGISTROS NA TABELA FUNCIONARIO
    public function apagarfuncionario($id)
    {
        $this->db->where('id_funcionario', $id);
        $this->db->delete('funcionario');
        return TRUE;
    }
    //  ACTUALIZA REGISTROS NA TABELA funcionario
    public function actualizar()
    {
        $id = $this->input->post('id_funcionario');
        
        $funcionario = array
        (
            "nome_funcionario" => $this->input->post("nome_funcionario"),
			"genero_funcionario" => $this->input->post("genero_funcionario"),
			"nascimento_funcionario" => $this->input->post("nascimento_funcionario"),
			"bi_funcionario" => $this->input->post("bi_funcionario"),
			"provincia" => $this->input->post("naturalidade"),
			"nivel_acesso" => $this->input->post("nivel_acesso"),
			"endereco_funcionario" => $this->input->post("endereco_funcionario"),
			"telemovel_funcionario" => $this->input->post("telemovel_funcionario"),
			"email_funcionario" => $this->input->post("email_funcionario")	
		);
        $this->db->where('id_funcionario', $id);
        return $this->db->update('funcionario', $funcionario);
    }
    //---------------------------------------------------------------------------------
    //  CRIAR NOVO UTILIZADOR
    public function add_utilizador()
    {
        $id = $this->input->post('id_funcionario');
		if (!empty($this->input->post("nome_user"))) {
			// Sanitiza a entrada removendo tags e espaços desnecessários
			$nome_user = trim($this->input->post("nome_user"));
			// Valida a entrada para garantir que ela contenha apenas letras minúsculas (sem espaços)
			if (!preg_match("/^[a-z]*$/", $nome_user)) {
				// Se por ventura for inserido algum caractere maiúsculo
				// Converte para minúsculas e remove espaços
				$nome_user = strtolower(str_replace(' ', '', $nome_user));
			}
		}
        $funcionario = array
        (
            "nome_user" => $nome_user,
            "password" => password_hash($this->input->post("password"), PASSWORD_DEFAULT)
            // "confirm_password" => md5($this->input->post("confirm_password"))
        );
        $this->db->where('id_funcionario', $id);
        return $this->db->update('funcionario', $funcionario);
    }
    //---------------------------------------------------------------------------------
    //  ALTERAR PALAVRA PASSE
    public function alterar_password()
    {
        $id = $this->input->post('id_funcionario');
        $funcionario = array
        (
            "password" => password_hash($this->input->post("password_new"), PASSWORD_DEFAULT)
        );
        $this->db->where('id_funcionario', $id);
        return $this->db->update('funcionario', $funcionario);
    }
    //  INSERIR REGISTROS NA TABELA PROF_TURMA
    public function add_prof_turma()
    {
        $prof_turma = array
        (
            "funcionario_id" => $this->input->post("id_funcionario"),
            "anolectivo_id" => $this->input->post("anolectivo"),
            "turma_id" => $this->input->post("turma_id")
        );
        $this->db->insert("prof_turma", $prof_turma);
    }
    /*
    ============================= JUSTIFICAR FALTA =============================
    */
    public function justificar_falta()
    {
        $id_assiduidade = $this->input->post('id_assiduidade');
        $justicar_falta = array(
			"justificacao" => $this->input->post('justificacao')
		);
        $this->db->where('id_assiduidade', $id_assiduidade);
        return $this->db->update('assiduidade_funcionario', $justicar_falta);
    }
}