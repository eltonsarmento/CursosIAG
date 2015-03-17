            <form action="/lms/aluno/busca/buscar" method="post" class="right searchbar">

                <select name="tipo">
                    <option value="1">Cursos</option>
                    <option value="2">Dúvidas</option>
                    <option value="3">Assinaturas</option>
                    <option value="5">Certificados</option>
                    <option value="6">Estatísticas</option>
                </select>

                <input type="text" name="palavra" placeholder="Digite sua busca..." />

                <button class="btn btn-primary">Buscar</button>

            </form>