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
                    <a href="/vendas" class="text-decoration-none text-muted">Vendas</a>
                </li>

                <li class="breadcrumb-item text-muted">Iniciar Venda</li>

                <li class="breadcrumb-item">Produtos</li>
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

    <div class="col-12 gx-3 my-3 border-bottom pt-3">
        <form action="" method="GET" class="row">
            <label for="nome_codigo"><i class="bi-search"></i> Nome ou Código</label>
            <div class="form-group col-12 col-md-10">
                <input type="text" name="nome_codigo" id="nome_codigo" class="form-control mt-2" placeholder="Insira o nome ou o código do produto">
            </div>
            <button class="btn btn-primary mx-auto mx-md-0 my-2 col-4 col-md-2"><i class="bi-search"></i> Pesquisar</button>
        </form>

        <table class="table table-striped mt-2">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Código</th>
                    <th>Quant.</th>
                    <th></th>
                </tr>
            </thead>
            
            <?php
                if(isset($params['nome_codigo'])){
                    if(count($produtos) > 0){
                        foreach($produtos as $produto){
            ?>
                <form action="/vendas/<?= $venda->uuid ?>/protudos/<?= $produto->uuid ?>" method="POST" class="d-flex">
                    <tr>
                        <th><?= $produto->nome ?></th>
                        <th><?= $produto->codigo ?></th>
                        <th><?= $produto->estoque ?></th>
                        <th>
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
                }else{
            ?>
                <p class="text-muted my-2">Pesquise um protudo</p>
            <?php
                }
            ?>
        </table>
        <a href="/vendas/<?= $venda->uuid ?>/produtos" class="btn btn-secondary">Limpar</a>
    </div>

    <div class="row my-3 border-bottom py-5">
        <h3 class="my-3"><i class="bi-cart-fill"></i> Produtos</h3>
        
    </div>

    <div class="row my-3 border-bottom py-5">
        <h3 class="my-3"><i class="bi-person-vcard-fill"></i> Seus dados</h3>

        <form action="/perfil/editar" method="POST" enctype="multipart/form-data">
            <?php
                require_once __DIR__ . '/../form.php';
            ?>
            <div class="form-group text-center mt-3">
                <button type="submit" class="btn btn-primary mx-1">Atualizar</button>
            </div>
        </form>
    </div>

    <div class="row my-3 border-bottom py-5">
        <h3 class="my-3"><i class="bi-person-fill-lock"></i> Nova senha</h3>

        <form action="/perfil/senha" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="senha">Insira uma nova senha</label>
                <input type="password" name="senha" id="senha" class="form-control" placeholder="Digite sua nova senha">
            </div>

            <div class="form-group text-center mt-3">
                <button type="submit" class="btn btn-primary mx-1">Atualizar</button>
            </div>
        </form>
    </div>

    <div class="row my-3 border-bottom mt-5 pt-0 px-1">
        <div class="col-12 alert alert-danger">
            <h3 class="my-3 text-danger"><i class="bi-person-fill-slash"></i> Deletar conta</h3>
            <div class="col-12 form-group text-center mt-3">
                <button type="submit" class="btn btn-danger mx-1" data-toggle="modal" data-target="#deletar"><i class="bi-trash-fill"></i> Deletar</button>

                <div class="modal fade" id="deletar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content text-dark">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle"><i class="bi-person-fill-slash"></i> Deletar conta?</h5>
                            </div>

                            <div class="modal-body">
                                <p class="my-auto">Deseja <b>deletar</b> sua conta?</p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <form action="perfil/deletar" method="POST">
                                    <button type="submit" class="btn btn-danger">Deletar</button>
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