<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//	CHAMA A VIEW AS VIEWS DO encarregados	
class Encarregados extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		if($this->session->userdata('logged_in') !== TRUE){
			redirect('/');
		}
	}
	/*=====================INICIO=LISTAR=ENCARREGADOS=====================*/
	//			CHAMA A VIEW LISTAR ENCARREGADOS	
	public function listar_encarregados()
	{	
		$lista = $this->Encarregados_Model->listarencarregados();
		$dados = array("encarregados" => $lista);	
		// CARREGA A VIZUALIZACAO DA VIEW LISTAR ENCARREGADOS
		$this->load->view('layout/cabecalho');
		$this->load->view('layout/menu_lateral');
		$this->load->view('conteudo/_secretaria/_encarregados/listar_encarregados', $dados);
		$this->load->view('layout/rodape');
		$this->load->view('layout/script');
	}
	//			CHAMA A VIEW do FURMULARIO CRIAR ENCARREGADOS   
	public function criar_encarregados(){
		$this->load->view('layout/cabecalho');
		$this->load->view('layout/menu_lateral');
		$this->load->view('conteudo/_secretaria/_encarregados/criar_encarregados');
		$this->load->view('layout/rodape');
		$this->load->view('layout/script');
	}
	/*=====================INICIO=CRIAR=NOVO=ENCARREGADOS=====================*/
	//  INSERIR REGISTROS NA TABELA UTILIZADORES
	public function guardar()
	{
		// Verifica se o encarregado já foi inserido 
		if ($this->Encarregados_Model->verificar_encarregado()){
			echo $this->session->set_flashdata('msg',"<div class='alert alert-danger text-center'>O ENCARREGADO QUE TENTOU ADICIONAR JÁ EXISTE
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span></button></div>");	
			$id_aluno = $this->input->post('aluno_encarregado'); 				
			redirect('secretaria/aluno/detalhe?id_aluno='.$id_aluno);
		}
		$this->Encarregados_Model->novoencarregados();		
		$id_aluno = $this->input->post('aluno_encarregado'); 				
		echo $this->session->set_flashdata('msg',"< class='alert alert-success text-center'>ENCARREGADO SALVO COM SUCESSO
			<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			<span aria-hidden='true'>&times;</span></button></div>");
		redirect('secretaria/aluno/detalhe?id_aluno='.$id_aluno); 	
	}
	/*=====================INICIO=APAGAR=ENCARREGADOS=====================*/
	/*		     	APAGAR REGISTROS NA TABELA UTILIZADORES			*/
	public function apagar($id)
	{
		$this->Encarregados_Model->apagarencarregados($id);
		redirect('secretaria/encarregados/listar_encarregados', 'refresh');
	}
	//	SALVA A ACTUALIZACAO DO REGISTROS NA TABELA UTILIZADORES
	public function salvaractualizacao($id=NULL)
	{
		$encarregados = array(
			"nome_pai" => $this->input->post('nome_pai'),
            "telemovel_pai" => $this->input->post('telemovel_pai'),
            "nome_mae" => $this->input->post('nome_mae'),
			"telemovel_mae" => $this->input->post('telemovel_mae'),
            "responsavel_aluno" => $this->input->post('responsavel_aluno'),
            "telemovel_resp" => $this->input->post('telemovel_resp')			
		);
		$this->load->model("Encarregados_Model");
		$this->Encarregados_Model->actualizar($encarregados);
		redirect('secretaria/encarregados/listar_encarregados', 'refresh');
	}
	// ============================================================================================= //
	//										 EDITAR ENCARREGADO 									 //
	// ============================================================================================= //
	public function editar_encarregado($id)
	{	
		$encarregado 	= $this->Encarregados_Model->retorna($id);
		$dados 	= array("encarregado" => $encarregado);
		/* ------------------------------------------------------------------------------------------------------------- */
		$this->load->model("Select_Dinamico_Model", "encarregado");
		$dados['anolectivo'] = $this->encarregado->get_anolectivo();
		/* ------------------------------------------------------------------------------------------------------------- */
		$this->db->select('encarregados.*, encarregado_aluno.id_aluno');
		$this->db->join('encarregado_aluno', 'encarregado_aluno.id_encarregado = encarregados.id_encarregado');
		$this->db->where('encarregados.id_encarregado', $id);
		$dados['encarregado'] = $this->db->get('encarregados')->result();
		/*------------------------------------------------*/
		$this->load->view('layout/cabecalho_secretaria');
		$this->load->view('layout/menu_lateral_secretaria');
		$this->load->view('conteudo/_secretaria/_encarregados/editar_encarregado', $dados);
		$this->load->view('layout/rodape');
		$this->load->view('layout/script');
	}
	public function actualizar()
	{
		$this->Encarregados_Model->actualizar();		
		$id_aluno = $this->input->post('aluno_encarregado'); 				
		echo $this->session->set_flashdata('msg',"<div class='alert alert-success text-center'>INFORMAÇÕES DO ENCARREGADO ALTERADAS COM SUCESSO
			<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			<span aria-hidden='true'>&times;</span></button></div>");	
		redirect('secretaria/aluno/detalhe?id_aluno='.$id_aluno); 
	}
}