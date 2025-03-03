<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= URL_SITE ?>/public/img/site/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= URL_SITE ?>/public/css/style.css">
    <title><?= SITE_NAME ?></title>
</head>

<body class="bg-theme">

    <div class="container">
      <div class="row g-3 justify-content-center align-items-center vh-100">
            <div class="card col-11 col-sm-4">
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

                <div class="card-body">
                    <form action="/login" method="POST">
                        <div class="my-4 text-center">
                            <img src="<?= URL_SITE ?>/public/img/site/logo-sem-fundo.png" alt="Logo site" class="col-3 mx-auto mb-3 logo-site">
                            <h3 class="my-3">Login</h3>
                        </div>

                        <div class="col-12 form-group my-3">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" class="form-control py-2" placeholder="Insira seu email">
                        </div>

                        <div class="col-12 form-group my-3">
                            <label for="senha">Senha</label>
                            <input type="password" id="senha" name="senha" class="form-control py-2" placeholder="Insira sua senha">
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>