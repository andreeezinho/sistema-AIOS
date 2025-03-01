<?php
    require_once __DIR__ . '/../layout/top.php';
?>

<div class="container">
    <div class="row">
        <div class="text-muted border-bottom d-flex">
            <p class="m-0 p-0 me-3 mb-2">
                <img src="<?= URL_SITE ?>/public/img/user/icons/<?= $_SESSION['user']->icone ?>" alt="Icone" class="user-icone rounded-circle me-2">
                Olá, <?= explode(' ', trim($user->nome))[0] ?>
            </p>
        </div>
    </div>

    <div class="row mt-3 g-3">
        <h3>Dashboard</h3>

        <div class="col-6 col-md-4 col-lg-3">
            <a href='/usuarios' class="card bg-primary text-light text-decoration-none">
                <div class="card-body py-3">
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
            <a href='#' class="card bg-primary text-light text-decoration-none">
                <div class="card-body py-3">
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
            <a href='#' class="card bg-success text-light text-decoration-none">
                <div class="card-body py-3">
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

        <div class="col-6 col-md-4 col-lg-3">
            <a href='#' class="card bg-success text-light text-decoration-none">
                <div class="card-body py-3">
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
            <a href='#' class="card bg-warning text-light text-decoration-none">
                <div class="card-body py-3">
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

    </div>
</div>

<?php
    require_once __DIR__ . '/../layout/bottom.php';
?>