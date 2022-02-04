<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>

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
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<div class="loading w-100 h-100">
	<div class="spinner-border text-white" role="status">
		<span class="sr-only">Loading...</span>
	</div>

	<div class="text-white fs-4">Carregando...</div>
</div>

<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img id="logo-loading" src="<?=$baseUrl?>app/assets/imgs/app/logo.jfif" alt="Consultoria Confiança" height="300" width="300">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Início</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
	  <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">10</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">10 notificações</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 novas mensagens
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
		  	<i class="fas fa-exclamation-triangle mr-2"></i>
			3 novos avisos
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 
			3 novos relatórios
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">Ver tudo</a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
		<img src="<?=$baseUrl?>app/assets/imgs/app/logo-mini-menu.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8; object-fit:cover;">
		<span class="brand-text font-weight-light">Consultoria Confiança</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image" id="avatar-menu">
          <img src="<?=$user['urlAvatar']?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?=$user['name'] . ' ' . $user['lastName']?></a>
        </div>
      </div>

	<!-- Sidebar Menu -->
	<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column h-100" data-widget="treeview" role="menu" data-accordion="false">
          	<!-- Add icons to the links using the .nav-icon class
			with font-awesome or any other icon font library -->
			<li class="nav-item">
				<a href="<?=$baseUrl?>" class="nav-link active">
					<i class="nav-icon fas fa-tachometer-alt"></i>
					<p>
						Dashboard
					</p>
				</a>

				<a href="#" id="logout-btn" class="nav-link align-self-baseline">
					<i class="nav-icon fas fa-sign-out-alt"></i>
					<p>
						Sair
					</p>
				</a>
			</li>
        </ul>
	</nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

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
                <h3>150</h3>

                <p>Lorem</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Lorem</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>

                <p>Lorem</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Lorem</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
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
						<li class="item">
							<div class="product-img">
								<i class="fas fa-dollar-sign"></i>
							</div>
							<div class="product-info">
								<a href="javascript:void(0)" class="product-title">
									Luciano Ferreira <span class="text-muted ms-2">15h</span>
									<span class="badge badge-warning float-right">Aguardando</span>
								</a>
								<span class="product-description">
									Posso dividir o valor do financiamento com outra pessoa? Estou perguntando porque meu amigo quer me ajudar a pagar
								</span>
								<div class="product-subinfo">
									<span class="product-type">Simulação</span>
									<div class="product-si-divider"></div>
									<span class="product-amount">R$200.000,00</span>
								</div>
							</div>
						</li>
						<!-- /.item -->
						<li class="item">
							<div class="product-img">
								<i class="fas fa-dollar-sign"></i>
							</div>
							<div class="product-info">
								<a href="javascript:void(0)" class="product-title">
									Valdemir Santos <span class="text-muted ms-2">1d</span>
									<span class="badge badge-info float-right">Em Atendimento</span>
								</a>
								<span class="product-description">
									Queria poder financiar o valor em mais vezes porque estou desempregado e ganho pouco
								</span>
								<div class="product-subinfo">
									<span class="product-type">Simulação</span>
									<div class="product-si-divider"></div>
									<span class="product-amount">R$50.000,00</span>
								</div>
							</div>
						</li>
						<!-- /.item -->
						<li class="item">
							<div class="product-img">
								<i class="far fa-envelope"></i>
							</div>
							<div class="product-info">
								<a href="javascript:void(0)" class="product-title">
									Luciana Aparecida <span class="text-muted ms-2">2d</span>
									<span class="badge badge-danger float-right">Spam</span>
								</a>
								<span class="product-description">
									Não tenho nada de útil para enviar, então estou escrevendo qualquer coisa para irrita-los
								</span>
								<div class="product-subinfo">
									<span class="product-type">Contato</span>
									<span class="product-amount"></span>
								</div>
							</div>
						</li>
						<!-- /.item -->
						<li class="item">
							<div class="product-img">
								<i class="far fa-envelope"></i>
							</div>
							<div class="product-info">
								<a href="javascript:void(0)" class="product-title">
									Bianca Eduarda <span class="text-muted ms-2">14d</span>
									<span class="badge badge-success float-right">Atendido</span>
								</a>
								<span class="product-description">
									Bom dia, tenho interesse em fazer um empréstimo para comprar uma casa nova, mas estou com o nome sujo
								</span>
								<div class="product-subinfo">
									<span class="product-type">Contato</span>
									<span class="product-amount"></span>
								</div>
							</div>
						</li>
					<!-- /.item -->
					</ul>
				</div>
              <!-- /.card-body -->
              <div class="card-footer text-center">
                <a href="javascript:void(0)" class="uppercase">Ver todas as mensagens</a>
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
                <!-- card tools -->
                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                    <i class="far fa-calendar-alt"></i>
                  </button>
                  <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
                <div id="world-map" style="height: 250px; width: 100%;"></div>
              </div>
              <!-- /.card-body-->
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-4 text-center">
                    <div id="sparkline-1"></div>
                    <div class="text-white">Visitantes</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-2"></div>
                    <div class="text-white">Mensagens</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-3"></div>
                    <div class="text-white">Lorem</div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
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
						<span class="badge badge-danger">8 Membros novos</span>
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
						<li>
							<div class="new-users-avatar">
								<img src="<?=$baseUrl?>app/assets/imgs/avatar/default.png" alt="User Image">
							</div>
							<a class="users-list-name" href="#">Lorem Lorem</a>
							<span class="users-list-date">Hoje</span>
						</li>
						<li>
							<div class="new-users-avatar">
								<img src="<?=$baseUrl?>app/assets/imgs/avatar/default.png" alt="User Image">
							</div>
							<a class="users-list-name" href="#">Lorem Lorem</a>
							<span class="users-list-date">Ontem</span>
						</li>
						<li>
							<div class="new-users-avatar">
								<img src="<?=$baseUrl?>app/assets/imgs/avatar/default.png" alt="User Image">
							</div>
							<a class="users-list-name" href="#">Lorem Lorem</a>
							<span class="users-list-date">12 Jan</span>
						</li>
						<li>
							<div class="new-users-avatar">
								<img src="<?=$baseUrl?>app/assets/imgs/avatar/default.png" alt="User Image">
							</div>
							<a class="users-list-name" href="#">Lorem Lorem</a>
							<span class="users-list-date">12 Jan</span>
						</li>
						<li>
							<div class="new-users-avatar">
								<img src="<?=$baseUrl?>app/assets/imgs/avatar/default.png" alt="User Image">
							</div>
							<a class="users-list-name" href="#">Lorem Lorem</a>
							<span class="users-list-date">13 Jan</span>
						</li>
						<li>
							<div class="new-users-avatar">
								<img src="<?=$baseUrl?>app/assets/imgs/avatar/default.png" alt="User Image">
							</div>
							<a class="users-list-name" href="#">Lorem Lorem</a>
							<span class="users-list-date">14 Jan</span>
						</li>
						<li>
							<div class="new-users-avatar">
								<img src="<?=$baseUrl?>app/assets/imgs/avatar/default.png" alt="User Image">
							</div>
							<a class="users-list-name" href="#">Lorem Lorem</a>
							<span class="users-list-date">15 Jan</span>
						</li>
						<li>
							<div class="new-users-avatar">
								<img src="<?=$baseUrl?>app/assets/imgs/avatar/default.png" alt="User Image">
							</div>
							<a class="users-list-name" href="#">Lorem Lorem</a>
							<span class="users-list-date">15 Jan</span>
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
<script src="<?=$baseUrl?>app/plugins/jqvmap/maps/jquery.vmap.brazil.js"></script>
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
</body>
</html>
