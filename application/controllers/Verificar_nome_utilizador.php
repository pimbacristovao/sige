<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verificar_nome_utilizador extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	/* ====================== VERIFICA NOME DE UTILIZADOR ====================== */
	public function verificar_utilizador()
	{
		// TODO: Apromirar essa função de forma a evitar ataques SQL INJECTION (desta forma não está protegida)
		if (!empty($_POST["nome_user"])) {
			$query = $this->db->query("SELECT * FROM funcionario WHERE nome_user='" . $_POST["nome_user"] . "'");
			$count = $query->num_rows();
			if ($count > 0) {
				echo "<span style='color:red'>Desculpe, este nome de utilizador já existe.</span>";
				echo "<script>$('#submit').prop('disabled',true);</script>";
			} else {
				echo "<span style='color:green'>Nome de utilizador disponível para Cadastro.</span>";
				echo "<script>$('#submit').prop('disabled',false);</script>";
			}
		}
	}
}
