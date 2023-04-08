<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sessao_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	// ==================VARIFICA AS CREDÊNCIAS DE ACESSO DO UTILIZADOR==================
	function validate($nome_user, $password)
	{
		// Esta linha de código define uma condição para verificar no banco de dados onde a coluna "nome_user" corresponde ao $nome_user fornecido
		$this->db->where('nome_user', $nome_user);
		// Esta linha de código executa uma consulta para recuperar todos os registros da tabela "funcionario" que correspondem à condição acima
		$result = $this->db->get('funcionario');
		// Esta linha de código verifica se algum registro foi encontrado verificando se o número de linhas retornadas é maior que 0
		if ($result->num_rows() > 0) {
			// Esta linha de código recupera a primeira linha do conjunto de resultados como um array associativo e atribui a variável $usuario
			$usuario = $result->row_array();
			// Esta linha de código verifica se a senha fornecida corresponde à senha armazenada no banco na forma hash para o respectivo usuário recuperado anteriormente.
			if (password_verify($password, $usuario['password'])) {
				// Se a validação for bem-sucedida, esta linha de código retorna o array $usuario
				return $usuario;
			}
		}

		// Esta linha de código retorna false indicando que a validação falhou ou nenhum registro correspondente foi encontrado
		return false;
	}
}
