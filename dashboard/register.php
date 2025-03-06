<?php 
include 'complementos/head.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Registro de usuario" />
    <meta name="author" content="" />
    <title>Registro de Usuario</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Crear cuenta</h3>
                                </div>
                                <div class="card-body">
                                    <form action="registro.php" method="POST">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="usuario" name="usuario" type="text" placeholder="Ingrese su usuario" required />
                                            <label for="usuario">Nombre de usuario</label>
                                        </div>


                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Ingrese su nombre" required />
                                            <label for="nombre">Nombre completo</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="email" name="correo" type="email" placeholder="correo@example.com" required />

                                            <label for="email">Correo Electrónico</label>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input class="form-control" id="password" name="password" type="password" placeholder="Crear una contraseña" required />
                                                    <label for="password">Contraseña</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input class="form-control" id="passwordConfirm" name="passwordConfirm" type="password" placeholder="Confirmar contraseña" required />
                                                    <label for="passwordConfirm">Confirmar Contraseña</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary btn-block">Crear Cuenta</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="login.php">¿Ya tienes una cuenta? Inicia sesión</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; </div>
                        <div>
                            <a href="#">Políticas de Privacidad</a>
                            &middot;
                            <a href="#">Términos &amp; Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>