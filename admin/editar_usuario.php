<?php
include("../includes/header.php");

// Instanciar db y conn
$baseDatos = new Basemysql();
$db = $baseDatos->connect();

// Validar si se envio el id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

// Instanciar el objeto usuario
$usuarios = new Usuario($db);
$resultado = $usuarios->leer_individual($id);


// Actualizar usuario
// Validar si se presiono el boton
if (isset($_POST['editarUsuario'])) {
    // Obtener los valores
    $idUsuario = $_POST['id'];
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];

    if (empty($nombre) || $nombre == "" || empty($rol) || $rol == "" || empty($idUsuario) || $idUsuario == "") {
        $error = "Algunos campos estan vacios";
    } else {
        // Si entra aqui es porque se enviaron todos los campos
        // Instanciar articulo
        $usuario = new Usuario($db);

        if ($usuario->actualizar($idUsuario, $nombre, $rol)) {
            $mensaje = "Usuario modificado correctamente";
            header("Location:usuarios.php?mensaje=" . urlencode($mensaje));
            exit();
        } else {
            $error = "Usuario no modificado";
        }
    }
}

// Borrar usuario
// Validar si se presiono el boton
if (isset($_POST['borrarUsuario'])){
    // Obtener el id
    $idUsuario = $_POST['id'];

    // Instanciar usuario
    $usuario = new Usuario($db);

    if ($usuario->borrar($idUsuario)) {
        $mensaje = "Usuario eliminado correctamente";
        header("Location:usuarios.php?mensaje=" . urlencode($mensaje));
    } else {
        $error = "Error al borrar el usuario";
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
    <div class="col-sm-6">
        <h3>Editar Usuario</h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 offset-3">
        <form method="POST" action="">

            <input type="hidden" name="id" value="<?php echo $resultado->usuario_id ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre"
                    value="<?php echo $resultado->usuario_nombre ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Ingresa el email"
                    value="<?php echo $resultado->usuario_email ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="rol" class="form-label">Rol:</label>
                <select class="form-select" aria-label="Default select example" name="rol">
                    <option value="">--Selecciona un rol--</option>
                    <option value="1" <?php if ($resultado->rol == "Administrador")
                        echo "selected" ?>>Administrador
                        </option>
                        <option value="2" <?php if ($resultado->rol == "Usuario")
                        echo "selected" ?>>Usuario</option>
                    </select>
                </div>

                <br />
                <button type="submit" name="editarUsuario" class="btn btn-success float-left"><i
                        class="bi bi-person-bounding-box"></i> Editar Usuario</button>

                <button type="submit" name="borrarUsuario" class="btn btn-danger float-right"><i
                        class="bi bi-person-bounding-box"></i> Borrar Usuario</button>
            </form>
        </div>
    </div>
<?php include("../includes/footer.php") ?>