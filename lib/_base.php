<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *		Libreria para la administracion de Modulos		 *
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	class mod
	{
		var $path;
		// content section
		var $ContentBody = "";
		var $ContentTitle = "";
		var $ContentBreadcrumb = "";
		var $ContentFooter = "";
		// Sidebar Section
		var $SidebarHeader = "";
		var $SidebarBody = "";
		var $SidebarFooter = "";
		// Navbar Section 
		var $NavbarTitle = "";
		var $NavbarAlert = "";
		var $NavbarUser = "";
		var $NavbarConfig = "";
		// Header Document
		var $Header = "";
		// Footer Document
		var $Footer = "";
		// more...
		var $Atajo = "";
		var $cPanel = "";
		var $Config = false;
		function __construct()
		{
			$this->path = URI_MOD;
		}
		function Sanitiza($datos)
		{
			$new=array();
			foreach($datos as $i=>$v)
			{
				if($v!="")
				{
					if(is_array($v))
					{
						$new[$i] = $this->Sanitiza($v);
					}
					else
					{
						$new[$i]= htmlspecialchars($v);
					}
				}
			}
			return $new;
		}
		function Notificacion($Message,$Type="warning")
		{
			//Type = error | warning | success
			if($Type=="error")
				return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-ban"></i> Error:</h4>
					'.$Message.'
                </div>';
			else if($Type=="warning")
				return '
				<div class="alert alert-warning alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-ban"></i> Advertencia:</h4>
					'.$Message.'
                </div>';
			else if($Type=="info")
				return '
				<div class="alert alert-info alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-ban"></i> Info:</h4>
					'.$Message.'
                </div>';
			else
				return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-ban"></i> Info:</h4>
					'.$Message.'
                </div>';
		}
		// Format Modal
		function ViewModal($name, $type="", $Button="", $Title="", $Body="")
		{
			$rtn = '
			<div class="modal fade" id="'.$name.'">
				<div class="modal-dialog '.$type.'">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title" id="ModalTitle">'.$Title.'</h4>
							</div>
						<div class="modal-body">
							<div class="row" id="ModalBody">
								'.$Body.'
							</div>
						</div>
						<div class="modal-footer">
							<span id="addButton">'.$Button.'</span>
							<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cerrar</button>
						</div>
					</div>
				</div>
			</div>';
			return $rtn;
		}
		function TitleContent($title="",$subtitle="")
		{
			$rtn='<h1>
				'.$title.'
				<small>'.$subtitle.'</small>
			</h1>';
			$this->ContentTitle = $rtn;
			return $rtn;
		}
		function breadcrumb( $list = array() )
		{
			$item='';
			$cont = count( $list );
			foreach( $list as $v )
			{
				if( is_array($v) && count($v)==3 )
				{
					$item .= '<li><a href="'.$v[1].'">
						<i class="'.$v[2].'"></i> '.$v[0].'
					</a></li>';
				}
				else if( is_array($v) && count($v)==2 )
				{
					$item .= '<li><a href="'.$v[1].'">
						'.$v[0].'
					</a></li>';
				}
				else if( is_array($v) && count($v)==2 )
				{
					$item .= '<li><a href="'.$v[1].'">
						'.$v[0].'
					</a></li>';
				}
			}
			
			$rtn = '<ol class="breadcrumb">
				'.$item.'
			</ol>';
			$this->ContentBreadcrumb = $rtn;
			return $rtn;
		}
		
		function getContentHeader()
		{
			$rtn = '<section class="content-header">
				'.$this->ContentTitle.'
				'.$this->ContentBreadcrumb.'
			</section>';
			return $rtn;
		}
		
		function getContent()
		{
			return $this->ContentBody;
		}
		function putContent( $content="" )
		{
			$this->ContentBody = $content;
		}
		
		// Crea contenido para permiso
		function ValidaContenido( $Modulo, $Permiso, $contenido, $else="" )
		{
			if( $this->GetPermisoUsuario( $Modulo,$Permiso ) )
			{
				$rtn=$contenido;
			}
			else
			{
				$rtn=$else;
			}
			return $rtn;
		}
		
		function GetPermisoUsuario($Modulo,$Codigo)
		{
			if(isset($_SESSION["Permiso"][$Modulo][$Codigo]))
			{
				return true;
			}
			return false;
		}
		function GetPermiso() //Obtiene lista de permisos
		{
			$rtn = array();
			if( $this->Config!=false )
			{
				foreach($this->Config as $i => $v)
				{
					$json = json_decode( $v['json'] );
					if( isset( $json->Permiso ) )
					{
						foreach( $json->Permiso as $code => $desc )
						{
							$rtn[ $v["directorio"] ][$code]=$desc;
						}
					}
				}
			}
			return $rtn;
		}
		//Busca Archivo de Configuracion de los Modulos
		function SearchConfigMod()
		{
			$rtn=false;
			$handle=dir($this->path);
			while ($directorio = $handle->read())
			{
				if(is_dir($this->path."/".$directorio) && $directorio!="." && $directorio!="..")
				{
					if(file_exists($this->path."/".$directorio."/config.json"))
					{
						$rtn[]=$directorio;
					}
				}
			}
			return $rtn;
		}
		
		//Abre Archivo de configuracion de modulos
		function CheckConfig($directorio)
		{
			$rtn=false;
			//if( is_array($directorio) )
			if( $directorio!=false )
			{
				foreach($directorio as $dir)
				{
					$json = @file_get_contents($this->path."/".$dir."/config.json");
					if( $json!==FALSE )
					{
						$rtn[]=array("json"=>$json,"directorio"=>$dir);
					}
				}
			}
			$this->Config=$rtn;
			return $rtn;
		}
		//Analiza Configuracion de Modulos
		//Genera Atributos para el menu
		function Attribute($attr)
		{
			$rtn="";
			if(isset($attr))
			{
				foreach($attr as $i=>$v)
				{
					$rtn.=$i.'="'.htmlspecialchars($v).'" ';
				}
			}
			return $rtn;
		}
		//Genera Menu de Usuario
		function MenuMod()
		{
			$Menu="";
			$cPanel="";
			$SubMenu="";
			if( $this->Config!=false )
			{
				foreach($this->Config as $i => $v)
				{
					$json = json_decode( $v['json'] );
					if( isset($json->UserMenu) && $json->UserMenu=="true" )
					{
						//var_dump($json);
						if( isset($json->Menu) )
						{
							foreach($json->Menu as $m)
							{
								//Falta Control de Permisos
								//AQUI
								if( $this->GetPermisoUsuario( $v["directorio"],$v["directorio"] ) )
								{
								$SubMenu='';
								$issm='';
								$isism='';
								if( isset($m->SubMenu) && count($m->SubMenu)>0 )
								{
									foreach( $m->SubMenuconsulta as $sm )
									{
										$SubMenu.='<li class="">
											<a href="'.URL.$v['directorio'].$sm->URL.'/" '.$this->attribute($sm->Attribute).'>
												<i class="'.$sm->Icon.'"></i><span>'.$sm->Name.'</span>
											</a>
										</li>';
										$issm = 'treeview';
										$isism = '<span class="pull-right-container">
											<i class="fa fa-angle-left pull-right"></i>
										</span>';
									}
									$SubMenu = ( $SubMenu!='' ) ? '<ul class="treeview-menu">'.$SubMenu.'</ul>':'';
								}
								$active = (MODULO == $v['directorio'])?' active':'';
								$Menu.='
								<li class="'.$issm.$active.'">
									<a href="'.URL.$v['directorio'].$m->URL.'/" '.$this->attribute($m->Attribute).'>
										<i class="'.$m->Icon.'"></i><span>'.$m->Name.'</span>
										'.$isism.'
									</a>
									'.$SubMenu.'
								</li>';
								}
							}
						}
					}
					// Genera Array Permisos
					if( isset( $json->Permiso ) )
					{
						foreach( $json->Permiso as $code => $value )
						{
							
						}
					}
				}
				$this->SidebarBody = '<ul class="sidebar-menu">
					<li class="header">MENU</li>
					'.$Menu.'
				</ul>';
			}
		}
		function getSidebarBody()
		{
			if($this->SidebarBody == "")
			{
				$this->CheckConfig($this->SearchConfigMod());
				$this->MenuMod();
			}
			return $this->SidebarBody;
		}
		function putSidebarBody($content="")
		{
			$this->SidebarBody = $content;
		}
		
		function SidebarUserPanel($Name,$image)
		{
			$rtn = '<div class="user-panel">
				<div class="pull-left image">
					<img src="'.$image.'" class="img-circle" alt="User">
				</div>
				<div class="pull-left info">
					<p>'.$Name.'</p>
					<!-- Status -->
					<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
				</div>
			</div>';
			$this->SidebarHeader = $rtn;
			return $rtn;
		}
		function putSidebarHeader($content="")
		{
			$this->SidebarHeader = $content;
		}
		function getSidebarHeader()
		{
			$this->SidebarUserPanel($this->GetSession("Nombre"),URL."images/foto/".$this->GetSession("Foto"));
			return $this->SidebarHeader;
		}
		function navUserPanel()
		{
			$rtn='<li class="dropdown user user-menu">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img src="'.URL.'images/foto/'.$this->GetSession("Foto").'" class="user-image" alt="'.$this->GetSession("login").'">
					<span class="hidden-xs">'.$this->GetSession("Nombre").'</span>
				</a>
				<ul class="dropdown-menu">
					<li class="user-header">
						<img src="'.URL.'images/foto/'.$this->GetSession("Foto").'" class="img-circle" alt="'.$this->GetSession("login").'">
					<p>
						'.$this->GetSession("Nombre").'
						<small>('.$this->GetSession("login").')</small>
					</p>
					</li>
					<!-- Menu Body -->
					<!--
					<li class="user-body">
						<div class="row">
							<div class="col-xs-4 text-center">
							<a href="#"><strong>SMS</strong></a>
							<p>200/500</p>
							</div>
							<div class="col-xs-4 text-center">
							<a href="#"><strong>Email</strong></a>
							<p>ilimitado</p>
							</div>
							<div class="col-xs-4 text-center">
							<a href="#"><strong>Claves</strong></a>
							<p>37</p>
							</div>
						</div>
					</li>
					-->
					<!-- Menu Footer-->
					<li class="user-footer">
					<div class="pull-left">
						<a href="#" class="btn btn-default btn-flat">Perfil</a>
					</div>
					<div class="pull-right">
						<button class="btn btn-default btn-flat SendAjax" data-destine="'.URL.'login/json/out" >Salir</button>
					</div>
					</li>
				</ul>
			</li>';
			return $rtn;
		}
		function TiempoTranscurrido($time) // int format
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
		function navMensaje($resultado, $cant=0, $url="")
		{
			$msj="";
			foreach($resultado as $obj)
			{
				$msj.='<li>
					<a href="'.$url.'" class="OpenModal" data-target="ModalPrincipal">
						<div class="pull-left">
							<img src="'.URL.'images/foto/'.$obj->FotoPerfil.'" class="img-circle" alt="User">
						</div>
						<h4>'.$obj->NombreCompleto.'<small><i class="fa fa-clock-o"></i> '.$this->TiempoTranscurrido($obj->FechaRegistro).'</small></h4>
						<p>'.$obj->Mensaje.'</p>
					</a>
				</li>';
			}
			$rtn = '
			<li class="dropdown messages-menu">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-envelope-o"></i>
					<span class="label label-success">'.$cant.'</span>
				</a>
				<ul class="dropdown-menu">
					<li class="header">Tienes '.$cant.' mensajes</li>
					<li>
						<ul class="menu">
							'.$msj.'
						</ul>
					</li>
					<li class="footer"><a href="#">Ver todos los mensajes</a></li>
				</ul>
			</li>';
			return $rtn;
		}
		
		
		function GenAtajos()
		{
			$this->Atajo = $this->SubMenu;
		}
		function GetAtajos()
		{
			if($this->SubMenu == "")
			{
				$this->CheckConfig($this->SearchConfigMod());
				$this->MenuMod();
			}
			return $this->SubMenu;
		}
		function GetMenu()
		{
			if($this->Menu == "")
			{
				$this->CheckConfig($this->SearchConfigMod());
				$this->MenuMod();
			}
			return $this->Menu;
		}
		function GetcPanel()
		{
			if($this->cPanel == "")
			{
				$this->CheckConfig($this->SearchConfigMod());
				$this->MenuMod();
			}
			return $this->cPanel;
		}
		function GetConfig()
		{
			$this->CheckConfig($this->SearchConfigMod());
			return $this->Config;
		}

		function SetSession($nombre,$valor)
		{
			$_SESSION[$nombre] = $valor;
		}
		function GetSession($nombre)
		{
			if(isset($_SESSION[$nombre]))
			{
				return $_SESSION[$nombre];
			}
			return false;
		}
		function ucwords_specific ($string, $delimiters = '', $encoding = NULL)
		{
			if ($encoding === NULL)
			{
				$encoding = mb_internal_encoding();
			}
			if (is_string($delimiters))
			{
				$delimiters =  str_split( str_replace(' ', '', $delimiters));
			}

			$delimiters_pattern1 = array();
			$delimiters_replace1 = array();
			$delimiters_pattern2 = array();
			$delimiters_replace2 = array();
			foreach ($delimiters as $delimiter)
			{
				$uniqid = uniqid();
				$delimiters_pattern1[]   = '/'. preg_quote($delimiter) .'/';
				$delimiters_replace1[]   = $delimiter.$uniqid.' ';
				$delimiters_pattern2[]   = '/'. preg_quote($delimiter.$uniqid.' ') .'/';
				$delimiters_replace2[]   = $delimiter;
			}

			// $return_string = mb_strtolower($string, $encoding);
			$return_string = $string;
			$return_string = preg_replace($delimiters_pattern1, $delimiters_replace1, $return_string);

			$words = explode(' ', $return_string);

			foreach ($words as $index => $word)
			{
				$words[$index] = mb_strtoupper(mb_substr($word, 0, 1, $encoding), $encoding).mb_substr($word, 1, mb_strlen($word, $encoding), $encoding);
			}

			$return_string = implode(' ', $words);

			$return_string = preg_replace($delimiters_pattern2, $delimiters_replace2, $return_string);

			return $return_string;
		}
		function Capitalizer($string)
		{
			mb_internal_encoding('UTF-8');
			return $this->ucwords_specific(mb_strtolower($string, 'UTF-8'), "'.");
		}
		function OptionSelect($name,$datos=array(),$default="",$Attr=array())
		{
			$rtn='<select class="form-control" '.$this->Attribute($Attr).'>'.
				$this->OptionSelectDate($datos,$default)
			.'</select>';
		}
		function OptionSelectDate($datos,$default="")
		{
			$rtn="";
			foreach($datos as $i=>$v)
			{
				$check = ($default == $i)? " selected":"";
				$rtn.='<option value="'.$i.'"'.$check.'>'.$v.'</option>';
			}
			return $rtn;
		}
		function num2letras($num,$fem=false,$dec=false)
		{
			$matuni[2]  = "dos";
			$matuni[3]  = "tres";
			$matuni[4]  = "cuatro";
			$matuni[5]  = "cinco";
			$matuni[6]  = "seis";
			$matuni[7]  = "siete";
			$matuni[8]  = "ocho";
			$matuni[9]  = "nueve";
			$matuni[10] = "diez";
			$matuni[11] = "once";
			$matuni[12] = "doce";
			$matuni[13] = "trece";
			$matuni[14] = "catorce";
			$matuni[15] = "quince";
			$matuni[16] = "dieciseis";
			$matuni[17] = "diecisiete";
			$matuni[18] = "dieciocho";
			$matuni[19] = "diecinueve";
			$matuni[20] = "veinte";
			$matunisub[2] = "dos";
			$matunisub[3] = "tres";
			$matunisub[4] = "cuatro";
			$matunisub[5] = "quin";
			$matunisub[6] = "seis";
			$matunisub[7] = "sete";
			$matunisub[8] = "ocho";
			$matunisub[9] = "nove";
			$matdec[2] = "veint";
			$matdec[3] = "treinta";
			$matdec[4] = "cuarenta";
			$matdec[5] = "cincuenta";
			$matdec[6] = "sesenta";
			$matdec[7] = "setenta";
			$matdec[8] = "ochenta";
			$matdec[9] = "noventa";
			$matsub[3]  = 'mill';
			$matsub[5]  = 'bill';
			$matsub[7]  = 'mill';
			$matsub[9]  = 'trill';
			$matsub[11] = 'mill';
			$matsub[13] = 'bill';
			$matsub[15] = 'mill';
			$matmil[4]  = 'millones';
			$matmil[6]  = 'billones';
			$matmil[7]  = 'de billones';
			$matmil[8]  = 'millones de billones';
			$matmil[10] = 'trillones';
			$matmil[11] = 'de trillones';
			$matmil[12] = 'millones de trillones';
			$matmil[13] = 'de trillones';
			$matmil[14] = 'billones de trillones';
			$matmil[15] = 'de billones de trillones';
			$matmil[16] = 'millones de billones de trillones';

			$num = trim((string)@$num);

			if ( $num[0] == '-' )
			{
				$neg = 'menos ';
				$num = substr( $num, 1 );
			}
			else
			{
				$neg = '';
			}
			while ( $num[0] == '0' ) $num = substr( $num, 1 );
			if ( $num[0] < '1' or $num[0] > 9 )
			{
				$num = '0' . $num;
			}
			$zeros = true;
			$punt = false;
			$ent = '';
			$fra = '';
			for ( $c = 0; $c < strlen($num); $c++ )
			{
				$n = $num[$c];
				if (! (strpos(".,'''", $n) === false))
				{
					if ($punt)
					{
						break;
					}
					else
					{
						$punt = true;
						continue;
					}
				}
				elseif (! (strpos('0123456789', $n) === false))
				{
					if ($punt)
					{
						if ($n != '0') $zeros = false;
						$fra .= $n;
					}
					else
					{
						$ent .= $n;
					}
				}
				else
				{
					break;
				}
			}

			$ent = '     ' . $ent;
			/*
			*/
			if ($dec and $fra and ! $zeros)
			{
				$fin = ' Coma';
				for ($n = 0; $n < strlen($fra); $n++)
				{
					if (($s = $fra[$n]) == '0')
					{
						$fin .= ' cero';
					}
					elseif ($s == '1')
					{
						$fin .= $fem ? ' una' : ' un';
					}
					else
					{
						$fin .= ' ' . $matuni[$s];
					}
				}
			}
			else
			{
				$fin = '';
			}
			if ((int)$ent === 0) return 'Cero ' . $fin;
			$tex = '';
			$sub = 0;
			$mils = 0;
			$neutro = false;

			while ( ($num = substr($ent, -3)) != '   ') {

				$ent = substr($ent, 0, -3);
				if (++$sub < 3 and $fem) {
				   $matuni[1] = 'una';
				   $subcent = 'as';
				}else{
				   $matuni[1] = $neutro ? 'un' : 'uno';
				   $subcent = 'os';
				}
				$t = '';
				$n2 = substr($num, 1);
				if ($n2 == '00') {
				}elseif ($n2 < 21)
				   $t = ' ' . $matuni[(int)$n2];
				elseif ($n2 < 30) {
				   $n3 = $num[2];
				   if ($n3 != 0) $t = 'i' . $matuni[$n3];
				   $n2 = $num[1];
				   $t = ' ' . $matdec[$n2] . $t;
				}else{
				   $n3 = $num[2];
				   if ($n3 != 0) $t = ' y ' . $matuni[$n3];
				   $n2 = $num[1];
				   $t = ' ' . $matdec[$n2] . $t;
				}

				$n = $num[0];
				if ($n == 1) {
				   $t = ' ciento' . $t;
				}elseif ($n == 5){
				   $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
				}elseif ($n != 0){
				   $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
				}

				if ($sub == 1) {
				}elseif (! isset($matsub[$sub])) {
				   if ($num == 1) {
					  $t = ' mil';
				   }elseif ($num > 1){
					  $t .= ' mil';
				   }
				}elseif ($num == 1) {
				   $t .= ' ' . $matsub[$sub] . 'ón';
				}elseif ($num > 1){
				   $t .= ' ' . $matsub[$sub] . 'ones';
				}
				if ($num == '000') $mils ++;
				elseif ($mils != 0) {
				   if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
				   $mils = 0;
				}
				$neutro = true;
				$tex = $t . $tex;
			}
			$tex = $neg . substr($tex, 1) . $fin;
			//return ucwords($tex);
			//return ucwords($tex);
			return ucfirst($tex);
		}

		function encrypt( $q )
		{
			$cryptKey = 'JossMP';
			$qEncoded = bin2hex( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
			return $qEncoded;
		}

		function decrypt( $q )
		{
			if( (strlen($q) % 64) == 0)
			{
				$cryptKey = 'JossMP';
				$qDecoded = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), hex2bin( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
				return $qDecoded;
			}
			return 0;
		}

		function json_encode($in)
		{
			return json_encode($in, JSON_PRETTY_PRINT);
		}
	}
?>
