<?php
    require_once __DIR__ . '/../layout/top.php';
?>

    <div class="container pb-5">
        <div class="row gx-3 mb-5 border-bottom">
            <div class="col-12">
                <ol class="breadcrumb mb-3">
                    <li class="breadcrumb-item">
                        <i class="icon-house_siding lh-1"></i>
                        <a href="/dashboard" class="text-decoration-none text-muted"><i class="bi-house"></i> Home</a>
                    </li>

                    <li class="breadcrumb-item">
                        <i class="lh-1"></i>
                        <a href="/os" class="text-decoration-none text-muted">O.S</a>
                    </li>

                    <li class="breadcrumb-item">Iniciar O.S</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <form action="/os/cadastro" method="POST" class="card col-11 col-sm-4 py-2 mt-md-5">
                <?php
                    if(isset($erro)){
                ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <p class="m-0 p-0"><?= $erro ?></p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                    }
                ?>
                <div class="row">
                    <h3 class="text-center my-2"><i class="bi-clipboard-data-fill"></i> Iniciar O.S</h3>
                    <?php 
                        include_once('form.php');
                    ?>
                    <div class="form-group text-center">
                        <a href="/os" class="btn btn-secondary mx-1">Cancelar</a>
                        <button type="submit" class="btn btn-primary mx-1">Confirmar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php
    require_once __DIR__ . '/../layout/bottom.php';
?>