{literal}
<style type="text/css">

div.section {
  cursor: move;
}

div.lineitem {
  margin: 0 0 5px 0;
  padding: 5px 10px;
  background-color: #f0f0f0;
  cursor: move;
}

div.lineitem-2 {
  background-color: #ccc;
}

</style>
{/literal}
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>GERENCIAMENTO DE CAPÍTULOS</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-tasks"></span></div>
            <div class="pagetitle">
                <h5>Aulas</h5>
                <h1>Gerenciar</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                <a href="/lms/{$categoria}/curso/listar" class="btn btn-large"><i class="iconfa-caret-left"></i> Voltar</a> <br/><br/>

                <div id="resposta_trocar_posicao"></div>
                {if $msg}<h3 style="text-align:center;"> {$msg} </h3>{/if}
                <div class="widget">
                <h4 class="widgettitle">{$cursoNome}</h4>
                <div class="widgetcontent">
                    {if $deleteSucesso == true} Excluido com sucesso {/if}
                    <div class="row-fluid">
                        <div class="span12">
                            
                            
                            <a href="javascript:mudarPosicao();" data-toggle="modal" class="btn btn-inverse"><i class="iconfa-edit"></i> Salvar Posição Capitulos</a>
                            <div id="page">
                            <input type="hidden" value="{$curso_id}" name="curso_id"/>
                            {foreach item=capitulo key=k from=$capitulos}
                                <div class="sessoes">
                                    <!-- USO SALVAR POSICOES CAPITULOS -->
                                    <input type="hidden" value="{$capitulo.capitulo_id}" class="ordem_capitulo_id" name="ordem_capitulo_id[]" />
                                    <!-- FIM USO SALVAR POSICOES CAPITULOS -->

                                    <div id="group{$capitulo.capitulo_id}" class="section widgetbox">
                                        <h4 class="widgettitle handle">Capítulo {$k+1} - <span id="capitulo_{$capitulo.capitulo_id}">{$capitulo.descricao}</span></h4>
                                        
                                        <!-- USO NO MODAL -->
                                        <input type="hidden" id="descricao_{$capitulo.capitulo_id}" value="{$capitulo.descricao}" />
                                        <input type="hidden" id="numero_{$capitulo.capitulo_id}" value="{$capitulo.capitulo}" />
                                        <input type="hidden" id="id_{$capitulo.capitulo_id}" value="{$capitulo.capitulo_id}" />
                                        <!-- FIM USO NO MODAL -->

            
                                        <a href="/lms/{$categoria}/aulas/novo/{$capitulo.capitulo_id}/" class="btn btn-success"><i class="iconfa-plus"></i> Cadastrar Aula</a>  
                                        <span onclick="javascript:setarValores({$capitulo.capitulo_id});">
                                            <a href="#myModal" data-toggle="modal" class="btn btn-inverse"><i class="iconfa-edit"></i> Editar Descrição Capítulo</a>
                                        </span>
                                        
                                        {foreach item=aulas key=v from=$capitulo.aulas}
                                            <div id="item_{$v+1}" class="lineitem">
                                                <input type="hidden" value="{$aulas.aula_id}" class="aulas" name="aulas[]"/>
                                                <a href="/lms/{$categoria}/aulas/editar/{$aulas.aula_id}/">Aula {$v+1} - {$aulas.nome}</a>
                                                <a href="javascript:;" onclick="javascript:deletar({$aulas.aula_id}, {$aulas.curso_id})" class="confirmbutton" style="float:right"><i class="iconfa-remove"></i></a>
                                             </div>
                                        {/foreach}
                                    </div>
                                </div>
                            {/foreach}

                            </div>
                            

                        </div> <!-- span12 00-->
                    </div><!--widgetcontent-->
                </div><!--widget-->

                    
                <div class="clearfix"></div>
                    
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

    <!-- MY MODAL -->
    <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
            <h3 id="myModalLabel">Editar Descrição do Capítulo</h3>
        </div>
        <div class="modal-body">
            
            <form action="" id="trocar_descricao" method="post">
                
                <!-- REPOSTA -->             
                <div id="resposta_trocar_descricao"></div>
                
                <input type="hidden" value="1" name="editar"/>
                <input type="hidden" value="" name="capitulo_id" id="capitulo_id"/>
                <input type="hidden" value="" name="capitulo_posicao" id="capitulo_posicao"/>
                
                <p class="margintop10">
                   <span id="numero_capitulo"></span> <input type="text" name="descricao_edicao" class="input-xlarge" id="descricao_edicao">
                </p>

            <button class="btn btn-primary" onclick="alterarDescricao(); return false;">Editar Descrição</button>

            </form>

        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn">Fechar</button>
        </div>
    </div>
    <!-- FIM MY MODAL -->

<script type="text/javascript" src="http://www.gregphoto.net/sortable/advanced/scriptaculous/prototype.js"></script>
<script type="text/javascript" src="http://www.gregphoto.net/sortable/advanced/scriptaculous/scriptaculous.js"></script>

{literal}  
<script type="text/javascript">

//Mudar Posição
{/literal}
sections = [
{foreach item=capitulo key=i from=$capitulos}
    'group{$capitulo.capitulo_id}' {if ($i+1) != $capitulos|@count},{/if}
{/foreach}
];
{literal}

function mudarPosicao() {
    var capitulos = [];
    var aulas = [];
    jQuery('.ordem_capitulo_id').each(function(){
        capitulos.push(jQuery(this).val());
    });
    for ( var i = 0; i < capitulos.length; i = i + 1 ) {
        var aulas_capitulo = [];
        jQuery('#group'+capitulos[i]+' .aulas').each(function(){
            aulas_capitulo.push(jQuery(this).val());
        });

        aulas[i] = aulas_capitulo;
    }
    
    {/literal}
    jQuery.post('/lms/{$categoria}/aulas/salvarPosicao', {ldelim}curso:{$curso_id}, capitulos:capitulos, aulas:aulas{rdelim}, function html(html) {ldelim} jQuery('#resposta_trocar_posicao').html(html); {rdelim});
    {literal}

}


//Drag Drop
  // <![CDATA[  
for(var i = 0; i < sections.length; i++) {
      Sortable.create(sections[i],{tag:'div',dropOnEmpty: true, containment: sections,only:'lineitem'});
}
Sortable.create('page',{tag:'div',only:'sessoes',handle:'handle'});
  // ]]>


//Mensagem
{/literal}
{if $msg_alert} jAlert('{$msg_alert}'); {/if}
{literal}

//Edição
function setarValores(capitulo) {
    jQuery("#resposta_trocar_descricao").html("");    
    jQuery("#capitulo_id").val(jQuery("#id_"+capitulo).val());
    jQuery("#capitulo_posicao").val(capitulo);
    jQuery("#numero_capitulo").html("Cápítulo " + jQuery("#numero_"+capitulo).val() + " - ");
    jQuery("#descricao_edicao").val(jQuery("#descricao_"+capitulo).val());
}

function alterarDescricao() {
    {/literal}
    jQuery.post('/lms/{$categoria}/aulas/mudarDescricao', jQuery('#trocar_descricao').serialize(), function html(html) {ldelim} jQuery('#resposta_trocar_descricao').html(html); {rdelim});
    {literal}
}


//Delete
function deletar(id, curso_id) {
    jConfirm('Deseja excluir esta aula?', 'Excluir Aula', function(r) {
        if (r) {
        {/literal}
        window.location.href='{$url_site}lms/{$categoria}/aulas/apagar/'+id;
        {literal}
    }     
    });
}
</script>
{/literal}