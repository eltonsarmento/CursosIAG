
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-user"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Professores</h5>
                <h1>Estatísticas</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <table class="table table-bordered" id="dyntable">
                                
                	<thead>
                        <th>Nome do Professor</th>
                        <th class="center">Total de Cursos</th>
                        <th class="center">Total de Dúvidas</th>
						<th class="center">Dúvidas Respondidas</th>
						<th class="center">Dúvidas Pendentes</th>
                    </thead>
                    
                    <tbody>
                    	{foreach item=professor from=$professores}
                         <tr>
                            <td>{$professor.nome}</td>
                            <td class="center">{$professor.total_cursos}</td>
                            <td class="center">{$professor.total_duvidas}</td>
                            <td class="center">{$professor.total_respondidas}</td>
                            <td class="center"><label class="label label-important">{math equation="(x-y)" x=$professor.total_duvidas y=$professor.total_respondidas}</label></td>
                        </tr>  
                        {/foreach}
                    </tbody>
                
                </table>
                
                <div class="footer">
                    <div class="footer-left">
                        <span>&copy; {date('Y')}. Cursos IAG.</span>
                    </div>
                    <div class="footer-right">
                        <span>Uma plataforma: <a href="http://www.iteacher.com.br/" title="iTeacher" target="_blank"><img src="http://www.iteacher.com.br/market/common/siteTemp/imgs/logo-iteacher.png" style="vertical-align:top;" width="70" class="img-responsive"></a></span>
                    </div>
                </div><!--footer-->
                
            </div><!--maincontentinner-->
        </div><!--maincontent-->
        
    </div><!--rightpanel-->