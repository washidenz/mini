<?php
	class fnHome
	{
		function __construct(&$parents)
		{
			$this->parents = $parents;
		}
		function ContenidoHome() // con Return
		{
			$rtn ='Este es el contenido del Home con return';
			return $rtn;
		}
		function ContenidoHomeDirecto()
		{
			$rtn ='Este es el contenido del Home usando parent';
			$this->parents->content->put_body($rtn);
		}
	}
?>
