<?php
	class extra
	{
		function get_transcurrido($time) // int format
		{ 
			$periodos = array("seg", "min", "hora", "día", "sem", "mes", "año", "década");
			$duraciones = array("60","60","24","7","4.35","12","10");
			$now = time();
			$diferencia = $now - $time;

			for($j = 0; $diferencia >= $duraciones[$j] && $j < count($duraciones)-1; $j++) {
				$diferencia /= $duraciones[$j];
			}
			$diferencia = round($diferencia);

			if($diferencia != 1) {
				if($j != 5){
					$periodos[$j].= "s";
				}else{
					$periodos[$j].= "es";
				}
			}

			return $diferencia." ".$periodos[$j];
		}
		public function redirection( $url, $no = false )
		{
			if( !$no )
			{
				header( "Location: ".$url );
				exit();
			}
		}
		function attribute( $attr = array() )
		{
			$rtn="";
			if( is_array($attr) )
			{
				foreach($attr as $i=>$v)
				{
					$rtn.=$i.'="'.htmlspecialchars($v).'" ';
				}
			}
			return $rtn;
		}
	}
?>
