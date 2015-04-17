
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-user"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Historico</h5>
                <h1>Historico do Aluno</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

            <form action="" onsubmit="return false;" id="form_historico" anem="form_historico">
                <input type="hidden" value="{$aluno.id}" name="aluno_id" id="aluno_id" />
                 <!-- RESULTADO -->
                <table class="table table-bordered">
                    <thead>
                        
                    </thead>
                    <tbody>
                        <tr>
                            <td>Aluno: <strong>{$aluno.nome}</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <select name="curso_id" id="curso_id" class="input-xxlarge curso_aluno">
                                    <option value="" selected>Selecione o Curso do Aluno</option>
                                    {foreach item=curso from=$cursos}
                                    <option value="{$curso.id}">{$curso.curso}</option>
                                    {/foreach}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Porcentagem Concluida: <input type="text" name="porcentagem" id="porcentagem" /> <small>(apenas numeros)</small>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="button" onclick="javascript:inserirHistorico();" value="  Inserir  " class="btn btn-success" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>

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
function inserirHistorico() {
    if (jQuery('#porcentagem').val() == '') {
        alert('Informe a porcentagem!');
    } else {
        jQuery.get('/lms/{/literal}administrador-geral{literal}/historico/salvar', jQuery('#form_historico').serialize(), function html(html) {
                jAlert('Inserido com sucesso!');
            }
        );
    }
}
</script>  
{/literal}