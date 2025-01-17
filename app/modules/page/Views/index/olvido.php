<div class="bx-general bx-login">
  <div class="row mx-0">
    <div class="col-md-6 login-bg">
      <img src="/skins/page/images/login-bg.png" alt="">
    </div>
    <div class="col-md-6">
      <div class="row w-100 text-center justify-content-center">
        <div class="col-lg-9 col-md-10 col-11">
          <div class="row">
            <div class="col-12">
              <img src="/skins/page/images/logo.jpg" alt="" class="logo">
            </div>
            <div class="col-12">
              <h3 class="login-title" style="font-size: 2.4rem;">Recupera tu contraseña</h3>
            </div>
            <div class="col-lg-10 col-md-12 mx-auto">
              <p class="login-par">
                <br>
                <br>
                Ingresa tu documento, si existe un usuario creado con tu ese NIT te llegara un mensaje al correo vinculado a tu cuenta.
                <br><br>
              </p>
            </div>

            <div class="col-xxl-6 col-md-7 col-9 mx-auto">
              <form action="/page/index/sendForgot" method="post" class="row" id="forgotForm">
                <div class="col-md-12 no-padding text-start">
                  <label for="cedula">Documento</label>
                  <div class="input-container">
                    <input type="text" class="form-control" id="nit" name="nit" placeholder="Ingresa tu documento" required="">
                  </div>
                </div>
                <a href="/" class="mb-4 mt-4">¿Ya tienes cuenta? Inicia sesión.</a>
                <button type="submit">RECUPERAR</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<style>
  header {
    display: none;
  }
</style>

<script>
  $(document).ready(function()
  {
    $('#forgotForm').on('submit', function(e){
      e.preventDefault();
      $.ajax({
        url: $(this).attr('action'),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(data){
          Swal.fire({
            icon: 'success',
            text: 'Si el documento ingresado se encuentra registrado se enviara un enlace de recuperación al correo asociado'
          }).then((result) => {
            window.location.href = '/'
          });
        }
      })
    })
  })
</script>