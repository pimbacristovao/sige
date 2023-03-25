<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recuperar_password extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->load->library('form_validation');
	}
	/* ========== carrega a pagina de recuperação de palavra-passe ========== */ 
	public function index()
	{
		$this->load->view('layout/cabecalho_recuperar_password');
		$this->load->view('conteudo/recuperar_password');
		$this->load->view('layout/rodape');
		$this->load->view('layout/script');
	}
}
