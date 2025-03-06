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
                    <a href="/os" class="text-decoration-none text-muted">O.S</a>
                </li>
            </ol>
        </div>

        <div class="col-4 col-xl-6">
            <div class="float-end">
                <a href="/os/cadastro" class="btn btn-outline-dark" > <i class="bi-clipboard2-plus-fill"></i> + </a>
            </div>
        </div>
    </div>

    <!-- filtros -->
    <div class="col-12">
        <button type="button" class="btn btn-light border p-3 me-2" data-toggle="modal" data-target="#filtro-modal">
            <i class="bi-search"></i>
            Filtrar O.S
        </button>

        <a href="/os" class="btn btn-secondary">Limpar</a>
    </div>

    <div class="modal fade" id="filtro-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="/os" method="GET" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Filtrar O.S</h5>
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
                        <label for="dispositivo">Dispositivo</label>
                        <input type="text" id="dispositivo" name="dispositivo" class="form-control py-2" placeholder="Insira o dispositivo">
                    </div>

                    <div class="col-12 form-group my-2">
                        <label for="data">Data da O.S</label>
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
            if(count($all_os) > 0){
                foreach($all_os as $os){
        ?>

            <div class="col-12 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-body py-3">
                        <p class="mt-3 text-muted"><i class="bi-calendar-fill"></i> <?= date('d/m/Y - H:i', strtotime($os->created_at)) ?></p>
                        <p class="mt-3 text-muted"><i class="bi-person-fill"></i> Cliente: <?= $os->cliente ?></p>
                        <p class="mt-3 text-muted"><i class="bi-pc-display"></i> Dispositivo: <?= $os->dispositivo ?></p>
                        <p class="mt-3 text-muted">
                            <?php
                                if($os->situacao == 'cancelada'){
                            ?>
                                <i class="bi-circle-fill small text-danger"></i> 
                            <?php
                                }
                            ?>

                            <?php
                                if($os->situacao == 'em andamento'){
                            ?>
                                <i class="bi-circle-fill small text-warning"></i> 
                            <?php
                                }
                            ?>

                            <?php
                                if($os->situacao == 'concluida'){
                            ?>
                                <i class="bi-circle-fill small text-success"></i> 
                            <?php
                                }
                            ?>
                            <?= $os->situacao ?>
                        </p>

                        <div class="d-flex mt-3 pt-2 border-top justify-content-center">
                            <a href="/os/<?= $os->uuid ?>/servicos" class="btn btn-dark mx-2"><i class="bi-eye-fill"></i></a>
                            <a href="/os/<?= $os->uuid ?>/servicos" class="btn btn-primary mx-2"><i class="bi-file-text-fill"></i></a>
                            <button type="button" class="btn btn-danger mx-2" data-toggle="modal" data-target="#cancelar-<?= $os->uuid ?>"><i class="bi-x-circle-fill"></i></button>

                            <div class="modal fade" id="cancelar-<?= $os->uuid ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content text-dark">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><i class="bi-clipboard-x-fill"></i> Cancelar O.S?</h5>
                                        </div>

                                        <div class="modal-body">
                                            <p class="my-auto">Deseja cancelar a O.S no valor de <b>R$ <?= number_format($os->total,2,",",".") ?></b>?</p>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <form action="/vendas/<?= $os->uuid ?>/cancelar" method="POST">
                                                <button type="submit" class="btn btn-danger"><i class="bi-clipboard-x-fill"></i> Cancelar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        <?php
                }
            }else{
        ?>

        <p class="mt-3 text-muted">O.S não encontradas...</p>

        <?php
            }
        ?>
    </div>

</div>

<?php
    require_once __DIR__ . '/../layout/bottom.php';
?>