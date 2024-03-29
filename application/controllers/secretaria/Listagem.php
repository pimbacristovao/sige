<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listagem extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		if($this->session->userdata('logged_in') !== TRUE)
		{
			redirect('/');
		}
	}
	/*-------------------------- LISTA NOMINAL --------------------------*/ 
	public function index()
	{
		$dados["options_anos"] 	 	  = $this->Ano_Model->selectAnos();
		$dados["options_turmas"] 	  = $this->Turmas_Model->selectTurmas();
		/* ------------------------------------------------------------------------- */
		$this->load->view('layout/cabecalho_secretaria');
		$this->load->view('layout/menu_lateral_secretaria');
		$this->load->view('conteudo/_secretaria/_listagem/listagem', $dados);
		$this->load->view('layout/rodape');	
		$this->load->view('layout/script');
	}
	/*-------------------------- MINI-PAUTAS --------------------------*/ 
	public function mini_pautas()
	{
		$dados["options_anos"] 	 	  = $this->Ano_Model->selectAnos();
		$dados["options_turmas"] 	  = $this->Turmas_Model->selectTurmas();
		/* ------------------------------------------------------------------------- */
		$this->load->view('layout/cabecalho');
		$this->load->view('layout/menu_lateral_coordenacao');
		$this->load->view('conteudo/_secretaria/_listagem/mini_pautas', $dados);
		$this->load->view('layout/rodape');	
		$this->load->view('layout/script');
	}
	/*					 							listar alunos/ano/turma
	==================================================================================================================*/
	public function listar_turma($anolectivo, $turma, $prof)
	{
		$this->db->select('*');													  					// select tudo
		$this->db->from('matricula');												 				// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
        $this->db->where("turma_id", $turma);									 					// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
		$this->db->join('turma', 'turma.id_turma = matricula.turma_id');							// join tbl turma e matricula
		$this->db->join('classe', 'classe.id_classe = turma.classe_id');							// Join tbl classe e [turma]
		$this->db->join('anolectivo', 'anolectivo.id_ano = matricula.anolectivo_id');				// join tbl ano lectivo e matricula
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id');						// join tbl periodo e turma
		$dados["listagem_alunos"] = $this->db->get()->row();										// retorna 1 linha
		if ( empty($dados["listagem_alunos"]) )
		{
			echo $this->session->set_flashdata('msg',"<div class='alert alert-warning text-center'>NÃO EXISTEM ALUNOS MATRICULADOS NA TURMA E ANO LECTIVO SELECIONADO
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span></button></div>");	
			redirect('secretaria/professor/turmas_professor_coordenacao/'.$prof);
		}
		elseif  ( !empty($dados["listagem_alunos"]) )
		{
			$this->db->select('*');																		// select tudo
			$this->db->from('matricula');																// da tbl matricula
			$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
        	$this->db->where("turma_id", $turma);														// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma 
			$this->db->order_by("nome", "asc");  														// Ordenar a travez do nome
			$this->db->join('aluno', 'aluno.id_aluno = matricula.aluno_id');		 					// Join tbl aluno e matricula
        	$this->db->join('anolectivo', 'anolectivo.id_ano = matricula.anolectivo_id'); 				// Join tbl anolectivo e matricula
			$this->db->join('turma', 'turma.id_turma = matricula.turma_id');		 					// Join tbl turma e matricula
			$dados['alunos'] = $this->db->get()->result();												// retorna várias linhas
			/* ===========================================================================================================*/
			$this->db->select('*');													  					// select tudo
			$this->db->from('prof_turma');												 				// da tbl prof_turma
			$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
			$this->db->where("turma_id", $turma);									 					// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
			$this->db->join('funcionario', 'funcionario.id_funcionario = prof_turma.funcionario_id');	// join tlb funcionario e prof_turma
			$dados["prof"] = $this->db->get()->row();													// retorna 1 linha
			/* ===========================================================================================================*/
			$this->load->view('layout/cabecalho');
			$this->load->view('layout/menu_lateral_secretaria');
			$this->load->view('conteudo/_secretaria/_listagem/listar_turma', $dados);
			$this->load->view('layout/rodape');
			$this->load->view('layout/script');
		}
	}
	public function listar_turma_secretaria($anolectivo, $turma, $prof)
	{
		$this->db->select('*');													  					// select tudo
		$this->db->from('matricula');												 				// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
        $this->db->where("turma_id", $turma);									 					// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
		$this->db->join('turma', 'turma.id_turma = matricula.turma_id');							// join tbl turma e matricula
		$this->db->join('classe', 'classe.id_classe = turma.classe_id');							// Join tbl classe [turma]
		$this->db->join('anolectivo', 'anolectivo.id_ano = matricula.anolectivo_id');				// join tbl ano_lectivo e matricula
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id');						// join tbl periodo e turma
		$dados["listagem_alunos"] = $this->db->get()->row();										// retorna 1 linha
		if ( empty($dados["listagem_alunos"]) )
		{
			echo $this->session->set_flashdata('msg',"<div class='alert alert-warning text-center'>NÃO EXISTEM ALUNOS MATRICULADOS NA TURMA E ANO LECTIVO SELECIONADO
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span></button></div>");	
			redirect('secretaria/professor/turmas_professor/'.$prof);
		}
		elseif  ( !empty($dados["listagem_alunos"]) )
		{
			$this->db->select('*');																		// select tudo
			$this->db->from('matricula');																// da tbl matricula
			$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
        	$this->db->where("turma_id", $turma);														// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma 
			$this->db->order_by("nome", "asc");  														// Ordenar a travez do nome
			$this->db->join('aluno', 'aluno.id_aluno = matricula.aluno_id');		 					// Join tbl aluno e matricula
        	$this->db->join('anolectivo', 'anolectivo.id_ano = matricula.anolectivo_id'); 				// Join tbl anolectivo e matricula
			$this->db->join('turma', 'turma.id_turma = matricula.turma_id');		 					// Join tbl turma e matricula
			$dados['alunos'] = $this->db->get()->result();												// retorna várias linhas
			/* ===========================================================================================================*/
			$this->db->select('*');													  					// select tudo
			$this->db->from('prof_turma');												 				// da tbl prof_turma
			$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
			$this->db->where("turma_id", $turma);									 					// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
			$this->db->join('funcionario', 'funcionario.id_funcionario = prof_turma.funcionario_id');	// join tbl funcionario e prof_turma
			$dados["prof"] = $this->db->get()->row();													// retorna 1 linha
			/* ===========================================================================================================*/
			$this->load->view('layout/cabecalho');
			$this->load->view('layout/menu_lateral_secretaria');
			$this->load->view('conteudo/_secretaria/_listagem/listar_turma', $dados);
			$this->load->view('layout/rodape');
			$this->load->view('layout/script');
		}
	}
	public function listar_turma_docente($anolectivo, $turma)
	{
		$this->db->select('*');													  					// select tudo
		$this->db->from('matricula');												 				// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
        $this->db->where("turma_id", $turma);									 					// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma 
		$this->db->join('turma', 'turma.id_turma = matricula.turma_id');							// join tbl turma e matricula
		$this->db->join('classe', 'classe.id_classe = turma.classe_id');							// Join tbl classe [turma]
		$this->db->join('anolectivo', 'anolectivo.id_ano = matricula.anolectivo_id');				// join tbl anolectivo e matricula
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id');						// join tbl periodo e turma
		$dados["listagem_alunos"] = $this->db->get()->row();										// retorna 1 linha
		if ( empty($dados["listagem_alunos"]) )
		{
			echo $this->session->set_flashdata('msg',"<div class='alert alert-warning text-center'>NÃO EXISTEM ALUNOS MATRICULADOS NA TURMA E ANO LECTIVO SELECIONADO
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span></button></div>");	
			redirect('home/docente');
		}
		elseif  ( !empty($dados["listagem_alunos"]) )
		{
			$this->db->select('*');																		// select tudo
			$this->db->from('matricula');																// da tbl matricula
			$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
	        $this->db->where("turma_id", $turma);														// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma 
			$this->db->order_by("nome", "asc");  														// Ordenar a travez do nome
			$this->db->join('aluno', 'aluno.id_aluno = matricula.aluno_id');		 					// Join tbl aluno e matricula
	        $this->db->join('anolectivo', 'anolectivo.id_ano = matricula.anolectivo_id'); 				// Join tbl anolectivo e matricula
			$this->db->join('turma', 'turma.id_turma = matricula.turma_id');		 					// Join tbl turma e matricula
			$dados['alunos'] = $this->db->get()->result();												// retorna várias linhas
			/* ===========================================================================================================*/
			$this->db->select('*');													  					// select tudo
			$this->db->from('prof_turma');												 				// da tbl matricula
			$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
			$this->db->where("turma_id", $turma);									 					// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
			$this->db->join('funcionario', 'funcionario.id_funcionario = prof_turma.funcionario_id');	// join tbl funcionario e prof_turma
			$dados["prof"] = $this->db->get()->row();													// retorna 1 linha
			/* ===========================================================================================================*/
			$this->load->view('layout/cabecalho');
			$this->load->view('layout/menu_lateral_docente');
			$this->load->view('conteudo/_secretaria/_listagem/listar_turma', $dados);
			$this->load->view('layout/rodape');
			$this->load->view('layout/script');
		}
	}
	public function listar_turma_docente_coordenador($anolectivo, $turma)
	{
		$this->db->select('*');													  					// select tudo
		$this->db->from('matricula');												 				// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
        $this->db->where("turma_id", $turma);									 					// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
		$this->db->join('turma', 'turma.id_turma = matricula.turma_id');							// join tbl turma e matricula
		$this->db->join('classe', 'classe.id_classe = turma.classe_id');							// Join tbl classe e [turma]
		$this->db->join('anolectivo', 'anolectivo.id_ano = matricula.anolectivo_id');				// join tbl anolectivo e matricula
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id');						// join tbl periodo e turma
		$dados["listagem_alunos"] = $this->db->get()->row();										// retorna 1 linha
		if ( empty($dados["listagem_alunos"]) )
		{
			echo $this->session->set_flashdata('msg',"<div class='alert alert-warning text-center'>NÃO EXISTEM ALUNOS MATRICULADOS NA TURMA E ANO LECTIVO SELECIONADO
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span></button></div>");	
			redirect('secretaria/professor/turma_coordenacao');
		}
		elseif  ( !empty($dados["listagem_alunos"]) )
		{
			$this->db->select('*');																		// select tudo
			$this->db->from('matricula');																// da tbl matricula
			$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
	        $this->db->where("turma_id", $turma);														// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
			$this->db->order_by("nome", "asc");  														// Ordenar a travez do nome
			$this->db->join('aluno', 'aluno.id_aluno = matricula.aluno_id');		 					// Join tbl aluno e matricula
	        $this->db->join('anolectivo', 'anolectivo.id_ano = matricula.anolectivo_id'); 				// Join tbl anolectivo e matricula
			$this->db->join('turma', 'turma.id_turma = matricula.turma_id');		 					// Join tbl turma e matricula
			$dados['alunos'] = $this->db->get()->result();												// retorna várias linhas
			/* ===========================================================================================================*/
			$this->db->select('*');													  					// select tudo
			$this->db->from('prof_turma');												 				// da tbl matricula
			$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
			$this->db->where("turma_id", $turma);									 					// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
			$this->db->join('funcionario', 'funcionario.id_funcionario = prof_turma.funcionario_id');	// join tbl funcionario e prof_turma
			$dados["prof"] = $this->db->get()->row();													// retorna 1 linha
			/* ===========================================================================================================*/
			$this->load->view('layout/cabecalho');
			$this->load->view('layout/menu_lateral_coordenacao');
			$this->load->view('conteudo/_secretaria/_listagem/listar_turma', $dados);
			$this->load->view('layout/rodape');
			$this->load->view('layout/script');
		}
	}
	public function listar_assiduidade_turma($anolectivo, $turma)
	{
		$this->db->select('*');													  					// select tudo
		$this->db->from('matricula');												 				// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
        $this->db->where("turma_id", $turma);									 					// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
		$this->db->join('turma', 'turma.id_turma = matricula.turma_id');							// join tbl turma e matricula
		$this->db->join('classe', 'classe.id_classe = turma.classe_id');							// Join tbl classe [turma]
		$this->db->join('anolectivo', 'anolectivo.id_ano = matricula.anolectivo_id');				// join tbl anolectivo e matricula
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id');						// join tbl periodo e turma
		$dados["listagem_alunos"] = $this->db->get()->row();										// retorna 1 linha
		if ( empty($dados["listagem_alunos"]) )
		{
			echo $this->session->set_flashdata('msg',"<div class='alert alert-warning text-center'>NÃO EXISTEM ALUNOS MATRICULADOS NA TURMA E ANO LECTIVO SELECIONADO
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span></button></div>");
			redirect('home/docente');
		}
		elseif  ( !empty($dados["listagem_alunos"]) )
		{
			$this->db->select('*');																		// select tudo
			$this->db->from('matricula');																// da tbl matricula
			$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
        	$this->db->where("turma_id", $turma);														// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma 
			$this->db->order_by("nome", "asc");  														// Ordenar a travez do nome
			$this->db->join('aluno', 'aluno.id_aluno = matricula.aluno_id');		 					// Join tbl aluno e matricula
        	$this->db->join('anolectivo', 'anolectivo.id_ano = matricula.anolectivo_id'); 				// Join tbl anolectivo e matricula
			$this->db->join('turma', 'turma.id_turma = matricula.turma_id');		 					// Join tbl turma e matricula
			$dados['alunos'] = $this->db->get()->result();												// retorna várias linhas
			/* ===========================================================================================================*/
			$this->db->select('*');													  					// select tudo
			$this->db->from('prof_turma');												 				// da tbl matricula
			$this->db->where("anolectivo_id", $anolectivo);												// onde
			$this->db->where("turma_id", $turma);									 					// onde
			$this->db->join('funcionario', 'funcionario.id_funcionario = prof_turma.funcionario_id');	// join ano lectivo e matricula
			$dados["prof"] = $this->db->get()->row();													// retorna 1 linha
			/* ===========================================================================================================*/
			$this->load->view('layout/cabecalho');
			$this->load->view('layout/menu_lateral_docente');
			$this->load->view('conteudo/_secretaria/_listagem/listar_assiduidade_turma', $dados);
			$this->load->view('layout/rodape');
			$this->load->view('layout/script');
		}
	}
	public function listar_assiduidade_turma_coordenador($anolectivo, $turma)
	{
		$this->db->select('*');													  					// select tudo
		$this->db->from('matricula');												 				// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);												// onde
        $this->db->where("turma_id", $turma);									 					// onde
		$this->db->join('turma', 'turma.id_turma = matricula.turma_id');							// join turma e matricula
		$this->db->join('classe', 'classe.id_classe = turma.classe_id');							// Join tbl classe [turma]
		$this->db->join('anolectivo', 'anolectivo.id_ano = matricula.anolectivo_id');				// join ano lectivo e matricula
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id');						// join periodo e turma
		$dados["listagem_alunos"] = $this->db->get()->row();										// retorna 1 linha
		if ( empty($dados["listagem_alunos"]) )
		{
			echo $this->session->set_flashdata('msg',"<div class='alert alert-warning text-center'>NÃO EXISTEM ALUNOS MATRICULADOS NA TURMA E ANO LECTIVO SELECIONADO
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span></button></div>");
			redirect('secretaria/professor/turma_coordenacao');
		}
		elseif  ( !empty($dados["listagem_alunos"]) )
		{
			$this->db->select('*');																		// select tudo
			$this->db->from('matricula');																// da tbl matricula
			$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
        	$this->db->where("turma_id", $turma);														// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma 
			$this->db->order_by("nome", "asc");  														// Ordenar a travez do nome
			$this->db->join('aluno', 'aluno.id_aluno = matricula.aluno_id');		 					// Join tbl aluno e matricula
        	$this->db->join('anolectivo', 'anolectivo.id_ano = matricula.anolectivo_id'); 				// Join tbl anolectivo e matricula
			$this->db->join('turma', 'turma.id_turma = matricula.turma_id');		 					// Join tbl turma e matricula
			$dados['alunos'] = $this->db->get()->result();												// retorna várias linhas
			/* ===========================================================================================================*/
			$this->db->select('*');													  					// select tudo
			$this->db->from('prof_turma');												 				// da tbl matricula
			$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
        	$this->db->where("turma_id", $turma);														// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma 
			$this->db->join('funcionario', 'funcionario.id_funcionario = prof_turma.funcionario_id');	// join funcionario e prof_turma
			$dados["prof"] = $this->db->get()->row();													// retorna 1 linha
			/* ===========================================================================================================*/
			$this->load->view('layout/cabecalho');
			$this->load->view('layout/menu_lateral_docente');
			$this->load->view('conteudo/_secretaria/_listagem/listar_assiduidade_turma', $dados);
			$this->load->view('layout/rodape');
			$this->load->view('layout/script');
		}
	}
	public function mapa_assiduidade($anolectivo, $turma, $aluno)
	{
		$this->db->select('*');													  // select tudo
		$this->db->from('aula');												 // da tbl aula
		$this->db->where("anolectivo_id", $anolectivo);								// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
        $this->db->where("turma_id", $turma);									 	// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
        $this->db->where("aluno_id", $aluno);									 	// onde o valor da coluna "aluno_id" é igual ao valor passado como parâmetro $aluno
		$this->db->join('aluno', 'aluno.id_aluno = aula.aluno_id');				// join tbl aluno e [aula]
		$this->db->join('anolectivo', 'anolectivo.id_ano = aula.anolectivo_id');// join tbl anolectivo e [aula]
		$this->db->join('turma', 'turma.id_turma = aula.turma_id');				// join tbl turma e [aula]
		$this->db->join('classe', 'classe.id_classe = turma.classe_id');		// Join tbl classe e [turma]
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id');	// join tbl periodo e [turma]
		$dados["listagem_alunos"] = $this->db->get()->row();					// retorna 1 linha
		/*			Total de Faltas 
		------------------------------------------------------------------------------------------------------------- */
		$this->db->select('*');													// select tudo
		$this->db->from('aula');												// da tbl aula
        $this->db->where("turma_id", $turma);										// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
		$this->db->where("anolectivo_id", $anolectivo);								// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
        $this->db->where("aluno_id", $aluno);										// onde o valor da coluna "aluno_id" é igual ao valor passado como parâmetro $aluno
        $this->db->where("falta", '1');									 			// onde o valor da coluna "falta" é igual a 1
		$dados["numero_faltas"] = $this->db->get()->num_rows();					// retorna várias linhas
		/*			Total de Falts Justificadas 
		------------------------------------------------------------------------------------------------------------- */
		$this->db->select('*');													  // select tudo
		$this->db->from('aula');												 // da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);								// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
        $this->db->where("turma_id", $turma);									 	// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
        $this->db->where("aluno_id", $aluno);									 	// onde o valor da coluna "aluno_id" é igual ao valor passado como parâmetro $aluno
        $this->db->where("justificacao", '1');									 	// onde o valor da coluna "justificação" é igual a 1
		$dados["faltas_justificadas"] = $this->db->get()->num_rows();			// retorna várias linhas
		/*			Total de Faltas Nao Justificadas 
		------------------------------------------------------------------------------------------------------------- */
		$this->db->select('*');													// select tudo
		$this->db->from('aula');												// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);								// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
        $this->db->where("turma_id", $turma);									 	// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
        $this->db->where("aluno_id", $aluno);									 	// onde o valor da coluna "aluno_id" é igual ao valor passado como parâmetro $aluno
        $this->db->where("justificacao", '0');									 	// onde o valor da coluna "justificação" é igual a 0
		$dados["faltas_n_justificadas"] = $this->db->get()->num_rows();			// retorna várias linhas
		/* ------------------------------------------------------------------------------------------------------------- */
		if (empty($dados["listagem_alunos"]))
		{
			echo $this->session->set_flashdata('msg',"<div class='alert alert-warning text-center'>NEHUMA FALTA MARCADA AOS ALUNOS DESTA TURMA
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span></button></div>");
			redirect('secretaria/listagem/listar_assiduidade_turma/'.$anolectivo.'/'.$turma);
		}
		elseif (!empty($dados["listagem_alunos"]))
		{
			$this->db->select('*');													// select tudo
			$this->db->from('aula');												// da tbl aula
			$this->db->where("anolectivo_id", $anolectivo);								// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
			$this->db->where("turma_id", $turma);									 	// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
			$this->db->where("aluno_id", $aluno);									 	// onde o valor da coluna "aluno_id" é igual ao valor passado como parâmetro $aluno
			$this->db->order_by("data", "asc");  									// Ordenar a travez da data
			$this->db->join('aluno', 'aluno.id_aluno = aula.aluno_id');		 		// Join aluno e aula
        	$this->db->join('anolectivo', 'anolectivo.id_ano = aula.anolectivo_id'); // Join anolectivo e aula
			$this->db->join('turma', 'turma.id_turma = aula.turma_id');		 		// Join turma e matricula
			$dados['alunos'] = $this->db->get()->result();							// retorna várias linhas
			/* ===========================================================================================================*/
			$this->db->select('*');													  	// select tudo
			$this->db->from('prof_turma');												// da tbl prof_turma
			$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
			$this->db->where("turma_id", $turma);									 		// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
			$this->db->join('funcionario', 'funcionario.id_funcionario = prof_turma.funcionario_id');	// join funcionario e prof_turma
			$dados["prof"] = $this->db->get()->row();													// retorna 1 linha
			/* ===========================================================================================================*/
			$this->load->view('layout/cabecalho');
			$this->load->view('layout/menu_lateral_docente');
			$this->load->view('conteudo/_secretaria/_listagem/mapa_assiduidade', $dados);
			$this->load->view('layout/modal_aluno');
			$this->load->view('layout/rodape');
			$this->load->view('layout/script');
		}
	}
	public function justificar_falta($id_aula)
	{
		$this->db->select('*');													  	// select tudo
		$this->db->from('aula');												 	// da tbl aula
		$this->db->where("id_aula", $id_aula);											// onde o valor da coluna "id_aula" é igual ao valor passado como parâmetro $id_aula
		$this->db->join('aluno', 'aluno.id_aluno = aula.aluno_id');					// join aluno e aula
		$this->db->join('anolectivo', 'anolectivo.id_ano = aula.anolectivo_id');	// join anolectivo e aula
		$this->db->join('turma', 'turma.id_turma = aula.turma_id');					// join turma e aula
		$this->db->join('classe', 'classe.id_classe = turma.classe_id');			// Join tbl classe e [turma]
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id');		// join periodo e [turma]
		$dados["listagem_alunos"] = $this->db->get()->row();						// retorna 1 linha
		/* ------------------------------------------------------------------------------------------------------------- */
		$this->db->select('*');														// select tudo
		$this->db->from('aula');													// da tbl aula
		$this->db->where("id_aula", $id_aula);										// onde o valor da coluna "id_aula" é igual ao valor passado como parâmetro $id_aula
		$this->db->order_by("data", "asc");  										// Ordenar a travez da data
		$this->db->join('aluno', 'aluno.id_aluno = aula.aluno_id');		 			// Join aluno e [aula]
		$this->db->join('anolectivo', 'anolectivo.id_ano = aula.anolectivo_id'); 	// Join anolectivo e [aula]
		$this->db->join('turma', 'turma.id_turma = aula.turma_id');		 			// Join turma e [aula]
		$dados['alunos'] = $this->db->get()->result();								// retorna várias linhas
		/* ===========================================================================================================*/
		$this->load->view('layout/cabecalho');
		$this->load->view('layout/menu_lateral_docente');
		$this->load->view('conteudo/_secretaria/_listagem/justificar_falta', $dados);
		$this->load->view('layout/modal_aluno');
		$this->load->view('layout/rodape');
		$this->load->view('layout/script');
	}
	public function mapa_assiduidade_geral($anolectivo, $turma)
	{
		$this->db->select('*');													  	// select tudo
		$this->db->from('aula');												 	// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
    	$this->db->where("turma_id", $turma);									 		// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
		$this->db->join('aluno', 'aluno.id_aluno = aula.aluno_id');					// join ano lectivo e [aula]
		$this->db->join('anolectivo', 'anolectivo.id_ano = aula.anolectivo_id');	// join ano lectivo e [aula]
		$this->db->join('turma', 'turma.id_turma = aula.turma_id');					// join turma e [aula]
		$this->db->join('classe', 'classe.id_classe = turma.classe_id');			// Join tbl classe e [turma]
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id');		// join periodo e [turma]
		$dados["listagem_alunos"] = $this->db->get()->row();						// retorna 1 linha
		/* ------------------------------------------------------------------------------------------------------------- */
		if (empty($dados["listagem_alunos"]))
		{
			echo $this->session->set_flashdata('msg',"<div class='alert alert-warning text-center'>NEHUMA FALTA MARCADA AOS ALUNOS DESTA TURMA
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span></button></div>");

			redirect('secretaria/listagem/listar_assiduidade_turma/'.$anolectivo.'/'.$turma);
		}
		elseif (!empty($dados["listagem_alunos"]))
		{
			/* ===========================================================================================================*/
			$this->db->from('aula');													// de notas disciplina
			$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo

			$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
			$this->db->join('aluno', 'aluno.id_aluno = aula.aluno_id', 'left');			// join turma e matricula
			$this->db->group_by('aula.aluno_id');											// agrupamento
			$this->db->order_by("nome", "asc");  											// Ordenar a travez do nome
			$dados['alunos'] = $this->db->get()->result();								// retorna várias linhas
			/*--------------------------------------------------------------------------------------------------------------------------------*/
			$this->db->select_sum('falta');												// seleciona a soma da coluna "falta"
			$this->db->select_sum('justificacao');										// e da coluna "justificacao"
			$this->db->from('aula');													// de notas disciplina
			$this->db->where("anolectivo_id", $anolectivo);								// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
			$this->db->where("turma_id", $turma);										// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
			$this->db->join('aluno', 'aluno.id_aluno = aula.aluno_id', 'left');			// join tbl aluno e aula
			$this->db->group_by('aula.aluno_id');											// agrupamento
			$this->db->order_by("nome", "asc");  										// Ordenar a travez do nome
			$dados['num_faltas'] = $this->db->get()->result();							// retorna várias linhas
			/* ===========================================================================================================*/
			$this->db->select('*');													  					// select tudo
			$this->db->from('prof_turma');												 				// da tbl prof_turma
			$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
			$this->db->where("turma_id", $turma);									 					// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
			$this->db->join('funcionario', 'funcionario.id_funcionario = prof_turma.funcionario_id');	// join funcionario e prof_turma
			$dados["prof"] = $this->db->get()->row();													// retorna 1 linha
			/* ===========================================================================================================*/
			$this->load->view('layout/cabecalho');
			$this->load->view('layout/menu_lateral_docente');
			$this->load->view('conteudo/_secretaria/_listagem/mapa_assiduidade_geral', $dados);
			$this->load->view('layout/modal_aluno');
			$this->load->view('layout/rodape');
			$this->load->view('layout/script');
		}
	}
	/*					 							listar alunos/ano/turma
	==================================================================================================================*/
	public function listar_aluno_turma()
	{
		$anolectivo = $this->input->post('anolectivo');
		$turma_id   = $this->input->post('turma_id');
		/* ===========================================================================================================*/
		$dados["options_anos"] = $this->Ano_Model->selectAnos();
		$dados["options_turmas"] = $this->Turmas_Model->selectTurmas();
		$dados["options_classe"] = $this->Classe_Model->selectClasses();
		$dados["options_disciplinas"] = $this->Disciplina_Model->selectDisciplinas();	
		/* ===========================================================================================================*/
		$this->db->select('*');													  		// select tudo
		$this->db->from('matricula');												 	// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);									// onde
        $this->db->where("turma_id", $turma_id);									 	// onde
		$this->db->join('turma', 'turma.id_turma = matricula.turma_id');				// join turma e turma
		$this->db->join('classe', 'classe.id_classe = turma.classe_id');				// Join tbl classe e [turma]
		$this->db->join('anolectivo', 'anolectivo.id_ano = matricula.anolectivo_id');	// join ano lectivo e [matricula]
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id');			// join tbl periodo e [turma]
		$this->db->join('turma_sala', 'turma_sala.id_turma = turma.id_turma');
		$this->db->join('sala', 'sala.id_sala = turma_sala.id_sala');		 		// Join sala e [turma_sala]
		$dados["listagem_alunos"] = $this->db->get()->row();							// retorna 1 linha
		if (empty($dados["listagem_alunos"]))
		{
			echo $this->session->set_flashdata('msg',"<div class='alert alert-warning text-center'>TURMA OU ANO LECTIVO SEM ALUNOS MATRICULADOS</div>");
			redirect('secretaria/listagem');
		}
		elseif  (!empty($dados["listagem_alunos"])) {
			$this->db->select('*');															// select tudo
			$this->db->from('matricula');													// da tbl matricula
			$this->db->where("anolectivo_id", $anolectivo);									// onde
			$this->db->where("turma_id", $turma_id);										// onde 
			$this->db->order_by("nome", "asc");  											// Ordenar a travez do nome
			$this->db->join('aluno', 'aluno.id_aluno = matricula.aluno_id');		 		// Join aluno e matricula
			$this->db->join('anolectivo', 'anolectivo.id_ano = matricula.anolectivo_id'); 	// Join anolectivo e matricula
			$this->db->join('turma', 'turma.id_turma = matricula.turma_id');		 		// Join turma e matricula
			$dados['alunos'] = $this->db->get()->result();									// retorna várias linhas
			/* ===========================================================================================================*/
			$this->load->view('layout/cabecalho');
			$this->load->view('layout/menu_lateral_secretaria');
			$this->load->view('conteudo/_secretaria/_listagem/listar_aluno_turma', $dados);
			$this->load->view('layout/rodape');
			$this->load->view('layout/script');
		}
	}
	/*					 							listar alunos/ano/turma
	==================================================================================================================*/
	public function listar_aluno_turma_pdf($anolectivo, $turma)
	{
		$this->db->select('*');															// select tudo
		$this->db->from('matricula');													// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);									// onde
    	$this->db->where("turma_id", $turma);											// onde 
		$this->db->order_by("nome", "asc");  											// Ordenar a travez do nome
		$this->db->join('aluno', 'aluno.id_aluno = matricula.aluno_id');		 		// Join aluno e matricula
    	$this->db->join('anolectivo', 'anolectivo.id_ano = matricula.anolectivo_id'); 	// Join anolectivo e matricula
		$this->db->join('turma', 'turma.id_turma = matricula.turma_id');		 		// Join turma e matricula
		$dados['alunos'] = $this->db->get()->result();									// retorna várias linhas
		/* ===========================================================================================================*/
		$this->db->select('*');													  		// select tudo
		$this->db->from('matricula');												 	// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);									// onde
    	$this->db->where("turma_id", $turma);									 		// onde
		$this->db->join('turma', 'turma.id_turma = matricula.turma_id');				// join turma e matricula
		$this->db->join('classe', 'classe.id_classe = turma.classe_id');				// join classe e turma
		$this->db->join('anolectivo', 'anolectivo.id_ano = matricula.anolectivo_id');	// join ano lectivo e matricula
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id');			// join periodo e turma
		$this->db->join('turma_sala', 'turma_sala.id_turma = turma.id_turma');			// join turma_sala e turma
		$this->db->join('sala', 'sala.id_sala = turma_sala.id_sala');		 			// Join sala e turma_Sala
		$dados["listagem_alunos"] = $this->db->get()->row();							// retorna 1 linha
		/* ===========================================================================================================*/
		$this->db->select('*');													  					// select tudo
		$this->db->from('prof_turma');												 				// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);												// onde
		$this->db->where("turma_id", $turma);									 					// onde
		$this->db->join('funcionario', 'funcionario.id_funcionario = prof_turma.funcionario_id');	// join ano lectivo e matricula
		$dados["prof"] = $this->db->get()->row();													// retorna 1 linha
		/* ===========================================================================================================*/
		// Carrega o PDF
		$this->load->library("My_dompdf");
		$this->my_dompdf->gerar_pdf('reports/listar_aluno_turma_pdf', $dados, TRUE);
	}
	/*					 							listar alunos/ano/turma
	==================================================================================================================*/
	public function mini_pauta_pdf( $anolectivo, $turma, $disciplina, $classe )
	{
		$this->db->select('*');													  					// select tudo
		$this->db->from('notas_disciplina');												 		// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);												// filtro - ano-lectivo
		$this->db->where("turma_id", $turma);														// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
		$this->db->where("disciplina_id", $disciplina);												// filtro - disciplina
		$this->db->join('turma', 'turma.id_turma = notas_disciplina.turma_id');						// join turma e matricula
		$this->db->join('classe', 'classe.id_classe  = turma.classe_id');							// Join tbl classe [turma]
		$this->db->join('anolectivo', 'anolectivo.id_ano = notas_disciplina.anolectivo_id');		// join ano lectivo e matricula
		$this->db->join('disciplina', 'disciplina.id_disciplina = notas_disciplina.disciplina_id');	// join ano lectivo e matricula
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id');						// join periodo e turma
		$dados["listagem_alunos"] = $this->db->get()->row();										// retorna 1 linha
		/* =====================================================================================================================*/
		$this->db->select('*');																		// select tudo
		$this->db->from('notas_disciplina');														// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo

		$this->db->where("turma_id", $turma);														// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
		$this->db->where("disciplina_id", $disciplina);												// filtro - disciplina
		$this->db->order_by("nome", "asc");  														// Ordenar a travez do nome
		$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id');		 				// Join aluno e matricula
		$this->db->join('anolectivo', 'anolectivo.id_ano = notas_disciplina.anolectivo_id'); 		// Join anolectivo e matricula
		$this->db->join('turma', 'turma.id_turma = notas_disciplina.turma_id');		 				// Join turma e matricula
		$dados['alunos'] = $this->db->get()->result();												// retorna várias linhas
		/* ===========================================================================================================*/
		// Carrega o PDF
		if ($classe == 41) 
		{
		// SE classe = iniciação - chama a view da iniciação
		$this->load->library("My_dompdf");
		$this->my_dompdf->gerar_pdf('reports/mini_pauta_iniciacao_pdf', $dados, TRUE);
		} else {
		// SE não - chama a view padrão
		$this->load->library("My_dompdf");
		$this->my_dompdf->gerar_pdf('reports/mini_pauta_pdf', $dados, TRUE);		
		}
	}
	//==================================================================================================================
	//												listar alunos/ano/turma
	//==================================================================================================================
	public function listar_aluno_disciplina()
	{
        $anolectivo = $this->input->post('anolectivo');
        $turma_id = $this->input->post('turma_id');
		/* ===========================================================================================================*/
		$this->db->select('*');															 	 // select tudo
		$this->db->from('notas_disciplina');											 	 // da tbl matricula
		/*------------------------------------------------------------------------------------------------------------*/
		$this->db->where("anolectivo_id", $anolectivo);									 	 // onde
        $this->db->where("turma_id", $turma_id);										 	 // onde 
		/*------------------------------------------------------------------------------------------------------------*/
		$this->db->order_by("nome", "asc");  												 // Ordenar a travez do nome
		$this->db->join('aluno', 	  'aluno.id_aluno 	 = notas_disciplina.aluno_id');		 // Join aluno e matricula
        $this->db->join('anolectivo', 'anolectivo.id_ano = notas_disciplina.anolectivo_id'); // Join anolectivo e matricula
		$this->db->join('turma', 	  'turma.id_turma 	 = notas_disciplina.turma_id');		 // Join turma e matricula
		$dados['alunos'] = $this->db->get()->result();									 	 // retorna várias linhas
		/* ===========================================================================================================*/
		$this->db->select('*');												// select tudo
		$this->db->from('notas_disciplina');								// da tbl matricula
		/*------------------------------------------------------------------------------------------------------------*/
		$this->db->where("anolectivo_id", $anolectivo);						// onde
        $this->db->where("turma_id", $turma_id);							// onde 
		/*------------------------------------------------------------------------------------------------------------*/
		$this->db->join('turma',  	  'turma.id_turma     = notas_disciplina.turma_id');  		 	 // join turma e matricula
		$this->db->join('classe', 	  'classe.id_classe   = notas_disciplina.classe_id');  	 		 // join classe e matricula
		$this->db->join('anolectivo', 'anolectivo.id_ano  = notas_disciplina.anolectivo_id');  		 // join ano lectivo e matricula
		$this->db->join('periodo', 	  'periodo.id_periodo = turma.periodo_id');		 	 			 // join periodo e turma
		$this->db->join('disciplina', 'disciplina.id_disciplina = notas_disciplina.disciplina_id');	 // join periodo e turma
		$dados["listagem_alunos"] = $this->db->get()->row();										 // retorna 1 linha
		/* ===========================================================================================================*/
		$this->load->view('layout/cabecalho');
		$this->load->view('layout/menu_lateral_secretaria');
		$this->load->view('conteudo/_secretaria/_aluno/listar_aluno_disciplina', $dados);
		$this->load->view('layout/rodape');
		$this->load->view('layout/script');
	}
	/*================================================================================================================*/
	/*					 							listar alunos/ano/turma
	==================================================================================================================*/
	public function listar_disciplinas($anolectivo, $turma, $classe)
	{
		$this->db->select('*');													  								// select tudo
		$this->db->from('notas_disciplina');												 					// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);															// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo

		$this->db->where("turma_id", $turma);									 								// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
		$this->db->join('turma', 'turma.id_turma = notas_disciplina.turma_id', 'left');							// join turma e matricula
		$this->db->join('classe', 'classe.id_classe  = turma.classe_id', 'left');								// Join tbl classe [turma]
		$this->db->join('anolectivo', 'anolectivo.id_ano = notas_disciplina.anolectivo_id', 'left');			// join ano lectivo e matricula
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id', 'left');							// join periodo e turma
		$dados["listagem_alunos"] = $this->db->get()->row();													// retorna 1 linha
		if ( empty($dados["listagem_alunos"]) )
		{
			echo $this->session->set_flashdata('msg',"<div class='alert alert-warning text-center'>NÃO EXISTEM ALUNOS MATRICULADOS NA TURMA E ANO LECTIVO SELECIONADO</div>");	
			redirect('home/docente');
		}
		elseif  ( !empty($dados["listagem_alunos"]) )
		{

			$this->db->select('*');																					// seleciona tudo
			$this->db->from('notas_disciplina');																	// de notas disciplina
			$this->db->where("anolectivo_id", $anolectivo);															// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo

			$this->db->where("turma_id", $turma);																	// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
			$this->db->join('disciplina', 'disciplina.id_disciplina = notas_disciplina.disciplina_id', 'left');		// join turma e matricula
			$this->db->join('anolectivo', 'anolectivo.id_ano = notas_disciplina.anolectivo_id', 'left');			// join turma e matricula
			$this->db->join('turma', 'turma.id_turma = notas_disciplina.turma_id', 'left');							// join turma e matricula
			$this->db->join('classe', 'classe.id_classe  = turma.classe_id');										// Join tbl classe [turma]
			$this->db->group_by('notas_disciplina.disciplina_id');													// agrupamento
			$dados['disciplinas'] = $this->db->get()->result();														// retorna várias linhas
			/* ---------------------------------------------------------------------------------------------------------------------------- */
			$this->load->view('layout/cabecalho');
			$this->load->view('layout/menu_lateral_docente');
			$this->load->view('conteudo/_secretaria/_disciplina/ver_disciplinas', $dados);
			$this->load->view('layout/rodape');
			$this->load->view('layout/script');
		}
	}
	/*================================================================================================================*/
	/*					 							listar alunos/ano/turma
	==================================================================================================================*/
	public function listar_mini_pautas()
	{
		$anolectivo = $this->input->post('anolectivo');
		$turma   = $this->input->post('turma_id');
		/*------------------------------------------------------*/ 
		$this->db->select('*');													  								// select tudo
		$this->db->from('notas_disciplina');												 					// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);															// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo

		$this->db->where("turma_id", $turma);									 								// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
		$this->db->join('turma', 'turma.id_turma = notas_disciplina.turma_id', 'left');							// join turma e matricula
		$this->db->join('classe', 'classe.id_classe  = turma.classe_id', 'left');								// Join tbl classe [turma]
		$this->db->join('anolectivo', 'anolectivo.id_ano = notas_disciplina.anolectivo_id', 'left');			// join ano lectivo e matricula
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id', 'left');							// join periodo e turma
		$dados["listagem_alunos"] = $this->db->get()->row();													// retorna 1 linha
		if ( empty($dados["listagem_alunos"]) )
		{
			echo $this->session->set_flashdata('msg',"<div class='alert alert-warning text-center'>NÃO EXISTEM ALUNOS MATRICULADOS NA TURMA E ANO LECTIVO SELECIONADO</div>");	
			redirect('secretaria/listagem/mini_pautas');
		}
		elseif  ( !empty($dados["listagem_alunos"]) )
		{

			$this->db->select('*');																					// seleciona tudo
			$this->db->from('notas_disciplina');																	// de notas disciplina
			$this->db->where("anolectivo_id", $anolectivo);															// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo

			$this->db->where("turma_id", $turma);																	// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
			$this->db->join('disciplina', 'disciplina.id_disciplina = notas_disciplina.disciplina_id', 'left');		// join turma e matricula
			$this->db->join('anolectivo', 'anolectivo.id_ano = notas_disciplina.anolectivo_id', 'left');			// join turma e matricula
			$this->db->join('turma', 'turma.id_turma = notas_disciplina.turma_id', 'left');							// join turma e matricula
			$this->db->join('classe', 'classe.id_classe  = turma.classe_id');										// Join tbl classe [turma]
			$this->db->group_by('notas_disciplina.disciplina_id');													// agrupamento
			$dados['disciplinas'] = $this->db->get()->result();														// retorna várias linhas
			/* ---------------------------------------------------------------------------------------------------------------------------- */
			$this->load->view('layout/cabecalho');
			$this->load->view('layout/menu_lateral_coordenacao');
			$this->load->view('conteudo/_secretaria/_disciplina/ver_disciplinas_coordenacao', $dados);
			$this->load->view('layout/rodape');
			$this->load->view('layout/script');
		}
	}
	public function listar_disciplinas_coordenador($anolectivo, $turma, $classe)
	{
		$this->db->select('*');													  								// select tudo
		$this->db->from('notas_disciplina');												 					// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);															// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo

		$this->db->where("turma_id", $turma);									 								// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
		$this->db->join('turma', 'turma.id_turma = notas_disciplina.turma_id', 'left');							// join turma e matricula
		$this->db->join('classe', 'classe.id_classe  = turma.classe_id', 'left');								// Join tbl classe [turma]
		$this->db->join('anolectivo', 'anolectivo.id_ano = notas_disciplina.anolectivo_id', 'left');			// join ano lectivo e matricula
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id', 'left');							// join periodo e turma
		$dados["listagem_alunos"] = $this->db->get()->row();													// retorna 1 linha
		if ( empty($dados["listagem_alunos"]) )
		{
			echo $this->session->set_flashdata('msg',"<div class='alert alert-warning text-center'>NÃO EXISTEM ALUNOS MATRICULADOS NA TURMA E ANO LECTIVO SELECIONADO</div>");	
			redirect('secretaria/professor/turma_coordenacao');
		}
		elseif  ( !empty($dados["listagem_alunos"]) )
		{

			$this->db->select('*');																					// seleciona tudo
			$this->db->from('notas_disciplina');																	// de notas disciplina
			$this->db->where("anolectivo_id", $anolectivo);															// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo

			$this->db->where("turma_id", $turma);																	// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
			$this->db->join('disciplina', 'disciplina.id_disciplina = notas_disciplina.disciplina_id', 'left');		// join turma e matricula
			$this->db->join('anolectivo', 'anolectivo.id_ano = notas_disciplina.anolectivo_id', 'left');			// join turma e matricula
			$this->db->join('turma', 'turma.id_turma = notas_disciplina.turma_id', 'left');							// join turma e matricula
			$this->db->join('classe', 'classe.id_classe  = turma.classe_id');										// Join tbl classe [turma]
			$this->db->group_by('notas_disciplina.disciplina_id');													// agrupamento
			$dados['disciplinas'] = $this->db->get()->result();														// retorna várias linhas
			/* ---------------------------------------------------------------------------------------------------------------------------- */
			$this->load->view('layout/cabecalho');
			$this->load->view('layout/menu_lateral_docente');
			$this->load->view('conteudo/_secretaria/_disciplina/ver_disciplinas', $dados);
			$this->load->view('layout/rodape');
			$this->load->view('layout/script');
		}
	}
	/*================================================================================================================*/
	/*					 							LANÇAR NOTAS
	==================================================================================================================*/
	public function lancar_notas($anolectivo, $turma, $disciplina, $classe )
	{
		/* =====================================================================================================================*/
		$dados["options_anos"] = $this->Ano_Model->selectAnos();
		$dados["options_turmas"] = $this->Turmas_Model->selectTurmas();
		$dados["options_classe"] = $this->Classe_Model->selectClasses();
		$dados["options_disciplinas"] = $this->Disciplina_Model->selectDisciplinas();
		/* =====================================================================================================================*/
		$this->db->select('*');													  					// select tudo
		$this->db->from('notas_disciplina');												 		// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);												// filtro - ano-lectivo
		$this->db->where("turma_id", $turma);														// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
		$this->db->where("disciplina_id", $disciplina);												// filtro - disciplina
		$this->db->join('turma', 'turma.id_turma = notas_disciplina.turma_id');						// join turma e matricula
		$this->db->join('classe', 'classe.id_classe  = turma.classe_id');							// Join tbl classe [turma]
		$this->db->join('anolectivo', 'anolectivo.id_ano = notas_disciplina.anolectivo_id');		// join ano lectivo e matricula
		$this->db->join('disciplina', 'disciplina.id_disciplina = notas_disciplina.disciplina_id');	// join ano lectivo e matricula
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id');						// join periodo e turma
		$dados["listagem_alunos"] = $this->db->get()->row();										// retorna 1 linha
		/* =====================================================================================================================*/
		$this->db->select('*');																		// select tudo
		$this->db->from('notas_disciplina');														// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo

		$this->db->where("turma_id", $turma);														// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
		$this->db->where("disciplina_id", $disciplina);												// filtro - disciplina
		$this->db->order_by("nome", "asc");  														// Ordenar a travez do nome
		$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id');		 				// Join aluno e matricula
		$this->db->join('anolectivo', 'anolectivo.id_ano = notas_disciplina.anolectivo_id'); 		// Join anolectivo e matricula
		$this->db->join('turma', 'turma.id_turma = notas_disciplina.turma_id');		 				// Join turma e matricula
		$this->db->join('classe', 'classe.id_classe  = turma.classe_id');							// Join tbl classe [turma]
		$dados['alunos'] = $this->db->get()->result();												// retorna várias linhas
		/* =====================================================================================================================*/
		if ($classe == 41) 
		{
			// SE classe = iniciação - chama a view da iniciação
			$this->load->view('layout/cabecalho');
			$this->load->view('layout/menu_lateral_docente');
			$this->load->view('conteudo/_secretaria/_professor/mini_pauta_iniciacao', $dados);
			$this->load->view('layout/rodape');
			$this->load->view('layout/script');
		} else {
			// SE não - chama a view padrão
			$this->load->view('layout/cabecalho');
			$this->load->view('layout/menu_lateral_docente');
			$this->load->view('conteudo/_secretaria/_professor/mini_pauta', $dados);
			$this->load->view('layout/rodape');
			$this->load->view('layout/script');
		}
	}
	/*================================================================================================================*/
	/*					 							LANÇAR NOTAS
	==================================================================================================================*/
	public function mini_pautas_coordenacao($anolectivo, $turma, $disciplina, $classe )
	{
		/* =====================================================================================================================*/
		$dados["options_anos"] = $this->Ano_Model->selectAnos();
		$dados["options_turmas"] = $this->Turmas_Model->selectTurmas();
		$dados["options_classe"] = $this->Classe_Model->selectClasses();
		$dados["options_disciplinas"] = $this->Disciplina_Model->selectDisciplinas();
		/* =====================================================================================================================*/
		$this->db->select('*');	// select tudo
		$this->db->from('notas_disciplina'); // da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo); // filtro - ano-lectivo
		$this->db->where("turma_id", $turma); // onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
		$this->db->where("disciplina_id", $disciplina); // filtro - disciplina
		$this->db->join('turma', 'turma.id_turma = notas_disciplina.turma_id'); // join turma e matricula
		$this->db->join('classe', 'classe.id_classe  = turma.classe_id'); // Join tbl classe [turma]
		$this->db->join('anolectivo', 'anolectivo.id_ano = notas_disciplina.anolectivo_id'); // join ano lectivo e matricula
		$this->db->join('disciplina', 'disciplina.id_disciplina = notas_disciplina.disciplina_id');	// join ano lectivo e matricula
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id'); // join periodo e turma
		$dados["listagem_alunos"] = $this->db->get()->row(); // retorna 1 linha
		/* =====================================================================================================================*/
		$this->db->select('*'); // select tudo
		$this->db->from('notas_disciplina'); // da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo); // onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
		$this->db->where("turma_id", $turma); // onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
		$this->db->where("disciplina_id", $disciplina); // filtro - disciplina
		$this->db->order_by("nome", "asc"); // Ordenar a travez do nome
		$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id'); // Join aluno e matricula
		$this->db->join('anolectivo', 'anolectivo.id_ano = notas_disciplina.anolectivo_id'); // Join anolectivo e matricula
		$this->db->join('turma', 'turma.id_turma = notas_disciplina.turma_id'); // Join turma e matricula
		$this->db->join('classe', 'classe.id_classe  = turma.classe_id'); // Join tbl classe [turma]
		$dados['alunos'] = $this->db->get()->result(); // retorna várias linhas
		/* =====================================================================================================================*/
		if ($classe == 1) 
		{
			// SE classe = iniciação - chama a view da iniciação
			$this->load->view('layout/cabecalho');
			$this->load->view('layout/menu_lateral_coordenacao');
			$this->load->view('conteudo/_secretaria/_coordenacao/mini_pauta_iniciacao', $dados);
			$this->load->view('layout/rodape');
			$this->load->view('layout/script');
		} else {
			// SE não - chama a view padrão
			$this->load->view('layout/cabecalho');
			$this->load->view('layout/menu_lateral_coordenacao');
			$this->load->view('conteudo/_secretaria/_coordenacao/mini_pauta', $dados);
			$this->load->view('layout/rodape');
			$this->load->view('layout/script');
		}
	}
	/*================================================================================================================*/
	/*					 							PAUTA GERAL
	==================================================================================================================*/
	// ! FIXME: Corrigir essa função para pegar o id da classe em vez de uma string, porque se por algum motivo for alterado o id resultará em erro
	public function pauta_geral($anolectivo, $turma, $classe, $prof)
	{
		/*--------------------------------------------------------------------------------------------------------------------------------*/
		$this->db->select('*');													  					// select tudo
		$this->db->from('prof_turma');												 				// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
		$this->db->where("turma_id", $turma);									 					// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma

		$this->db->join('funcionario', 'funcionario.id_funcionario = prof_turma.funcionario_id');	// join funcionario e prof_turma
		$dados["prof"] = $this->db->get()->row();													// retorna 1 linha
		/*-------------------------------------------------------------------------------------------------------------------------------*/
		$this->db->select('*');													  					// select tudo
		$this->db->from('notas_disciplina');												 		// da tbl matricula
		$this->db->where("anolectivo_id", $anolectivo);												// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo

		$this->db->where("turma_id", $turma);									 					// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
		$this->db->join('turma', 'turma.id_turma = notas_disciplina.turma_id', 'left');				// join tbl turma e matricula
		$this->db->join('classe', 'classe.id_classe  = turma.classe_id', 'left');					// Join tbl classe e [turma]
		$this->db->join('anolectivo', 'anolectivo.id_ano = notas_disciplina.anolectivo_id', 'left');// join tbl anolectivo e matricula
		$this->db->join('periodo', 'periodo.id_periodo = turma.periodo_id', 'left');				// join tbl periodo e turma
		$dados["listagem_alunos"] = $this->db->get()->row();										// retorna 1 linha
		/*-------------------------------------------------------------------------------------------------------------------------------*/
		if ( empty($dados["listagem_alunos"]) )
		{
			echo $this->session->set_flashdata('msg',"<div class='alert alert-warning text-center'>NÃO EXISTEM ALUNOS MATRICULADOS NA TURMA E ANO LECTIVO SELECIONADO
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span></button></div>");
			redirect('secretaria/professor/turmas_professor_coordenacao/'.$prof);
		}
		elseif  ( !empty($dados["listagem_alunos"]) )
		{
			/*--------------------------------------------------------------------------------------------------------------------------------*/
			$this->db->select('*');															// seleciona tudo
			$this->db->from('notas_disciplina');											// de notas disciplina
			$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo

			$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
			$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplina
			$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
			$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
			$dados['lista_alunos'] = $this->db->get()->result();							// retorna várias linhas
			/*--------------------------------------------------------------------------------------------------------------------------------*/
			/* ================== pauta geral iniciacao ================== */
			if ($classe == 1) 
			{
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo

				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '1');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplina
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['representacao_matematica'] = $this->db->get()->result();				// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');							// seleciona tudo
				$this->db->from('notas_disciplina');			// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);	// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo

				$this->db->where("turma_id", $turma);			// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '2');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e turma
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['C_Ling_Literatura_Infant'] = $this->db->get()->result();				// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');														// seleciona tudo
				$this->db->from('notas_disciplina');										// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);								// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo

				$this->db->where("turma_id", $turma);										// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '3');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');							// agrupamento
				$this->db->order_by("nome", "asc");  											// Ordenar a travez do nome
				$dados['Meio_Fisico_Social'] = $this->db->get()->result();					// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '4');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['Exp_Manual_Plastica'] = $this->db->get()->result();						// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '5');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['Exp_Musical'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');														// seleciona tudo
				$this->db->from('notas_disciplina');										// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);								// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo

				$this->db->where("turma_id", $turma);										// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '6');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');// join tbl aluno e notas_disciplina
				$this->db->group_by('notas_disciplina.aluno_id');							// agrupamento
				$this->db->order_by("nome", "asc");  											// Ordenar a travez do nome
				$dados['Psicomotricidade'] = $this->db->get()->result();					// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select_sum('ce');													// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas_disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['classificacao_exame'] = $this->db->get()->result();						// retorna várias linhas
				/*================================================================================================================================*/
				$this->load->view('layout/cabecalho');
				$this->load->view('layout/menu_lateral_coordenacao');
				$this->load->view('conteudo/_secretaria/_pautas/pauta_geral_0', $dados);
				$this->load->view('layout/rodape');
				$this->load->view('layout/script');
			} /* ================== end pauta iniciacao ================== */
			/* ============== pauta geral 1ª classe ============== */
			elseif ($classe == 2)	
			{
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas_disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '7');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['l_portuguesa'] = $this->db->get()->result();							// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '8');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['matematica'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '9');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['estudo_meio'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '10');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['ed_musical'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '11');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join turma e matricula
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['ed_fisica'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '12');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join aluno e notas_disciplina
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['ed_plastica'] = $this->db->get()->result();									// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select_sum('ce');													// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['classificacao_exame'] = $this->db->get()->result();						// retorna várias linhas
				/*================================================================================================================================*/
				$this->load->view('layout/cabecalho');
				$this->load->view('layout/menu_lateral_coordenacao');
				$this->load->view('conteudo/_secretaria/_pautas/pauta_geral_1', $dados);
				$this->load->view('layout/rodape');
				$this->load->view('layout/script');
			} /* ================== end pauta 1ª classe ================== */
			/* ============== pauta geral 2ª classe ============== */
			elseif ($classe == 3)
			{
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '13');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['l_portuguesa'] = $this->db->get()->result();							// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '14');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['matematica'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '15');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['estudo_meio'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '16');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['ed_musical'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '17');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['ed_fisica'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '18');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['ed_plastica'] = $this->db->get()->result();									// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select_sum('ce');													// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['classificacao_exame'] = $this->db->get()->result();						// retorna várias linhas
				/*================================================================================================================================*/
				$this->load->view('layout/cabecalho');
				$this->load->view('layout/menu_lateral_coordenacao');
				$this->load->view('conteudo/_secretaria/_pautas/pauta_geral_2', $dados);
				$this->load->view('layout/rodape');
				$this->load->view('layout/script');
			} /* ================== end pauta 2ª classe ================== */
			/* ============== pauta geral 3ª classe ============== */
			elseif ($classe == 4)	
			{
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '19');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['l_portuguesa'] = $this->db->get()->result();							// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '20');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['matematica'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '21');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['estudo_meio'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '22');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['ed_musical'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '23');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['ed_fisica'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '24');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['ed_plastica'] = $this->db->get()->result();									// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select_sum('ce');													// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['classificacao_exame'] = $this->db->get()->result();						// retorna várias linhas
				/*================================================================================================================================*/
				$this->load->view('layout/cabecalho');
				$this->load->view('layout/menu_lateral_coordenacao');
				$this->load->view('conteudo/_secretaria/_pautas/pauta_geral_3', $dados);
				$this->load->view('layout/rodape');
				$this->load->view('layout/script');
			} /* ================== end pauta 3ª classe ================== */
			/* ============== pauta geral 4ª classe ============== */
			elseif ($classe == 5)	
			{
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '25');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['l_portuguesa'] = $this->db->get()->result();							// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '26');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['matematica'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '27');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['estudo_meio'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '28');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['ed_musical'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '29');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['ed_fisica'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '30');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['ed_plastica'] = $this->db->get()->result();									// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select_sum('ce');													// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['classificacao_exame'] = $this->db->get()->result();						// retorna várias linhas
				/*================================================================================================================================*/
				$this->load->view('layout/cabecalho');
				$this->load->view('layout/menu_lateral_coordenacao');
				$this->load->view('conteudo/_secretaria/_pautas/pauta_geral_4', $dados);
				$this->load->view('layout/rodape');
				$this->load->view('layout/script');
			} /* ================== end pauta 4ª classe ================== */
			/* ============== pauta geral 5ª classe ============== */
			elseif ($classe == 6)
			{
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '31');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['l_portuguesa'] = $this->db->get()->result();							// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '32');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['matematica'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '33');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplinas
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['c_natureza'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '34');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join turma e matricula
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['geografia'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '35');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join turma e matricula
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['historia'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '36');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join turma e matricula
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['e_m_p'] = $this->db->get()->result();									// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '37');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join turma e matricula
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['e_m_c'] = $this->db->get()->result();									// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '38');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join turma e matricula
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['ed_fisica'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '39');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join turma e matricula
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['ed_musical'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select_sum('ce');													// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplina
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['classificacao_exame'] = $this->db->get()->result();						// retorna várias linhas
				/*================================================================================================================================*/
				$this->load->view('layout/cabecalho');
				$this->load->view('layout/menu_lateral_coordenacao');
				$this->load->view('conteudo/_secretaria/_pautas/pauta_geral_5', $dados);
				$this->load->view('layout/rodape');
				$this->load->view('layout/script');
			}/* ================== end pauta 5ª classe ================== */
			/* ============== pauta geral 6ª classe ============== */
			elseif ($classe == 7)
			{
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '40');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join turma e matricula
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['l_portuguesa'] = $this->db->get()->result();							// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '41');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join turma e matricula
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['matematica'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '42');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join turma e matricula
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['c_natureza'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '43');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join turma e matricula
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['geografia'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '44');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join turma e matricula
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['historia'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '45');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join turma e matricula
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['e_m_p'] = $this->db->get()->result();									// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '46');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join turma e matricula
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['e_m_c'] = $this->db->get()->result();									// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '47');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join turma e matricula
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['ed_fisica'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->where("disciplina_id", '48');
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join tbl aluno e notas_disciplina
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['ed_musical'] = $this->db->get()->result();								// retorna várias linhas
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				/*--------------------------------------------------------------------------------------------------------------------------------*/
				$this->db->select('*');															// seleciona tudo
				// $this->db->select_sum('ce');													// seleciona tudo
				$this->db->from('notas_disciplina');											// de notas disciplina
				$this->db->where("anolectivo_id", $anolectivo);									// onde o valor da coluna "anolectivo_id" é igual ao valor passado como parâmetro $anolectivo
				$this->db->where("turma_id", $turma);											// onde o valor da coluna "turma_id" é igual ao valor passado como parâmetro $turma
				$this->db->join('aluno', 'aluno.id_aluno = notas_disciplina.aluno_id', 'left');	// join aluno e notas_disciplina
				$this->db->group_by('notas_disciplina.aluno_id');								// agrupamento
				$this->db->order_by("nome", "asc");  												// Ordenar a travez do nome
				$dados['classificacao_exame'] = $this->db->get()->result();						// retorna várias linhas
				/*================================================================================================================================*/
				$this->load->view('layout/cabecalho');
				$this->load->view('layout/menu_lateral_coordenacao');
				$this->load->view('conteudo/_secretaria/_pautas/pauta_geral_6', $dados );
				$this->load->view('layout/rodape');
				$this->load->view('layout/script');
			}/* ================== end pauta 6ª classe ================== */
		}
	}
}
