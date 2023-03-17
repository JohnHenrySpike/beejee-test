<?if (isset($this->data["error"])):?>
<div class="alert alert-warning" role="alert">
  <?=$this->data["error"]?>
</div>
<?endif?>


<form class="needs-validation" novalidate action="/login" method="POST">
    <div class="row">
        <h1 class="fs-5" id="exampleModalLabel">Авторизация</h1>
    </div>
    <div class="row">
        <div class="row">
            <div class="col">
            <div class="input-group has-validation">
                <input type="text" class="form-control" name="username" placeholder="Имя пользователя" required>
                <div class="invalid-feedback">
                Заполните имя пользователя.
                </div>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
            <div class="input-group has-validation">
            <input type="password" class="form-control" name="password" placeholder="Пароль" required>
                <div class="invalid-feedback">
                Заполните пароль.
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        <button type="submit" class="btn btn-primary">Войти</button>
    </div>
</form>