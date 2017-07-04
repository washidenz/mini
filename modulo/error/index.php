<?php
	class Error extends Controller
	{
		function index()
		{
			$this->content->put_title("Pagina no encontrada");
			$list = array(
				array("Error",""),
				array("404","")
			);
			//$this->mod->breadcrumb($list);
			
			require URI_THEME.'404.php';
		}
	}
?>

