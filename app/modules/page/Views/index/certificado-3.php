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
        CERTIFICA QUE
      </div>
    </td>
  </tr>
  <tr>
    <td class="">
      <p>
        El(la) asociado(a) <?php echo $this->data['basic']->NombreCompleto ?> con Cédula de Ciudadanía <?php echo $this->data['basic']->Cedula ?>,
        a fecha <?php echo $this->data['date-day'] ?> de <?php echo $this->data['date-month-in-letter'] ?> de <?php echo $this->data['date-year'] ?> presenta los siguientes saldos:
      </p>
      <br>
    </td>
  </tr>
  <tr>
    <td>
      <table style="width: 100%; margin-top: 20px;" border="1" class="border-collapsed list-table">
        <tr>
          <td colspan="2" class="text-center">
            <span class="titulo-tabla bold">SALDOS DE AHORRO</span>
          </td>
        </tr>
        <tr>
          <td class="text-center">
            <span class="titulo-tabla bold">PRODUCTO</span>
          </td>
          <td>
            <span class="titulo-tabla bold">SALDO DISPONIBLE</span>
          </td>
        </tr>
        <?php foreach ($this->data['saving-accounts'] as $saving): ?>
          <?php if ($saving->SaldoDisponible > 0) { ?>
            <tr>
              <td>
                <?php echo $saving->NombreProducto ?>
              </td>
              <td>
                $<?php echo number_format($saving->SaldoDisponible, 0, ',', '.') ?>
              </td>
            </tr>
          <?php } ?>
        <?php endforeach; ?>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <div style="height: 25px;">
        <br>
      </div>
    </td>
  </tr>
  <tr>
    <td class="">
      <table style="width: 100%;" border="1" class="border-collapsed list-table">
        <tr>
          <td colspan="4" class="text-center">
            <span class="titulo-tabla bold">SALDOS DE CRÉDITO</span>
          </td>
        </tr>
        <tr>
          <td class="text-center">
            <span class="titulo-tabla bold">PRODUCTO</span>
          </td>
          <td>
            <span class="titulo-tabla bold">SALDO</span>
          </td>
          <td>
            <span class="titulo-tabla bold">CUOTA</span>
          </td>
          <td>
            <span class="titulo-tabla bold">ESTADO</span>
          </td>
        </tr>
        <?php foreach ($this->data['credit-accounts'] as $credit): ?>
          <?php if ($credit->SaldoCapital > 0) { ?>

            <tr>
              <td>
                <?php echo $credit->NombreProducto ?>
              </td>
              <td>
                $<?php echo number_format($credit->SaldoCapital, 0, ',', '.') ?>
              </td>
              <td>
                $<?php echo number_format($credit->Cuota, 0, ',', '.') ?>
              </td>
              <td>
                <?php echo $credit->CuotasAtrasadas > 0 ? $credit->CuotasAtrasadas . ' cuota(s) atrasadas' : 'Al dia'; ?>
              </td>
            </tr>
          <?php } ?>
        <?php endforeach; ?>
      </table>
    </td>
  </tr>
  <tr>
    <td class="">
      <p>
        <br><br>
        Este certificado se expide a solicitud del (la) interesado(a) a los <?php echo $this->data['date-day'] ?> días del mes de <?php echo $this->data['date-month-in-letter'] ?> del
        <?php echo $this->data['date-year'] ?>, con una validez de 30 días.
      </p>
    </td>
  </tr>
  <tr>
    <td>
      Cordialmente,
    </td>
  </tr>
  <br>
  <br>
  <tr>
    <td class="my">
      GERENCIA GENERAL FODUN
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