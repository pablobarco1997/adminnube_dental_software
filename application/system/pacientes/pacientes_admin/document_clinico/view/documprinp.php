
<?php


    $accion = "";

    if(isset($_GET['v']) && $_GET['v'] == "listdocumment") //lista de documentos
    {
        $accion = $_GET['v'];
    }

    if(isset($_GET['v']) && $_GET['v'] == "docum_clin") //documento nuevo o modificar
    {
        $accion = $_GET['v'];
    }

?>

<script>
    $acciondocummAsociado = "<?= $accion; ?>"; //accion de documentos asociados
</script>


    <?php

        if(isset($_GET['v'])) #TIPO DE VISTA
        {
            if($_GET['v']=="listdocumment")
            {
                include_once 'document_list.php'; #lista de documento creados
            }

            if($_GET['v']=="docum_clin")
            {
                include_once 'docum_clin.php'; #Se muestra los documentos si se va a crear un nuevo documento
            }

            if($_GET['v'] != "docum_clin" && $_GET['v'] != "listdocumment") //si en caso no se encuentra ninguna vista
            {
                echo '<h2 style="color: red; font-weight: bolder">OCURRIO UN ERROR NO SE ENCONTRO LA VISTA</h2>';
                die();
            }

        }else{

            echo '<h2 style="color: red; font-weight: bolder">OCURRIO UN ERROR NO SE ENCONTRO LA VISTA</h2>';
            die();
        }
    ?>
