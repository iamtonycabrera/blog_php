<?php

include("includes/header_front.php");

// Instanciar db y conn
$baseDatos = new Basemysql();
$db = $baseDatos->connect();

// Instanciar articulo
$usuario = new Usuario($db);

if (isset($_POST['acceder'])) {
    // Obtener los valores
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Si entra es porque si se subio la imagen
    // Validar los demas campos
    if (empty($email) || $email == "" || empty($password) || $password == "") {
        $error = "Algunos campos estan vacios";
    } else {
        if ($usuario->login($email, $password)) {
            $mensaje = "Acceso correcto";

            $_SESSION['autenticado'] = true;
            $_SESSION['email'] = $email;

            echo ("<script>location.href = '" . RUTA_FRONT . "'</script>");

        } else {
            $error = "Error, combinacion de usuario y contraseña no encontrado";
        }
    }
}

?>

<div class="row">
    <div class="col-sm-12">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>
                    <?php echo $error ?>
                </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php if (isset($_GET['mensaje'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>
                    <?php echo $_GET['mensaje'] ?>
                </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>
    </div>
</div>

<div class="container-fluid">
    <h1 class="text-center">Acceso de Usuarios</h1>
    <div class="row">
        <div class="col-sm-6 offset-3">
            <div class="card">
                <div class="card-header">
                    Ingresa tus datos para acceder
                </div>
                <div class="card-body">
                    <form method="POST" action="">



                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" name="email" placeholder="Ingresa el email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" name="password"
                                placeholder="Ingresa el password">
                        </div>

                        <br />
                        <button type="submit" name="acceder" class="btn btn-primary w-100"><i
                                class="bi bi-person-bounding-box"></i> Acceder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<?php include("includes/footer.php") ?>