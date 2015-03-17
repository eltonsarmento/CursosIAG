   
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/professor/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Painel do Professor</a> <span class="separator"></span></li>
            <li>Meus Questionários</li>     
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="professor/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-file"></span></div>
            <div class="pagetitle">
                <h5>Painel do Professor</h5>
                <h1>Meus Questionários</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <table class="table table-bordered responsive" id="dyntable">
                    <thead>
                        <tr>
                            <th class="head0">Nome do Curso</th>
                            <th class="head1 center">Quantidade de Capítulos</th>
                            <th class="head0 center">Quiz Cadastrados</th>
                            <th class="head1 center">Área</th>
                            <th class="head0">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach item=curso from=$cursos}
                        <tr>
                            <td>{$curso.curso}</td>
                            <td class="center" width="180">{$curso.qt_capitulos}</td>
                            <td class="center">{$curso.total_quiz}</td>
                            <td class="center">
                                {foreach item=categoria from=$curso.categorias}
                                    {$categoria.categoria}<br/>
                                {/foreach}
                            </td>
                            <td class="center" width="270"><a href="/lms/professor/quiz/novo/{$curso.id}" class="btn btn-info"><i class="iconfa-question-sign"></i> CADASTRAR QUIZ</a> <a href="/lms/professor/quiz/listar/{$curso.id}" class="btn btn-warning"><i class="iconfa-edit"></i> EDITAR QUIZ</a> </td>
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
    
