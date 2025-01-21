<div class="bx-general bx-login">
  <div class="row mx-0">
    <div class="col-md-6 login-bg">
      <img src="/skins/page/images/login-bg.webp" alt="">
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
                Si tu token es válido, ingresa tu nueva contraseña.
                <br><br>
              </p>
            </div>

            <div class="col-xxl-6 col-md-7 col-9 mx-auto">
              <form action="/page/index/changePassword" method="post" class="row" id="change" autocomplete="off">
                <input type="hidden" name="token" value="<?php echo $_GET['t'] ?>">
                <input type="hidden" name="document" value="<?php echo $_GET['d'] ?>">
                <input type="hidden" value="<?php echo $this->user->id ?>" name="user_id">
                <div class="col-md-12 no-padding text-start">
                  <label for="password">Contraseña</label>
                  <div class="input-container">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu nueva contraseña" required="" maxlength="6">
                  </div>
                  <div class="invalid-feedback" id="passwordFeedback"></div>
                </div>
                <div class="col-md-12 no-padding text-start my-3">
                  <label for="second_password">Repite tu contraseña</label>
                  <div class="input-container">
                    <input type="password" class="form-control" id="second_password" name="second_password" placeholder="Repite tu nueva contraseña" required="" maxlength="6">
                  </div>
                  <div class="invalid-feedback" id="secondPasswordFeedback"></div>
                </div>
                <a href="/" class="mb-4 mt-2">¿Ya tienes cuenta? Inicia sesión.</a>
                <?php
                switch ($_GET['error']) {
                  case '1':
                ?>
                    <div class="alert alert-danger" role="alert">
                      No se ha encontrado un asociado registrado con ese documento, por favor realice el proceso nuevamente.
                    </div>
                  <?php
                    break;
                  case '2':
                  ?>
                    <div class="alert alert-danger" role="alert">
                      El token no est valido o ha caducado, por favor realice el proceso nuevamente.
                    </div>
                  <?php
                    break;
                  case '3':
                  ?>
                    <div class="alert alert-danger" role="alert">
                      Las contraseñas deben ser iguales.
                    </div>
                <?php
                    break;
                }

                ?>
                <button type="submit">Cambiar</button>
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
  document.addEventListener('DOMContentLoaded', function() {
    var passwordInput = document.getElementById('password');
    var secondPasswordInput = document.getElementById('second_password');
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