<?php
    if(isset($cadastro)){
?>
    <div class="col-12 form-group my-2">
        <label for="cliente">Cliente</label>
        <select name="cliente" id="cliente" class="form-select">
            <option value="" <?= (isset($venda) && $venda->cliente == "") ? 'selected' : "" ?> >Selecione o cliente</option>
            <?php
                foreach($clientes as $cliente){
            ?>
                <option value="<?= $cliente->uuid ?>" <?= (isset($venda) && $venda->cliente == $venda->cliente) ? 'selected' : "" ?> ><?= $cliente->nome ?></option>
            <?php
                }
            ?>
        </select>
    </div>
<?php
    }
?>

<div class="col-12 col-md-12 form-group my-2">
    <label for="desconto">Desconto</label>
    <input type="number" name="desconto" id="desconto" class="form-control py-2" max=100 placeholder="Insira o desconto" value="<?= $venda->desconto ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="situacao">Situação</label>
    <select name="situacao" id="situacao" class="form-select">
        <option value="" <?= (isset($venda) && $venda->situacao == "") ? 'selected' : "" ?> >Selecione a situação</option>
        <option value="cancelada" <?= (isset($venda) && $venda->situacao == "cancelada") ? 'selected' : "" ?>>Cancelada</option>
        <option value="em andamento" <?= (isset($venda) && $venda->situacao == "em andamento") ? 'selected' : "" ?>>Em Andamento</option>
        <option value="concluída" <?= (isset($venda) && $venda->situacao == "concluida") ? 'selected' : "" ?>>Concluída</option>
    </select>
</div>


