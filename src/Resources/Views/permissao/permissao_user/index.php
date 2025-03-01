<?php
    require_once __DIR__ . '/../../layout/top.php';
?>

<div class="container">
    <div class="row gx-3 mb-2 border-bottom pb-1">
        <div class="col-12 col-md-6">
            <ol class="breadcrumb mb-3">
                <li class="breadcrumb-item">
                    <i class="icon-house_siding lh-1"></i>
                    <a href="/dashboard" class="text-decoration-none text-muted"><i class="bi-house"></i> Home</a>
                </li>

                <li class="breadcrumb-item">
                    <i class="icon-house_siding lh-1"></i>
                    <a href="/usuarios" class="text-decoration-none text-muted">Usuários</a>
                </li>

                <li class="breadcrumb-item">
                    <i class="icon-house_siding lh-1"></i>
                    <span class="text-decoration-none text-muted">Permissões</span>
                </li>
            </ol>
        </div>

        <div class="col-12 col-md-6">
            <div class="float-md-end">
                <button type="submit" class="btn btn-outline-dark" data-toggle="modal" data-target="#vincular"><i class="bi-link-45deg"></i> Vincular Permissão + </button>
            </div>

            <div class="modal fade" id="vincular" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <form action='/usuarios/<?= $usuario->uuid ?>/vincular' method="POST" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Vincular permissão</h5>
                        </div>

                        <div class="modal-body">
                            <p class="my-2">Permissões</p>
                            <select name="permissao" id="permissao" class="form-select">
                                <option value="" selected>Escolha uma permissão</option>
                                <?php
                                    if(count($permissoes) > 0){
                                        foreach($permissoes as $permissao){
                                ?>
                                    <option value="<?= $permissao->uuid ?>"><?= $permissao->nome ?></option>
                                <?php
                                        }
                                    }else{
                                ?>
                                    <option value="" selected>Não há permissões</option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary"><i class="bi-link-45deg"></i> Vincular</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3 g-3 pb-4">
        <h3 class="my-3">Permissões do usuário</h3>
        <?php
            if(count($permissao_user) > 0){
                foreach($permissao_user as $permissao){
        ?>

            <div class="col-12 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-body py-3">                        
                        <p class="mt-3 text-muted"><i class="bi-sliders"></i> <?= $permissao->nome ?></p>

                        <div class="d-flex mt-3 pt-2 border-top justify-content-center">
                            <button type="button" class="btn btn-danger mx-2" data-toggle="modal" data-target="#permissao-<?= $permissao->uuid ?>">
                                <i class="bi-trash-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="permissao-<?= $permissao->uuid ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Deletar permissão?</h5>
                        </div>

                        <div class="modal-body">
                            <p class="my-auto">Deseja desvincular <b><?= $permissao->nome ?></b> do usuário?</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <form action="/usuarios/<?= $usuario->uuid ?>/desvincular/<?= $permissao->uuid ?>" method="POST">
                                <button type="submit" class="btn btn-danger">Desvincular</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        
        <?php
                }
            }else{
        ?>

        <p class="mt-3 text-muted">Usuário não tem permissões vinculadas...</p>

        <?php
            }
        ?>
    </div>

</div>

<?php
    require_once __DIR__ . '/../../layout/bottom.php';
?>