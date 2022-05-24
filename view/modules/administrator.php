<?php

    session_start();

    require_once "../../model/connection.php";
    require_once "../../model/adminModel.php";
    require_once "../../controller/adminController.php";



    /* 
        Si la sesión existe: session_started y el role es 1, es decir: Administrador .
        Entonces podrá visualizar toda esta página. 
    */
    if(isset($_SESSION["session"]) && $_SESSION["role"] === "1") {

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido Administrador</title>


    <!-- Data Tables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <!-- Boostrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- My CUSTOM CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    
</head>
<body>
 
<header>
        <nav class="nav">
            <div class="nav-container">
                <h3 class="nav-logo">Imove - Administrador <?php echo $_SESSION["name"]; ?></h3>

                <label for="menu" class="nav-label">
                    <img src="../assets/img/menu.svg" class="nav-img" alt="Icono menú de navegación">
                </label>
                <input class="nav-input" type="checkbox" id="menu">

                <div class="nav-menu">
                    <a href="../../index.php" class="nav-item">Inicio</a>
                    <a href="../../controller/logoutController.php" class="nav-item">Cerrar sesión</a>
                </div>

            </div>
        </nav>
    </header>
    <div class="main">
        <div class="container-administrator">

            <div class="container-button">

                <h1>Gestión de usuarios</h1>

                <button type="button" id="newUser" class="btn btn-primary" data-toggle="modal" data-target="#userModal">
                    Nuevo usuario
                </button>
            </div>

            <div class="container-users">
                <table id="table_users" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Foto</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Editar</th>
                            <th scope="col">Eliminar</th>      
                        </tr>
                    </thead>
                </table>
            </div>
        </div>


        <!-- Modal de registro de usuarios -->
        
        <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalLabel">Registrar usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body">
                        <form method="POST" id="userForm" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label  class="form-label float-left">Nombre</label>
                                <input class="form-control" id="name" name="name" type="text" placeholder="Ingrese el nombre">
                            </div>
                            <div class="mb-3">
                                <label  class="form-label float-left">Correo</label>
                                <input class="form-control" id="email" name="email" type="email" placeholder="Ingrese el correo">
                            </div>
                            <div class="mb-3">
                                <label  class="form-label float-label">Contraseña</label>
                                <input class="form-control" id="password" name="password" type="password" placeholder="Ingrese la contraseña">
                            </div>
                            <div class="mb-3">
                                <label class="form-label float-left">Rol</label>
                                <select id="role" name="role" class="form-control">
                                    <option value="1">Administrador</option>
                                    <option value="2">Usuario normal</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label  class="form-label float-left">Elija el estado</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnRegisterUser">Registrar nuevo usuario</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal de actualización de información de usuarios -->
        
        <div class="modal fade" id="updateUserModal" tabindex="-1" role="dialog" aria-labelledby="updateUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateUserModalLabel">Registrar usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body">
                        <form method="POST" id="updateUserForm" enctype="multipart/form-data">
                            <input type="hidden" name="updateId" id="updateId">

                            <div class="mb-3">
                                <label  class="form-label float-left">Nombre</label>
                                <input class="form-control" id="updateName" name="name" type="text" placeholder="Ingrese el nombre">
                            </div>
                            <div class="mb-3">
                                <label  class="form-label float-left">Correo</label>
                                <input class="form-control" id="updateEmail" name="email" type="email" placeholder="Ingrese el correo">
                            </div>
                            <div class="mb-3">
                                <label class="form-label float-left">Rol</label>
                                <select id="updateRole" name="role" class="form-control">
                                    <option value="2">Usuario normal</option>
                                    <option value="1">Administrador</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label  class="form-label float-left">Elija el estado</label>
                                <select id="updateStatus" name="status" class="form-control">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnUpdateUser">Actualizar información</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
                </div>
            </div>
        </div>
    <!-- Js - JQuery -->
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <!-- Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- My CUSTOM JS -->
    <script src="../assets/js/admin.js"></script>

    <!-- BOOTSTRAP JS -->
    <!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- CSS DataTABLES-->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
</body>
</html>


<?php

    } else {
        header("Location: /imove/");
    }
?>
