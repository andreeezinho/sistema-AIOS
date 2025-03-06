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
                    <a href="/servicos" class="text-decoration-none text-muted">Serviços</a>
                </li>

                <li class="breadcrumb-item"><i class="bi-tools"></i></li>
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

    <h3 class="my-3"><i class="bi-boxes"></i> Inserir Produtos</h3>

    <form action="/servicos/<?= $servico->uuid ?>/produtos" method="GET" class="row mb-3 pt-3">
        <label for="nome_codigo"><i class="bi-search"></i> Nome ou Código</label>
        <div class="form-group col-12 col-md-10 ps-md-0">
            <input type="text" name="nome_codigo" id="nome_codigo" class="form-control mt-2" placeholder="Insira o nome ou o código do produto">
        </div>
        <button class="btn btn-primary mx-auto mx-md-0 my-2 col-4 col-md-2"><i class="bi-search"></i> Pesquisar</button>
    </form>

    <div class="row mb-3 pt-3">
        <table class="table table-striped mt-2 col-11 col-sm-12">
            
            <?php
                if(isset($params['nome_codigo'])){
                    if(count($produtos) > 0){

            ?>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="d-none d-sm-table-cell">Código</th>
                        <th>R$</th>
                        <th class="d-none d-sm-table-cell">Quant.</th>
                        <th></th>
                    </tr>
                </thead>
            <?php
                        foreach($produtos as $produto){
            ?>
                <form action="/servicos/<?= $servico->uuid ?>/produtos/<?= $produto->uuid ?>" method="POST" class="d-flex">
                    <tr>
                        <th><?= $produto->nome ?></th>
                        <th class="d-none d-sm-table-cell"><?= $produto->codigo ?></th>
                        <th><?= number_format($produto->preco,2,",",".") ?></th>
                        <th class="d-none d-sm-table-cell"><?= $produto->estoque ?></th>
                        <th class="text-center">
                            <button type="submit" class="btn btn-primary"><i class="bi-cart-plus-fill"></i></button>
                        </th>
                    </tr>
                </form>
            <?php
                        }
                    }else{
            ?>
                <p class="text-muted my-2">Produto não encontrado...</p>
            <?php
                    }
                }
            ?>
        </table>
        <?php
            if(isset($params['nome_codigo'])){
        ?>
            <a href="/servicos/<?= $servico->uuid ?>/produtos" class="btn btn-secondary col-4 col-sm-1">Limpar</a>
        <?php
            }
        ?>
    </div>

    <div class="row mb-3 border-bottom py-5 table-responsive">
        <h3 class="my-3"><i class="bi-tools"></i> Produtos do Serviço</h3>
        
        <table class="table table-striped mt-2">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th class="d-none d-sm-table-cell">Código</th>
                    <th>R$</th>
                    <th></th>
                </tr>
            </thead>
            
            <?php
                if(count($produtoServicos) > 0){
                    foreach($produtoServicos as $produto){
            ?>
                <form action="/servicos/<?= $servico->uuid ?>/produtos/<?= $produto->uuidProduto ?>/deletar" method="POST" class="d-flex">
                    <tr>
                        <th><?= $produto->nome ?></th>
                        <th class="d-none d-sm-table-cell"><?= $produto->codigo ?></th>
                        <th><?= number_format($produto->preco,2,",",".") ?></th>
                        <th class="text-center">
                            <button type="submit" class="btn btn-danger"><i class="bi-cart-x-fill"></i></button>
                        </th>
                    </tr>
                </form>
            <?php
                        }
                    }else{
            ?>
                <p class="text-muted my-2">Ainda não há produtos no serviço...</p>
            <?php
                }
            ?>

        </table>
    </div>

    <div class="row my-3 border-bottom mt-5 pt-0">
        <div class="col-11 col-sm-12">
            <div class="col-12 form-group text-center mt-3">
                <div class="d-flex float-start float-md-end">
                    <h5 class="p-0 m-0 mx-2 my-auto">Valor Total: <b>R$ <?= number_format($total,2,",",".") ?></b></h5>
                    <button type="submit" class="btn btn-primary mx-1" data-toggle="modal" data-target="#finalizar"><i class="bi-tools"></i> Adicionar</button>
                </div>

                <div class="modal fade" id="finalizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content text-dark">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle"><i class="bi-cart-check-fill"></i> Finalizar o serviço?</h5>
                            </div>

                            <div class="modal-body">
                                <p class="my-auto">Deseja adicionar os produtos no valor total de <b>R$ <?= number_format($total,2,",",".") ?></b>?</p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <form action="/servicos/<?= $servico->uuid ?>/adicionar" method="POST">
                                    <button type="submit" class="btn btn-primary"><i class="bi-check"></i> Confirmar</button>
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