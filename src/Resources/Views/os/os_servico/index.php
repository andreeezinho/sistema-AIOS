<?php
    require_once __DIR__ . '/../../layout/top.php';
?>

<div class="container pb-5">
    <div class="row gx-3 mb-2 border-bottom pb-1">
        <div class="col-12 col-md-6">
            <ol class="breadcrumb mb-3">
                <li class="breadcrumb-item">
                    <i class="icon-house_siding lh-1"></i>
                    <a href="/dashboard" class="text-decoration-none text-muted"><i class="bi-house"></i> Home</a>
                </li>

                <li class="breadcrumb-item">
                    <i class="icon-house_siding lh-1"></i>
                    <a href="/os" class="text-decoration-none text-muted">O.S</a>
                </li>

                <li class="breadcrumb-item"><i class="bi-clipboard-data-fill"></i></li>
            </ol>
        </div>
    </div>

    <?php
        if(isset($erro)){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p class="m-0 p-0"><?= $erro ?></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
        }
    ?>

    <h3 class="my-3"><i class="bi-tools"></i> Inserir Serviços</h3>

    <form action="/os/<?= $os->uuid ?>/servicos" method="GET" class="row mb-3 pt-3">
        <label for="nome"><i class="bi-search"></i> Nome ou Código</label>
        <div class="form-group col-12 col-md-10 ps-md-0">
            <input type="text" name="nome" id="nome" class="form-control mt-2" placeholder="Insira o nome do serviço">
        </div>
        <button class="btn btn-primary mx-auto mx-md-0 my-2 col-4 col-md-2"><i class="bi-search"></i> Pesquisar</button>
    </form>

    <div class="row border-bottom pt-3">
        <table class="table table-striped mt-2 col-11 col-sm-12">
            <?php
                if(isset($params['nome'])){   
            ?>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="d-none d-sm-table-cell">Descrição</th>
                        <th>R$</th>
                        <th></th>
                    </tr>
                </thead>
            <?php
                    if(count($servicos) > 0){
                        foreach($servicos as $servico){
            ?>
                <form action="/os/<?= $os->uuid ?>/servicos/<?= $servico->uuid ?>" method="POST" class="d-flex">
                    <tr>
                        <th><?= $servico->nome ?></th>
                        <th class="d-none d-sm-table-cell"><?= $servico->descricao ?></th>
                        <th><?= number_format($servico->preco,2,",",".") ?></th>
                        <th class="text-center">
                            <button type="submit" class="btn btn-primary"><i class="bi-cart-plus-fill"></i></button>
                        </th>
                    </tr>
                </form>
            <?php
                        }
                    }else{
            ?>
                <p class="text-muted my-2">Serviço não encontrado...</p>
            <?php
                    }
                }
            ?>
        </table>
        <?php
            if(isset($params['nome'])){
        ?>  
            <a href="/os/<?= $os->uuid ?>/servicos" class="btn btn-secondary col-4 col-sm-1 mb-3">Limpar</a>
        <?php
            }
        ?>
    </div>

    <div class="row mb-3 border-bottom py-3 justify-content-center">
        <h3 class="mb-3"><i class="bi-clipboard-data-fill"></i> Dados da O.S</h3>

        <form action="/os/<?= $os->uuid ?>/editar" method="POST" class="row col-11 col-sm-8 col-md-8 col-lg-6 mt-3">
            <div class="col-12 form-group my-2">
                <span><i class="bi-calendar-fill"></i> Data</span>
                <span class="form-control bg-theme px-0"><?= date('d/m/Y - H:i', strtotime($os->created_at)) ?></span>
            </div>

            <div class="col-12 col-md-6 form-group my-2 border-end">
                <span><i class="bi-person-fill"></i> Cliente</span>
                <span class="form-control bg-theme px-0"><?= $cliente->nome ?></span>
            </div>
            
            <div class="col-12 col-md-6 form-group my-2">
                <span><i class="bi-person-vcard-fill"></i> Reponsável</span>
                <span class="form-control bg-theme px-0"><?= $usuario->nome ?></span>
            </div>
            <?php
                require_once __DIR__ . '/../form.php';
            ?>
            <div class="form-group text-center mt-3">
                <button type="submit" class="btn btn-primary mx-1">Atualizar</button>
            </div>
        </form>
    </div>

    <div class="row mb-3 border-bottom py-5 table-responsive">
        <h3 class="my-3"><i class="bi-ui-checks"></i> Serviços da O.S</h3>
        
        <table class="table table-striped mt-2">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th class="d-none d-sm-table-cell">Descrição</th>
                    <th>R$</th>
                    <th></th>
                </tr>
            </thead>
            
            <?php
                if(count($osServicos) > 0){
                    foreach($osServicos as $servico){
            ?>
                <form action="/os/<?= $os->uuid ?>/servicos/<?= $servico->uuidServico ?>/deletar/<?= $servico->uuid?>" method="POST" class="d-flex">
                    <tr>
                        <th><?= $servico->nome ?></th>
                        <th class="d-none d-sm-table-cell"><?= $servico->descricao ?></th>
                        <th><?= number_format($servico->preco,2,",",".") ?></th>
                        <th class="text-center">
                            <button type="submit" class="btn btn-danger"><i class="bi-cart-x-fill"></i></button>
                        </th>
                    </tr>
                </form>
            <?php
                        }
                    }else{
            ?>
                <p class="text-muted my-2">Ainda não há serviços na O.S...</p>
            <?php
                }
            ?>

        </table>
    </div>

    <div class="row my-3 border-bottom mt-5 pt-0">
        <div class="col-11 col-sm-12">
            <div class="col-12 form-group text-center mt-3">
                <div class="d-flex float-start">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancelar"><i class="bi-x-circle-fill"></i> Cancelar</button>
                    <a href="/os/<?= $os->uuid ?>/gerar" class="btn btn-secondary mx-2">Ver Orçamento <i class="bi-file-text-fill"></i></a>
                </div>

                <div class="d-flex float-start float-md-end">
                    <h5 class="p-0 m-0 mx-2 my-auto">Valor Total: <b>R$ <?= number_format($total,2,",",".") ?></b></h5>
                    <button type="button" class="btn btn-primary mx-1" data-toggle="modal" data-target="#finalizar"><i class="bi-clipboard2-check-fill"></i> Finalizar</button>
                </div>

                <div class="modal fade" id="finalizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content text-dark">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle"><i class="bi-cart-check-fill"></i> Finalizar O.S?</h5>
                            </div>

                            <div class="modal-body">
                                <p class="my-auto">Deseja finalizar a O.S no valor de <b>R$ <?= number_format($total,2,",",".") ?></b>?</p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <form action="/os/<?= $os->uuid ?>/finalizar" method="POST">
                                    <button type="submit" class="btn btn-primary"><i class="bi-check"></i> Finalizar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="cancelar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content text-dark">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle"><i class="bi-clipboard-x-fill"></i> Cancelar O.S?</h5>
                            </div>

                            <div class="modal-body">
                                <p class="my-auto">Deseja cancelar a O.S no valor de <b>R$ <?= number_format($total,2,",",".") ?></b>?</p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <form action="/os/<?= $os->uuid ?>/cancelar" method="POST">
                                    <button type="submit" class="btn btn-danger"><i class="bi-clipboard-x-fill"></i> Cancelar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    require_once __DIR__ . '/../../layout/bottom.php';
?>