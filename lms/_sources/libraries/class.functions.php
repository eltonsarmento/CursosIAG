<?php
// ===================================================================
class Functions {
	// ===============================================================
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();
	}
	// ===============================================================
	public function iif($condition, $truevalue, $falsevalue = '') {
    	return ($condition) ? $truevalue : $falsevalue;
	}
	// ===============================================================
	public function is_number($number) {
	    if (preg_match("/^([0-9]+)$/", $number)) {
	    	return true;
	    } else {
	    	return false;
	    }
	}
	// ===============================================================
    public function writetofile($root_path, $data) {
        $fp = fopen($root_path, 'w');
        fwrite($fp, $data);
        fclose($fp);
    }
	// ===============================================================
    public function readfromfile($arquivo) {
        if (file_exists($arquivo)) {
            $conteudo = implode('', file($arquivo));
            return $conteudo;
        }
    }
	// ===============================================================
	public function upper($string, $return = 'upper') {
		$arrayLower = array('ç','â','ã','à','á','ä','é','è','ê','ë','í','ì','î','ï','ó','ò','ô','õ','ö','ú','ù','û','ü');
		$arrayUpper = array('Ç','Â','Ã','Á','À','Ä','É','È','Ê','Ë','Í','Ì','Î','Ï','Ó','Ò','Õ','Ô','Ö','Ú','Ù','Û','Ü');
		if($return == 'lower') {
			$text = strtolower($string);
			for($i = 0; $i < count($arrayLower); $i++) {
				$string = str_replace($arrayUpper[$i], $arrayLower[$i], $string);
			}
		} elseif($return == 'upper') {
			$string = strtoupper($string);
			for($i = 0; $i < count($arrayLower); $i++) {
				$string = str_replace($arrayLower[$i], $arrayUpper[$i], $string);
			}
		}
		return($string);
	}
	// ===============================================================
	public function checkEmail($email) {
	    return $this->iif(preg_match('/^[-!#$%&\'*+\\.\/0-9=?A-Z^_`{|}~]+@([-0-9A-Z]+\.)+([0-9A-Z]){2,4}$/i', $email), true, false);
	}
	// ===============================================================
	public function checkDo($do, $arrDo) {
	    if (is_array($arrDo)) {
	        if (!in_array($do, $arrDo)) {
	            $do = $arrDo[0];
	        }
	    }
	    return $do;
	}
	// ===============================================================
	public function makelinkcode($text, $url, $onclick='', $class='', $target="", $title="") {
        $url = htmlspecialchars($url);
        return "<a href=\"".$url."\"".$this->iif($target, " target=\"".$target."\"", "").$this->iif($title != '', " title=\"".$title."\"", "").$this->iif($class!='', " class=\"".$class."\"", "").$this->iif($onclick!='', " onclick=\"".$onclick."\"", "").">".$text."</a>";
    }
	// ===============================================================
	public function select_array($name, $cselected, $array) {
		$return = "<select name=\"".$name."\" id=\"".$name."\">";
		foreach ($array as $key => $value) {
			$selected = ($key == $cselected) ? ' selected="selected"' : '';
			$return .= "<option value=\"".$key."\"".$selected.">".$value."</option>";
		}
		$return .= "</select>";
		return $return;
	}
	// ===============================================================
	public function gera_randomico($tamanho=10) {
		$randomico = '';
		$cont = 1;
		while ($cont <= $tamanho) {
			$x = mt_rand(48, 122);
			if ($x <= 57 || $x >= 97) {
				$randomico .= chr($x);
				$cont++;
			}
		}
		return $randomico;
	}
	// ===============================================================
	public function paginacao($pagina, $num, $num_total, $base_url, $indicador='', $ajax=0, $function='', $campo='', $delimitador=', ', $selected_inicial='<strong>', $selected_final='</strong>', $classlink='', $anterior='&laquo; Anterior', $proxima='Pr&oacute;xima &raquo;') {
        
		$pg 	= $pagina - 1;
        $inicio = $pg * $num;
        $fim 	= $inicio + $num;
        
		if ($fim >= $num_total) $fim = $num_total;
        
		$inicio 		= $inicio + 1;
        $num_totalx 	= $num_total - 1;
        $pages 			= @intval($num_totalx / $num) + 1;
        $total_pagina 	= $pages;
        $on_page 		= @floor($inicio / $num) + 1;
        
		$page_string = '';
        $endereco = $base_url.'&amp;pagina=';
        
		if ($total_pagina > 10) {
    		$init_page_max = ($total_pagina > 3) ? 3 : $total_pagina;
    		
     		for($i = 1; $i < $init_page_max + 1; $i++) {
				if ($ajax)
					$page_string .= ($i == $on_page) ? $selected_inicial . $i . $selected_final : "<a href=\"javascript:void(0);\" ".$classlink." onclick=\"".$function."('".$indicador."','".$campo."','".$i."');\">".$i."</a>";
	    		else
	    			$page_string .= ($i == $on_page) ? $selected_inicial . $i . $selected_final : "<a href=\"".stripslashes($endereco.$i)."\" ".$classlink.">".$i."</a>";
    	    	if ($i < $init_page_max)
					$page_string .= $delimitador;
    		}
    		
    		if ($total_pagina > 3) {
    	    	if ($on_page > 1  && $on_page < $total_pagina) {
	    		
					$page_string  .= ($on_page > 5) ? ' ... ' : $delimitador;
	    			$init_page_min = ($on_page > 4) ? $on_page : 5;
	    			$init_page_max = ($on_page < $total_pagina - 4) ? $on_page : $total_pagina - 4;
	    		
					for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++) {
						if ($ajax)
							$page_string .= ($i == $on_page) ? $selected_inicial . $i . $selected_final : "<a href=\"javascript:void(0);\" ".$classlink." onclick=\"".$function."('".$indicador."','".$campo."','".$i."');\">".$i."</a>";
	    				else
	    					$page_string .= ($i == $on_page) ? $selected_inicial . $i . $selected_final : "<a href=\"".stripslashes($endereco.$i)."\" ".$classlink.">".$i."</a>";
	    		    	if ($i < $init_page_max + 1)
	    			     	$page_string .= $delimitador;
	    			}
	    			
	    			$page_string .= ($on_page < $total_pagina - 4) ? ' ... ' : $delimitador;
	    	    } else
  		      		$page_string .= ' ... ';
	    	    
    	    	for($i = $total_pagina - 2; $i < $total_pagina + 1; $i++) {
					if ($ajax)
						$page_string .= ($i == $on_page) ? $selected_inicial . $i . $selected_final : "<a href=\"javascript:void(0);\" ".$classlink." onclick=\"".$function."('".$indicador."','".$campo."','".$i."');\">".$i."</a>";
   					else
    					$page_string .= ($i == $on_page) ? $selected_inicial . $i . $selected_final : "<a href=\"".stripslashes($endereco.$i)."\" ".$classlink.">".$i."</a>";
	    			if ($i <  $total_pagina)
	    		    	$page_string .= $delimitador;
  	    		}
    		}
  		
        } else {
        	for($i = 1; $i < $total_pagina + 1; $i++) {
    			if ($ajax)
					$page_string .= ($i == $on_page) ? $selected_inicial . $i . $selected_final : "<a href=\"javascript:void(0);\" ".$classlink." onclick=\"".$function."('".$indicador."','".$campo."','".$i."');\">".$i."</a>";
				else
					$page_string .= ($i == $on_page) ? $selected_inicial . $i . $selected_final : "<a href=\"".stripslashes($endereco.$i)."\" ".$classlink.">".$i."</a>";
        	    if ($i < $total_pagina)
        	    	$page_string .= $delimitador;
        	}
        }
        
        $paginacao = array(
	        'pagina'       => $pagina,
	        'page_string'  => $page_string,
	        'total_pagina' => $total_pagina,
	        'num_total'    => $num_total,
	        'inicio'       => $inicio,
	        'fim'          => $fim
        );
        
        if ($ajax) {
			if ($pagina > 1) {
	           $num = $pagina - 1;
	           $paginacao['anterior'] = "<a href=\"javascript:void(0);\" onclick=\"".$function."('".$indicador."','".$campo."','".$num."');\" ".$classlink.">".$anterior."</a>";
	        }
    	    if ($pagina < $pages) {
    	        $num = $pagina + 1;
    	        $paginacao['proxima']  = "<a href=\"javascript:void(0);\" onclick=\"".$function."('".$indicador."','".$campo."','".$num."');\" ".$classlink.">".$proxima."</a>";
    	    }
	   	} else {
			if ($pagina > 1) {
	           $num = $pagina - 1;
	           $paginacao['anterior'] 	= array('url' => stripslashes($endereco.$num), 		'num' => $num);
	        }
    	    if ($pagina < $pages) {
    	        $num = $pagina + 1;
    	        $paginacao['proxima'] 	= array('url' => stripslashes($endereco.$num), 		'num' => $num);
    	    }
    	    if ($pagina > 1) {
    	        $paginacao['primeira'] 	= array('url' => stripslashes($endereco.'1'), 		'num' => 1);
    	    }
    	    if ($pagina < $pages) {
    	        $paginacao['ultima'] 	= array('url' => stripslashes($endereco.$pages),	'num' => $pages);
    	    }
		}
		
        return $paginacao;
	}
	// ===============================================================
	public function geraTituloUrl($str) {
		$search	= '_';
		$replace = '-';
		$trans = array(
			$search					=> $replace,
			"\s+"					=> $replace,
			"[^a-z0-9".$replace."]"	=> '',
			$replace."+"			=> $replace,
			$replace."$"			=> '',
			"^".$replace			=> ''
		);
		$str = strip_tags(strtolower($this->removeAcentos($str)));
		foreach ($trans as $key => $val){
			$str = preg_replace("#".$key."#", $val, $str);
		}
		return trim(stripslashes($str));
	}
	// ===============================================================
	public function removeAcentos($texto) {
       return strtr($texto, "áàâãäÁÀÂÃÄéèêëÉÈÊËíìîïÍÌÎÏóòôõöÓÒÔÕÖúùûüÚÙÛÜçÇñÑ", "aaaaaAAAAAeeeeEEEEiiiiIIIIoooooOOOOOuuuuUUUUcCnN");
   	}
   	// ===============================================================
   	public function getExtensaoArquivo($file) {
		$ext = explode('.', $file);
		return end($ext);
	}
	// ===============================================================
    private function lang_strftime($currtime, $timeformatstring) {
        global $arrayDias, $arrayDias_short, $arrayMeses , $arrayMeses_short;
        $str = stripslashes($timeformatstring);
        if (setlocale(LC_TIME, portuguese)) {
            $str = ereg_replace('%a', ucwords(strftime('%a', $currtime)), $str);
            $str = ereg_replace('%A', ucwords(strftime('%A', $currtime)), $str);
            $str = ereg_replace('%b', ucwords(strftime('%b', $currtime)), $str);
            $str = ereg_replace('%B', ucwords(strftime('%B', $currtime)), $str);
        } else {
            $str = ereg_replace('%a', $arrayDias_short[(int)strftime('%w',$currtime)], $str);
            $str = ereg_replace('%A', $arrayDias[(int)strftime('%w',$currtime)], $str);
            $str = ereg_replace('%b', $arrayMeses_short[(int)strftime('%m',$currtime)], $str);
            $str = ereg_replace('%B', $arrayMeses[(int)strftime('%m',$currtime)], $str);
            $str = ereg_replace('%p', (int)strftime('%H',$currtime)<12?"am":"pm", $str);
        }
        return strftime($str, $currtime);
	}
	// ===============================================================
    public function data($logTime, $timeformatstring) {
        $timeFormat = '';
        $time = 0;
        $time = $time * 3600;
        $nowtime = $time + time();
        $time += $logTime;
       	return $this->lang_strftime($time, $timeformatstring);
	}
	// ===============================================================
	public function validaCPF($cpf = null) {
	    // Verifica se um número foi informado
	    if(empty($cpf)) {
	        return false;
	    }
	 
	    // Elimina possivel mascara
	    $cpf = ereg_replace('[^0-9]', '', $cpf);
	    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
	     
	    // Verifica se o numero de digitos informados é igual a 11 
	    if (strlen($cpf) != 11) {
	        return false;
	    }
	    // Verifica se nenhuma das sequências invalidas abaixo 
	    // foi digitada. Caso afirmativo, retorna falso
	    else if ($cpf == '00000000000' || 
	        $cpf == '11111111111' || 
	        $cpf == '22222222222' || 
	        $cpf == '33333333333' || 
	        $cpf == '44444444444' || 
	        $cpf == '55555555555' || 
	        $cpf == '66666666666' || 
	        $cpf == '77777777777' || 
	        $cpf == '88888888888' || 
	        $cpf == '99999999999') {
	        return false;
	     // Calcula os digitos verificadores para verificar se o
	     // CPF é válido
	     } else {   
	         
	        for ($t = 9; $t < 11; $t++) {
	             
	            for ($d = 0, $c = 0; $c < $t; $c++) {
	                $d += $cpf{$c} * (($t + 1) - $c);
	            }
	            $d = ((10 * $d) % 11) % 10;
	            if ($cpf{$c} != $d) {
	                return false;
	            }
	        }
	 
	        return true;
	    }
	}
	// ===============================================================
	public function validaCNPJ($cnpj = null) {
			//Etapa 1: Cria um array com apenas os digitos numéricos, isso permite receber o cnpj em diferentes formatos como "00.000.000/0000-00", "00000000000000", "00 000 000 0000 00" etc...
			$j=0;
			for($i=0; $i<(strlen($cnpj)); $i++)
				{
					if(is_numeric($cnpj[$i]))
						{
							$num[$j]=$cnpj[$i];
							$j++;
						}
				}
			//Etapa 2: Conta os dígitos, um Cnpj válido possui 14 dígitos numéricos.
			if(count($num)!=14)
				{
					$isCnpjValid=false;
				}
			//Etapa 3: O número 00000000000 embora não seja um cnpj real resultaria um cnpj válido após o calculo dos dígitos verificares e por isso precisa ser filtradas nesta etapa.
			if ($num[0]==0 && $num[1]==0 && $num[2]==0 && $num[3]==0 && $num[4]==0 && $num[5]==0 && $num[6]==0 && $num[7]==0 && $num[8]==0 && $num[9]==0 && $num[10]==0 && $num[11]==0)
				{
					$isCnpjValid=false;
				}
			//Etapa 4: Calcula e compara o primeiro dígito verificador.
			else
				{
					$j=5;
					for($i=0; $i<4; $i++)
						{
							$multiplica[$i]=$num[$i]*$j;
							$j--;
						}
					$soma = array_sum($multiplica);
					$j=9;
					for($i=4; $i<12; $i++)
						{
							$multiplica[$i]=$num[$i]*$j;
							$j--;
						}
					$soma = array_sum($multiplica);	
					$resto = $soma%11;			
					if($resto<2)
						{
							$dg=0;
						}
					else
						{
							$dg=11-$resto;
						}
					if($dg!=$num[12])
						{
							$isCnpjValid=false;
						} 
				}
			//Etapa 5: Calcula e compara o segundo dígito verificador.
			if(!isset($isCnpjValid))
				{
					$j=6;
					for($i=0; $i<5; $i++)
						{
							$multiplica[$i]=$num[$i]*$j;
							$j--;
						}
					$soma = array_sum($multiplica);
					$j=9;
					for($i=5; $i<13; $i++)
						{
							$multiplica[$i]=$num[$i]*$j;
							$j--;
						}
					$soma = array_sum($multiplica);	
					$resto = $soma%11;			
					if($resto<2)
						{
							$dg=0;
						}
					else
						{
							$dg=11-$resto;
						}
					if($dg!=$num[13])
						{
							$isCnpjValid=false;
						}
					else
						{
							$isCnpjValid=true;
						}
				}
		return $isCnpjValid;			
	}
	// ===============================================================
	public function checkDate($data = '00/00/0000', $podeDataFutura = true) {
		$data = explode('/',$data);
		if (!$podeDataFutura) { 
			if ($data[2].$data[1].$data[0] > date('Ymd'))
				return false;
		}
		if (count($data) != 3)
			return false;
       	return checkdate($data[1], $data[0], $data[2]);
	}
	// ===============================================================
	public function converteData($data = '00/00/0000') {
		$data = explode('/', $data);
		return $data[2].'-'.$data[1].'-'.$data[0];
	}
	// ===============================================================
	public function getValorUrl($posicao = 0) {
		if (substr($_SERVER['REQUEST_URI'], 0, 7) == 'http://')
			$urlCompleta = substr($_SERVER['REQUEST_URI'], 7);
		else
			$urlCompleta = $_SERVER['REQUEST_URI'];
		$url = explode('/', $urlCompleta);
		return $url[$posicao];
	}
	// ===============================================================
	public function getMes($mes) {
		$meses = array(1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro');
		return $meses[$mes];
	}
	// ===============================================================
	public function posicoesMenusGlobais($menu) {
		switch($menu) {
			case 'curso':
				switch($this->system->session->getItem('session_nivel')) {
					case 1:
						return 7;
					case 2:
						return 3;
					case 3:
						return 10;
				}
				break;
			case 'vendas':
				switch($this->system->session->getItem('session_nivel')) {
					case 1:
						return 9;
					case 6:
						return 2;
				}
				break;
			case 'certificados-gerenciar':
				switch($this->system->session->getItem('session_nivel')) {
					case 1:
						return 3;
					case 6:
						return 2;
				}
				break;
			case 'cupons':
				switch($this->system->session->getItem('session_nivel')) {
					case 1:
						return 6;
					case 6:
						return 2;
				}
				break;
			case 'categorias': 
				switch ($this->system->session->getItem('session_nivel')) {
					case 2:
						return 2;
					case 1:
						return ;
				}
				break;
		}
		return 0;
	}
	// ===============================================================
	public function redirecionar($url = '/dashboard/home') {
		$categoria = $this->system->session->getItem('session_nivel_categoria');
		session_write_close();
		header('Location: ' . $this->system->getUrlSite() . 'lms/' . $categoria . $url);
		exit();
	}

	//=================================================================
	public function htmlToPdf($html, $debug = false) {
		require_once(dirname(__FILE__).'/pdf/html2pdf.class.php');
		try {
		    $html2pdf = new HTML2PDF('P', 'A4', 'fr');
		    if ($debug)
		    	$html2pdf->setModeDebug();
		    $html2pdf->setDefaultFont('Arial');
		    $html2pdf->writeHTML($html);
		    $html2pdf->Output('resultado.pdf');
		}
		catch(HTML2PDF_exception $e) {
		    echo $e;
		    exit;
		}
	}
	//=================================================================
	public function htmlToPdf2($html, $format = 'A4', $semMargin = false, $salvar = false) {
		ini_set('memory_limit', '-1');
		require_once(dirname(__FILE__)."/mpdf/mpdf.php");
		preg_match('/<link href="(.*?)" type="text\/css" rel="stylesheet">/', $html, $css);
		
		if ($semMargin)
			$mpdf = new mPDF('pt-BR', $format, 9, 'dejavusans', 0, 0, 0, 0, 0, 0);
		else
			$mpdf = new mPDF('pt-BR', $format, 9, 'dejavusans');
		foreach($css as $value) {
			if ($value) {
				$stylesheet = file_get_contents($value);
				$mpdf->WriteHTML($stylesheet, 1);
			}
		}
		$mpdf->WriteHTML($html);
		if ($salvar) {
			$mpdf->Output($salvar, 'F');
		}
		else {
			$mpdf->Output();
			die;
		}

		
	}
	//=================================================================
	public function htmlToJpg($html) {
		$categoria = $this->system->session->getItem('session_nivel_categoria');
		$htmlPartes = explode('</body>', $html);
		$htmlParteInicial = explode('<body>',$htmlPartes[0]);
		$html = $htmlParteInicial[0] . '<body><div>' . $htmlParteInicial[1];
		//form
		$html .= '<form method="POST" enctype="multipart/form-data" action="/lms/' . $categoria . '/jpg/download" id="myForm"><input type="hidden" name="img_val" id="img_val" value="" /></form>';
		//script
		$html .= '<script type="text/javascript" src="/lms/common/js/jquery-1.9.1.min.js"></script>';
		$html .= '<script type="text/javascript" src="/lms/common/js/canvas/html2canvas.js"></script>';
		$html .= '<script type="text/javascript" src="/lms/common/js/canvas/jquery.plugin.html2canvas.js"></script>';
		$html .= '<script>
						function enviar() {
						    $("canvas").html2canvas({
						        onrendered: function (canvas) {
						            $("#img_val").val(canvas.toDataURL("image/jpeg"));
						            document.getElementById("myForm").submit();           
						        }
						    });
						}

						html2canvas(document.body, {
						    onrendered: function(canvas) {
						        document.body.appendChild(canvas);
						        enviar();
						    }
						});
					</script>';
		$html .= '</div></body>' . $htmlPartes[1];
		echo $html;
	}
	// ================================================================
	public function isInt($valor) {
		return (preg_match('/^[0-9]*$/', $valor) ? true : false);
	}
	// ================================================================
	public function isUnique($tabela, $campo, $valor,  $condicao = '') {
		$query = $this->system->sql->select($campo, $tabela, $campo . " = '" . $valor .  "' ". $condicao);
		$result = end($this->system->sql->fetchrowset($query));
		return ($result[$campo] ? false : true);
	}
	//=================================================================
	public function sendMail($to, $titulo, $mensagem, $deNome = 'Cursos IAG', $deEmail = '', $anexos = array()) {		
		if (!$deEmail) {
			$deEmail = $this->system->getEmail();
		}

		error_reporting(0);
		require_once(dirname(__FILE__)."/phpmailer/class.phpmailer.php");
		// Inicia a classe PHPMailer
		$mail = new PHPMailer();

		$mail->IsSMTP();

        try {
			//$mail->Host       = "mail.yourdomain.com"; 
			//$mail->SMTPDebug  = 2;                     

			//Ar
			// $mail->SMTPSecure = "tls";                 
			// $mail->Host       = "mail.cursosiag.com.br";      
			// $mail->Port       = 587;                   
			// $mail->Username   = "naoresponda@cursosiag.com.br";  
			// $mail->Password   = "PrivateEvent21";            

	
			$mail->AddAddress($to);
			$mail->SetFrom($deEmail, $deNome);
			
			$mail->Subject = $titulo;
			$mail->MsgHTML($mensagem);
			foreach ($anexos as $anexo)
				$mail->AddAttachment($anexo);      // attachment
			
			$mail->Send();
		} catch (phpmailerException $e) {
  			//echo $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
  			//echo $e->getMessage(); //Boring error messages from anything else!
		}


		//Enviar o email (MODO ANTIGO)
		// $this->system->emailer->clear(TRUE);
		// $this->system->emailer->to($to);
		// $this->system->emailer->from($deEmail, $deNome);
		// $this->system->emailer->message($mensagem);
		// $this->system->emailer->subject($titulo);
		// foreach ($anexos as $anexo) 
		// 	$this->system->emailer->attach($anexo);
		// $this->system->emailer->send();
		// echo $this->system->emailer->print_debugger();die;	
	
	}

	//==================================================================
	public function setCacheVariaveis($arquivo, $variaveis, $minutos = 5) {
		$dirCache = dirname(__FILE__).'/../_views/cache/';
		$conteudo['expira'] = date('Y-m-d H:i:s', mktime(date('H'), (date('i') + $minutos), date('s'), date('m'), date('d'), date('Y')));
		$conteudo['variaveis'] = $variaveis;
		file_put_contents($dirCache . $arquivo . '.txt', json_encode($conteudo));
	}
	//==================================================================
	public function getCacheVariaveis($arquivo) {
		$dirCache = dirname(__FILE__).'/../_views/cache/';
		
		if (file_exists($dirCache . $arquivo . '.txt')) {
			$conteudo = json_decode(file_get_contents($dirCache . $arquivo . '.txt'), true);	
			$dataAtual = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y')));
			if ($conteudo['expira'] > $dataAtual) 
				return $conteudo['variaveis'];
			unlink($dirCache . $arquivo . '.txt');
		}
		
		return false;	
	}
	// ===============================================================
	public function stringToUrl($str, $separator = '-', $lowercase = TRUE) {
				
		$q_separator = preg_quote($separator);
		$trans = array(
			'&.+?;'                 => '',
			'[^a-z0-9 _-]'          => '',
			'\s+'                   => $separator,
			'('.$q_separator.')+'   => $separator
		);

		$str = strip_tags($str);

		$str = strtr($str,array(
          'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
          'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
          'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
          'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
          'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
          'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
          'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
	      'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
		));

		foreach ($trans as $key => $val) 
			$str = preg_replace("#".$key."#i", $val, $str);

		if ($lowercase === TRUE) 
			$str = strtolower($str);

		return trim($str, $separator);
	}
	// ==============================================================
	public function urlAmazon($url) {
		$url = parse_url($url);

		$bucket = current(explode('.', $url['host']));
		$filename = $url['path'];
		echo '/lms/video.php?dominio=' . $bucket . '&arquivo=' . $filename;
		return '/lms/video.php?dominio=' . $bucket . '&arquivo=' . $filename;
	}
	// =============================================================
	public function getIP() {
		$ipaddress = '';
	    if ($_SERVER['HTTP_CLIENT_IP'])
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if($_SERVER['HTTP_X_FORWARDED'])
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if($_SERVER['HTTP_FORWARDED_FOR'])
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if($_SERVER['HTTP_FORWARDED'])
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if($_SERVER['REMOTE_ADDR'])
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $ipaddress = 'UNKNOWN';
	 
	 	$ipaddress = end(explode(',', $ipaddress));

	    return $ipaddress;
	}
	// ===============================================================
	public function baseurl($url = '/home/dashboard') {
		$categoria = $this->system->session->getItem('session_nivel_categoria');
		return $this->system->getUrlSite() . 'lms/' . $categoria . $url;
	}
	// ===============================================================
	public function divisaoCusto($valorTotal, $precoCurso, $custo) {
		$porcentagem = ((100 * $precoCurso) / $valorTotal);
		return (($custo * $porcentagem) / 100);
	}
}
// ===================================================================