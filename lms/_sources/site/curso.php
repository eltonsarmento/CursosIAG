<?php
// ===================================================================
class Curso {
	// ===============================================================
	protected $system = null;
	private $limit = 12;
	private $tituloPagina = 'Cursos';
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('curso');
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {
			case 'visualizar':	$this->doVisualizar(); break;
			case 'buscar':		$this->doBuscar(); break;
			case 'carregarMais':$this->doCarregarMais(); break;
			case 'preco':		$this->doPreco(); break;
			default: 			$this->doVisualizar(); break;
		}	
	}
	// ===============================================================
	protected function doVisualizar() {
		$this->system->load->dao('aulas');
		$this->system->load->dao('professores');
		$this->system->load->dao('configuracoesgerais');
		$this->system->load->dao('depoimentos');

		$id = $this->system->input['id'];

		if (!$id) {
			$url = $this->system->func->getValorUrl(2);
			$id = $this->system->curso->getIdByUrl($url);
		}

		/*$categorias = $this->system->curso->getCategoriasByCurso($id, true);
		foreach ($categorias as $key => $categoria) {
			if(in_array('Carreiras', $categoria)) {
			 	echo 'Categoria Carreiras';
			}
		}*/
		
		if ($id) {
			//curso
			$curso = $this->system->curso->getCursoCondicao(" and id = $id and home = 1");	

			if (!$curso['id']) {
				session_write_close();
				header('Location: ' . $this->system->getUrlSite() . 'home');
				exit();
			}
			$this->tituloPagina = $curso['curso'];

			$curso['valor_6'] = number_format(($curso['valor'] / 6), 2, ',', '.');
			$curso['valor'] = number_format($curso['valor'], 2,',','.');

			if ($curso['gratuito']) $curso['valor'] = 0;

			//certificado
			if ($curso['certificado']) {
				$certificado = $this->system->configuracoesgerais->getProdutosCertificados();

				if ($certificado['produtos_certificado_tipo'] == 0) 
					$curso['certificado'] = 0;

				//Preço certificado
				if ($certificado['produtos_certificado_tipo'] != 2)
					$precoCertificado = 0;
				else
					$precoCertificado = $certificado['produtos_certificado_valor'];
				
			}

			//suporte
			if ($curso['suporte']) {
				$suporte = $this->system->configuracoesgerais->getProdutosSuporte();
				
				if ($suporte['produtos_suporte_tipo'] == 0 || $curso['gratuito'] == 1)
					$curso['suporte'] = 0;
				
				//Preço suporte
				if (in_array($suporte['produtos_suporte_tipo'], array(0, 1)) || $curso['gratuito'] == 1)
					$precoSuporte = 0;
				elseif ($suporte['produtos_suporte_tipo'] == 2) //fixo
					$precoSuporte = $suporte['produtos_suporte_valor']; 
				elseif ($suporte['produtos_suporte_tipo'] == 3)  //porcentagem
					$precoSuporte = (($suporte['produtos_suporte_valor'] * $curso['valor']) / 100);	

			}	

			//Servidor Padrão
			if ($curso['servidor'] == 1)//amazon
				$servidor = 1;
			elseif ($curso['servidor'] == 2)
				$servidor = 2;
			else {
				$this->system->load->dao('configuracoesgerais');
				$servidor = $this->system->configuracoesgerais->getServidor();
				$servidor = $servidor['servidor_padrao'];
			}

			//cursos relacionados
			$cursosRelacionados = $this->system->curso->getCursosRelacionados($curso['id'], true);
			foreach ($cursosRelacionados as $key => $value) {
				$cursosRelacionados[$key]['valor'] = number_format($value['valor'], 2, ',', '.');
				$cursosRelacionados[$key]['categorias'] = $this->system->curso->getCategoriasByCurso($value['id'], true);
			}

			//professor
			$professor = $this->system->professores->getProfessor($curso['professor_id'], true);
			$professor['minicurriculo'] = $this->system->professores->getValorExtra($professor['id'], 'minicurriculo');
			
			//depoimentos
			$depoimentos = $this->system->depoimentos->getDepoimentos(" and curso_id = '$id' and status = 1");
			if($curso['review_curso']){
				
				$this->system->view->assign('aulaGratuita', base64_encode(urldecode($curso['review_curso'])));
			}
				
			else
				$this->system->view->assign('aulaGratuita', $this->system->aulas->getAulaGratuitaByCurso($curso['id']));
            
            $aulas = $this->system->aulas->getAulas(" and curso_id = $id and gratuito = 1");
			
			$this->system->view->assign('cursosRelacionados', $cursosRelacionados);
			$this->system->view->assign('curso', $curso);
            $this->system->view->assign('aulas', $aulas);
			$this->system->view->assign('precoCertificado', $precoCertificado);
			$this->system->view->assign('servidor', $servidor);
			$this->system->view->assign('precoSuporte', $precoSuporte);
			$this->system->view->assign('capitulos', $this->system->aulas->getCapitulosByCurso($curso['id']));
			$this->system->view->assign('depoimentos', $depoimentos);
			$this->system->view->assign('professor', $professor);
		} else {
			session_write_close();
			header('Location: ' . $this->system->getUrlSite() . '/home');
			exit();
		}

		$this->system->site->topo($this->tituloPagina);
		$this->system->view->display('site/curso.tpl');
		$this->system->site->rodape();
	}

	// ===============================================================
	protected function doBuscar() {
		$palavraChave = $this->system->input['palavras'];
		$ordenacao = $this->system->input['ordenacao'];
		$this->system->session->deleteItem('resultado_busca_mais');

		switch($ordenacao) {
			case 1:
				$orderBy = 'curso';
				break;
			case 2:
				$orderBy = 'curso desc';
				break;
			case 3:
				$orderBy = 'valor';
				break;
			case 4:
				$orderBy = 'valor desc';
				break;
			default:
				$orderBy = 'data_cadastro desc';
				break;

		}

		$where = ' and home = 1 ' . ($palavraChave != ''? " and curso like '%" . $palavraChave.  "%'" : '');
		$cursos = $this->system->curso->getCursosCondicao($where, '', $orderBy, 'id, curso, destaque_arquivo, valor, gratuito, url');

		$cursosExibir = array();
		$cursosListarMais = array();
		foreach ($cursos as $key => $curso) {
			$curso['valor'] = str_replace('.', ',', $curso['valor']);
			$curso['categorias'] = $this->system->curso->getCategoriasByCurso($curso['id'], true);

			//if ($key < $this->limit)
				$cursosExibir[] = $curso;
			//else
			//	$cursosListarMais[] = $curso;
		}
		$this->system->session->addItem('resultado_busca_mais', $cursosListarMais);

		$this->system->view->assign('palavraChave', $palavraChave);
		$this->system->view->assign('cursos', $cursosExibir);
		$this->system->view->assign('totalExibindo', count($cursosExibir));
		$this->system->view->assign('total', (count($cursosExibir)+count($cursosListarMais)));
		$this->system->site->topo($this->tituloPagina);
		$this->system->view->display('site/busca.tpl');
		$this->system->site->rodape();	
	}
	// ==============================================================
	protected function doCarregarMais() {
		$cursos = $this->system->session->getItem('resultado_busca_mais');
		$this->system->session->deleteItem('resultado_busca_mais');

		$cursosExibir = array();
		$cursosListarMais = array();
		foreach ($cursos as $key => $curso) {
			if ($key < $this->limit)
				$cursosExibir[] = $curso;
			else
				$cursosListarMais[] = $curso;
		}
		$this->system->session->addItem('resultado_busca_mais', $cursosListarMais);

		$this->system->view->assign('url_site', $this->system->getUrlSite());
		$this->system->view->assign('cursos', $cursosExibir);
		$this->system->view->display('site/carregar_mais.tpl');
		if (!count($cursosListarMais))  {
			echo "<script>$('#load-more').hide();$('#load-more-disable').fadeIn(500);</script>";
		}
	}
	// ===============================================================
	protected function doPreco() {
		$preco = $this->system->input['preco'];
		$suportePreco = $this->system->input['suporte_p'];
		$certificadoPreco = $this->system->input['certificado_p'];
		$suporte = $this->system->input['suporte'];
		$certificado = $this->system->input['certificado'];
		
		$preco = str_replace(',', '.', $preco);

		if ($suporte)
			$preco += $suportePreco;
		if ($certificado)
			$preco += $certificadoPreco;

		echo "<script type='text/javascript'>";
		if ($preco > 0)
			echo "jQuery('.preco_curso').html('6x de R$ " . number_format($preco/6, 2, ',', '.') . "');";
		else 
			echo "jQuery('.preco_curso').html('Gratuito');";


		echo "jQuery('.6_vezes').html('sem juros ou R$ " . number_format($preco, 2, ',', '.') . "');";
		echo "</script>";
	}
	// ===============================================================
	protected function pagina404() {
		$url = end(explode($this->system->getUrlSite(), $_SERVER['REQUEST_URI']));
		$this->system->view->assign('url', $url);
		$this->system->site->topo(0);
		$this->system->view->display('site/pagina404.tpl');
		$this->system->site->rodape();
	}
}
// ===================================================================