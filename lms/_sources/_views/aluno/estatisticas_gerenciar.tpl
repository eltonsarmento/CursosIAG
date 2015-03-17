<div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/aluno/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="/lms/aluno/dashboard/home">Painel principal</a> <span class="separator"></span></li>
            <li>Estatísticas</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="aluno/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-signal"></span></div>
            <div class="pagetitle">
                <h5>Painel do Aluno</h5>
                <h1>Estatísticas</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="row-fluid">
                    
                    <div class="span12">
                        
                        <h4 class="widgettitle">Percentual Concluído</h4>
                        <div class="widgetcontent">
                            <table class="table table-bordered">

                                <thead>
                                    <th>Nome do Curso</th>
                                    <th class="center">Concluído</th>
                                    <th class="center">Aulas Assistidas</th>
                                </thead>

                                <tbody>
                                {foreach item=curso from=$cursos_adquiridos}
                                    <tr>
                                        <td>{$curso.curso}</td>
                                        <td class="center">
                                            <span class="right marginleft15"><strong>{math equation="(( x / y ) * z )" x=$curso.aulas_assistidas y=$curso.aulas_total z=100 format="%.2f"}%</strong></span>
                                            <div class="progress progress progress-striped active nomargin">
                                                <div style="width: {math equation="(( x / y ) * z )" x=$curso.aulas_assistidas y=$curso.aulas_total z=100}%" class="bar"></div>
                                            </div><!--progress-->
                                        </td>
                                        <td class="center">{$curso.aulas_assistidas}</td>
                                    </tr>
                                {/foreach}
                                   

                                </tbody>    

                            </table> 

                        </div><!--widgetcontent-->
                    
                    </div><!--span6-->
                    
                </div><!--row-fluid-->
                
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