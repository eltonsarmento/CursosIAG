    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/professor/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Painel do Professor</a> <span class="separator"></span></li>
            <li>Meus Cursos</li>
            
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="professor/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-book"></span></div>
            <div class="pagetitle">
                <h5>Painel do Aluno</h5>
                <h1>Meus Cursos</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <div class="widgetbox">

                    <h4 class="widgettitle title-primary">Meus Cursos</h4>
                    <div class="widgetcontent">

                        <div class="row-fluid">
                            <div class="span6">
                                {foreach item=curso key=k from=$cursos}

                                    <div>

                                        <div class="media">

                                            <img src="{$url_site}lms/uploads/imagens/{$curso.destaque_arquivo}" class="img-polaroid pull-left">                                 
                                            <div class="media-body">

                                                <h4 class="media-heading"><strong>{$curso.curso}</strong></h4>
                                                <i class="iconfa-user"></i> {$curso.professor}
                                                <div class="media">
                                                    <i class="iconfa-film"></i> {$curso.totalAulas} Aulas                              
                                                    <a href="{$url_site}lms/professor/cursos/verCurso/{$curso.id}" class="btn btn-info margintop18 right"><i class="iconfa-play"></i> Acessar Curso</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {if count($cursos) / ($k+1) <= 2 && $quebrado == false}
                                {assign var=quebrado value=true}  
                                </div>
                                <div class="span6">
                                {/if}
                                {/foreach}
                            </div>
                        </div>
                    </div>
                </div>
                
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
    
