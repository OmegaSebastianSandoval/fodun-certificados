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
              <form action="/page/index/login" class="row" method="post" id="loginForm">
                <label for="nit">Documento asociado</label>
                <input type="number" class="form-control mb-3" id="nit" name="nit" placeholder="Ej 9100000" required>
                <input type="password" class="form-control mb-3" name="password" placeholder="Contraseña">
                <a href="/page/index/olvido" class="mb-2">¿Olvidaste tu contraseña?</a>
                <a href="/page/index/registro" class="mb-4">¿No tienes una cuenta? Regístrate</a>
                <div class="col-12 my-2">
                  <?php if ($_GET['pass']) { ?>
                    <div class="alert alert-success" role="alert">
                      Cambio de contraseña correcto.
                    </div>
                  <?php } ?>
                </div>
                <button type="submit">INGRESAR</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">Términos y condiciones</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          Con la creación del usuario y el acceso al módulo de expedición de certificados
          de RETEICA, RETEFUENTE y RETEIVA de la plataforma de OPAIN
          (www.opain.co) está autorizando de manera voluntaria, previa, explícita,
          informada e inequívoca a OPAIN y a OMEGA para tratar la información
          personal que consigna en el mencionado módulo (identificación, correo
          electrónico, teléfono, etc.), con el fin de crear el usuario en la plataforma,
          custodiar información para dar acceso al módulo, enviar correos de
          notificaciones relacionadas con su uso y habilitar la descarga de los certificados.
          El período de tratamiento de la información será desde la autorización hasta la
          finalización del Contrato de Concesión No. 6000169OK de 2006, cuya consulta
          es de público acceso a través del link:
          <a target="_blank" href="https://www.contratos.gov.co/consultas/detalleProceso.do?numConstancia=05-1-
            1033">https://www.contratos.gov.co/consultas/detalleProceso.do?numConstancia=05-1-
            1033</a>
          Desde OPAIN le recordamos que de conformidad con la ley, los derechos del
          titular de los datos son los siguientes: a) Conocer, actualizar y rectificar sus datos
          personales frente a los Responsables o Encargados del Tratamiento. Este derecho
          se podrá ejercer, entre otros frente a datos parciales, inexactos, incompletos,
          fraccionados, que induzcan a error, o aquellos cuyo Tratamiento esté
          expresamente prohibido o no haya sido autorizado; b) Solicitar prueba de la
          autorización otorgada al Responsable del Tratamiento salvo cuando
          expresamente se exceptúe como requisito para el Tratamiento de conformidad
          con lo previsto en el artículo 10 de la Ley 1581 de 2012; c) Ser informado por el
          Responsable del Tratamiento o el Encargado del Tratamiento, previa solicitud,
          respecto del uso que le ha dado a sus datos personales; d) Presentar ante la
          Superintendencia de Industria y Comercio quejas por infracciones a lo dispuesto
          en la citada ley y las demás normas que la modifiquen, adicionen o
          complementen; e) Revocar la autorización y/o solicitar la supresión del dato
          cuando en el Tratamiento no se respeten los principios, derechos y garantías
          constitucionales y legales. La revocatoria y/o supresión procederá cuando la
          Superintendencia de Industria y Comercio haya determinado que en el
          Tratamiento el responsable o Encargado han incurrido en conductas contrarias a
          la ley y/o a la Constitución; f) Acceder en forma gratuita a sus datos personales
          que hayan sido objeto de Tratamiento.
          Para leer nuestra Política de Tratamiento de Datos ingrese a:

          <a target="_blank" href="https://www.opain.co/files/membretepoliticastratamientodatos.pdf">https://www.opain.co/files/membretepoliticastratamientodatos.pdf</a>
          y en caso de
          quejas o peticiones relacionados con el tratamiento de sus datos por favor
          contactarse al correo electrónico habeasdataoficial@eldorado.aero
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