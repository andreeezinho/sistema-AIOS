<?php
    require_once __DIR__ . '/../layout/top.php';
?>

<div class="container">
    <div class="row gx-3 mb-2">
        <div class="col-8 col-xl-6">
            <ol class="breadcrumb mb-3">
                <li class="breadcrumb-item">
                    <i class="icon-house_siding lh-1"></i>
                    <a href="/dashboard" class="text-decoration-none text-muted"><i class="bi-house"></i> Home</a>
                </li>

                <li class="breadcrumb-item">
                    <i class="icon-house_siding lh-1"></i>
                    <a href="/clientes" class="text-decoration-none text-muted">Clientes</a>
                </li>
            </ol>
        </div>

        <div class="col-4 col-xl-6">
            <div class="float-end">
                <a href="/clientes/cadastro" class="btn btn-outline-dark" > + </a>
            </div>
        </div>
    </div>

    <!-- filtros -->
    <div class="col-12">
        <button type="button" class="btn btn-light border p-3 me-2" data-toggle="modal" data-target="#filtro-modal">
            <i class="bi-people-fill"></i>
            Filtrar clientes
        </button>

        <a href="/clientes" class="btn btn-secondary">Limpar</a>
    </div>

    <div class="modal fade" id="filtro-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="/clientes" method="GET" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Filtrar clientes</h5>
                </div>

                <div class="modal-body">
                    <p class="mt-2 text-muted">Insira as informações para filtrar</p>

                    <div class="col-12 form-group my-2">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" class="form-control py-2" placeholder="Insira o nome">
                    </div>

                    <div class="col-12 form-group my-2">
                        <label for="cpf">CPF</label>
                        <input type="text" id="cpf" name="cpf" class="form-control py-2" placeholder="Insira o CPF">
                    </div>

                    <div class="col-12 form-group my-2">
                        <label for="ativo">Situação</label>
                        <select name="ativo" id="ativo" class="form-select">
                            <option value="" selected>Selecione situação</option>
                            <option value="1">Ativo</option>
                            <option value="0">Inativo</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi-search"></i> Pesquisar</button>
                </div>
            </form>
        </div>
    </div>

    <!--  -->


    <div class="row mt-3 g-3 pb-4">
        <?php
            if(count($clientes) > 0){
                foreach($clientes as $cliente){
        ?>

            <div class="col-12 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-body py-3">
                        <p class="mt-3 text-muted"><i class="bi-person-fill"></i> <?= $cliente->nome ?></p>

                        <p class="mt-3 text-muted"><i class="bi-wallet-fill"></i> DOC: <?= $cliente->documento ?></p>
                        <p class="mt-3 text-muted"><i class="bi-envelope-fill"></i> Email: <?= $cliente->email ?></p>
                        <p class="mt-3 text-muted">
                            <i class="bi-circle-fill small <?= ($cliente->ativo == 1) ? 'text-success' : 'text-danger' ?>"></i>  
                            <?= ($cliente->ativo == 1) ? 'Ativo' : 'Inativo' ?>
                        </p>

                        <div class="d-flex mt-3 pt-2 border-top justify-content-center">
                            <a href="/clientes/<?= $cliente->uuid ?>/editar" class="btn btn-primary mx-2"><i class="bi-pencil-fill"></i></a>
                            <a href="/clientes/<?= $cliente->uuid ?>/informacoes" class="btn btn-secondary mx-2"><i class="bi-eye-fill"></i></a>
                            <button type="button" class="btn btn-danger mx-2" data-toggle="modal" data-target="#cliente-<?= $cliente->uuid ?>">
                                <i class="bi-trash-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="cliente-<?= $cliente->uuid ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Deletar cliente?</h5>
                        </div>

                        <div class="modal-body">
                            <p class="my-auto">Deseja inativar o cliente <b><?= explode(' ', trim($cliente->nome))[0] ?></b>?</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <form action="/clientes/<?= $cliente->uuid ?>/deletar" method="POST">
                                <button type="submit" class="btn btn-danger">Excluir</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        
        <?php
                }
            }else{
        ?>

        <p class="mt-3 text-muted">Clientes não encontrados...</p>

        <?php
            }
        ?>
    </div>

</div>

<?php
    require_once __DIR__ . '/../layout/bottom.php';
?>