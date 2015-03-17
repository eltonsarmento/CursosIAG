<div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Gerenciar Administrativo</a> <span class="separator"></span></li>
            <li>Gerenciar Cupons</li>

        </ul>
        
        <div class="pageheader">
            {include file="$categoria/busca_topo.tpl"}
            <div class="pageicon"><span class="iconfa-tags"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Administrativo</h5>
                <h1>Gerenciar Cupons</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                <a href="/lms/{$categoria}/cupons/novo" class="btn btn-primary"><i class="iconfa-plus"></i> Adicionar novo cupom</a>
                
                <br /><br />

                <table class="table table-bordered" id="dyntable">

                    <thead>
                        
                        <th>Nome do Cupom</th>
                        <th class="center">Tipo do cupom</th>
                        <th class="center">Status do cupom</th>
                        <th>Criado por</th>
                        <th>Ações</th>
                    </thead>

                    <tbody>
						{foreach item=cupom from=$cupons}
                        <tr>
							<td>{$cupom.nome}</td>
                            <td class="center">
								{if $cupom.tipo eq 1}
								Único
								{elseif $cupom.tipo eq 2}
								Intervalo de Tempo
								{elseif $cupom.tipo eq 3}
								Quantidade
								{elseif $cupom.tipo eq 4}
								Indeterminado
								{/if}
							</td>
                            <td class="center">
								{if $cupom.ativo eq 0}
								<span class="label label-important"><i class="iconfa-remove"></i> Inativo</span>
								{elseif $cupom.ativo eq 1}
								<span class="label label-success"><i class="iconfa-ok"></i> Ativo</span>
								{elseif $cupom.ativo eq 2}
								<span class="label label-warning"><i class="iconfa-minus"></i> Usado</span>
								{elseif $cupom.ativo eq 3}
								<span class="label label-info"><i class="iconfa-calendar"></i> Futuro</span>
								{/if}
							</td>
							<td>{$cupom.usuario}</td>
                            <td width="90">
                                              
                              <ul class="tooltipsample">
                                <li><a href="/lms/{$categoria}/cupons/editar/{$cupom.id}" class="btn" data-placement="bottom" data-rel="tooltip" data-original-title="Editar Cupom"><i class="iconfa-pencil"></i></a></li>
								<li><a href="javascript:;" onclick="javascript:deletar({$cupom.id})" class="btn btn-primary confirmbutton" data-placement="bottom" data-rel="tooltip" data-original-title="Remover Cupom"><i class="iconfa-remove"></i></a></li>
                              </ul>

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
{literal}
<script type="text/javascript">
jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});

function deletar(id) {
    jConfirm('Deseja excluir este cupom?', 'Excluir Cupom', function(r) {
         if (r) {
        {/literal}
        window.location.href='{$url_site}lms/{$categoria}/cupons/apagar/'+id;
        {literal}
    }     
    });
}
</script>  
{/literal}