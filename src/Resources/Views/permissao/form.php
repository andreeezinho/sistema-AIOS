<div class="col-12 col-md-12 form-group my-2">
    <label for="nome">Nome</label>
    <input type="text" name="nome" id="nome" class="form-control py-2" placeholder="Insira seu nome" value="<?= $permissao->nome ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="tipo">Tipo</label>
    <select name="tipo" id="tipo" class="form-select">
        <option value="" <?= (isset($permissao) && $permissao->tipo == "") ? 'selected' : "" ?> >Selecione o tipo</option>
        <option value="cadastrar" <?= (isset($permissao) && $permissao->tipo == "cadastrar") ? 'selected' : "" ?>>Cadastrar</option>
        <option value="deletar" <?= (isset($permissao) && $permissao->tipo == "deletar") ? 'selected' : "" ?>>Deletar</option>
        <option value="editar" <?= (isset($permissao) && $permissao->tipo == "editar") ? 'selected' : "" ?>>Editar</option>
        <option value="visualizar" <?= (isset($permissao) && $permissao->tipo == "visualizar") ? 'selected' : "" ?>>Visualizar</option>
    </select>
</div>

<div class="col-12 form-group my-2">
    <label for="ativo">Situação</label>
    <select name="ativo" id="ativo" class="form-select">
        <option value="" <?= (isset($permissao) && $permissao->ativo == "") ? 'selected' : "" ?> >Selecione situação</option>
        <option value="1" <?= (isset($permissao) && $permissao->ativo == "1") ? 'selected' : "" ?>>Ativo</option>
        <option value="0" <?= (isset($permissao) && $permissao->ativo == "0") ? 'selected' : "" ?>>Inativo</option>
    </select>
</div>

<div class="form-group text-center">
    <a href="/permissoes" class="btn btn-secondary mx-1">Cancelar</a>
    <button type="submit" class="btn btn-primary mx-1">Confirmar</button>
</div>