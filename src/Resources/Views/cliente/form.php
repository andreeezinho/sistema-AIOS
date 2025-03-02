<div class="col-12 col-md-12 form-group my-2">
    <label for="nome">Nome</label>
    <input type="text" name="nome" id="nome" class="form-control py-2" placeholder="Insira o nome" value="<?= $cliente->nome ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="email">Email</label>
    <input type="text" name="email" id="email" class="form-control py-2" placeholder="Insira o email" value="<?= $cliente->email ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="documento">DOC</label>
    <input type="text" name="documento" id="documento" class="form-control py-2" placeholder="Insira o CPF ou CNPJ" value="<?= $cliente->documento ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="telefone">Telefone</label>
    <input type="text" name="telefone" id="telefone" class="form-control py-2" placeholder="Insira o telefone" value="<?= $cliente->telefone ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="endereco">Endereço</label>
    <input type="text" name="endereco" id="endereco" class="form-control py-2" placeholder="Insira o endereco" value="<?= $cliente->endereco ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="ativo">Situação</label>
    <select name="ativo" id="ativo" class="form-select">
        <option value="" <?= (isset($cliente) && $cliente->ativo == "") ? 'selected' : "" ?> >Selecione a situação</option>
        <option value="1" <?= (isset($cliente) && $cliente->ativo == "1") ? 'selected' : "" ?>>Ativo</option>
        <option value="0" <?= (isset($cliente) && $cliente->ativo == "0") ? 'selected' : "" ?>>Inativo</option>
    </select>
</div>

