<div class="header">
  <div class="logo-container">
    <img src="<?php echo IMAGE_PATH ?>Logo_Fodun.png" alt="" width="250" class="logo">
  </div>
</div>
<table>
  <tr>
    <td class="my text-center">
      <div class="titulo text-center bold">
        PAZ Y SALVO
        <br>
      </div>
    </td>
  </tr>
<!--   <tr>
    <td class="my">
      Profesor(a); <br>
      <?php echo $this->data['basic']->NombreCompleto ?><br>
      Bogotá
    </td>
  </tr> -->
  <tr>
    <td class="my">
      Señores; <br>
      <?php echo $this->data['Addressee'] ?><br>
      Bogotá
    </td>
  </tr>
  <tr>
    <td>
      <br>
      <span class="title bold">REF: CERTIFICACIÓN PAZ Y SALVO FODUN</span>
      <br>
      <br>
      <br>
    </td>
  </tr>
  <tr>
    <td class="">
      <p>
        <br><br><br>
        Estimado(a) profesor(a) <?php echo $this->data['basic']->NombreCompleto ?>,
        <br><br><br>
        Mediante la presente nos permitimos informarle que, a la fecha, usted se encuentra a paz
        y salvo con FODUN por todo concepto y/u obligaciones.
      </p>
      <br>
    </td>
  </tr>
  <tr>
    <td class="">
      <p>
        <br>
        Este certificado se expide a solicitud del interesado a los <?php echo $this->data['date-day'] ?> días del mes de <?php echo $this->data['date-month-in-letter'] ?> del
        <?php echo $this->data['date-year'] ?>, con una validez de 30 días.
      </p>
    </td>
  </tr>
  <tr>
    <td>
      <br>
      Cordialmente,
    </td>
  </tr>
  <tr>
    <td class="my">
      <br><br><br>
      GERENCIA FODUN
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
<!-- <?php
      echo '<pre>';
      print_r($this->data);
      echo '</pre>';
      ?> -->
<style>
  @page {
    margin: 50px 100px;
  }

  * {
    font-family: Arial, Helvetica, sans-serif;
  }

  footer {
    position: fixed;
    bottom: 0;
    left: 0;
  }

  .text-right {
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
    padding: 10px 0;
  }

  .header {
    position: relative;
  }

  .logo {
    position: absolute;
    top: 0;
    right: 0;
    width: 250px;
    margin-right: -20px;
  }

  .logo-container {
    text-align: right;
  }

  .red {
    color: #af1c30;
  }

  .gray {
    color: #454045;
  }

  .border-collapsed {
    border-collapse: collapse;
    border: 1px solid #000;
  }

  .titulo-tabla {
    font-size: 14px;
  }
</style>