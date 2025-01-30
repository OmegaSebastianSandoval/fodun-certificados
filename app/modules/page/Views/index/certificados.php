<style>
  body {

    overflow-y: scroll;
  }

  .contenedor-general {
    height: auto;
  }
</style>
<div class="certificados-bx">
  <div class="container">
    <div class="row">
      <div class="col-12 mb-2 mb-md-5">
        <div class="row align-items-center">
          <div class="col-md-5 text-right pe-3">
            <h3>Certificados</h3>
          </div>
          <div class="col-md-7">
            <p>
              Estimado(a) Asociado(a),
            </p>
            <p>
              Hemos creado este espacio para que acceda de manera rápida y sencilla a su información, asegurando que siempre tenga lo que necesita al alcance de su mano.
            </p>
            <p>
              En este módulo podrá descargar fácilmente sus certificados. Solo elija el tipo de certificado que necesita.
            </p>
          </div>
        </div>
      </div>
      <?php
     /*  echo '<pre>';
      print_r($this->tipos);
      print_r($this->apiData);
      echo '</pre>'; */
      ?>
      <input type="hidden" name="csrf_token" value="<?php echo Session::getInstance()->get('csrf_token_user') ?>">
      <div class="col-12 text-center">
        <div class="row">
          <?php foreach ($this->tipos as $key => $tipo) { ?>
            <?php $validateInPeace = true; ?>
            <?php if ($tipo['isPeace']) { ?>
              <?php if (!$this->apiData['credit-accounts-to-peace']) { ?>
                <?php $validateInPeace = false; ?>
              <?php } ?>
            <?php } ?>
            <?php if (!$tipo['isRetired'] && $this->apiData['basic']->FechaRetiro == '') { ?>
              <?php if ($validateInPeace) { ?>
                <div class="col-6 col-md-3">
                  <div class="row">
                    <div class="col-12">
                      <div class="image-bx">
                        <img src="/images/<?php echo $tipo['image'] ?>" alt="" class="bg-image rounded-4">
                        <div class="text">
                          <img src="/skins/page/images/icono-busqueda.png" alt="" class="icon">
                          <span><?php echo $tipo['title'] ?></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 mt-1 mt-md-3 mb-5">
                      <?php if ($tipo['optionsBool']) { ?>
                        <a href="#" class="btn-generar" data-bs-toggle="modal" data-bs-target="#modal_php<?php echo $key ?>">
                          <?php echo $tipo['optionsBtn'] ?>
                        </a>
                        <div class="modal fade" id="modal_php<?php echo $key ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo $tipo['optionsBtn'] ?></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form action="/page/index/generar" method="post" class="row" target="_blank" onsubmit="return closeModals()">
                                  <input type="hidden" value="<?php echo $key ?>" name="id">
                                  <?php if ($tipo['optionsType'] == 'API') { ?>
                                    <div class="col-12">

                                      <select name="cert_option" id="cert_option" class="form-control">
                                        <?php foreach ($this->apiData[$tipo['optionApi']] as $optionKey => $option): ?>

                                          <option value="<?php echo $optionKey ?>"><?php echo $option ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                    </div>
                                  <?php } ?>
                                  <?php if ($tipo['optionsType'] == 'Addressee') { ?>
                                    <div class="col-12">
                                      <label for="">Dirigido a:</label>
                                      <input type="text" class="form-control" name="addressee">
                                    </div>
                                  <?php } ?>
                                  <div class="col-12 mt-3">
                                    <button class="btn-generar" type="submit">
                                      Generar
                                    </button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php } else { ?>
                        <a href="/page/index/generar?id=<?php echo $key ?>" class="btn-generar" target="_blank">
                          Generar
                        </a>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              <?php } ?>
            <?php } ?>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- <?php
      echo '<pre>';
      print_r($this->apiData['credit-accounts-to-peace']);
      echo '</pre>';
      ?> -->
<?php if ($_GET['error'] == 'true') { ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: '<?php echo $_GET['message'] ?>',
      confirmButtonColor: "#af1c30",
      confirmButtonText: "Aceptar",
    }).then(() => {
      // window.location.href = '/page/index/certificados';
    })
  </script>
<?php } ?>

<script>
  function closeModals() {
    $('.modal').modal('hide');
    return true;
  }
</script>