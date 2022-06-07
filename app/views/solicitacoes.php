

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Solicitações | Consultoria Confiança</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/assets/css/solicitacoes.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/assets/css/normalize.css">
    <script src="<?=$baseUrl?>app/plugins/jquery/jquery.min.js"></script>
    <script src="<?=$baseUrl?>app/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?=$baseUrl?>app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?=$baseUrl?>app/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
                    <h1 class="m-0">Solicitações</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=$baseUrl?>">Início</a></li>
                        <li class="breadcrumb-item active">Solicitações</li>
                    </ol>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Filtros</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div id="accordion">
                                    <ul class="nav nav-pills flex-column">
                                        <li class="nav-item active">
                                            <a href="#" class="nav-link main-nav-item d-flex align-items-center" @click="setMinhasSolicitacoes()">
                                                <i class="fas fa-user mr-2"></i> 
                                                Minhas avaliações
                                                <span class="badge badge-info ml-auto">{{minhasSolicitacoes}}</span>
                                            </a>
                                        </li>

                                        <li class="nav-item active" id="headTipoSolicitacao">
                                            <a href="#" class="nav-link main-nav-item d-flex align-items-center" data-toggle="collapse" data-target="#collapseTipoSolicitacao" aria-expanded="true" aria-controls="collapseTipoSolicitacao">
                                                <i class="fas fa-clipboard-list mr-2"></i> 
                                                Status
                                                <i class="fas fa-angle-down ml-auto"></i>
                                            </a>

                                            <ul class="collapse-filtro collapse" id="collapseTipoSolicitacao" aria-labelledby="headTipoSolicitacao" data-parent="#accordion">
                                                <li class="nav-item active" v-for="(status, id) in listaStatus">
                                                    <a href="#" class="nav-link" data-id="id">
                                                        <label><input type="checkbox" class="mr-2" @change="addStatus(id)">{{status}}</label>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Solicitações</h3>

                                <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped table-responsive projects">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%">
                                                Nome
                                            </th>
                                            <th style="width: 10%" class="text-center">
                                                Responsável
                                            </th>
                                            <th style="width: 10%" class="text-center">
                                                Status
                                            </th>
                                            <th style="width: 20%">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="solicitacao in solicitacoes" :key="solicitacao.id">
                                            <td>
                                                <a>
                                                    {{solicitacao.nome}}
                                                </a>
                                                <br/>
                                                <small class="text-muted">
                                                    <b>
                                                        {{solicitacao.createdAt}}
                                                    </b>
                                                </small>
                                            </td>
                                            <td class="avatar-responsavel text-center admin-data" v-show="solicitacao.idAdmin > 0">
                                                <img :src="solicitacao.admin.urlAvatar" class="img-circle elevation-2" alt="User Image" :title="solicitacao.admin.name" data-trigger="hover" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?">
                                                <span class="name-admin" v-if="solicitacao.idAdmin == idAdmin">(Você)</span>
                                                <span class="name-admin" v-else>{{solicitacao.admin.name}}</span>
                                            </td>
                                            <td class="avatar-responsavel text-center" v-show="solicitacao.idAdmin == 0">
                                                <b>-</b>
                                            </td>
                                            <td class="project-state">
                                                <span class="badge badge-warning" v-if="solicitacao.statusAdmin == 0">Aguardando</span>
                                                <span class="badge badge-info" v-if="solicitacao.statusAdmin == 1">Em Atendimento</span>
                                                <span class="badge badge-success" v-if="solicitacao.statusAdmin == 2">Atendido</span>
                                                <span class="badge badge-danger" v-if="solicitacao.statusAdmin == 3">Reprovado</span>
                                            </td>
                                            <td class="project-actions text-right">
                                                <a class="btn btn-primary btn-sm" :href="'<?=$baseUrl?>solicitacao/'+solicitacao.id" target="_blank" v-if="solicitacao.idAdmin == idAdmin">
                                                    <i class="fas fa-reply"></i>
                                                </a>

                                                <a class="btn btn-secondary btn-sm" :href="'<?=$baseUrl?>solicitacao/'+solicitacao.id" target="_blank" v-else-if="solicitacao.statusAdmin == 1 || solicitacao.statusAdmin == 2 && solicitacao.idAdmin != idAdmin">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <a class="btn btn-success btn-sm" :href="'<?=$baseUrl?>solicitacao/'+solicitacao.id" target="_blank" v-else>
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<input type="hidden" id="baseUrl" value="<?=$baseUrl?>">
<script src="<?=$baseUrl?>app/assets/js/solicitacoes.js"></script>
</body>
</html>
