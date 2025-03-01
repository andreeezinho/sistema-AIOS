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
                    <a href="/perfil" class="text-decoration-none text-muted">Seu perfil</a>
                </li>
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

    <h3 class="my-3"><i class="bi-person-lines-fill"></i> Seu perfil</h3>

    <div class="row gx-3 my-3 border-bottom pt-3">
        <form action="/perfil/icone" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="icone" class="text-muted small d-flex flex-column text-center">
                    <div class="d-flex position-relative mx-auto mb-2">
                        <img src="<?= URL_SITE ?>/public/img/user/icons/<?= ($usuario->icone == "default.png" || $usuario->icone == "") ? "default.png" : $usuario->icone ?>" alt="Icone de usuario" id="preview" class="bg-secondary cadastro-icone rounded-circle mx-auto hover-border">
                        <span class="position-absolute bottom-0 end-0"><i class="bi-camera-fill rounded-circle bg-light p-1"></i></span>
                    </div>
                    Insira uma foto de perfil
                </label>

                <input type="file" name="icone" id="icone" class="d-none">
            </div>

            <div class="form-group text-center my-3">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </form>
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