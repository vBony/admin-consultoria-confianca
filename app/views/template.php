
<input type="hidden" id="path" value="<?=$path?>">

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
					<a href="<?=$baseUrl?>" class="nav-link" data-id='dashboard'>
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashboard
						</p>
					</a>

					<li class="nav-item">
						<a href="<?=$baseUrl?>usuario" class="nav-link" data-id="usuarios">
							<i class="fas fa-user nav-icon"></i>
							<p>Usuários</p>
						</a>
					</li>

                    <li class="nav-item">
						<a href="<?=$baseUrl?>solicitacoes" class="nav-link" data-id="solicitacoes">
                            <i class="fas fa-clipboard-list  nav-icon"></i>
							<p>Solicitações</p>
						</a>
					</li>

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