<div class="container text-center">
  <div class="row justify-content-between">
    <div class="col-2">
      Список задач
    </div>
    <div class="col-1 p-0">
      <!-- login/logout button -->
      <?if ($this->data["isAdmin"]):?>
      <form action="/logout" method="POST">
          <button type="submit" class="btn btn-secondary btn-sm">Выход</button>
      </form>
      <?else:?>
        <a href="/login" class="btn btn-primary btn-sm">Войти</a>
      <?endif?>
    </div>
  </div>

  <!-- Add task form -->
  <form class="row my-5 justify-content-start text-start needs-validation" novalidate action="/task/add" method="POST">
    <div class="row">
      <div class="col-md-4">
        <label for="username" class="form-label">Имя пользователя</label>
        <div class="input-group has-validation">
          <input type="text" class="form-control" id="username" name="username" placeholder="Имя пользователя" required>
          <div class="invalid-feedback">
            Заполните имя пользователя.
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <label for="email" class="form-label">Email</label>
        <div class="input-group has-validation">
          <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
          <div class="invalid-feedback">
              Заполните Email.
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <label for="text" class="form-label">Текст задачи</label>
        <div class="input-group has-validation">
          <input type="text" class="form-control" id="text" name="text" placeholder="Текст задачи" required>
          <div class="invalid-feedback">
            Заполните текст задачи.
          </div>
        </div>
      </div>
    </div>
    <div class="row my-3">
      <div class="col-md-4">
          <button type="submit" class="btn btn-primary btn-sm">Добавить</button>
      </div>
    </div>
  </form>

  <!-- task list -->
  <?
  $sort = $this->data["sort_by"];
  $pgnt = $this->data["paginate"];
  ?>
  <table id="dtBasicExample" class="table table-bordered table-sm" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th class="th-sm sorting">
          Имя пользователя 
          <a class="text-decoration-none" href="?sort_by=<?=$sort=="username_asc"?"":"username_asc"?>&page=<?=$pgnt["current"]?>"><?=$sort=="username_asc"?"&#9660;":"&#9661;"?></a>
          <a class="text-decoration-none" href="?sort_by=<?=$sort=="username_desc"?"":"username_desc"?>&page=<?=$pgnt["current"]?>"><?=$sort=="username_desc"?"&#9650;":"&#9651;"?></a>
        </th>
        <th class="th-sm">
          Email
          <a class="text-decoration-none" href="?sort_by=<?=$sort=="email_asc"?"":"email_asc"?>&page=<?=$pgnt["current"]?>"><?=$sort=="email_asc"?"&#9660;":"&#9661;"?></a>
          <a class="text-decoration-none" href="?sort_by=<?=$sort=="email_desc"?"":"email_desc"?>&page=<?=$pgnt["current"]?>"><?=$sort=="email_desc"?"&#9650;":"&#9651;"?></a>
        </th>
        <th class="th-sm">Текст задачи</th>
        <th class="th-sm">
          Статус
          <a class="text-decoration-none" href="?sort_by=<?=$sort=="status_asc"?"":"status_asc"?>&page=<?=$pgnt["current"]?>"><?=$sort=="status_asc"?"&#9660;":"&#9661;"?></a>
          <a class="text-decoration-none" href="?sort_by=<?=$sort=="status_desc"?"":"status_desc"?>&page=<?=$pgnt["current"]?>"><?=$sort=="status_desc"?"&#9650;":"&#9651;"?></a>
        </th>
        <?if ($this->data["isAdmin"]):?>
          <th class="th-sm"></th>
        <?endif?>
      </tr>
    </thead>
    <tbody>
    <?if (count($this->data["data"])==0):?>
      <tr>
        <td colspan=<?=$this->data["isAdmin"]?5:4?>>Список пуст</td>
      </tr>
    <?endif?>
    <?foreach ($this->data["data"] as $val):?>
      <tr>
        <form action="/task/update?id=<?=$val["id"]?>" method="POST">
          <td><?=$val["username"]?></td>
          <td><?=$val["email"]?></td>
          <td>
            <?if ($this->data["isAdmin"]):?>
              <input type="text" class="form-control" name="text" value="<?=$val["text"]?>" placeholder="task text"></td>
            <?else:?>
              <?=$val["text"]?>
            <?endif?>
          <td>
            <?if ($this->data["isAdmin"]):?>
                <select name="status">
                  <option value="false" <?=$val["status"]?"":"selected"?> disabled>Не выполнено</option>
                  <option value="true" <?=$val["status"]?"selected":""?> >Выполнено</option>
                </select>
            <?else:?>
              <?=$val["status"]?"Выполнено":"Не выполнено"?>
            <?endif?>
            <?=$val["changed"]?"</br><small>Отредактировано </br>администратором.</small>":""?>
          </td>
          <?if ($this->data["isAdmin"]):?>
            <td><button type="submit" class="btn btn-success btn-sm">Сохранить</button></td>
          <?endif?>
        </form>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>

<?

if ($pgnt["pages"]>1):
?>

  <!-- Paginate -->
  <div class="row my-3">
    <nav aria-label="Page nav">
      <ul class="pagination justify-content-center">
        <?for ($i=1; $i <= $pgnt["pages"]; $i++):?>
          <li class="page-item <?=$i==$pgnt["current"]?:"active"?>"><a class="page-link" href="<?=$pgnt["link"]?><?=$i?>"><?=$i?></a></li>
        <?endfor?>
      </ul>
    </nav>
  </div>
  <?endif?>

<!-- end container -->
</div>