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
              <h3 class="login-title">Regístrate</h3>
            </div>
            <div class="col-lg-10 col-md-12 mx-auto">
              <p class="login-par">
                <br>
                <br>
                Consulte y descargue sus certificados tributarios.
                <br><br>
              </p>
            </div>

            <div class="col-lg-5 col-md-7 col-9 mx-auto">
              <form action="/page/index/createUser" method="post" class="row login-container" id="registerForm" autocomplete="off">
                <div class="col-sm-12 form-group">
                  <div class="col-sm-12 col-md-12 margen_icono">
                    <div class="row">
                      <div class="col-md-12 no-padding text-start">
                        <label for="cedula">Documento</label>
                        <div class="input-container">
                          <input type="text" class="form-control" id="user" name="user" placeholder="Usuario" required="">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 password-container mt-3">
                    <div class="row">
                      <div class="col-md-12 no-padding text-start">
                        <label for="cedula">Contraseña</label>
                        <div class="input-container">
                          <input type="password" class="form-control " id="password" name="password" placeholder="Contraseña" required="">
                        </div>
                        <div class="invalid-feedback" id="passwordFeedback"></div>
                      </div>
                      <div class="col-md-12 no-padding text-start mt-3">
                        <label for="cedula">Repite la contraseña</label>
                        <div class="input-container">
                          <input type="password" class="form-control " id="repeat_password" name="repeat_password" placeholder="Contraseña" required="">
                        </div>
                        <div class="invalid-feedback" id="secondPasswordFeedback"></div>
                      </div>
                    </div>
                  </div>
                  <a href="/" class="mb-4 mt-3">¿Ya tienes cuenta? Inicia sesión.</a>
                  <div class="col-md-12">
                    <button type="button" class="btn btn-azul" id="btn-found-user">
                      Buscar
                    </button>
                  </div>
                  <div class="col-md-12 password-container">
                    <button class="btn btn-azul" type="submit">
                      Registrarse
                    </button>
                  </div>
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

  .input-container .invalid-feedback {
    display: block;
  }

  .is-invalid+.invalid-feedback {
    display: block;
  }


</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var passwordInput = document.getElementById('password');
    var secondPasswordInput = document.getElementById('repeat_password');
    var passwordFeedback = document.getElementById('passwordFeedback');
    var secondPasswordFeedback = document.getElementById('secondPasswordFeedback');

    function validatePassword() {
      var password = passwordInput.value;
      var isValid = true;

      // Reset feedback
      passwordFeedback.style.display = 'none';

      // Check password criteria
      if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{1,6}$/.test(password)) {
        passwordFeedback.textContent = 'La contraseña debe contener letras, números y un máximo de 6 caracteres.';
        passwordFeedback.style.display = 'block';
        passwordInput.classList.add('is-invalid');
        isValid = false;
      } else {
        passwordInput.classList.remove('is-invalid');
      }

      return isValid;
    }

    function validateSecondPassword() {
      var password = passwordInput.value;
      var secondPassword = secondPasswordInput.value;
      var isValid = true;

      // Reset feedback
      secondPasswordFeedback.style.display = 'none';

      // Check if passwords match
      if (password !== secondPassword) {
        secondPasswordFeedback.textContent = 'Las contraseñas no coinciden.';
        secondPasswordFeedback.style.display = 'block';
        secondPasswordInput.classList.add('is-invalid');
        isValid = false;
      } else {
        secondPasswordInput.classList.remove('is-invalid');
      }

      return isValid;
    }

    passwordInput.addEventListener('input', validatePassword);
    secondPasswordInput.addEventListener('input', validateSecondPassword);

    document.getElementById('forgotForm').addEventListener('submit', function(event) {
      var isValid = validatePassword() && validateSecondPassword();

      if (!isValid) {
        event.preventDefault();
      }
    });
  });
</script>