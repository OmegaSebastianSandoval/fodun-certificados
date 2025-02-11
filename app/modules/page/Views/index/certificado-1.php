<header>
  <img src="<?php echo IMAGE_PATH ?>banner-coop.jpg" alt="">
</header>
<table>
  <tr>
    <td class="my">
      <span><!--Bogotá,--> D.C, <?php echo $this->data['date-in-letter'] ?></span>
    </td>
  </tr>
  <tr>
    <td class="my text-center">
      <div class="titulo text-center">
        EL BANCO COOPERATIVO COOPCENTRAL
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
        Que el(la) Señor(a) <?php echo $this->data['basic']->NombreCompleto ?> identificado con CC <?php echo $this->data['basic']->Cedula ?> se encuentra inscrito en el registro social de FODUN y posee el siguiente producto:
      </p>
    </td>
  </tr>
  <tr>
    <td>
      Banco: <strong>Coopcentral</strong>
    </td>
  </tr>
  <tr>
    <td>
      Número de cuenta: <strong><?php echo $this->data['account']->CuentaCoopcentral ?></strong>
    </td>
  </tr>
  <tr>
    <td>
      Tipo: <strong><?php echo $this->data['account']->NombreProducto ?></strong>
    </td>
  </tr>
  <tr>
    <td class="my">
    </td>
  </tr>
  <tr>
    <td class="my">
      <div class="titulo bold">
        Banco Cooperativo Coopcentral
      </div>
    </td>
  </tr>
</table>
<footer>
  <img src="<?php echo IMAGE_PATH ?>footer-coop.jpg" alt="">
</footer>
<style>
  * {
    font-family: Arial, Helvetica, sans-serif;
  }

  footer {
    margin-left: -60px;
    margin-right: -60px;
    position: fixed;
    bottom: -60px;
    left: 0;
  }

  .titulo {
    font-size: 20px;
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
</style>