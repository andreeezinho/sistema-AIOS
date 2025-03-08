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

        .services-container{
            min-height: 550px;
        }
    </style>
</head>
<body class="bg-theme">

    <div class="container">
        <div class="col-12">
            <p style="font-size: 30px;margin-bottom:20px"
                <img src="data:image/png;base64,<?=base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/public/img/site/logo-pdf.jpg'))?>" width="100" style="margin-right:80px;">
                Orçamento
            </p>
        </div>

        
        <table>
            <tr>
                <td width="300px" height="25px" class="colunas"><b>Data:</b> <?= date('d/m/Y - h:i', strtotime($os->created_at)) ?></td>
            </tr>

            <tr>
                <td width="350px" height="50px" class="colunas"><b>Cliente:</b> <?= $nome_cliente ?></td>
                <td width="200px" height="50px" class="colunas"><b>Doc.:</b> <?= $doc_cliente ?></td>
            </tr>
            
            <tr>
                <td width="300px" height="25px" class="colunas"><b>Dispositivo:</b> <?= $os->dispositivo ?></td>
            </tr>
        </table>

        <div class="col-12 text-center">
            <p style='font-size: 20px; margin: 30px 0 30px 0'>Serviços</p>
        </div>

        <div class="services-container bg-services">
            <table class="" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <td width="400px" height="60px" class="colunas borda borda-linha"><b style="font-size: 18px">Serviço</b></td>
                        <td width="117px" height="60px" class="colunas borda-linha"><b style="font-size: 18px">Preço</b></td>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if(count($servicos) > 0){
                        foreach($servicos as $servico){
                ?>
                    <tr>
                        <td width="400px" height="50px" class="colunas borda "><?= $servico->nome ?></td>
                        <td width="117px" height="50px" class="colunas ">R$ <?= number_format($servico->preco,2,",",".") ?></td>
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

        <div class="col-12 pt-3">
            <div class="float-start">
                <p style="font-size: 16px" class="my-1"><b>PIX:</b> 103.171.015-95</p>
                <p style="font-size: 16px" class="my-1"><b>Contato:</b> (75) 99116-4106</p>
            </div>

            <div class="float-end">
                <p style="font-size: 18px" class="my-1"><b>Desconto:</b> <?= $os->desconto ?>%</p>
                <p style="font-size: 18px" class="my-1"><b>Total:</b> R$: <?= number_format($os->total,2,",",".") ?></p>
            </div>
        </div>

    </div>
</body>
</html>