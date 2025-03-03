<?php
    require_once __DIR__ . '/../layout/top.php';
?>

<div class="container">
    <div class="row">
        <div class="text-muted border-bottom border-secondary pb-sm-3">
            <img src="<?= URL_SITE ?>/public/img/user/icons/<?= $_SESSION['user']->icone ?>" alt="Icone" class="user-icone rounded-circle me-2">
            Olá, <?= explode(' ', trim($user->nome))[0] ?>

            <div class="float-sm-end mx-auto mt-2 mx-sm-0 mt-sm-0 d-flex">
                <p class="p-0">Seus feitos |</p>
                <p class="mx-2 p-0"><i class="bi-clipboard2-data-fill"></i> O.S - <b><?= count($servicos) ?></b></p>
                <p class="mx-2 p-0"><i class="bi-handbag-fill"></i> Vendas - <b><?= count($servicos) ?></b></p>
            </div>
        </div>
    </div>

    <div class="row mt-3 g-3">
        <h3>Dashboard</h3>

        <div class="col-6 col-md-4 col-lg-3">
            <a href='/usuarios' class="card bg-dark text-light text-decoration-none">
                <div class="card-body py-3 hover-border">
                    <div class='d-flex'>
                        <h3><i class="bi-person-lines-fill"></i></h3>
                        <p class="my-auto ms-2">Usuários</p>
                    </div>
                    <?php
                        if(isset($usuarios) && count($usuarios) > 0){
                    ?>
                        <h3 class="my-2"><?= count($usuarios) ?> </h3>
                    <?php
                        }else{
                    ?>
                        <p class="my-2">Ainda não há usuarios</p>
                    <?php
                        }
                    ?>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <a href='/clientes' class="card bg-dark text-light text-decoration-none">
                <div class="card-body py-3 hover-border">
                    <div class='d-flex'>
                        <h3><i class="bi-people-fill"></i></h3>
                        <p class="my-auto ms-2">Clientes</p>
                    </div>
                    <?php
                        if(isset($clientes) && count($clientes) > 0){
                    ?>
                        <h3 class="my-2"><?= count($clientes) ?> </h3>
                    <?php
                        }else{
                    ?>
                        <p class="my-2">Ainda não há clientes</p>
                    <?php
                        }
                    ?>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <a href='#' class="card bg-dark text-light text-decoration-none">
                <div class="card-body py-3 hover-border">
                    <div class='d-flex'>
                        <h3><i class="bi-clipboard2-data-fill"></i></h3>
                        <p class="my-auto ms-2">O.S</p>
                    </div>
                    <?php
                        if(isset($os) && count($os) > 0){
                    ?>
                        <h3 class="my-2"><?= count($os) ?> </h3>
                    <?php
                        }else{
                    ?>
                        <p class="my-2">Ainda não há O.S</p>
                    <?php
                        }
                    ?>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <a href='#' class="card bg-dark text-light text-decoration-none">
                <div class="card-body py-3 hover-border">
                    <div class='d-flex'>
                        <h3><i class="bi-handbag-fill"></i></h3>
                        <p class="my-auto ms-2">Vendas</p>
                    </div>
                    <?php
                        if(isset($vendas) && count($vendas) > 0){
                    ?>
                        <h3 class="my-2"><?= count($vendas) ?> </h3>
                    <?php
                        }else{
                    ?>
                        <p class="my-2">Ainda não há vendas</p>
                    <?php
                        }
                    ?>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <a href='/servicos' class="card bg-dark text-light text-decoration-none">
                <div class="card-body py-3 hover-border">
                    <div class='d-flex'>
                        <h3><i class="bi-tools"></i></h3>
                        <p class="my-auto ms-2">Serviços</p>
                    </div>
                    <?php
                        if(isset($servicos) && count($servicos) > 0){
                    ?>
                        <h3 class="my-2"><?= count($servicos) ?> </h3>
                    <?php
                        }else{
                    ?>
                        <p class="my-2">Ainda não há serviços</p>
                    <?php
                        }
                    ?>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <a href='#' class="card bg-dark text-light text-decoration-none">
                <div class="card-body py-3 hover-border">
                    <div class='d-flex'>
                        <h3><i class="bi-box-seam-fill"></i></h3>
                        <p class="my-auto ms-2">Produtos</p>
                    </div>
                    <?php
                        if(isset($produtos) && count($produtos) > 0){
                    ?>
                        <h3 class="my-2"><?= count($produtos) ?> </h3>
                    <?php
                        }else{
                    ?>
                        <p class="my-2">Ainda não há produtos</p>
                    <?php
                        }
                    ?>
                </div>
            </a>
        </div>

    </div>
</div>

<?php
    require_once __DIR__ . '/../layout/bottom.php';
?>