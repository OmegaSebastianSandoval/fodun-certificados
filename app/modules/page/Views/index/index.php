<div class="bx-general bx-login">
  <div class="row mx-0">
    <div class="col-md-6 login-bg">
      <img src="/skins/page/images/login-bg.webp?v=1.0" alt="">
    </div>
    <div class="col-md-6">
      <div class="row w-100 text-center justify-content-center h-100">
        <div class="col-lg-9 col-md-10 col-11 d-flex justify-content-center align-items-center">
          <div class="row">
            <div class="col-12">
              <img src="/skins/page/images/logo.jpg" alt="" class="logo">
            </div>
            <div class="col-12">
              <h3 class="login-title">Bienvenidos</h3>
            </div>
            <div class="col-lg-10 col-md-12 mx-auto">
              <p class="login-par">
                Consulte y descargue sus certificados tributarios.
              </p>
            </div>

            <div class="col-xxl-6 col-lg-8 col-9 mt-2 mx-auto">
              <form action="/page/login/" class="row" method="post" id="loginForm">
                <label for="text" class="text-start p-0">Documento asociado</label>
                <input type="text" class="form-control mb-3" id="nit" name="nit" placeholder="Ej 9100000" onkeypress="return soloNumerosYGuion(event)" required>
                <div class="g-recaptcha  mb-3 d-flex justify-content-center" data-sitekey="6LfFDZskAAAAAE2HmM7Z16hOOToYIWZC_31E61Sr"></div>
                <button type="submit">INGRESAR</button>
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

  .contenedor-general {
    height: calc(100vh - 60px);
  }
</style>
<script>
  function soloNumerosYGuion(event) {
    const charCode = event.keyCode ? event.keyCode : event.which;

    // Permitir números (0-9) y el guion (-)
    if (
      charCode !== 45 && // Código ASCII del guion "-"
      (charCode < 48 || charCode > 57) // Números (0-9)
    ) {
      event.preventDefault();
      return false;
    }

    return true;
  }
</script>