<?php
include("../includes/header.php");
// Instanciar db y conn
$baseDatos = new Basemysql();
$db = $baseDatos->connect();

// Validar si se presiono el boton
if (isset($_POST['crearArticulo'])) {
    // Obtener los valores
    $titulo = $_POST['titulo'];
    $texto = $_POST['texto'];

    if ($_FILES['imagen']['error'] > 0) {
        $error = "Error, ningun archivo seleccionado";
    } else {
        // Si entra es porque si se subio la imagen
        // Validar los demas campos
        if (empty($titulo) || $titulo == "" || empty($texto) || $texto == "") {
            $error = "Algunos campos estan vacios";
        } else {
            // Si entra aqui es porque se enviaron todos los campos
            // Subida de archivos
            $image = $_FILES['imagen']['name'];
            $image_arr = explode('.', $image);
            $rand = rand(1000, 99999);
            $image_name = $image_arr[0] . $rand . '.' . $image_arr[1];
            $ruta_final = "../img/articulos/" . $image_name;
            move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_final);

            // Instanciar articulo
            $articulo = new Articulo($db);

            if ($articulo->crear($titulo, $image_name, $texto)) {
                $mensaje = "Articulo creado correctamente";
                header("Location:articulos.php?mensaje=" . urlencode($mensaje));
            } else {
                $error = "Articulo no creado";
                header("Location:articulos.php?error=" . urlencode($mensaje));
            }
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
    <div class="col-sm-6">
        <h3>Crear un Nuevo Artículo</h3>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 offset-3">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Ingresa el título">
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen" id="apellidos"
                    placeholder="Selecciona una imagen">
            </div>
            <div class="mb-3">
                <label for="texto">Texto</label>
                <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="texto"
                    style="height: 200px"></textarea>
            </div>

            <br />
            <button type="submit" name="crearArticulo" class="btn btn-primary w-100"><i
                    class="bi bi-person-bounding-box"></i> Crear Nuevo Artículo</button>
        </form>
    </div>
</div>
<?php include("../includes/footer.php") ?>