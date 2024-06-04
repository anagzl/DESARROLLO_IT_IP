<?php @session_start(); ?>
<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistema Control de Personal</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="../../img/logoInstitucion/logo_sin_letras.png">

    <!-- Custom fonts for this template-->
<!--     <link href="../css/all.min.css" rel="stylesheet" type="text/css"> -->
    <link href="../../assets/fontawesome-free-6.0.0-web/css/all.css" rel="stylesheet" type="text/css"> 

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../assets/css/sb-admin-2.css" rel="stylesheet">

    <!-- Importacion de boostraps-->
    <link href="../../assets/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet">
    

    <!-- Data tables  -->
    <link  rel="stylesheet" href="../../assets/datatables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"> 

    <!-- Icons bootstrap -->
    <link rel="stylesheet" href="../../assets/bootstrap-icons-1.8.1/bootstrap-icons.css"> 


    <style type="text/css">
        #cuadro{
            width: 250%;
            height: 500px;
            }
    </style>

</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="tablero.php">
                <div class="sidebar-brand-icon ">
                    <img alt="Logo IP" width="40" height="35" src="../../img/desing/asistencia1.png">
                </div>
                <div class="sidebar-brand-text mx-3">Control de Personal</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="tablero.php">
                    <i class="bi bi-speedometer2"></i>
                    <span><strong>Tablero</strong></span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interfaz
            </div>

            <!-- Nav Item - Pages Collapse Menu Area Personal -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="bi bi-person-badge-fill"></i>
                    <span><strong>Área Personal</strong></span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Ver  </h6>
                        <a class="collapse-item" href="registrar_asistencia.php"><i class="bi bi-stopwatch-fill"></i> Marcar Asistencia</a>
                        <a class="collapse-item" href="ver_asistencia_usuario.php"><i class="bi bi-hourglass-split"></i> Bitácora De Asistencias</a>
                        <a class="collapse-item" href="ver_dias_laborados_individual.php"><i class="bi bi-calendar-week-fill"></i> Bitácora Dias Laborados</a>
                        <a class="collapse-item" href="ver_permisos_personales.php"><i class="bi bi-file-earmark-post"></i> Bitácora De Permisos</a>
                        <a class="collapse-item" href="ver_voucher_personal.php"><i class="bi bi-file-earmark-pdf-fill"></i> Bitácora De  Voucher </a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Configuracion Collapse Menu Configuracion -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="bi bi-gear-fill"></i>
                    <span><strong>Configuración</strong></span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestión</h6>
                        <a class="collapse-item" href="ver_perfil.php"><i class="bi bi-person-circle"></i> Ver Perfil Usuario</a>
                        <!-- <a class="collapse-item" href="modificar_perfil.php"><i class="bi bi-file-earmark-person-fill"></i> Editar Perfil</a> -->
<!--                         <a class="collapse-item" href="../views/user/cambiar_password.php"><i class="bi bi-key-fill"></i> Cambiar Contraseña</a> -->
                    </div>
                </div>
            </li>

            <!-- Heading -->
            <div class="sidebar-heading">
                Gestiones
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
                    aria-controls="collapsePages">
                    <i class="bi bi-folder-fill"></i>
                    <span><strong> Trámites Disponibles </strong></span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Procesos Habilitados:</h6>
                        <a class="collapse-item" href="frmLlenadoPermisos.php"><i class="bi bi-credit-card-2-front-fill"></i> Generador De Permiso <br>Para RRHH</a>
<!--                         <a class="collapse-item" href="frmLlenadoPermisos.php"><i class="bi bi-brightness-high-fill"></i> Proceso De Vacaciones</a> -->
<!--                         <a class="collapse-item" href="frmPaseDeSalida.php"><i class="bi bi-postcard"></i> Pase De Salida</a>
                        <a class="collapse-item" href="frmPaseOficial.php"><i class="bi bi-postcard-fill"></i> Pase Oficial</a> -->
                    </div>
                </div>
            </li>

            <!-- Nav Item - FAQs -->
            <li class="nav-item">
                <a class="nav-link" href="ver_faqs.php">
                    <i class="fas fa-fw fa-info-circle"></i>
                    <span><strong> FAQs </strong></span></a>
            </li>

            <!-- Nav Item - Contacto -->
            <li class="nav-item">
                <a class="nav-link" href="ver_contacto.php">
                    <i class="fas fa-fw fa-headset"></i>
                    <span><strong> Contacto </strong></span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

<!--            Sidebar Toggler (Sidebar) 
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div> -->

            <!-- Sidebar Message - Cuadrado de tono mas oscuro con el logo IP + nombre del sistema -->
                <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="../../img/logoInstitucion/logo_sin_letras.png" width="46" height="86"  alt="...">
                <p class="text-center mb-2"><strong>Control de Personal</strong></p>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
<!--                     <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."*/
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="../../img/profile_user/user.png">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> 
                                    <!-- Nombre del usuario traido por LDAP --> 
                                <?php echo "&nbsp;&nbsp;". $_SESSION["user"] ?>
                            </span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="ver_perfil.php">
                                <i class="bi bi-person-circle"></i>
                                    Perfil
                                </a>
                                <a class="dropdown-item" href="registrar_asistencia.php">
                                <i class="bi bi-stopwatch-fill"></i>
                                    Realizar Su Marcado De Asistencia
                                </a>
                                <a class="dropdown-item" href="../admin/login.php">
                                <i class="bi bi-shield-lock"></i>
                                    Modo Administrador
                                </a>
                                <a class="dropdown-item" href="#"  onclick="ver_modal()">
                                <i class="bi bi-file-earmark-pdf"></i>
                                    Comunicados Institucionales RRHH
                                </a>
<!--                                 <a class="dropdown-item" href="#">
                                    <i class="bi bi-key-fill"></i>
                                    Cambiar contraseña 
                                </a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../../config/salir.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="bi bi-box-arrow-left"></i>
                                    Cerrar Sesión
                                </a>
                            </div>
                        </li>

                    </ul>
                </nav>
                <!-- End of Topbar -->
