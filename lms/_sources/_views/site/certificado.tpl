        <section class="container">

            <section class="certificate-title">
                <section class="certificate-title-content">
                    <h1>Consultar certificado: {$id}</h1>
                </section><!--.certificate-title-content-->

            </section><!--.certificate-title-->

            <section class="certificate-content">

                <section class="certificate-content-header">
                    <figure><img src="{$url_site}lms/common/site/images/logo-cursosiag.png"></figure>
                    {if $certificado.id}
                    <h1>Certificado de Conclusão de Curso</h1>
                    {else}
                    <h1>Esse certificado não consta em nossa base</h1>
                    {/if}

                </section><!--.certificate-content-header-->
                {if $certificado.id}
                <section class="certificate-info">

                    <h2>Certificamos que <strong>{$aluno.nome}</strong></h2>

                    <h2>Concluiu o <strong>{$curso.curso}</strong> em <strong>{$certificado.data_solicitacao|date_format:"%d/%m/%Y"}</strong> <!--com carga horária de <strong>40</strong> Horas Aula.--></h2>

                    <section class="certificate-auth">
                            
                        <h2>Autentificação do documento <strong>CIAG{$certificado.id}</strong></h2>
                            
                        <h2>Número de matrícula <strong>{$aluno.id}</strong></h2>

                    </section><!--.certificate-auth-->

                    <section class="certificate-signature">

                        <cite>Maceió, {$data}</cite>

                        <cite class="signature">Adriano Gianini Soares - Diretor</cite>

                    </section><!--.certificate-signature-->

                </section><!--.certificate-info-->
                {/if}

            </section><!--.certificate-content-->
        
        </section>
    