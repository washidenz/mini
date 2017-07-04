<?php
function minimime($fname)
{
    $fh=fopen($fname,'rb');
    if ($fh) {
        $bytes6=fread($fh,6);
        fclose($fh);
        if ($bytes6===false) return false;
        if (substr($bytes6,0,3)=="\xff\xd8\xff") return 'image/jpeg';
        if ($bytes6=="\x89PNG\x0d\x0a") return 'image/png';
        if ($bytes6=="GIF87a" || $bytes6=="GIF89a") return 'image/gif';
        return 'application/octet-stream';
    }
    return false;
}
	$path = "./foto/";
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
			$type = minimime($filename);
			//echo $archivo." => ".$type."<br>";
			if( $type == "application/octet-stream" && $archivo!="index.php" )
			{
				echo "\n<br>Borrado: ".$filename;
				unlink($filename);
			}
		}
	}
?>
