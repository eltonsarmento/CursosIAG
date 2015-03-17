 
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/aluno/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Painel do Aluno</a> <span class="separator"></span></li>
            <li>Certificados</li>
            
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="aluno/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->

            <div class="pageicon"><span class="iconfa-certificate"></span></div>
            <div class="pagetitle">
                <h5>Painel do Aluno</h5>
                <h1>Cerfiticados</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                <table class="table table-bordered" id="dyntable">

                    <thead>

                        <th>Nome do Curso</th>
                        <th class="center">Emitido em</th>
                        <th class="center">Tipo de Certificado</th>
                        <th class="center">Status do Certificado</th>
                        <th class="center"><i class="iconfa-truck"></i> Código de Rastreamento</th>
                        <th class="center">Download</th>

                    </thead>

                    <tbody>
                        {foreach item=certificado from=$certificados}
                        <tr>

                            <td>{$certificado.curso.curso}</td>
                            <td class="center">
                                {if $certificado.data_emissao == '0000-00-00'}
                                    <strong>Ainda não emitido</strong>
                                {else}
                                    <strong>{$certificado.data_emissao|date_format:'%d/%m/%Y'}</strong>
                                {/if}
                            </td>
                            <td class="center">
                                {if $certificado.tipo_certificado == 1}
                                    Digital
                                {else}
                                    Impresso
                                {/if}
                            </td>
                            <td class="center">
                                {if $certificado.status == 1}
                                    <span class="label label-success"><i class="iconfa-ok"></i> Entregue</span>
                                {elseif $certificado.status == 2}
                                    <span class="label label-info"><i class="iconfa-info-sign"></i> Enviado</span>
                                {elseif $certificado.status == 3}
                                    <span class="label label-warning"><i class="iconfa-warning-sign"></i> Aguardando pagamento</span>
                                {elseif $certificado.status == 4}
                                    <span class="label label-important"><i class="iconfa-remove"></i> Cancelado por falta de pagamento</span>
                                {elseif $certificado.status == 5}
                                    <span class="label label-info"><i class="iconfa-info-sign"></i> Enviado</span>
                                {/if}
                            </td>
                            <td class="center">
                                {if $certificado.codigo_rastreamento}
                                    {$certificado.codigo_rastreamento}
                                {else}
                                    Não Existe
                                {/if}
                            </td>
                            <td class="center">
                                {if $certificado.tipo_certificado == 1}
                                <ul class="tooltipsample">
                                    <li><a href="{$url_site}lms/aluno/certificados/certificado/{$certificado.matricula_curso_id}" target="_blank" class="btn btn-warning"  data-placement="bottom" data-rel="tooltip" data-original-title="Download do Certificado"><i class="iconfa-upload-alt"></i></a></li>
                                </ul>
                                {/if}
                            </td>
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
    
</div><!--mainwrapper-->

