<?php
include("../includes/header.php");

// Instanciar db y conn
$baseDatos = new Basemysql();
$db = $baseDatos->connect();

// Instanciar el objeto articulo
$comentarios = new Comentario($db);
$resultado = $comentarios->leer();
?>


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

<div class="row">
    <div class="col-sm-6">
        <h3>Lista de Comentarios</h3>
    </div>
</div>
<div class="row mt-2 caja">
    <div class="col-sm-12">
        <table id="tblContactos" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Comentario</th>
                    <th>Usuario</th>
                    <th>Artículo</th>
                    <th>Estado</th>
                    <th>Fecha de creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultado as $comentario): ?>
                    <tr>
                        <td>
                            <?php echo $comentario->comentario_id ?>
                        </td>
                        <td>
                            <?php echo $comentario->comentario ?>
                        </td>
                        <td>
                            <?php echo $comentario->nombre_usuario ?>
                        </td>
                        <td>
                            <?php echo $comentario->titulo_articulo ?>
                        </td>
                        <td>
                            <?php echo $comentario->estado ?>
                        </td>
                        <td>
                            <?php echo $comentario->comentario_fecha_creacion ?>
                        </td>
                        <td>
                            <a href="editar_comentario.php?id=<?php echo $comentario->comentario_id ?>"
                                class="btn btn-warning"><i class="bi bi-pencil-fill"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<?php include("../includes/footer.php") ?>

<script>
    $(document).ready(function () {
        $('#tblContactos').DataTable();
    });
</script>