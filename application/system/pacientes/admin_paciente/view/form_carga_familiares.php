<div class="row">

    <div class="col-md-12">

        <div class="row">

            <div style="padding: 10px">

                <div class="col-md-12">
                    <div style="width: 100%; padding: 10px">

                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-9 col-xs-12 margin-bottom">
                                    <select name="" id="cargafamiliar" style="width: 100%">
                                        <option value=""></option>

                                        <?php

                                            $sql = "SELECT * FROM tab_admin_pacientes";
                                            $rs =  $db->query($sql);

                                            if($rs->rowCount() > 0)
                                            {
                                                while($obj = $rs->fetchObject())
                                                {
                                                    echo "<option value='$obj->rowid'>$obj->nombre  $obj->apellido</option>";
                                                }
                                            }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3 col-xs-12 margin-bottom">
                                    <button class="btn btn-success"> Agregar </button>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <br>

                <div class="col-md-12">
                    <div style="width: 100%; padding: 10px">
                        <div class="form-group">
                            <div class="table-responsive">

                                <table class="table" id="table_carga_familiares" width="100%">

                                    <thead style="background-color: #FDFEFE">
                                        <tr>
                                            <th WIDTH="33.33%" >Nombre</th>
                                            <th WIDTH="33.33%" >RUT/DNI</th>
                                            <th WIDTH="33.33%" >Fecha</th>
                                        </tr>
                                    </thead>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>

    </div>

</div>