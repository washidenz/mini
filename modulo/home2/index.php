<?php
	require dirname(__FILE__).'/function.php';
	class Home2 extends Controller
	{
		function __construct()
		{
			parent::__construct();
			// redirecion para no usuarios (Solo para modulos protegidos)
			//$this->fn->redirection( URL."login", $this->session->check_login() );
		}
		function index()
		{
			$this->content->put_title("Pagina de Inicio");
			// call function.php
			$fn = new fnHome($this);
			
			// usando el retorno de $fn->ContenidoHome()
			//$this->content->put_body( $fn->ContenidoHome() );
			
			// usando $...->content->put_body() dentro de la funcion
			$fn->ContenidoHomeDirecto();
			require URI_THEME.'vacio.php';
		}
	}
