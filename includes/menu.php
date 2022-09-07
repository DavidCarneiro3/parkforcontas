<div class="col-sm-3">
				<div class="sidebar-nav">
					<div class="navbar navbar-default" role="navigation">
						<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<span class="visible-xs navbar-brand">Menu</span>
						</div>
						<div class="navbar-collapse collapse sidebar-navbar-collapse">
						<div class="logo-nav">
							<a href="index.php"><img class="logo-img" src="images/parkbg.png" alt=""/></a>
						</div>
							<ul class="nav navbar-nav">
								<li><a href="index.php" class="active"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
                                <?php if($_SESSION['grupo'] != 45 && $_SESSION['grupo'] != 46){ ?>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-building-o" aria-hidden="true"></i> Empresas <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="insert_emp.php">Inserir</a></li>
										<li><a href="busca_emp.php">Consultar/Editar</a></li> 
										<!-- <li><a href="#">Something else here</a></li>
										<li class="divider"></li>
										<li class="dropdown-header">Nav header</li>
										<li><a href="#">Separated link</a></li>
										<li><a href="#">One more separated link</a></li> -->
									</ul>
								</li>
                                <?php } ?>
                                <?php if($_SESSION['grupo'] != 45 && $_SESSION['grupo'] != 46){ ?>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-truck" aria-hidden="true"></i> Fornecedores <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="insert_forne.php">Inserir</a></li>
										<li><a href="busca_forn.php">Consultar/Editar</a></li>
										<!-- <li><a href="#">Something else here</a></li>
										<li class="divider"></li>
										<li class="dropdown-header">Nav header</li>
										<li><a href="#">Separated link</a></li>
										<li><a href="#">One more separated link</a></li> -->
									</ul>
								</li>
                                <?php } ?>
                                <?php if($_SESSION['grupo'] != 45 && $_SESSION['grupo'] != 46){ ?>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users" aria-hidden="true"></i> Clientes<b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="insert_cli.php">Inserir</a></li>
										<li><a href="busca_cli.php">Consultar/Editar</a></li>
										<!-- <li><a href="#">Something else here</a></li>
										<li class="divider"></li>
										<li class="dropdown-header">Nav header</li>
										<li><a href="#">Separated link</a></li>
										<li><a href="#">One more separated link</a></li> -->
									</ul>
								</li>
                                <?php } ?>
								<!-- <li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-usd" aria-hidden="true"></i> Centro de Custos<b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="insert_cent.php">Inserir</a></li>
										<li><a href="busca_cent.php">Consultar/Editar</a></li>
										<li><a href="#">Something else here</a></li>
										<li class="divider"></li>
										<li class="dropdown-header">Nav header</li>
										<li><a href="#">Separated link</a></li>
										<li><a href="#">One more separated link</a></li>
									</ul>
								</li> -->
                                <?php if($_SESSION['grupo'] != 45 || $_SESSION['grupo'] == 46){ ?>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-share" aria-hidden="true"></i> Contas a Receber <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="insert_cntrec.php">Inserir</a></li>
										<li><a href="busca_cntrec.php">Consultar/Editar</a></li>
										<li><a href="insert_frmrec.php">Inserir Forma de Recebimento</a></li>
										<li><a href="busca_frmrec.php">Consultar/Editar Forma de Recebimento</a></li>
                                        <?php if($_SESSION['nivel'] == 3){ ?>
										<li><a href="insert_centrec.php">Inserir Centro de Custo</a></li>
										<li><a href="busca_cenrec.php">Consultar/Editar Centro de Custo</a></li>
                                        <?php } ?>
										<?php if($_SESSION['grupo'] == 10 || $_SESSION['grupo'] == 11|| $_SESSION['grupo'] == 42){ ?>
										<li><a href="busca_boletos.php">Consultar Boletos</a></li>
										<?php } ?>
										<!-- <li><a href="#">Something else here</a></li>
										<li class="divider"></li>
										<li class="dropdown-header">Nav header</li>
										<li><a href="#">Separated link</a></li>
										<li><a href="#">One more separated link</a></li> -->
									</ul>
								</li>
                                <?php } ?>
                                <?php if($_SESSION['grupo'] == 45 || $_SESSION['grupo'] != 46){ ?>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-reply" aria-hidden="true"></i> Contas a Pagar <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="insert_cntpag.php">Inserir</a></li>
										<li><a href="busca_cntpag.php">Consultar/Editar</a></li>
                                        <?php if($_SESSION['nivel'] == 3){ ?>
										<li><a href="insert_cent.php">Inserir Centro de Custo</a></li>
										<li><a href="busca_cent.php">Consultar/Editar Centro de Custo</a></li>
                                        <?php } ?>
										<li><a href="insert_frmpag.php">Inserir Forma de Pagamento</a></li>
										<li><a href="busca_frmpag.php">Consultar/Editar Forma de Pagamento</a></li>
										<li><a href="busca_cntpag_exc.php">Consultar Contas a Pagar Excluidas</a></li>
										<!-- <li><a href="#">Something else here</a></li>
										<li class="divider"></li>
										<li class="dropdown-header">Nav header</li>
										<li><a href="#">Separated link</a></li>
										<li><a href="#">One more separated link</a></li> -->
									</ul>
								</li>
                                <?php } ?>
                                <?php if($_SESSION['grupo'] != 45 && $_SESSION['grupo'] != 46){ ?>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-file-text" aria-hidden="true"></i> Documentos <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="insert_doc.php">Inserir</a></li>
										<li><a href="busca_doc.php">Consultar/Editar</a></li>
										<li><a href="insert_tip_doc.php">Inserir Tipo de Documento</a></li>
										<li><a href="busca_tip_doc.php">Consultar/Editar Tipo de Documento</a></li>
										<!-- <li><a href="#">Something else here</a></li>
										<li class="divider"></li>
										<li class="dropdown-header">Nav header</li>
										<li><a href="#">Separated link</a></li>
										<li><a href="#">One more separated link</a></li> -->
									</ul>
								</li>
                                <?php } ?>
                                <?php if($_SESSION['grupo'] != 45 && $_SESSION['grupo'] != 46){ ?>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bar-chart-o" aria-hidden="true"></i> Relatórios<b class="caret"></b></a>
									<ul class="dropdown-menu">
										<!-- <li><a href="rel_cntrece.php">Contas a Receber</a></li> -->
										<li><a href="rel_cntpag.php">Contas a Pagar</a></li>
										<li><a href="faturamento.php">Faturamento</a></li>
										<!-- <li><a href="#">Something else here</a></li>
										<li class="divider"></li>
										<li class="dropdown-header">Nav header</li>
										<li><a href="#">Separated link</a></li>
										<li><a href="#">One more separated link</a></li> -->
									</ul>
								</li>
                                <?php } ?>
                                
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog" aria-hidden="true"></i> Gerencial <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="meus_dados.php">Meus Dados</a></li>
										<?php if($_SESSION['nivel'] == 3){ ?>
										<li><a href="insert_user.php">Cadastrar Usuário</a></li>
										<li><a href="busca_user.php">Caonsultar/Editar Usuário</a></li>
										<li><a href="log.php">Log do Sistema</a></li>
										<?php } ?>
										<li><a href="out.php">Sair do Sistema</a></li>
										<!-- <li><a href="#">Something else here</a></li>
										<li class="divider"></li>
										<li class="dropdown-header">Nav header</li>
										<li><a href="#">Separated link</a></li>
										<li><a href="#">One more separated link</a></li> -->
									</ul>
								</li>
								<!-- <li><a href="#">Menu Item 4</a></li>
								<li><a href="#">Reviews <span class="badge">1,118</span></a></li> -->
							</ul>
						</div><!--/.nav-collapse -->
					</div>
				</div>
			</div>