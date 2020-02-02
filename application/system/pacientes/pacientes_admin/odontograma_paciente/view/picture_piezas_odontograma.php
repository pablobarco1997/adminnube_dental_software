
<style>

    /*estylos caras dientes*/

    .boderTd{
        border: 1px solid black;
        padding: 7px;
        cursor: pointer;
    }

    .activeCara{
        background-color: #9f191f;
    }

    .pieza .boderTd:hover{
        background-color: #9f191f;
    }

    /*end style caras*/

    .dropdown-content-diente{
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 140px;
        overflow: auto;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 0;
        height: 190px;
        overflow-y: scroll;
    }

    .dropdown-content-diente a{
        color: black;
        font-size: 1rem !important;
        padding: 4px 8px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content-diente a:hover{

        border-left: 1.5px solid black;
        background-color: rgba(204, 209, 209,0.5);
    }
    .mostratMenuEstadosDentales{
        display: block;
    }

    .dienteActivo{
        background-color: rgba(204, 209, 209,0.5);
    }

    .dropbtn-diente img{
        width: 40px;
        height: 90px;
    }


</style>

<div class="table-responsive" >
    <div style="width: 1250px">

        <?php

        $dropdownMenuEstadosDientes = "
<a href='#' class='linkdiente' onclick='fetch_diente_odontograma($(this))' title='Lesión de Caries' data-id='1'>  <img src='".DOL_HTTP."/logos_icon/logo_default/odontograma/estados_dientes/caries.png' width='20px' height='15px' alt=''> &nbsp;Lesión de Caries</a>                               
<a href='#' class='linkdiente' onclick='fetch_diente_odontograma($(this))' title='Infección Pulpar' data-id='2'><img src='".DOL_HTTP."/logos_icon/logo_default/odontograma/estados_dientes/infeccion_pulpar.png' width='20px' height='15px' alt=''> &nbsp;Infección Pulpar</a>
<a href='#' class='linkdiente' onclick='fetch_diente_odontograma($(this))' title='Fractura' data-id='3'><img src='".DOL_HTTP."/logos_icon/logo_default/odontograma/estados_dientes/fractura.png' width='20px' height='15px' alt=''> &nbsp;Fractura</a>
<a href='#' class='linkdiente' onclick='fetch_diente_odontograma($(this))' title='Indicación de extracción' data-id='4'><img src='".DOL_HTTP."/logos_icon/logo_default/odontograma/estados_dientes/indicacion_extraccion.png' width='20px' height='15px' alt=''> &nbsp;Indicación de extracción</a>
<a href='#' class='linkdiente' onclick='fetch_diente_odontograma($(this))' title='Ausente' data-id='5'><img src='".DOL_HTTP."/logos_icon/logo_default/odontograma/estados_dientes/ausente.png' width='20px' height='15px' alt=''> &nbsp; Ausente</a>
<a href='#' class='linkdiente' onclick='fetch_diente_odontograma($(this))' title='Restauración' data-id='6'><img src='".DOL_HTTP."/logos_icon/logo_default/odontograma/estados_dientes/restauracion.png' width='20px' height='15px' alt=''> &nbsp;Restauración</a>
<a href='#' class='linkdiente' onclick='fetch_diente_odontograma($(this))' title='Endodoncia' data-id='7'><img src='".DOL_HTTP."/logos_icon/logo_default/odontograma/estados_dientes/endodoncia.png' width='20px' height='15px' alt=''> &nbsp;Endodoncia</a>
<a href='#' class='linkdiente' onclick='fetch_diente_odontograma($(this))' title='Corona' data-id='8'><img src='".DOL_HTTP."/logos_icon/logo_default/odontograma/estados_dientes/corona.png' width='20px' height='15px' alt=''> &nbsp;Corona</a>
<a href='#' class='linkdiente' onclick='fetch_diente_odontograma($(this))' title='Implante' data-id='9'><img src='".DOL_HTTP."/logos_icon/logo_default/odontograma/estados_dientes/implante.png' width='20px' height='15px' alt=''> &nbsp;Implante</a>
<a href='#' class='linkdiente' onclick='fetch_diente_odontograma($(this))' title='Perno muñon' data-id='10'><img src='".DOL_HTTP."/logos_icon/logo_default/odontograma/estados_dientes/perno_punon.png' width='20px' height='15px' alt=''> &nbsp;Perno muñon</a>
<a href='#' class='linkdiente' onclick='fetch_diente_odontograma($(this))' title='Otros' data-id='0'>Otros</a>
";

        ?>


        <ul class="list-inline" >

            <!--        ==================================  HEMIARCADA SUPERIOR DERECHA ==============================================-->
            <li class="diente-18 dientePermanente" data-diente="18" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza18/pieza18-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">18</td>
                        <td></td></tr>


                    <!--                HEMIARCADA SUPERIOR DERECHA -->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal"   title="distal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal"  title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="palatino" title="palatino" ></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA SUPERIOR DERECHA -->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"></td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-17 dientePermanente" data-diente="17" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente" onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza17/pieza17-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">17</td>
                        <td></td></tr>

                    <!--                HEMIARCADA SUPERIOR DERECHA -->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal"   title="distal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal"  title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="palatino" title="palatino" ></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA SUPERIOR DERECHA -->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"></td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-16 dientePermanente" data-diente="16" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >


                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza16/pieza16-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">16</td>
                        <td></td></tr>

                    <!--                HEMIARCADA SUPERIOR DERECHA -->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal"   title="distal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal"  title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="palatino" title="palatino" ></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA SUPERIOR DERECHA -->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-15 dientePermanente" data-diente="15" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza15/pieza15-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">15</td>
                        <td></td></tr>

                    <!--                HEMIARCADA SUPERIOR DERECHA -->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal"   title="distal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal"  title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="palatino" title="palatino" ></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA SUPERIOR DERECHA -->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"></td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-14 dientePermanente" data-diente="14" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza14/pieza14-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">14</td>
                        <td></td></tr>

                    <!--                HEMIARCADA SUPERIOR DERECHA -->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal"   title="distal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal"  title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="palatino" title="palatino" ></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA SUPERIOR DERECHA -->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"></td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-13 dientePermanente" data-diente="13" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza13/pieza13-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">13</td>
                        <td></td></tr>

                    <!--                HEMIARCADA SUPERIOR DERECHA -->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal"   title="distal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal"  title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"> </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="palatino" title="palatino" ></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA SUPERIOR DERECHA -->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"></td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-12 dientePermanente" data-diente="12" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >


                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza12/pieza12-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">12</td>
                        <td></td></tr>

                    <!--                HEMIARCADA SUPERIOR DERECHA -->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal"   title="distal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal"  title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="palatino" title="palatino" ></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA SUPERIOR DERECHA -->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"></td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-11 dientePermanente" data-diente="11" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >


                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza11/pieza11-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">11</td>
                        <td></td></tr>

                    <!--                HEMIARCADA SUPERIOR DERECHA -->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal"   title="distal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal"  title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="palatino" title="palatino" ></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA SUPERIOR DERECHA -->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"></td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <!--        ================================== END  HEMIARCADA SUPERIOR DERECHA ==============================================-->


            <!--        ========================================HEMIARCADA  SUPERIOR IZQUIERDA =========================================-->
            <li class="diente-21 dientePermanente" data-diente="21" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza11/pieza11-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">21</td>
                        <td></td></tr>

                    <!--                CARAS HEMIARCADA  SUPERIOR IZQUIERDA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal" title="distal"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara"data-id="palatino" title="palatino" ></td>
                        <td></td>
                    </tr>
                    <!--                CARAS HEMIARCADA  SUPERIOR IZQUIERDA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"></td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-22 dientePermanente" data-diente="22" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >


                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza22/pieza22-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">22</td>
                        <td></td></tr>

                    <!--                CARAS HEMIARCADA  SUPERIOR IZQUIERDA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"   ></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal" title="distal"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="palatino" title="palatino" ></td>
                        <td></td>
                    </tr>
                    <!--                CARAS HEMIARCADA  SUPERIOR IZQUIERDA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-23 dientePermanente" data-diente="23" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >


                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza23/pieza23-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">23</td>
                        <td></td></tr>

                    <!--                CARAS HEMIARCADA  SUPERIOR IZQUIERDA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"   ></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal" title="distal"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="palatino" title="palatino" ></td>
                        <td></td>
                    </tr>
                    <!--                CARAS HEMIARCADA  SUPERIOR IZQUIERDA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-24 dientePermanente" data-diente="24" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza24/pieza24-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">24</td>
                        <td></td></tr>

                    <!--                CARAS HEMIARCADA  SUPERIOR IZQUIERDA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal" title="distal"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="palatino" title="palatino" ></td>
                        <td></td>
                    </tr>
                    <!--                CARAS HEMIARCADA  SUPERIOR IZQUIERDA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"></td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-25 dientePermanente" data-diente="25" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >


                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza25/pieza25-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">25</td>
                        <td></td></tr>

                    <!--                CARAS HEMIARCADA  SUPERIOR IZQUIERDA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"   ></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal" title="distal"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="palatino" title="palatino" ></td>
                        <td></td>
                    </tr>
                    <!--                CARAS HEMIARCADA  SUPERIOR IZQUIERDA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-26 dientePermanente" data-diente="26" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza26/pieza26-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">26</td>
                        <td></td></tr>

                    <!--                CARAS HEMIARCADA  SUPERIOR IZQUIERDA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"   ></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal" title="distal"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="palatino" title="palatino" ></td>
                        <td></td>
                    </tr>
                    <!--                CARAS HEMIARCADA  SUPERIOR IZQUIERDA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-27 dientePermanente" data-diente="27" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >


                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza27/pieza27-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">27</td>
                        <td></td></tr>

                    <!--                CARAS HEMIARCADA  SUPERIOR IZQUIERDA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"   ></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal" title="distal"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="palatino" title="palatino" ></td>
                        <td></td>
                    </tr>
                    <!--                CARAS HEMIARCADA  SUPERIOR IZQUIERDA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-28 dientePermanente" data-diente="28" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >


                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza28/pieza28-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">28</td>
                        <td></td></tr>

                    <!--                CARAS HEMIARCADA  SUPERIOR IZQUIERDA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"   ></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal" title="distal"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="palatino" title="palatino" ></td>
                        <td></td>
                    </tr>
                    <!--                CARAS HEMIARCADA  SUPERIOR IZQUIERDA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

        </ul>


        <!--        ========================================HEMIARCADA  SUPERIOR IZQUIERDA =========================================-->


        <!--        ========================================HEMIARCADA  INFERIOR DERECHA =========================================-->

        <ul class="list-inline"  >

            <li class="diente-48 dientePermanente" data-diente="48" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza48/pieza48-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">48</td>
                        <td></td></tr>

                    <!--                HEMIARCADA  INFERIOR DERECHA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="lingual" title="lingual"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="distal" title="distal" ></td>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="mesial" title="mesial"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular" ></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA  INFERIOR DERECHA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-47 dientePermanente" data-diente="47" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza47/pieza47-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">47</td>
                        <td></td></tr>

                    <!--                HEMIARCADA  INFERIOR DERECHA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="lingual" title="lingual"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="distal" title="distal" ></td>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="mesial" title="mesial"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular" ></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA  INFERIOR DERECHA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-46 dientePermanente" data-diente="46" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza46/pieza46-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">46</td>
                        <td></td></tr>

                    <!--                HEMIARCADA  INFERIOR DERECHA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="lingual" title="lingual"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="distal" title="distal" ></td>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="mesial" title="mesial"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular" ></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA  INFERIOR DERECHA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-45 dientePermanente" data-diente="45" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza45/pieza45-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">45</td>
                        <td></td></tr>

                    <!--                HEMIARCADA  INFERIOR DERECHA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="lingual" title="lingual"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="distal" title="distal" ></td>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="mesial" title="mesial"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular" ></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA  INFERIOR DERECHA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-44 dientePermanente" data-diente="44" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza44/pieza44-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">44</td>
                        <td></td></tr>

                    <!--                HEMIARCADA  INFERIOR DERECHA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="lingual" title="lingual"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="distal" title="distal" ></td>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="mesial" title="mesial"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular" ></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA  INFERIOR DERECHA-->
                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-43 dientePermanente" data-diente="43" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza43/pieza43-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">43</td>
                        <td></td></tr>

                    <!--                HEMIARCADA  INFERIOR DERECHA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="lingual" title="lingual"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="distal" title="distal" ></td>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="mesial" title="mesial"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular" ></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA  INFERIOR DERECHA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-42 dientePermanente" data-diente="42" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza42/pieza42-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">42</td>
                        <td></td></tr>

                    <!--                HEMIARCADA  INFERIOR DERECHA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="lingual" title="lingual"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="distal" title="distal" ></td>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="mesial" title="mesial"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular" ></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA  INFERIOR DERECHA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-41 dientePermanente" data-diente="41" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza41/pieza41-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">41</td>
                        <td></td></tr>

                    <!--                HEMIARCADA  INFERIOR DERECHA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="lingual" title="lingual"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="distal" title="distal" ></td>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara"   data-id="mesial" title="mesial"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular" ></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA  INFERIOR DERECHA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <!--  =========================================    HEMIARCADA INFERIOR IZQUIERDA ====================================  -->

            <li class="diente-31 dientePermanente" data-diente="31" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza31/pieza31-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">31</td>
                        <td></td></tr>

                    <!--                HEMIARCADA INFERIOR IZQUIERDA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="lingual" title="lingual"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal" title="distal"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA INFERIOR IZQUIERDA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-32 dientePermanente" data-diente="32" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza32/pieza32-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">32</td>
                        <td></td></tr>

                    <!--                HEMIARCADA INFERIOR IZQUIERDA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="lingual" title="lingual"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal" title="distal"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA INFERIOR IZQUIERDA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-33 dientePermanente" data-diente="33" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza33/pieza33-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">33</td>
                        <td></td></tr>

                    <!--                HEMIARCADA INFERIOR IZQUIERDA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="lingual" title="lingual"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal" title="distal"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA INFERIOR IZQUIERDA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-34 dientePermanente" data-diente="34" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza34/pieza34-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">34</td>
                        <td></td></tr>

                    <!--                HEMIARCADA INFERIOR IZQUIERDA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="lingual" title="lingual"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal" title="distal"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA INFERIOR IZQUIERDA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-35 dientePermanente" data-diente="35" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza35/pieza35-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">35</td>
                        <td></td></tr>

                    <!--                HEMIARCADA INFERIOR IZQUIERDA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="lingual" title="lingual"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal" title="distal"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA INFERIOR IZQUIERDA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-36 dientePermanente" data-diente="36" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >


                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza36/pieza36-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">36</td>
                        <td></td></tr>

                    <!--                HEMIARCADA INFERIOR IZQUIERDA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="lingual" title="lingual"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal" title="distal"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA INFERIOR IZQUIERDA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-37 dientePermanente" data-diente="37" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza37/pieza37-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">37</td>
                        <td></td></tr>

                    <!--                HEMIARCADA INFERIOR IZQUIERDA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="lingual" title="lingual"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal" title="distal"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA INFERIOR IZQUIERDA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

            <li class="diente-38 dientePermanente" data-diente="38" style="margin-right: 6.5px ; margin-left: 6.5px">

                <!--                                    PIEZAS DIENTES-->

                <table class="pieza piezaClick " id="" style="padding: 5px; margin-left: 2px" >

                    <!--                        MENU DROP DOWN ESTADOS-->
                    <tr>
                        <td colspan="3">
                            <div class="dropdown-diente">
                                <div class="dropbtn-diente " onclick="mostratDientesEstados($(this))">
                                    <img src="<?= DOL_HTTP . '/logos_icon/logo_default/odontograma/numeros_dientes/dropwdon-menu-pieza38/pieza38-ai.png'?>" alt="">
                                </div>
                                <div id="myDropdown-detalle" class="dropdown-content-diente">
                                    <?= $dropdownMenuEstadosDientes; ?>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr><td></td>
                        <td  style="font-size: 1rem" class="text-center" title="">38</td>
                        <td></td></tr>

                    <!--                HEMIARCADA INFERIOR IZQUIERDA-->
                    <tr>
                        <td></td>
                        <td  class="boderTd CaraClickDenticionPermanente cara" data-id="lingual" title="lingual"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="mesial" title="mesial"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="oclusal" title="oclusal"></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="distal" title="distal"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="boderTd CaraClickDenticionPermanente cara" data-id="vestibular" title="vestibular"></td>
                        <td></td>
                    </tr>
                    <!--                HEMIARCADA INFERIOR IZQUIERDA-->

                    <tr>
                        <td></td>
                        <td class="text-center"><input type="checkbox" id="CheckPiezas" class="CheckPiezasDenticionPermanente"> </td>
                        <td></td>
                    </tr>

                </table>

            </li>

        </ul>


        <!--    ------------------------------------    -->


        <?php

        //    $ix++; }

        ?>
    </div>
</div>


