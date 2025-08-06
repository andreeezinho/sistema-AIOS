<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= URL_SITE ?>/public/img/site/site-icone.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= URL_SITE ?>/public/css/style.css">
    <title>Venda</title>

    <style>
        *{
            margin: 0;
        }

        .bg-services{
            background-color: #EBEBEB;
        }

        .colunas{
            padding-left: 10px;
        }

        .borda{
            border-right: 3px solid #313131;
        }

        .borda-linha{
            border-bottom: 1px solid #313131;
        }

        .borda-linha-titulo{
            border-bottom: 3px solid #313131;
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
                <img src="data:image/png;base64,<?=base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/public/img/site/logo-pdf.jpg'))?>" width="100" style="margin-right:130px;">
                Ordem de Venda
            </p>
        </div>

        
        <table>
            <tr>
                <td width="500px" height="50px" class="colunas"><b>Cliente:</b> <?= $nome_cliente ?></td>
                <td width="500px" height="50px" class="colunas"><b>Doc.:</b> <?= $doc_cliente ?></td>
            </tr>

            <tr>
                <td width="500px" height="25px" class="colunas"><b>Data:</b> <?= date('d/m/Y - h:i', strtotime($venda->updated_at)) ?></td>
            </tr>
        </table>

        <div class="col-12">
            <p style='font-size: 20px; margin: 30px 0 20px 0' class="text-center">Produtos</p>
        </div>

        <div class="services-container bg-services">
            <table class="" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <td width="451px" height="60px" class="colunas borda borda-linha-titulo"><b style="font-size: 18px">Produto</b></td>
                        <td width="115px" height="60px" class="colunas borda borda-linha-titulo"><b style="font-size: 18px">Quant.</b></td>
                        <td width="115px" height="60px" class="colunas borda-linha-titulo"><b style="font-size: 18px">Preço</b></td>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if(count($produtos) > 0){
                        foreach($produtos as $produto){
                ?>
                    <tr>
                        <td width="451px" height="50px" class="colunas borda borda-linha"><?= $produto->nome ?></td>
                        <td width="115px" height="50px" class="colunas borda borda-linha"><?= $produto->quantidade ?></td>
                        <td width="115px" height="50px" class="colunas borda-linha">R$ <?= number_format($produto->preco,2,",",".") ?></td>
                    </tr>
                <?php
                        }
                    }else{
                ?>
                    <tr>
                        <td width="400px" height="50px" class="colunas">Não há produtos na venda</td>
                        <td width="117px" height="50px" class="colunas"></td>
                    </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
        </div>

        <div class="col-12 pt-3">
            <div class="float-start">
                <?php
                    if(!is_null($qr_code)){
                ?>
                    <img src="data:image/png;base64,<?= $qr_code ?>" width="100" style="">
                <?php
                    }
                ?>
            </div>

            <div class="float-end">
                <p style="font-size: 18px" class="my-1"><b>Desconto:</b> <?= $venda->desconto ?>%</p>
                <p style="font-size: 18px" class="my-1"><b>Total:</b> R$: <?= number_format($venda->total,2,",",".") ?></p>
            </div>
            
            <p style="word-wrap: break-word; white-space: normal; width: 100%; font-size: 14px;" class="my-1"><?= $code ?></p>
        </div>

    </div>
</body>
</html>