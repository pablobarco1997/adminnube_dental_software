<!--<!-- Main Footer -->
<!--<footer class="main-footer" style="margin: 0px; background-color: #212F3D !important; color: #FDFEFE; width: 100%">-->
<!--    <!-- To the right -->
<!--    <div class="pull-right hidden-xs">-->
<!--        Anything you want-->
<!--    </div>-->
<!--    <!-- Default to the left -->
<!--    <strong>Copyright &copy; --><?php //echo date('Y')   ?><!-- <a href="#">Company</a>.</strong> Todos los derechos reservados.-->
<!--</footer>-->

<div class="control-sidebar-bg"></div>

<?php include_once DOL_DOCUMENT .'/public/view/modal_glob.php'; ?>
<?php include_once DOL_DOCUMENT .'/public/view/informacion_entidad.php'; ?>

</body>
</html>

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="<?php echo DOL_HTTP.'/public/bower_components/jquery/dist/jquery.js'?>"></script>
<!-- Bootstrap 3.4 -->
<script src="<?php echo DOL_HTTP .'/public/bower_components/bootstrap/dist/js/bootstrap.js'?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo DOL_HTTP .'/public/js/adminlte.min.js'?>"></script>
<!--datatable-->
<script src="<?php echo DOL_HTTP .'/public/bower_components/datatable/datatables.net/js/jquery.dataTables.js'?>"></script>
<script src="<?php echo DOL_HTTP .'/public/bower_components/datatable/datatables.net-bs/js/dataTables.bootstrap.js'?>"></script>
<!--select2-->
<script src="<?php echo DOL_HTTP .'/public/bower_components/select2/select2.js'?>"></script>
<script src="<?php echo DOL_HTTP .'/public/bower_components/select2/select2_locale_es.js'?>"></script>
<!-- sweetalert2 -->
<script src="<?php echo DOL_HTTP .'/public/lib/sweetalert2/sweetalert2.js'?>" ></script>
<!--    mask-->
<script src="<?php echo DOL_HTTP .'/public/lib/jquery.mask.min.js'?> "></script>
<script src="<?php echo DOL_HTTP .'/public/lib/jquery.maskMoney.js'?> "></script>
<!--javascript global-->
<script src="<?php echo DOL_HTTP .'/public/js/lib_glob.js' ?>"></script>

<!--daterangepicker-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>

    //LOADDING ---------------------------------------------------------------------------------------------------------

    // DomLoadding($('#loaddin-text'), 'start');
    //
    // $(window).ready(function() {
    //     DomLoadding($('#loaddin-text'), 'stop');
    // });
    //
    //
    // function DomLoadding(screen, ac) {
    //     if( ac == 'start' ){
    //         screen.fadeIn();
    //
    //     }
    //     if( ac == 'stop' ){
    //         screen.fadeOut();
    //
    //     }
    //
    // }
    //
    // configLoaddingScreen($('#loaddin-text'));
    //
    // function configLoaddingScreen(screen){
    //
    //     $(document)
    //         .ajaxStart( function() {
    //             screen.fadeIn();
    //             $('body').addClass('disabled_link3').css('overflow-y','hidden');
    //         })
    //         .ajaxStop( function() {
    //             screen.fadeOut();
    //             $('body').removeClass('disabled_link3').css('overflow-y','scroll');
    //         })
    //
    // }

</script>
