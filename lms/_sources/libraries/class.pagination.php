<?php 
class Pagination {

	var $base_url			= ''; //URL BASE
	var $total_rows			=  0; //TOTOAL DE RESULTADO
	var $per_page			= 10; //EXIBIR POR PAGINA
	var $num_links			=  2; //NÚMEROS DE LINKS QUE SERÃO EXIBIDOS
	var $cur_page			=  0; //PÁGINA ATUAL
	var $use_page_numbers	= TRUE; //USAR NÚMERO DA PAGINA OU VALORES. Ex: True - 1, 2, 3, 4... | False - 0, 10, 20, 30...
	var $first_link			= '&lt;&lt;'; //TEXTO "Primeira pagina" (TROCAR POR FALSE, SE NÃO QUISER)
	var $next_link			= '&gt;'; //TEXTO "Próxima pagina" (TROCAR POR FALSE, SE NÃO QUISER)
	var $prev_link			= '&lt;'; //TEXTO "Próxima pagina" (TROCAR POR FALSE, SE NÃO QUISER)
	var $last_link			= '&gt;&gt;'; //TEXTo "Ultima Página" (TROCAR POR FALSE, SE NÃO QUISER)
	var $full_tag_open		= '<div class="pagination pagination-centered"><ul>'; //ABRE TAG QUE ENGLOBA TODA PAGINAÇÃO
	var $full_tag_close		= '</ul></div>'; //FECHA TAG QUE ENGLOBA TODA PAGINAÇÃO
	var $first_tag_open		= '<li>'; //ABRE TAG DA "PRIMEIRA PAGINA"
	var $first_tag_close	= '</li>'; //FECHA TAG DA "PRIMEIRA PAGINA"
	var $last_tag_open		= '<li>'; //ABRE TAG DA "ULTIMA PAGINA"
	var $last_tag_close		= '</li>'; //FECHA TAG DA "ULTIMA PAGINA"
	var $first_url			= ''; //LINK ALTERNATIVO PARA "PRIMEIRA PAGINA"
	var $cur_tag_open		= '<li class="active"><a href="javascript:;">'; //ABRE TAG DA "PAGINA ATUAL"
	var $cur_tag_close		= '</a></li>'; //FECHA TAG DA "PAGINA ATUAL"
	var $next_tag_open		= '<li>'; //ABRE TAG DA "PRÓXIMA PAGINA"
	var $next_tag_close		= '</li>'; //FECHA TAG DA "PRÓXIMA PAGINA"
	var $prev_tag_open		= '<li>'; //ABRE TAG DA "PAGINA ANTERIOR"
	var $prev_tag_close		= '</li>'; //FECHA TAG DA "PAGINA ANTERIOR"
	var $num_tag_open		= '<li>'; //ABRE TAG DA PAGINA NORMAIS
	var $num_tag_close		= '</li>'; //FECHA TAG DA PAGINA NORMAIS
	var $display_pages		= TRUE; //EXIBE ÁS PAGINAS NORMAIS
	var $anchor_class		= ''; //CLASS DOS HYPERLINKS
	var $var_name 			= 'pag'; //NOME DA VARIAVEL. Ex. index.php?PAG=1
	var $tag_separador 		= '&amp;'; // ? ou &amp; //SE NA URL Será usando ? ou &;

	public function __construct($params = array()) {
		if (count($params) > 0) 
			$this->initialize($params);
	
		if ($this->anchor_class != '') 
			$this->anchor_class = 'class="'.$this->anchor_class.'" ';
	}

	// --------------------------------------------------------------------
	function initialize($params = array()) {
		if (count($params) > 0) {
			foreach ($params as $key => $val) {
				if (isset($this->$key))	
					$this->$key = $val;
			}
		}
	}

	// --------------------------------------------------------------------

