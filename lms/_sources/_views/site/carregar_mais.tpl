                    {foreach item=curso from=$cursos}
                    <article>
                        
                        <figure><a href="{$url_site}curso/{$curso.url}"><img src="{$url_site}lms/uploads/imagens/{$curso.destaque_arquivo}" alt=""></a></figure>
                        
                       <!--  <h2>
                            {foreach item=categoria from=$curso.categorias}
                                {$categoria.categoria}
                            {/foreach}
                        </h2> -->
                        
                        <section class="box-cursos-content">
                            
                            <a href="{$url_site}curso/{$curso.url}"><h1>{$curso.curso}</h1></a>
                            
                            <section class="info-curso">
                                
                                <span>Curso Online</span>
                            
                            </section><!--.info-cursos-->
                            
                            <section class="btn">
                            
                                <a href="{$url_site}curso/{$curso.url}" class="btn-orange btn-block">Conheça o Curso</a>
                            
                            </section><!--.btn-->
                        
                        </section><!--.box-cursos-content-->
                    
                    </article><!--.article-->
                    {/foreach}

                    