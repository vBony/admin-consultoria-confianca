

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | Consultoria Confiança</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/assets/css/usuario.css">
    <script src="<?=$baseUrl?>app/plugins/jquery/jquery.min.js"></script>
    <script src="<?=$baseUrl?>app/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?=$baseUrl?>app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?=$baseUrl?>app/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://unpkg.com/vue@3"></script>
    <script src="<?=$baseUrl?>app/dist/js/adminlte.js"></script>
    <script src="<?=$baseUrl?>app/assets/js/template.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper" id="app">
    <header id="header" class="header-transparent">
        <?php $this->loadTemplate($templateData); ?>
    </header>

    <div class="loading w-100 h-100" v-show="loading == 1">
        <div class="spinner-border text-white" role="status">
            <span class="sr-only">Loading...</span>
        </div>

        <div class="text-white fs-4">Carregando...</div>
    </div>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Usuários</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=$baseUrl?>">Início</a></li>
                        <li class="breadcrumb-item active">Usuários</li>
                    </ol>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Criar código de cadastro</h3>
                            </div>
        
                            <form>
                                <div class="card-body row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="col-12 p-4 border mb-4">
                                            <div class="row">
                                                <div class="col-9">
                                                    <div class="form-group">
                                                        <label>Cargo</label>
                                                        <select class="form-control" v-model="idCargo" v-bind:class="{ 'is-invalid': messages.cargo }" @change="messages.cargo = ''">
                                                            <option value="0">Selecione</option>
                                                            <?php foreach($listas['cargos'] as $cargos): ?>
                                                                <option value="<?=$cargos['id']?>"><?=$cargos['name']?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <div class="invalid-feedback">{{messages.cargo}}</div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label>&nbsp;</label>
                                                        <button class="form-control btn btn-success" @click.stop.prevent="gerarCodigo"> Gerar </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-12" v-show="idCargo != 0">
                                            <div class="info-box bg-info bg-light">
                                                <div class="info-box-content">
                                                    <span class="info-box-text"> <b> Permissões </b></span>
                                                    <ul class="text-muted" v-if="idCargo == 1">
                                                        <li>Acesso a todas as estatísticas</li>
                                                        <li>Responder contatos</li>
                                                        <li>Avaliar simulações</li>
                                                        <li>Responder simulações</li>
                                                    </ul>
                                                    <ul class="text-muted" v-if="idCargo == 2">
                                                        <li>Responder contatos</li>
                                                        <li>Avaliar simulações</li>
                                                        <li>Responder simulações</li>
                                                    </ul>
                                                    <ul class="text-muted" v-if="idCargo == 3">
                                                        <li>Responder contatos</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Código</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" disabled v-model="codigo" aria-label="Código de cadastro" aria-describedby="basic-addon2">
                                                <div class="input-group-append" >
                                                    <div class="input-group-text" id="basic-addon2"><span class="btn btn-success badge">copiar</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Códigos disponíveis</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body p-0 table-responsive">
                                                <table class="table table-striped" v-if="codigos">
                                                    <thead>
                                                        <tr>
                                                            <th>Código</th>
                                                            <th>Cargo</th>
                                                            <th>Vence em</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="codigo in codigos" :key="codigo.id">
                                                            <td><span class="badge bg-info">{{codigo.token}}</span></td>
                                                            <td>
                                                                {{codigo.nomeHierarchy}}
                                                            </td>
                                                            <td>{{codigo.restanteVencimento}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="text-center py-3" v-if="!codigos">
                                                    <p class="text-muted"> Nenhum código disponível </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<input type="hidden" id="baseUrl" value="<?=$baseUrl?>">
<script src="<?=$baseUrl?>app/assets/js/usuario.js"></script>
</body>
</html>