	function create_links() {
		//Se o total for zero
		if ($this->total_rows == 0 OR $this->per_page == 0) 
			return '';		

		// Calcula o total de paginas
		$num_pages = ceil($this->total_rows / $this->per_page);

		// Se existir apenas uma pagina
		if ($num_pages == 1) 
			return '';

		// Pagina base
		if ($this->use_page_numbers)    //Ex. Pag 1, 2, 3...
			$base_page = 1;
		else 							//Ex. Pag 0, 10, 20... 
			$base_page = 0;
		
	
		// Se a pagina atual não estiver setada, usa a pagina base
		if ($this->use_page_numbers AND $this->cur_page == 0)
			$this->cur_page = $base_page;
		
		//Pagina não é um numero
		if (!is_numeric($this->cur_page))	
			$this->cur_page = $base_page;

		//Numero de links de paginas que serão exibidas na paginação
		$this->num_links = (int)$this->num_links;

		
		//Paginas maiores que o total
		if ($this->use_page_numbers) {
			if ($this->cur_page > $num_pages)
				$this->cur_page = $num_pages;
			
		} else {
			if ($this->cur_page > $this->total_rows)
				$this->cur_page = ($num_pages - 1) * $this->per_page;

			$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);
		}

		$uri_page_number = $this->cur_page;
		

		//Gera a pagina inicial e final
		$start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;

		$this->base_url = rtrim($this->base_url). $this->tag_separador .$this->var_name.'=';
		

		$output = '';

		// Gera o link "Primeira Página"
		if  ($this->first_link !== FALSE AND $this->cur_page > ($this->num_links + 1)) {
			$first_url = ($this->first_url == '') ? $this->base_url . $base_page : $this->first_url;
			$output .= $this->first_tag_open.'<a '.$this->anchor_class.'href="'.$first_url.'">'.$this->first_link.'</a>'.$this->first_tag_close;
		}

		// Gera o link "Página Anterior"
		if  ($this->prev_link !== FALSE AND $this->cur_page != 1) {
			if ($this->use_page_numbers) 
				$i = $uri_page_number - 1;
			else 
				$i = $uri_page_number - $this->per_page;
		

			if ($i == 0 && $this->first_url != '')	{
				$output .= $this->prev_tag_open.'<a '.$this->anchor_class.'href="'.$this->first_url.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
			}
			else {
				$i = ($i == 0) ? '' : $i;
				$output .= $this->prev_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$i.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
			}

		}

		// Gera as paginas
		if ($this->display_pages !== FALSE)	{
			// Write the digit links
			for ($loop = $start -1; $loop <= $end; $loop++)	{
				
				if ($this->use_page_numbers) 
					$i = $loop;
				else
					$i = ($loop * $this->per_page) - $this->per_page;
				

				if ($i >= $base_page) {
					if ($this->cur_page == $loop) {
						$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Current page
					}
					else {
						$n = ($i == $base_page) ? '' : $i;

						if ($n == '' && $this->first_url != '') {
							$output .= $this->num_tag_open.'<a '.$this->anchor_class.'href="'.$this->first_url.'">'.$loop.'</a>'.$this->num_tag_close;
						}
						else {
							$n = ($n == '') ? '' : $n;

							$output .= $this->num_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$n.'">'.$loop.'</a>'.$this->num_tag_close;
						}
					}
				}
			}
		}

		// Gera o botão "próximo"
		if ($this->next_link !== FALSE AND $this->cur_page < $num_pages) {
			if ($this->use_page_numbers) 
				$i = $this->cur_page + 1;
			else
				$i = ($this->cur_page * $this->per_page);

			$output .= $this->next_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$i.'">'.$this->next_link.'</a>'.$this->next_tag_close;
		}

		// Gera o botão ultima
		if ($this->last_link !== FALSE AND ($this->cur_page + $this->num_links) < $num_pages) {
			if ($this->use_page_numbers)
				$i = $num_pages;
			else
				$i = (($num_pages * $this->per_page) - $this->per_page);

			$output .= $this->last_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$i.'">'.$this->last_link.'</a>'.$this->last_tag_close;
		}

		//$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;

		return $output;
	}
}
