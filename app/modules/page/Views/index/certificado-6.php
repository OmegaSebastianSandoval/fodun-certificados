<div class="header">
  <div class="logo-container">
    <img src="<?php echo IMAGE_PATH ?>Logo_Fodun.png" alt="" width="250" class="logo">
  </div>
</div>
<table>
  <tr>
    <td class="text-right">
      <!--Bogotá,--> <?php echo $this->data['date-in-letter'] ?>
    </td>
  </tr>
  <tr>
    <td class="my">
      Señores: <br>
      <?php echo $this->data['Addressee'] ?>
    </td>
  </tr>
  <tr>
    <td>
      <br>
      <span class="title bold">REF: CERTIFICACIÓN <span style="text-transform: uppercase;"><?php echo $this->data['account']->NombreProducto ?></span></span>
      <br>
      <br>
      <br>
    </td>
  </tr>
  <tr>
    <td class="my text-center">
      <div class="titulo text-center bold">
        EL FONDO DE EMPLEADOS DOCENTES DE LA UNIVERSIDAD NACIONAL DE COLOMBIA
        <br>
        FODUN
        <br>
        NIT: 800.112.808-7
      </div>
    </td>
  </tr>
  <tr>
    <td class="my text-center">
      <div class="titulo bold text-center">
        CERTIFICA QUE,
      </div>
    </td>
  </tr>
  <tr>
    <td class="">
      <p>
        <br>
        <br>
        El(la) asociado(a) <?php echo $this->data['basic']->NombreCompleto ?> con Cédula de Ciudadanía <?php echo $this->data['basic']->Cedula ?>, actualmente cuenta con la línea de <?php echo $this->data['account']->NombreProducto ?> #<?php echo $this->data['account']->NumeroCredito ?>, desde el <?php echo date('d/m/Y', strtotime($this->data['account']->FechaDesembolso)) ?> con un monto desembolsado de $<?php echo number_format($this->data['account']->Monto, 0, ',', '.') ?>, el cual presenta un saldo de $<?php echo number_format($this->data['account']->SaldoCapital, 0, ',', '.') ?> a la
        fecha, con cuota mensual de $<?php echo number_format($this->data['account']->Cuota, 0, ',', '.') ?> la cual debe cancelar antes de <?php echo date('d/m/Y', strtotime($this->data['account']->FechaProximoPago)) ?>.
      </p>
      <br>
    </td>
  </tr>
  <tr>
    <td class="">
      <p>
        <br>
        Este certificado se expide a solicitud del (la) interesado(a) a los <?php echo $this->data['date-day'] ?> días del mes de <?php echo $this->data['date-month-in-letter'] ?> del
        <?php echo $this->data['date-year'] ?>, con una validez de 30 días.
      </p>
    </td>
  </tr>
  <tr>
    <td>
      <br>
      <br>
      Cordialmente,

    </td>
  </tr>
  <br>
  <br>
  <tr>
    <td class="my bold">
      <br>
      <br>
      DEPARTAMENTO CARTERA FODUN
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