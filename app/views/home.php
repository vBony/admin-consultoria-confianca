<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | Consultoria Confiança</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=$baseUrl?>app/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?=$baseUrl?>app/plugins/summernote/summernote-bs4.min.css">

  <link rel="stylesheet" href="<?=$baseUrl?>app/assets/css/home.css">

  <script src="https://unpkg.com/vue@3"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">

  
<div class="wrapper" id="app" v-cloak>
  <div class="loading w-100 h-100" v-if="loading == true">
    <div class="spinner-border text-white" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  
    <div class="text-white fs-4">Carregando...</div>
  </div>
  
	<header id="header" class="header-transparent">
        <?php $this->loadTemplate($templateData); ?>
    </header>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Dashboard</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Início</a></li>
					<li class="breadcrumb-item active">Dashboard</li>
				</ol>
			</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3 v-if="loadingDataDashboard">...</h3>
                <h3 v-else>{{acessos.total ?? 0}}</h3>

                <p>Acessos (total)</p>
              </div>
              <div class="icon">
                <!-- <i class="ion ion-bag"></i> -->
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3 v-if="loadingDataDashboard">...</h3>
                <h3 v-else>{{solicitacoes.atendidas ?? 0}}</h3>

                <p>Atendidas</p>
              </div>
              <div class="icon">
                <!-- <i class="ion ion-stats-bars"></i> -->
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 v-if="loadingDataDashboard">...</h3>
                <h3 v-else>{{solicitacoes.pendentes ?? 0}}</h3>

                <p>Aguardando Atendimento</p>
              </div>
              <div class="icon">
                <!-- <i class="ion ion-person-add"></i> -->
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3 v-if="loadingDataDashboard">...</h3>
                <h3 v-else>{{solicitacoes.reprovadas ?? 0}}</h3>

                <p>Reprovadas</p>
              </div>
              <div class="icon">
                <!-- <i class="ion ion-pie-graph"></i> -->
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Acessos
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart"
                       style="position: relative; height: 300px;">
                      <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                   </div>
                  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                  </div>
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->

			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Últimas Mensagens</h3>

					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse">
							<i class="fas fa-minus"></i>
						</button>
						<button type="button" class="btn btn-tool" data-card-widget="remove">
							<i class="fas fa-times"></i>
						</button>
					</div>
				</div>
              	<!-- /.card-header -->
				<div class="card-body p-0">
					<ul class="products-list product-list-in-card pl-2 pr-2">
						<li class="item" v-for="solicitacao in solicitacoes.ultimasSolicitacoes" :key="solicitacao.createdAt">
							<div class="product-img">
								<i v-if="solicitacao.tipoSolicitacao == 1" class="fas fa-dollar-sign"></i>
								<i v-if="solicitacao.tipoSolicitacao == 2"  class="far fa-envelope"></i>
							</div>
							<div class="product-info">
								<a :href="'<?=$baseUrl?>solicitacao/'+solicitacao.id" target="_blank" class="product-title">
									{{solicitacao.nome}} <span class="text-muted ms-2">{{solicitacao.eCreatedAt}}</span>
									<span class="badge badge-warning float-right" v-if="solicitacao.statusAdmin == 0">Aguardando</span>
                  					<span class="badge badge-info float-right" v-if="solicitacao.statusAdmin == 1">Em Atendimento</span>
                 					<span class="badge badge-success float-right" v-if="solicitacao.statusAdmin == 2">Atendido</span>
									<span class="badge badge-danger float-right" v-if="solicitacao.statusAdmin == 3">Reprovado</span>
								</a>
								<span class="product-description">
									{{solicitacao.observacao != '' ? solicitacao.observacao : 'Nenhuma mensagem enviada'}}
								</span>
								<div class="product-subinfo">
									<span class="product-type">{{solicitacao.tipoSolicitacaoDescricao}}</span>
									<div v-if="solicitacao.valorImovel > 0" class="product-si-divider"></div>
									<span v-if="solicitacao.valorImovel > 0" class="product-amount">R${{solicitacao.valorImovel}}</span>
								</div>
							</div>
						</li>
					</ul>
				</div>
              <!-- /.card-body -->
				<div class="card-footer text-center">
					<a href="<?=$baseUrl?>solicitacoes" target="_blank" class="uppercase">Ver todas as mensagens</a>
				</div>
              <!-- /.card-footer -->
            </div>
			
				<!--/.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

            <!-- Map card -->
            <div class="card bg-gradient-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-map-marker-alt mr-1"></i>
                  Visitantes
                </h3>
              </div>
              <div class="card-body">
                <div id="world-map" style="height: 250px; width: 100%;"></div>
              </div>
            </div>
            <!-- /.card -->
           

            <!-- Calendar -->
            <div class="card bg-gradient-success">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendário
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                  <!-- button with a dropdown -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                      <i class="fas fa-bars"></i>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a href="#" class="dropdown-item">Adicionar novo evento</a>
                      <a href="#" class="dropdown-item">Limpar eventos</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">Ver calendário</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Últimos membros</h3>

					<div class="card-tools">
						<span class="badge badge-danger">{{membros.totalMembros}} Membros</span>
						<button type="button" class="btn btn-tool" data-card-widget="collapse">
							<i class="fas fa-minus"></i>
						</button>
						<button type="button" class="btn btn-tool" data-card-widget="remove">
							<i class="fas fa-times"></i>
						</button>
					</div>
				</div>
				<!-- /.card-header -->
				<div class="card-body p-0">
					<ul class="users-list clearfix">
						<li v-for="membro in membros.membros" :key="membro.id">
							<div class="new-users-avatar">
								<img :src="membro.urlAvatar" alt="User Image">
							</div>
							<a class="users-list-name" target="_blank" :href="'<?=$baseUrl?>usuario/perfil/' + membro.id">{{membro.name + ' ' + membro.lastName}}</a>
							<span class="users-list-date">{{membro.createdAtFormatted}}</span>
						</li>
					</ul>
					<!-- /.users-list -->
				</div>
				<!-- /.card-body -->
				<div class="card-footer text-center">
				<a href="javascript:">Ver todos</a>
				</div>
				<!-- /.card-footer -->
			</div>

          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<input type="hidden" value="<?=$baseUrl?>" id="burl">

<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?=$baseUrl?>app/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=$baseUrl?>app/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?=$baseUrl?>app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?=$baseUrl?>app/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?=$baseUrl?>app/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?=$baseUrl?>app/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?=$baseUrl?>app/plugins/jqvmap/maps/jquery.vmap.world.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?=$baseUrl?>app/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?=$baseUrl?>app/plugins/moment/moment.min.js"></script>
<script src="<?=$baseUrl?>app/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=$baseUrl?>app/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?=$baseUrl?>app/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=$baseUrl?>app/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=$baseUrl?>app/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=$baseUrl?>app/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=$baseUrl?>app/dist/js/pages/dashboard.js"></script>

<script src="<?=$baseUrl?>app/assets/js/home.js"></script>
<script src="<?=$baseUrl?>app/assets/js/template.js"></script>
</body>
</html>
