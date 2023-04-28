<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('_assets/dompdf/autoload.inc.php');
use Dompdf\Dompdf;

class My_dompdf
{
    protected $ci;
    function __construct()
    {
        // parent::__construct();
        $this->ci =& get_instance();
    }
    /*                  GERAR PDF VERTICAL   
    =======================================================================================================================================*/
    public function gerar_pdf($view, $dados = array(), $papel = 'A4', $orientacao = 'portrait') //Orientacao: portrait / landscape
    {
		/**
		 * @param $view: define o caminho do arquivo de visualização que será transformado em PDF.
		 * @param $dados: é um array que contém dados adicionais para serem passados para a visualização.
		 * @param $papel: define o tamanho do papel que será usado para o PDF, onde o padrão é 'A4'.
		 * @param $orientacao: define a orientação da página (retrato ou paisagem), sendo o padrão 'retrato'.
		 */
        $dompdf = new Dompdf(); 							// Cria uma nova instância do Dompdf
        $html = $this->ci->load->view($view, $dados, TRUE);
        $dompdf->loadHtml($html); 							// Carrega o conteúdo HTML
        $dompdf->setPaper($papel, $orientacao); 			// Define o tamanho do papel e a orientação da página
        /*  Converter o HTML em PDF */
        $dompdf->render(); 									// Converte o HTML em PDF
        $dompdf->stream(date('d-m-Y-H-i-s').".pdf", array("Attachment" => FALSE)); // O método steam envia o PDF gerado para a exibição no navegador.
    }
    /*                  GERAR PDF HORIZONTAL   
    =======================================================================================================================================*/
    public function gerar_pdf_landscape($view, $dados = array(), $papel = 'A4', $orientacao = 'landscape') //Orientacao: portrait / landscape
    {
		/**
		 * @param $view: define o caminho do arquivo de visualização que será transformado em PDF.
		 * @param $dados: é um array que contém dados adicionais para serem passados para a visualização.
		 * @param $papel: define o tamanho do papel que será usado para o PDF, onde o padrão é 'A4'.
		 * @param $orientacao: define a orientação da página (retrato ou paisagem), sendo o padrão 'retrato'.
		 */
        $dompdf = new Dompdf(); 							// Cria uma nova instância do Dompdf
        $html = $this->ci->load->view($view, $dados, TRUE);
        $dompdf->loadHtml($html); 							// Carrega o conteúdo HTML
        $dompdf->setPaper($papel, $orientacao); 			// Define o tamanho do papel e a orientação da página
        /*  Converter o HTML em PDF */
        $dompdf->render(); 									// Converte o HTML em PDF
        $dompdf->stream(date('d-m-Y-H-i-s').".pdf", array("Attachment" => FALSE)); // O método steam envia o PDF gerado para a exibição no navegador.
    }
}