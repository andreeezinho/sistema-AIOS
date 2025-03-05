<?php
    if(isset($cadastro)){
?>
    <div class="col-12 form-group my-2">
        <label for="cliente">Cliente</label>
        <select name="cliente" id="cliente" class="form-select">
            <option value="" <?= (isset($os) && $os->cliente == "") ? 'selected' : "" ?> >Selecione o cliente</option>
            <?php
                foreach($clientes as $cliente){
            ?>
                <option value="<?= $cliente->uuid ?>" <?= (isset($os) && $os->cliente == $os->cliente) ? 'selected' : "" ?> ><?= $cliente->nome ?></option>
            <?php
                }
            ?>
        </select>
    </div>
<?php
    }
?>

<div class="col-12 col-md-12 form-group my-2">
    <label for="dispositivo">Dispositivo</label>
    <input type="text" name="dispositivo" id="dispositivo" class="form-control py-2" max=100 placeholder="Insira o dispositivo" value="<?= $os->dispositivo ?? '' ?>">
</div>

<div class="col-12 col-md-12 form-group my-2">
    <label for="desconto">Desconto</label>
    <input type="number" name="desconto" id="desconto" class="form-control py-2" max=100 placeholder="Insira o desconto" value="<?= $os->desconto ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="situacao">Situação</label>
    <select name="situacao" id="situacao" class="form-select">
        <option value="" <?= (isset($os) && $os->situacao == "") ? 'selected' : "" ?> >Selecione a situação</option>
        <option value="cancelada" <?= (isset($os) && $os->situacao == "cancelada") ? 'selected' : "" ?>>Cancelada</option>
        <option value="em andamento" <?= (isset($os) && $os->situacao == "em andamento") ? 'selected' : "" ?>>Em Andamento</option>
        <option value="concluída" <?= (isset($os) && $os->situacao == "concluida") ? 'selected' : "" ?>>Concluída</option>
    </select>
</div>


