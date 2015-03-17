 
    <div class="rightpanel">
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Configurações Gerais</a> <span class="separator"></span></li>
            <li>Termos e Condições</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-tasks"></span></div>
            <div class="pagetitle">
                <h5>Configurações Gerais</h5>
                <h1>Termos e Condições</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <form action="" method="post">
                    <input type="hidden" value="1" name="editar"/>
            
                    <div>
                        <textarea id="elm1" name="termos_condicoes" rows="15" cols="80" style="width: 80%" class="tinymce">
                            {$termos.termos_condicoes}
                        </textarea>
                    </div>
                    <br />
                    <input type="submit" name="submit" value="Salvar Variação" class="btn btn-primary">

            </form>
            
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
</script>  
{/literal}