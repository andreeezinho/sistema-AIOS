<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= URL_SITE ?>/public/img/site/site-icone.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= URL_SITE ?>/public/css/style.css">
    <title>Ordem de Serviço</title>

    <style>
        .bg-services{
            background-color: #EBEBEB;
        }

        .colunas{
            padding-left: 10px;
        }

        .borda{
            border-right: 1px solid #313131;
        }

        .borda-linha{
            border-bottom: 1px solid #313131;
        }
    </style>
</head>
<body class="bg-theme">

    <div class="container">
        <div class="col-12">
            <h3 style="margin-bottom:20px"
                <img src="data:image/png;base64,<?=base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/public/img/site/logo-pdf.jpg'))?>" width="100" style="margin-right:120px;">
                Orçamento
            </h3>
        </div>

        
        <table>
            <tr>
                <td width="300px" height="50px" class="colunas">Data: <?= date('d/m/Y - h:i', strtotime($os->created_at)) ?></td>
            </tr>
            <tr>
                <td width="300px" height="50px" class="colunas">Cliente: <?= $nome_cliente ?></td>
                <td width="300px" height="50px" class="colunas">Documento: <?= $doc_cliente ?></td>
            </tr>
        </table>
        <div class="">
            <table style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <td width="400px" height="50px" class="colunas borda borda-linha">Serviço</td>
                        <td width="100px" height="50px" class="colunas borda-linha">Preço</td>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if(count($servicos) > 0){
                        foreach($servicos as $servico){
                ?>
                    <tr>
                        <td width="400px" height="50px" class="colunas borda borda-linha"><?= $servico->nome ?></td>
                        <td width="100px" height="50px" class="colunas borda-linha"><?= $servico->preco ?></td>
                    </tr>
                <?php
                        }
                    }else{
                ?>
                    <p>Não há serviços na O.S</p>
                <?php
                    }
                ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>