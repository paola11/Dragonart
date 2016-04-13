<?php
require_once ('doctype.php');
?>
<body>

    <?php
    require_once ('header.php');
    ?>

    <div class="container main-pubIndex">
        <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading postHeader">
                <div class="row">
                    <h1 class="col-md-12">Nueva contraseña</h1>
                </div>
            </div>
            <div class="panel-body postDesc">
                <p>Ingresa tu nueva contraseña</p>
                <form id="nuevaContrasena" class="form-horizontal col-xs-12 col-md-8 col-md-offset-2" action="javascript:alert( 'success!' );" method="post">

                    <div class="form-group">
                        <label for="password">Contraseña: </label>
                        <div>
                            <input type="password" class="form-control" id="password" placeholder="Contreseña" name="password" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="passwordConfirmacion">Repetir contraseña: </label>
                        <div>
                            <input type="password" class="form-control" id="passwordConfirmacion" placeholder="Repetir contreseña" name="passwordConfirmacion" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12 col-md-8 col-md-offset-2">
                            <button type="submit" class="btn btn-warning btn-block"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar cambios</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>  
</body>

<?php
require_once ('footer.php');
?>

<script>
    $('#nuevaContrasena').submit(function(event){
        var inputs = $('#nuevaContrasena input');
        if(!(validarInputs(inputs))){
            event.preventDefault();
        }   
    });
</script>

</html>