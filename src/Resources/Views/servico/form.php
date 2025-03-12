<div class="col-12 col-md-12 form-group my-2">
    <label for="nome">Nome</label>
    <input type="text" name="nome" id="nome" class="form-control py-2" placeholder="Insira o nome" value="<?= $servico->nome ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="descricao">Descrição</label>
    <input type="text" name="descricao" id="descricao" class="form-control py-2" placeholder="Insira a descrição" value="<?= $servico->descricao ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="preco">Preço</label>
    <input type="number" name="preco" id="preco" class="form-control py-2" placeholder="Insira o valor" value="<?= $servico->preco ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="ativo">Situação</label>
    <select name="ativo" id="ativo" class="form-select">
        <option value="" <?= (isset($servico) && $servico->ativo == "") ? 'selected' : "" ?> >Selecione a situação</option>
        <option value="1" <?= (isset($servico) && $servico->ativo == "1") ? 'selected' : "" ?>>Ativo</option>
        <option value="0" <?= (isset($servico) && $servico->ativo == "0") ? 'selected' : "" ?>>Inativo</option>
    </select>
</div>


