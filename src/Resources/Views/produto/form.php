<div class="col-12 col-md-12 form-group my-2">
    <label for="nome">Nome</label>
    <input type="text" name="nome" id="nome" class="form-control py-2" placeholder="Insira o nome" value="<?= $produto->nome ?? '' ?>">
</div>

<div class="col-12 col-md-12 form-group my-2">
    <label for="codigo">Código</label>
    <input type="text" name="codigo" id="codigo" class="form-control py-2" placeholder="Insira o código" value="<?= $produto->codigo ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="preco">Preço</label>
    <input type="number" name="preco" id="preco" class="form-control py-2" placeholder="Insira o preço" value="<?= $produto->preco ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="estoque">Estoque</label>
    <input type="number" name="estoque" id="estoque" class="form-control py-2" placeholder="Insira o estoque" value="<?= $produto->estoque ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="ativo">Situação</label>
    <select name="ativo" id="ativo" class="form-select">
        <option value="" <?= (isset($produto) && $produto->ativo == "") ? 'selected' : "" ?> >Selecione a situação</option>
        <option value="1" <?= (isset($produto) && $produto->ativo == "1") ? 'selected' : "" ?>>Ativo</option>
        <option value="0" <?= (isset($produto) && $produto->ativo == "0") ? 'selected' : "" ?>>Inativo</option>
    </select>
</div>


