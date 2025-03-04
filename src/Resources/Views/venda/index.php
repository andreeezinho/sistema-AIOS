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
                    <a href="/vendas" class="text-decoration-none text-muted">Vendas</a>
                </li>
            </ol>
        </div>

        <div class="col-4 col-xl-6">
            <div class="float-end">
                <a href="/vendas/cadastro" class="btn btn-outline-dark" > <i class="bi-handbag-fill"></i> + </a>
            </div>
        </div>
    </div>

    <!-- filtros -->
    <div class="col-12">
        <button type="button" class="btn btn-light border p-3 me-2" data-toggle="modal" data-target="#filtro-modal">
            <i class="bi-search"></i>
            Filtrar Vendas
        </button>

        <a href="/vendas" class="btn btn-secondary">Limpar</a>
    </div>

    <div class="modal fade" id="filtro-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="/vendas" method="GET" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Filtrar venda</h5>
                </div>

                <div class="modal-body">
                    <p class="mt-2 text-muted">Insira as informações para filtrar</p>

                    <div class="col-12 form-group my-2">
                        <label for="cliente">Nome ou DOC</label>
                        <input type="text" id="cliente" name="cliente" class="form-control py-2" placeholder="Insira o nome ou DOC do cliente">
                    </div>

                    <div class="col-12 form-group my-2">
                        <label for="usuario">Vendedor</label>
                        <input type="text" id="usuario" name="usuario" class="form-control py-2" placeholder="Insira o nome ou CPF do vendedor">
                    </div>

                    <div class="col-12 form-group my-2">
                        <label for="data">Data de venda</label>
                        <input type="date" id="data" name="data" class="form-control py-2">
                    </div>


                    <div class="col-12 form-group my-2">
                        <label for="situacao">Situação</label>
                        <select name="situacao" id="situacao" class="form-select">
                            <option value="" selected>Selecione situação</option>
                            <option value="cancelada">Cancelada</option>
                            <option value="em andamento">Em Andamento</option>
                            <option value="concluida">Concluída</option>
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
            if(count($vendas) > 0){
                foreach($vendas as $venda){
        ?>

            <div class="col-12 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-body py-3">
                        <p class="mt-3 text-muted"><i class="bi-person-fill"></i> Cliente: <?= $venda->cliente ?></p>
                        <p class="mt-3 text-muted"><i class="bi-currency-dollar"></i> Preço: R$<?= number_format($venda->total ?? 0,2,",",".") ?></p>
                        <p class="mt-3 text-muted">
                            <?php
                                if($venda->situacao == 'cancelada'){
                            ?>
                                <i class="bi-circle-fill small text-danger"></i> 
                            <?php
                                }
                            ?>

                            <?php
                                if($venda->situacao == 'em andamento'){
                            ?>
                                <i class="bi-circle-fill small text-warning"></i> 
                            <?php
                                }
                            ?>

                            <?php
                                if($venda->situacao == 'concluida'){
                            ?>
                                <i class="bi-circle-fill small text-success"></i> 
                            <?php
                                }
                            ?>
                            <?= $venda->situacao ?>
                        </p>

                        <div class="d-flex mt-3 pt-2 border-top justify-content-center">
                            <a href="/vendas/<?= $venda->uuid ?>/produtos" class="btn btn-dark mx-2"><i class="bi-eye-fill"></i></a>
                            <a href="/vendas/<?= $venda->uuid ?>/produtos" class="btn btn-primary mx-2"><i class="bi-file-text-fill"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        
        <?php
                }
            }else{
        ?>

        <p class="mt-3 text-muted">Vendas não encontradas...</p>

        <?php
            }
        ?>
    </div>

</div>

<?php
    require_once __DIR__ . '/../layout/bottom.php';
?>