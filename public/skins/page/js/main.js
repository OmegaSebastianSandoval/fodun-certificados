$(document).ready(function () {
  $("#btn-found-user").on("click", function () {
    var user = $("#user").val();
    $.ajax({
      url: "/page/index/foundUser",
      method: "post",
      data: {
        user: user,
      },
      dataType: "json",
      success: function (response) {
        if (response.status == "found") {
          var data = JSON.parse(response.data);
          $(".password-container").show(300);
        } else if (response.status == "exist") {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Ya existe un usuario con ese documento",
          });
        } else {
          $(".password-container").hide();
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "El usuario no existe",
          });
        }
      },
    });
  });
  $("#loginForm").on("submit", function (e) {
    e.preventDefault();
    let data = $(this).serialize();
    $.ajax({
      url: $(this).attr("action"),
      method: "post",
      data: data,
      dataType: "json",
      success: function (response) {
        if (response.status == "success") {
          Swal.fire({
            icon: "success",
            text: 'Bienvenido ' + response.name,
          }).then((result) => {
            window.location.href = "/";
          });
        } else if (response.status == "error") {
          Swal.fire({
            icon: "error",
            text: response.message,
          });
        }
      },
    });
  });
  $("#registerForm").on("submit", function (e) {
    e.preventDefault();
    let data = $(this).serialize();
    $.ajax({
      url: $(this).attr("action"),
      method: "post",
      data: data,
      dataType: "json",
      success: function (response) {
        if (response.status == "success") {
          Swal.fire({
            icon: "success",
            text: response.message,
          }).then((result) => {
            window.location.href = "/";
          });
        } else if (response.status == "error") {
          Swal.fire({
            icon: "error",
            text: response.message,
          });
        }
      },
    });
  });
  $("#password").on("keyup", function () {
    validar_clave($(this).val());
    console.log($(this).val());
    comparar_claves();
  });
  $("#repeat_password").on("keyup", function () {
    comparar_claves();
  });
  function comparar_claves() {
    let clave = $("#password").val(),
      clave2 = $("#repeat_password").val();
    if (clave == clave2) {
      $("#alert-contrasenia2").hide();
    } else {
      $("#alert-contrasenia2").show();
    }
  }
});
function validar_clave(contrasenna) {
  var mayuscula = false;
  var minuscula = false;
  var numero = false;
  var count = false;

  for (var i = 0; i < contrasenna.length; i++) {
    if (contrasenna.charCodeAt(i) >= 65 && contrasenna.charCodeAt(i) <= 90) {
      mayuscula = true;
    } else if (
      contrasenna.charCodeAt(i) >= 97 &&
      contrasenna.charCodeAt(i) <= 122
    ) {
      minuscula = true;
    } else if (
      contrasenna.charCodeAt(i) >= 48 &&
      contrasenna.charCodeAt(i) <= 57
    ) {
      numero = true;
    }
  }
  if (mayuscula == true && minuscula == true && numero == true) {
    if (contrasenna.length > 8) {
      $("#alert-contrasenia").hide();
    } else {
      $("#alert-contrasenia").show();
    }
  } else {
    $("#alert-contrasenia").show();
  }
}

// ==============================================================================================
$(document).ajaxStart(function () {
  $(".loader-bx").addClass("show");
});
$(document).ajaxStop(function () {
  $(".loader-bx").removeClass("show");
});

// ==============================================================================================
var videos = [];
$(document).ready(function () {
  $(".dropdown-toggle").dropdown();
  $(".carouselsection").carousel({
    quantity: 4,
    sizes: {
      900: 3,
      500: 1,
    },
  });

  $(".banner-video-youtube").each(function () {
    // console.log($(this).attr('data-video'));
    const datavideo = $(this).attr("data-video");
    const idvideo = $(this).attr("id");
    const playerDefaults = {
      autoplay: 0,
      autohide: 1,
      modestbranding: 0,
      rel: 0,
      showinfo: 0,
      controls: 0,
      disablekb: 1,
      enablejsapi: 0,
      iv_load_policy: 3,
    };
    const video = {
      videoId: datavideo,
      suggestedQuality: "hd1080",
    };
    videos[videos.length] = new YT.Player(idvideo, {
      videoId: datavideo,
      playerVars: playerDefaults,
      events: {
        onReady: onAutoPlay,
        onStateChange: onFinish,
      },
    });
  });

  function onAutoPlay(event) {
    event.target.playVideo();
    event.target.mute();
  }

  function onFinish(event) {
    if (event.data === 0) {
      event.target.playVideo();
    }
  }
  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
  );
  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );
});
