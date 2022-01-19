<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cadastro | Consultoria Coniança</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=$baseUrl?>app/dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
        <div class='col-12 text-center'>
            <h3 style="font-size: 1.9rem;">Consultoria <b>Confiança</b></h3>
        </div>
        <div class='col-12 text-center' style="margin-top:-10px !important">
            <span class="badge bg-danger" style="font-size:12px !important">Área do administrador</span>
        </div>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Registre um novo membro</p>

      <form method="post" id="regForm">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Código do Admin">
          <div class="input-group-append">
            <div class="input-group-text">
                <i class="fas fa-key"></i>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <input type="text" name="name" aria-label="Nome" placeholder="Nome" class="form-control">
            <input type="text" name="lastName" aria-label="Sobrenome" placeholder="Sobrenome" class="form-control">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="retypePassword" class="form-control" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Registrar</button>
            </div>
        </div>
      </form>

      <a href="<?=$baseUrl?>login" class="text-center mt-2">Já sou um membro</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<input type="hidden" value="<?=$baseUrl?>" id="burl">

<!-- jQuery -->
<script src="<?=$baseUrl?>app/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=$baseUrl?>app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=$baseUrl?>app/dist/js/adminlte.min.js"></script>
<script src="<?=$baseUrl?>app/assets/js/cadastro.js"></script>
</body>
</html>
