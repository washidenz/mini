<?php
	function Ext($fname)
	{
		$ext = substr($fname, -3);
		return $ext;
	}

	$path = "./firma/";
	$directorio = opendir($path);
	while ($archivo = readdir($directorio))
	{
		if (is_dir($archivo))
		{
			//echo "[".$archivo . "]<br />";
		}
		else
		{
			$filename = $path.$archivo;
			$type = Ext($filename);
			$new = substr($filename,0, -3)."png";
			if( $type == "jpg" && $archivo!="index.php" )
			{
				echo "\n<br>Cambio de Nombre: ".$filename."=>".$new;
				rename($filename,$new);
			}
		}
	}
?>
