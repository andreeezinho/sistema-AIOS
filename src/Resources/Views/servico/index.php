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
                    <a href="/servicos" class="text-decoration-none text-muted">Serviços</a>
                </li>
            </ol>
        </div>

        <div class="col-4 col-xl-6">
            <div class="float-end">
                <a href="/servicos/cadastro" class="btn btn-outline-dark" > + </a>
            </div>
        </div>
    </div>

    <!-- filtros -->
    <div class="col-12">
        <button type="button" class="btn btn-light border p-3 me-2" data-toggle="modal" data-target="#filtro-modal">
            <i class="bi-search"></i>
            Filtrar serviços
        </button>

        <a href="/servicos" class="btn btn-secondary">Limpar</a>
    </div>

    <div class="modal fade" id="filtro-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="/servicos" method="GET" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Filtrar serviços</h5>
                </div>

                <div class="modal-body">
                    <p class="mt-2 text-muted">Insira as informações para filtrar</p>

                    <div class="col-12 form-group my-2">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" class="form-control py-2" placeholder="Insira o nome">
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
            if(count($servicos) > 0){
                foreach($servicos as $servico){
        ?>

            <div class="col-12 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-body py-3">
                        <p class="mt-3 text-muted"><i class="bi-tools"></i> <?= $servico->nome ?></p>
                        <p class="mt-3 text-muted"><i class="bi-currency-dollar"></i> Preço: <?= number_format($servico->preco,2,",","."); ?></p>
                        <p class="mt-3 text-muted">
                            <i class="bi-circle-fill small <?= ($servico->ativo == 1) ? 'text-success' : 'text-danger' ?>"></i>  
                            <?= ($servico->ativo == 1) ? 'Ativo' : 'Inativo' ?>
                        </p>

                        <div class="d-flex mt-3 pt-2 border-top justify-content-center">
                            <a href="/servicos/<?= $servico->uuid ?>/editar" class="btn btn-primary mx-2"><i class="bi-pencil-fill"></i></a>
                            <a href="/servicos/<?= $servico->uuid ?>/produtos" class="btn btn-secondary mx-2"><i class="bi-tools"></i></a>
                            <button type="button" class="btn btn-danger mx-2" data-toggle="modal" data-target="#servico-<?= $servico->uuid ?>">
                                <i class="bi-trash-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="servico-<?= $servico->uuid ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Deletar servico?</h5>
                        </div>

                        <div class="modal-body">
                            <p class="my-auto">Deseja inativar o servico <b><?= $servico->nome ?></b>?</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <form action="/servicos/<?= $servico->uuid ?>/deletar" method="POST">
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

        <p class="mt-3 text-muted">Serviços não encontrados...</p>

        <?php
            }
        ?>
    </div>

</div>

<?php
    require_once __DIR__ . '/../layout/bottom.php';
?>