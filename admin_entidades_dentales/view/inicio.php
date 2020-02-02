

<div class="row">

    <div class="col-xs-12 col-ms-12 col-md-12 col-lg-12">
        <h2>LISTA DE ENTIDADES - CLINICAS DENTALES</h2>

        <br>

        <div class="table-responsive">
            <table class="table" id="list_clinicas" width="100%">
                <thead>
                    <th>ID ENTIDAD</th>
                    <th>NOMBRE CLINICA</th>
                    <th>DIRECCION</th>
                    <th>EMAIL</th>
                    <th>PAIS</th>
                    <th>CIUDAD</th>
                </thead>
            </table>
        </div>

    </div>

</div>


<script>


    function list_entidades()
    {
        $('#list_clinicas').DataTable({
            searching: false,
            ordering:false,
            destroy:true,
            // scrollX: true,
            ajax:{
                url: "<?= DOL_HTTP ?>" + "/admin_entidades_dentales/entidad_controller/controller.php",
                type:'POST',
                data:{ 'ajaxSend':'ajaxSend', 'accion':'list_entidades' },
                dataType:'json',
            },
            language:{
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },

                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }

            },
        });
    }

    $(document).ready(function() {

        list_entidades();
    });

</script>