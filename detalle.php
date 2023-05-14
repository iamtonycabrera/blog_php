<?php

include("includes/header_front.php");

// Instanciar db y conn
$baseDatos = new Basemysql();
$db = $baseDatos->connect();

if (isset($_GET['id'])) {
    $idArticulo = $_GET['id'];
}

// Instanciar el objeto articulo
$articulos = new Articulo($db);
$resultado = $articulos->leer_individual($idArticulo);

// Instanciar el objeto comentario
$comentarios = new Comentario($db);
$resultadoComentarios = $comentarios->comentariosDeArticulo($idArticulo);

// Crear comentario
if (isset($_POST['enviarComentario'])){
    // Obtener el id
    $idArticulo = $_POST['articulo'];
    $email = $_POST['usuario'];
    $comentario = $_POST['comentario'];

    if (empty($email) || $email == "" || empty($comentario) || $comentario == "") {
        $error = "Error, algunos campos estan vacios";
    } else {
        // Instanciar comentario
        $comentarioObj = new Comentario($db);
        if ($comentarioObj->crear($email, $comentario, $idArticulo)) {
            $mensaje = "Comentario insertado correctamente";
            echo("<script>location.href = '".RUTA_FRONT."'</script>");
        } else {
            $error = "Error al insertar el comentario";
        }
    }
}
?>

<div class="row">

</div>

<div class="container-fluid">

    <div class="row">

        <div class="row">
            <div class="col-sm-12">

            </div>
        </div>

        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1>
                        <?php echo $resultado->titulo ?>
                    </h1>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid img-thumbnail"
                            src="<?php echo RUTA_FRONT; ?>img/articulos/<?php echo $resultado->imagen ?>">
                    </div>

                    <p>
                        <?php echo $resultado->texto ?>
                    </p>

                </div>
            </div>
        </div>
    </div>

    <?php if(isset($_SESSION['autenticado'])) : ?>
    <div class="row">

        <div class="col-sm-6 offset-3">
            <form method="POST" action="">
                <input type="hidden" name="articulo" value="<?php echo $idArticulo ?>">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario:</label>
                    <input type="text" class="form-control" name="usuario" id="usuario" value="<?php echo $_SESSION['email'];?>"
                        readonly>
                </div>

                <div class="mb-3">
                    <label for="comentario">Comentario</label>
                    <textarea class="form-control" name="comentario" style="height: 200px"></textarea>
                </div>

                <br />
                <button type="submit" name="enviarComentario" class="btn btn-primary w-100"><i
                        class="bi bi-person-bounding-box"></i> Crear Nuevo Comentario</button>
            </form>
        </div>
    </div>
    <?php endif ?>

</div>

<div class="row">
    <h3 class="text-center mt-5">Comentarios</h3>
    <?php foreach ($resultadoComentarios as $comentario): ?>
        <h4><i class="bi bi-person-circle"></i>
            <?php echo $comentario->nombre_usuario ?>
        </h4>
        <p>
            <?php echo $comentario->comentario ?>
        </p>
    <?php endforeach ?>
</div>

</div>
<?php include("includes/footer.php") ?>