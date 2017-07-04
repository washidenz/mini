<?php
	require dirname(__FILE__).'/function.php';
	class Home extends Controller
	{
		function __construct()
		{
			parent::__construct();
			// redirecion para no usuarios (Solo para modulos protegidos)
			//$this->fn->redirection( URL."login", $this->session->check_login() );
		}
		function index()
		{
			$this->content->register("sidebar_left_footer","Pie de pagina sidebar");
			
			$this->content->put_title("Pagina de Inicio");
			$this->interfaz->title_subtitle("TITULO","Sub-Titulo");
			
			$list = array(
				array("Inicio",URL,"fa fa-dashboard")
			);
			$this->interfaz->breadcrumb($list);
			
			//
			$fn = new fnHome($this);
			
			// usando el retorno de $fn->ContenidoHome()
			//$this->content->put_body( $fn->ContenidoHome() );
			
			// usando $...->content->put_body() dentro de la funcion
			$fn->ContenidoHomeDirecto();
			require URI_THEME.'content.php';
		}
	}
