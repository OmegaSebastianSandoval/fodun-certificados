<div class="header">
  <div class="left">
    <img src="/skins/page/images/logo-negativo.png" alt="" class="logo">
  </div>
  <div class="right">
    <div class="d-flex">
      <div class="row mx-0 username">
        <div class="col-12">
          <strong>
            Bienvenido
          </strong>
        </div>
        <div class="col-12">
          <?php echo Session::getInstance()->get('user')->NombreCompleto; ?>
        </div>
      </div>
      <div class="row mx-0 logout">
        <a href="/page/login/logout">
          Salir 
          <i class="fa-solid fa-arrow-right-from-bracket"></i>
        </a>
      </div>
    </div>
  </div>
</div>