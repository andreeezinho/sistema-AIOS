<div class="col-12 col-md-12 form-group my-2">
    <label for="nome">Nome</label>
    <input type="text" name="nome" id="nome" class="form-control py-2" placeholder="Insira seu nome" value="<?= $usuario->nome ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="email">Email</label>
    <input type="text" name="email" id="email" class="form-control py-2" placeholder="Insira seu email" value="<?= $usuario->email ?? '' ?>">
</div>

<?php
    if(!$perfil){
?>
    <div class="col-12 form-group my-2">
        <label for="ativo">Situação</label>
        <select name="ativo" id="ativo" class="form-select">
            <option value="" <?= (isset($usuario) && $usuario->ativo == "") ? 'selected' : "" ?> >Selecione situação</option>
            <option value="1" <?= (isset($usuario) && $usuario->ativo == "1") ? 'selected' : "" ?>>Ativo</option>
            <option value="0" <?= (isset($usuario) && $usuario->ativo == "0") ? 'selected' : "" ?>>Inativo</option>
        </select>
    </div>
<?php
    }
?>

<div class="col-12 form-group my-2">
    <label for="cpf">CPF</label>
    <input type="text" name="cpf" id="cpf" class="form-control py-2" placeholder="Insira seu cpf" value="<?= $usuario->cpf ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="telefone">Telefone</label>
    <input type="text" name="telefone" id="telefone" class="form-control py-2" placeholder="Insira seu telefone" value="<?= $usuario->telefone ?? '' ?>">
</div>

