
<!--  * @Autor: Ana Zavala 
 * @Fecha Creacion: 07/07/2022-->

        <!-- Llamado de la cabeza del -->
        <?php
        require 'header.php';
        ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
                                <!-- Page Heading -->
                                <h1 class="h3 mb-2 text-gray-800"><i class="bi bi-person-badge-fill"></i> Visualización de Empleados.</h1>
                            <p class="mb-4"> En esta área puede ver los Empleados Asignados a Ventanilla <i class="bi bi-info-circle-fill"></i>
                             IMPORTANTE crear el Usuario antes de crear un Empleado
                               
                            </p>

                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                            <div class="card-body">
                            
                            
                                    <!-- Begin Page Content -->
                                    <div class="container-fluid">
                                        <!-- Page Heading -->
                            <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><i class="bi bi-person-badge-fill"></i>&nbsp;Empleado</h6>
                                </div>
                                <div class="card-body">
                            <button type="button" class="btn btn-outline-info  btn-lg" data-bs-toggle="modal" data-bs-target="#modalEmpleado" id="botonCrear">
                            <i class="bi bi-plus-circle-fill"></i> Crear
					    </button>

                        </div>
                    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEstado" data-bs-whatever="@mdo" id="btnCrearEstados"><i class="bi bi-person-plus-fill"></i> Crear</button>
                                <p></p> 
 -->

                                <!-- Tabla de  -->    
                    
                                <div class="table-responsive"><!-- inicio de table responsive -->
                                                <!-- Tabla  -->
                                                     <table id="datos_empleado" class="table table-bordered ">
                                                    <!-- Encabezado -->
                                                    <thead ><!-- class="table-dark" -->
                                                        <!-- Creacion de fila de encabezados -->
                                                            <tr>
                                                            <!-- Columnas -->
                                                            <th><i class="bi bi-credit-card-2-front"></i> Id Empleado</th>
                                                            <th><i class="bi bi-credit-card-2-front"></i> Identidad </th>
                                                            <th><i class="bi bi-credit-card-2-front"></i> Nombre </th>
                                                            <th><i class="bi bi-credit-card-2-front"></i> Apellido </th>
                                                            <th><i class="bi bi-people-fill"></i> Rol </th>
                                                      <!--  <th><i class="bi bi-toggle2-on"></i></i> Ventanilla_idVentanilla </th -->
                                                            <th><i class="bi bi-envelope-check-fill"></i> Correo Institucional </th>
                                                            <th><i class="bi bi-box-arrow-in-right"></i> Login </th>
                                                            <!-- Botones para la edicion  -->
                                                            <th><i class="bi bi-pencil-square"></i> Actualizar </th>
                                                            <th><i class="bi bi-toggles2"></i> Cambiar Estado </th>
                                                          
                                                      
                                                         
                                                      
                                                            </tr>

                                                    </thead>
                                                </table>
                                        </div><!-- fin de table responsive -->
                                </div>
                            </div>
        </div>
        <!-- /.container-fluid -->

                <!-- Creacion del modal  -->  
                <div class="modal fade" id="modalEmpleado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                            <!-- Colocando el nombre del modal para que el boton sepa que se va desplegar  -->
                 <!--        <h5 class="modal-title" ><i class="bi bi-person-plus-fill"></i> Creación de Estado </h5> -->

            
                        <label for="idEmpleado"><i class="bi bi-person-badge-fill"></i>&nbsp;Crear Empleado:</label> 

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        

                                <!-- Creacion del formulario -->
                            <form method="POST" id="formularioCreacionEmpleado" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <p> Los campos que tengan el asterico color rojo(<B><FONT COLOR="red">*</FONT></B>) son campos obligatorios para su obligatorio llenado. </p>
                                            </div>
                                            <!-- <label for="idEmpleado"><i class="bi bi-hash"></i>Id de Empleado: <B><FONT COLOR="red">*</FONT></B></label> -->
                                            <input type="hidden" name="idEmpleado" id="idEmpleado" class="form-control"> <!-- icono estado -->
                                            <label for="idUsuario"><i class="bi bi-credit-card-2-front"></i> Ingrese la Identidad de Empleado: <B><FONT COLOR="red">*</FONT></B></label> <!-- icono estado -->
                                            <input type="text" name="idUsuario" id="idUsuario" class="form-control" pattern="^[01][0-9][0-3][0-9][12][0-9][0-9][0-9][0-9]{5}$" oninvalid="setCustomValidity('Porfavor ingresa un número de identidad válido.')"  oninput="setCustomValidity('')" maxlength="14" required>
                                            <br/>
                                            <label for="nombre"><i class="bi bi-person"></i> Nombre:</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="text" name="primerNombre" id="primerNombre" class="form-control" placeholder="Primer Nombre" pattern="[a-zA-Z]{3,12}" oninvalid="setCustomValidity('Porfavor ingresa un nombre válido.')"  oninput="setCustomValidity('')" style="text-transform: capitalize;" maxlength="25" required>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" name="segundoNombre" id="segundoNombre" class="form-control" placeholder="Segundo Nombre" pattern="[a-zA-Z]{3,12}" style="text-transform: capitalize;" maxlength="25">
                                                </div>
                                            </div>
                                            <br/>
                                            <label for="nombre"><i class="bi bi-person"></i> Apellido:</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="text" name="primerApellido" id="primerApellido" class="form-control" placeholder="Primer Apellido"  pattern="[a-zA-Z]{3,12}" oninvalid="setCustomValidity('Porfavor ingresa un apellido válido.')"  oninput="setCustomValidity('')" style="text-transform: capitalize;" maxlength="25" required>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" name="segundoApellido" id="segundoApellido" class="form-control" placeholder="Segundo Apellido" pattern="[a-zA-Z]{3,12}" style="text-transform: capitalize;" maxlength="25">
                                                </div>
                                            </div>
                                            <br/>
                                            <label for="Rol_idRol"><i class="bi bi-people-fill"></i> Selecione el Rol que tendrá el Empleado: <B><FONT COLOR="red">*</FONT></B></label> <!-- icono estado -->
                                            <select name="Rol_idRol" id="Rol_idRol" class="form-control" required>
                                            <option value="0" style="color:black;">Seleccione el Rol del Empleado</option>
                                            <?php
                                                    include("../../config/conexion.php");
                                                    $query = $conexion->prepare("SELECT
                                                                                    idRol,
                                                                                    nombreRol,
                                                                                    descripcionRol,
                                                                                    estado
                                                                                FROM
                                                                                    rol");
                                                    $query->execute();
                                                    $data = $query->fetchAll();

                                                    foreach ($data as $valores):
                                                    echo '<option value="'.$valores["idRol"].'">'.$valores["nombreRol"].'</option>';
                                                    endforeach;
                                            ?>
                                            </select>   
                                            <br/>
                                            <label for="correo"><i class="bi bi-envelope-check-fill"></i> Ingrese el Correo Institucional del Empleado: <B><FONT COLOR="red">*</FONT></B></label> <!-- icono estado -->
                                            <input type="email" name="correo" id="correo"class="form-control" required>
                                            <br/>
                                            <label for="login"><i class="bi bi-box-arrow-in-right"></i> Ingrese la Cuenta Institucional del Empleado: <B><FONT COLOR="red">*</FONT></B></label> <!-- icono estado -->
                                            <input type="text" name="login" id="login"class="form-control" required>
                                            <br/>
                                            <label for="numeroCelular"><i class="bi bi-123"></i> Ingrese el Número de Célular: <B><FONT COLOR="red">*</FONT></B></label> <!-- icono estado -->
                                            <input type="text" name="numeroCelular" id="numeroCelular"class="form-control"  pattern="^[389][0-9]{7}$" oninvalid="setCustomValidity('Porfavor ingresa un número de celular válido.')"  oninput="setCustomValidity('')" required>

                                            

                                        <div class="modal-footer">
                                            <input type="hidden" name="idEmpleados" id="idEmpleados">
                                        
                                    <!--  <input type="hidden" name="operacion"  id="operacion" value="Crear">  -->
                                                    <input type="hidden" class="btn btn-secondary" name="operacion" id="operacion" value="Crear">
                                                    <input type="submit" name="action" id="action" class="btn btn-outline-info  btn-lg" value="Crear">
                                                    <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Cerrar</button>
                                <!-- Funcionalidad para crear o editar llamada por el input -->
                            </div>
                    </div><!--  -->
                        </form>


                        </div><!-- modal-dialog -->
                </div><!-- modal fade -->

        </div>
        <!-- End of Main Content -->

                                                <!-- scripts -->
                                                <script src="../../assets/particulas/particles.js"></script>
                                                <script src="../../assets/particulas/js/app.js"></script>

                                                <!-- stats.js -->
                                                <script src="../../assets/particulas/js/lib/stats.js"></script>
                                                <!--  JavaScript -->
                                                    <!-- Jquery  -->
                                                    <script src="../../assets/jquery-3.6.0/jquery-3.6.0.min.js"></script>

                                                    <!-- Data tables -->
                                                    <script charset="utf8"  src="../../assets/datatables/js/jquery.dataTables.min.js" ></script>
                                                <!--     <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->

                                                    <!--  Bootstrap  -->
                                                    <script src="../../assets/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
                                                    <script src="../../assets/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
                                                
                                                <!-- Funcionalidad del datatables de empleado -->
                                                <script src="../../controllers/tb_empleado.js"></script>

                                                <!-- Bootstrap core JavaScript-->
                                                <script src="../../assets/js/jquery.min.js"></script>
                                                <script src="../../assets/js/bootstrap.bundle.min.js"></script>

                                                <!-- Core plugin JavaScript-->
                                                <script src="../../assets/js/jquery.easing.min.js"></script>

                                                <!-- Custom scripts for all pages-->
                                                <script src="../../assets/js/sb-admin-2.min.js"></script>

                                                <!--  JavaScript -->
                                                    <!-- Jquery  -->
                                                    <script src="../../assets/jquery-3.6.0/jquery-3.6.0.min.js"></script>

                                                    <!-- Data tables -->
                                                    <script charset="utf8"  src="../../assets/datatables/js/jquery.dataTables.min.js" ></script>
                                                <!--     <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->

                                                    <!--  Bootstrap  -->
                                                    <script src="../../assets/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
                                                    <script src="../../assets/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
                                                <!-- Footer -->
                                                <footer class="sticky-footer bg-white">
                                                    <div class="container my-auto">
                                                        <div class="copyright text-center my-auto">
                                                            <span>Copyright &copy; Instituto de la Propiedad 2022</span>
                                                        </div>
                                                    </div>
                                                </footer>
                                                <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
        </a>

        <!-- Cerrar Sesión Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5> 
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Seleccione "Cerrar sesión" a continuación si está listo para finalizar su sesión actual.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.php">Cerrar Sesión</a>
            </div>
        </div>
        </div>
        </div>


        </body>

        </html>

