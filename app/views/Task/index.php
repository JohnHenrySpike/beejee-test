<div class="container-sm text-center">
<div class="row ">
  <div class="col">
    Task list
  </div>
</div>

<!-- login/logout button -->
<?if ($this->data["isAdmin"]):?>
<form action="/logout" method="POST">
    <button type="submit" class="btn btn-secondary">Logout</button>
</form>
<?else:?>
  <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary btn-sm">Sing in</button>
<?endif?>

<!-- Add task form -->

<form class="row my-5 justify-content-center" action="/task/add" method="POST">
  <div class="col-2">
    <input type="text" class="form-control" id="username" name="username" placeholder="username">
  </div>
  <div class="col-2">
    <input type="email" class="form-control" id="Email1" name="email" placeholder="email">
  </div>
  <div class="col-5">
    <input type="text" class="form-control" id="text" name="text" placeholder="task text">
  </div>
  <div class="col-2">
      <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</form>

<!-- Sort select -->

<?if (count($this->data["data"])>1):?>
<div class="row justify-content-center">
  <div class="col-1">
  <form class="row my-2" action="/task/index?page=2">
    <select name="sort" class="form-select" aria-label="Default select example">
      <option disabled selected>Sort by</option>
      <option value="username">username</option>
      <option value="email">email</option>
      <option value="status">status</option>
    </select>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  </div>
</div>
<?endif?>


<!-- task list -->
<?foreach ($this->data["data"] as $val):?>

<form class="row justify-content-left border border-primary-subtle rounded-3" <?=$this->data["isAdmin"]?"action=\"/task/update?id=".$val["id"]."\" method=\"POST\"":""?>>
  <div class="col-1">
    <input class="form-check-input" type="checkbox" value="true" name="status" id="flexCheckDefault" <?=$this->data["isAdmin"]?:"disabled"?> <?=$val["status"]?"checked":""?>>
  </div>
  <div class="col-2">
    <?=$val["username"]?>
  </div>
  <div class="col-2">
    <?=$val["email"]?>
  </div>
  <div class="col">
    <input type="text" class="form-control" id="text" name="text" value="<?=$val["text"]?>" placeholder="task text">
  </div>
  <?if ($this->data["isAdmin"]):?>
  <div class="col-2">
      <button type="submit" class="btn btn-success">Submit</button>
  </div>
  <?endif?>
</form>
<?php

endforeach;
$pgnt = $this->data["paginate"];
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
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/login" method="POST">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Login form</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row ">
              <div class="col">
                <input type="text" class="form-control" id="username" name="username" placeholder="username">
              </div>
            </div>
            <div class="row ">
              <div class="col">
                <input type="password" class="form-control" id="password" name="password" placeholder="password">
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </form>
    </div>
  </div>
</div>