<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Consultoria Confiança</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="my-4">
        <div class='col-12 text-center'>
            <h3 style="font-size: 2.1rem;">Consultoria <b>Confiança</b></h3>
        </div>
        <div class='col-12 text-center' style="margin-top:-10px !important">
            <span class="badge bg-danger" style="font-size:15px !important">Área do administrador</span>
        </div>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <form action="<?=$baseUrl?>app/index3.html" method="post">
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Senha">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                        <a id="submitBtn" class="btn btn-primary btn-block">Requisicao</a>
                    </div>
                </div>
            </form>

            <p class="mb-1 mt-2">
                <a href="forgot-password.html">Esqueci minha senha</a>
            </p>
            <p class="mb-0">
                <a href="<?=$baseUrl?>cadastro" class="text-center">Registrar um novo membro</a>
            </p>
        </div>
    </div>
</div>

<script src="<?=$baseUrl?>app/plugins/jquery/jquery.min.js"></script>
<script src="<?=$baseUrl?>app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=$baseUrl?>app/dist/js/adminlte.min.js"></script>
<script src="<?=$baseUrl?>app/assets/js/login.js"></script>
</body>
</html>
