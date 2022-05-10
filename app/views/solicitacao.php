

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atender Solicitação | Consultoria Confiança</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/assets/css/solicitacao.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/assets/css/normalize.css">
    <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/summernote/summernote-bs4.min.css">
    <script src="<?=$baseUrl?>app/plugins/jquery/jquery.min.js"></script>
    <script src="<?=$baseUrl?>app/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?=$baseUrl?>app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?=$baseUrl?>app/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/vue@3"></script>
    <link rel="stylesheet" href=".<?=$baseUrl?>app/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <h1 class="m-0">Atender Solicitação</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=$baseUrl?>">Início</a></li>
                        <li class="breadcrumb-item"><a href="<?=$baseUrl?>solicitacoes">Solicitações</a></li>
                        <li class="breadcrumb-item active">Atender Solicitação</li>
                    </ol>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card ">
                            <div class="card-header d-flex flex-row align-items-center flex-wrap">
                                <h3 class="card-title">Status da Avaliação</h3>
                                <div class="ml-lg-auto ml-md-auto ml-sm-0 d-flex align-items-center">
                                    <span class="badge badge-warning" v-if="solicitacao.statusAdmin == 0">Aguardando</span>
                                    <span class="badge badge-info" v-if="solicitacao.statusAdmin == 1">Em Atendimento</span>
                                    <span class="badge badge-success" v-if="solicitacao.statusAdmin == 2">Atendido</span>
                                    <span class="badge badge-danger" v-if="solicitacao.statusAdmin == 3">Reprovado</span>
                                </div>
                            </div>

                            <div class="card-body" v-if="solicitacao.idAdmin == 0">
                                <div class="loading loading-statusAvaliacao" v-show="loadingStatusAvaliacao == true">
                                    <div class="spinner-border text-white" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>

                                <div class="alert alert-info" role="alert">
                                    <h6><i class="fas fa-info-circle me-2"></i> Atenção</h6>
                                    <p class="fs-12">
                                        Para avaliar a solicitação e contatar o cliente é necessário ser um avaliador. Se deseja torna-se um,
                                        e ser responsável pela aprovação/reprovação, clique no botão abaixo
                                    </p>
                                </div>

                                <div class="text-center">
                                    <button class="btn btn-success" @click="tornarAvaliador()">Tornar-se avaliador</button>
                                </div>
                            </div>

                            <div class="card-body" v-if="solicitacao.idAdmin > 0">
                                <div class="alert alert-info" role="alert" v-if="idAdmin != solicitacao.idAdmin">
                                    <h6><i class="fas fa-info-circle me-2"></i> Atenção</h6>
                                    <p class="fs-12">
                                        Você não possui cargo e não é avaliador dessa solicitação. Por isso, não é possivel
                                        Aprovar/Reprovar ou entrar em contato com o cliente.
                                    </p>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Avaliador</label>
                                            <input type="text" class="form-control" placeholder="Nome" :value="idAdmin == solicitacao.idAdmin ? solicitacao.admin.name + ' (Você)' : solicitacao.admin.name" readonly="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Formas de contato</label>
                                            <button type="button" class="btn btn-block btn-success btn-sm" :disabled="idAdmin != solicitacao.idAdmin" data-toggle="modal" data-target="#modalMensagemWhatsapp">
                                                <i class="fab fa-whatsapp mr-1"></i>
                                                Whatsapp
                                            </button>    

                                            <button type="button" class="btn btn-block btn-info btn-sm" :disabled="idAdmin != solicitacao.idAdmin" data-toggle="modal" data-target="#modalEmail">
                                                <i class="fas fa-envelope mr-1"></i>
                                                E-mail
                                            </button>

                                            <button type="button" class="btn btn-block btn-secondary btn-sm" :disabled="idAdmin != solicitacao.idAdmin" data-toggle="modal" data-target="#modalLigacao" @click="getTelefone()">
                                                <i class="fas fa-phone-alt mr-1"></i>
                                                Ligação
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Alterar Status</label>

                                            <div class="row">
                                                <div class="col-6 text-center">
                                                    <button type="button" class="btn btn-block btn-danger btn-sm" :disabled="idAdmin != solicitacao.idAdmin">
                                                        <i class="fas fa-times"></i>
                                                        Reprovar
                                                    </button>
                                                </div>
                                                <div class="col-6 text-center">
                                                    <button type="button" class="btn btn-block btn-success btn-sm" :disabled="idAdmin != solicitacao.idAdmin">
                                                        <i class="fas fa-check"></i>
                                                        Aprovar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center" v-if="solicitacao.idAdmin == 0">
                                    <button class="btn btn-success">Tornar-se avaliador</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex flex-row align-items-center flex-wrap">
                                <h3 class="card-title">Solicitação n° {{solicitacao.id}}</h3>
                                <span class="card-title text-muted createdAtTxt ml-lg-auto ml-md-auto ml-sm-0">Solicitado em {{solicitacao.createdAt}}</span>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" class="form-control" placeholder="Nome" :value="solicitacao.nome" readonly="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>CPF</label>
                                            <input type="text" class="form-control" placeholder="CPF" :value="solicitacao.cpf" readonly="true">
                                        </div>
                                    </div>
    
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>CPF Cônjuge</label>
                                            <input type="text" class="form-control" placeholder="CFP Cônjuge" :value="solicitacao.cpfConjuge" readonly="true">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-12">
                                        <div class="form-group">
                                            <label>Tipo de imóvel</label>
                                            <select class="form-control" :value="solicitacao.idTipoImovel" readonly="true" disabled>
                                                <option v-for="tipoImovel in listas.tiposImovel" :key="tipoImovel.id" :value="tipoImovel.id">{{tipoImovel.descricao}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select class="form-control" :value="solicitacao.idEstadoImovel" readonly="true" disabled >
                                                <option v-for="estado in listas.estados" :key="estado.id" :value="estado.id">{{estado.nome}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Valor do imóvel</label>
                                            <input type="text" class="form-control" placeholder="Valor do imóvel" :value="solicitacao.valorImovel" readonly="true">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Valor do Finan.</label>
                                            <input type="text" class="form-control" placeholder="Valor do financiamento" :value="solicitacao.valorFinanciamento" readonly="true">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Prazo Finan.</label>
                                            <input type="text" class="form-control" placeholder="Prazo do Financiamento" :value="solicitacao.prazoFinanciamento" readonly="true">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Observação</label>
                                            <textarea class="form-control" rows="3" placeholder="Observação" readonly="true" :value="solicitacao.observacao"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="modalMensagemWhatsapp" tabindex="-1" role="dialog" aria-labelledby="mmwLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mmwLabel">Enviar mensagem via WhatsApp</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Mensagem</label>
                                <textarea class="form-control" rows="3" placeholder="Digite aqui a sua mensagem" :value="mensagemWhatsapp"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-success btn-sm">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLigacao" tabindex="-1" role="dialog" aria-labelledby="ligacaoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ligacaoLabel">Entrar em contato por ligação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="overlay" v-if="loadingTelefone == true">
                        <div class="spinner-border text-white" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>

                        <div class="text-white fs-4">Carregando...</div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <h6><b> Como deseja prosseguir? </b></h6>
                                <div class="row d-flex justify-content-around mt-2">
                                    <button class="btn btn-primary mt-2" @click="ligarCliente()">
                                        <i class="fas fa-phone-alt mr-2"></i>
                                        Realizar ligação
                                    </button>
                                    <button class="btn btn-primary mt-2" @click="copiarNumeroCliente()">
                                        <i class="fas fa-clipboard mr-2"></i>
                                        Copiar número
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-success btn-sm">Enviar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEmail" tabindex="-1" role="dialog" aria-labelledby="emailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="emailLabel">Entrar em contato por E-mail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="overlay" v-if="loadingTelefone == true">
                        <div class="spinner-border text-white" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>

                        <div class="text-white fs-4">Carregando...</div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Para: </label>
                                <input type="email"  class="form-control" readonly="true" :value="solicitacao.email">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Assunto: </label>
                                <input type="text"  class="form-control" :value="'blablabla'">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <textarea class="form-control" rows="5" placeholder="Digite aqui a sua mensagem" :value="mensagemEmail"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-success btn-sm">Enviar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="baseUrl" value="<?=$baseUrl?>">
<script src="<?=$baseUrl?>app/plugins/summernote/summernote-bs4.min.js"></script>
<script type="module" src="<?=$baseUrl?>app/assets/js/solicitacao.js"></script>
<script>
  $(function () {
    //Add text editor
    $('#compose-textarea').summernote({
        height: 200
    })
  })
</script>
</body>
</html>
