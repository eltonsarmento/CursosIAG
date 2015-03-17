 
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
            <div class="pageicon"><span class="iconfa-money"></span></div>
            <div class="pagetitle">
                <h5>Painel do Aluno</h5>
                <h1>Assinaturas</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                <table class="table table-bordered" id="dyntable">

                    <thead>

                        <th>Tipo de Assinatura</th>
                        <th class="center">Assinado em</th>
                        <th class="center">Status</th>
                        <th class="center">Expira em</th>
                        <th class="center">Renovar Automaticamente?</th>

                    </thead>

                    <tbody>
                        {foreach item=assinatura from=$assinaturas}
                        <tr>
                            <td>{$assinatura.plano.plano}</td>
                            <td class="center"><strong>{$assinatura.data_cadastro|date_format:"%d/%m/%Y"}</strong></td>
                            <td class="center">
                                {if $assinatura.excluido == 0}
                                <span class="label label-success"><i class="iconfa-ok"></i> Ativa</span></span>
                                {else}
                                <span class="label label-important"><i class="iconfa-remove"></i> Expirado</span></span>
                                {/if}
                            </td>
                            <td class="center">{$assinatura.data_expiracao|date_format:"%d/%m/%Y"}</td>
                            <td class="center" id="cancelar_assinatura_{$assinatura.id}">
                            {if $assinatura.excluido == 0 && $assinatura.renovar == 1}
                            <a href="javascript:;" onclick="renovar({$assinatura.id})"> Cancelar minha renovação automática </a>
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

<div id="retorno_renovar"></div>

{literal}
<script type="text/javascript">

function renovar(id) {
    jConfirm('Deseja realmente cancelar a renovação dessa assinatura? Essa ação não poderá ser desfeita.', 'Cancelar Assinatura', function(r) {
         if (r) {
            {/literal}
            jQuery.post('/lms/aluno/assinaturas/renovar', {ldelim} assinatura:id {rdelim}, function html(html) {ldelim} jQuery('#retorno_renovar').html(html) {rdelim});
            {literal}
        } 
    });
    
}
</script>
{/literal}