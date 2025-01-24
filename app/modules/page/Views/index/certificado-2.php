<div class="header">
  <div class="logo-container">
    <img src="<?php echo IMAGE_PATH ?>fodun-logo.jpg" alt="" width="300" class="logo">
  </div>
</div>
<table>
<tr>
    <td class="my">
    </td>
  </tr>
  <tr>
    <td class="my text-center">
      <div class="titulo text-center bold">
      EL FONDO DE EMPLEADOS DOCENTES DE LA UNIVERSIDAD NACIONAL DE COLOMBIA
      <br>
      - FODUN -
      <br>
      NIT: 800.112.808-7
      </div>
    </td>
  </tr>
  <tr>
    <td class="my text-center">
      <div class="titulo bold text-center">
        CERTIFICA
      </div>
    </td>
  </tr>
  <tr>
    <td class="my">
      <p>
      El(la) asociado(a) <?php echo $this->data['basic']->NombreCompleto ?> con cedula de ciudadanía <?php echo $this->data['basic']->Cedula ?>, a la fecha se
        encuentra registrado en nuestras bases de datos como asociado activo al FODUN. Con
        fecha de ingreso el día <?php echo $this->data['basic']->FechaIngresoLetra ?>.
        Este certificado se expide a solicitud del interesado a los <?php echo $this->data['date-day'] ?> días del mes de <?php echo $this->data['date-month-in-letter'] ?> del
        <?php echo $this->data['date-year'] ?>, con una validez de 30 días.
      </p>
    </td>
  </tr>
  <tr>
    <td>
      Cordialmente,
    </td>
  </tr>
  <tr>
    <td class="my">
      GERENCIA GENERAL ‐FODUN-
    </td>
  </tr>
</table>
<footer>
  <table style="width: 100%;">
    <tr>
      <td class="text-right gray bold">
      FONDO DE EMPLEADOS DOCENTES UNIVERSIDAD NACIONAL DE COLOMBIA
      </td>
    </tr>
    <tr>
      <td class="text-right gray bold">
      Nit. 800.112.808-7
      </td>
    </tr>
    <tr>
      <td class="text-right gray bold">
      Página web: <a href="https://www.fodun.com.co/" class="red" style="text-decoration: none;">www.fodun.com.co</a>
      </td>
    </tr>
  </table>
</footer>

<style>
  * {
    font-family: Arial, Helvetica, sans-serif;
  }

  footer {
    position: fixed;
    bottom: 0;
    left: 0;
  }

  .text-right{
    text-align: right;
  }

  .titulo {
    font-size: 18px;
  }

  .text-center {
    text-align: center;
  }

  .bold {
    font-weight: bold;
  }

  .my {
    padding: 30px 0;
  }

  .header {
    position: relative;
    padding-bottom: 10px;
    margin-bottom: 20px;
  }

  .logo {
    position: absolute;
    top: 0;
    right: 0;
    width: 280px;
  }

  .logo-container {
    text-align: right;
  }

  .red{
    color: #af1c30;
  }
  .gray{
    color: #454045;
  }
</style>