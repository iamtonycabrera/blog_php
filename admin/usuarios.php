<?php
    include("../includes/header.php");
    
    // Instanciar db y conn
    $baseDatos = new Basemysql();
    $db = $baseDatos->connect();

    // Instanciar el objeto articulo
    $usuarios = new Usuario($db);
    $resultado = $usuarios->leer();
?>

<div class="row">
    <div class="col-sm-12">
        <?php if(isset($_GET['mensaje'])) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?php echo $_GET['mensaje'] ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <h3>Lista de Usuarios</h3>
    </div>     
</div>
<div class="row mt-2 caja">
    <div class="col-sm-12">
            <table id="tblUsuarios" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Fecha de Creación</th>                       
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
              <?php foreach($resultado as $usuario) : ?>
                    <tr>
                        <td><?php echo $usuario->usuario_id ?></td>
                        <td><?php echo $usuario->usuario_nombre ?></td>
                        <td><?php echo $usuario->usuario_email ?></td>
                        <td><?php echo $usuario->rol ?></td>
                        <td><?php echo $usuario->usuario_fecha_creacion ?></td>
                        <td>
                            <a href="editar_usuario.php?id=<?php echo $usuario->usuario_id ?>" class="btn btn-warning"><i class="bi bi-pencil-fill"></i></a>                                            
                        </td>
                    </tr>
                         <?php endforeach ?>                  
                </tbody>       
            </table>
    </div>
</div>
<?php include("../includes/footer.php") ?>

<script>
    $(document).ready( function () {
        $('#tblUsuarios').DataTable();
    });
</script>