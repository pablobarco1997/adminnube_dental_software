
    <p class="text-center">FICHA CLINICA</p>
        <div style="width: 100%">
            <p class="text-center" style="background-color: black; color: #dddddd">DATOS PERSONALES</p>
        </div>

        <div class="row">
            <div class="col-md-12">
                NOMBRE Y APELLIDO
                <input type="text" class="form-control input-sm" name="doc_nombre_apellido" id="doc_nombre_apellido">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">CEDULA/PASAPORTE <input type="text" class="form-control input-sm" name="doc_cedula" id="doc_cedula"></div>
            <div class="col-md-6">FECHA NACIMIENTO <input type="date" class="form-control input-sm" name="doc_fecha_nc" id="doc_fecha_nc"></div>
        </div>

    <div class="row">
        <div class="col-md-4">LUGAR DE NACIMIENTO <input type="text" class="form-control input-sm" id="doc_lugar_n"></div>


        <div class="col-md-4">ESTADO CIVIL
                    <select  class="form-control input-sm" id="doc_estado_civil">
                                    <option value="soltero(a)">soltero(a)</option>
                                    <option value="casado(a)">casado(a)</option>
                      </select>
        </div>

        <div class="col-md-4">N DE HIJOS          <input type="text" class="form-control input-sm" id="doc_hijos_n"></div>
    </div>

    <div class="row">
        <div class="col-md-3">
             SEXO:&nbsp;
            <div class="checkbox"><label><input type="radio" id="radioMasculino" name="sexo"  value="masculino" >&nbsp;Masculino</label></div>
        </div>
        <div class="col-md-3">
            &nbsp;
            <div class="checkbox"><label><input type="radio" id="radioFemenino" name="sexo" value="femenino" >&nbsp;Femenino</label></div>
        </div>
        <div class="col-md-3">EDAD <input type="text" class="form-control input-sm" id="doc_edad"></div>
        <div class="col-md-3">OCUPACIÓN <input type="text" class="form-control input-sm" id="doc_ocupacion"></div>
    </div>

    <div class="row">
        <div class="col-md-12">DIRECCIÓN DE DOMICILIO <input type="text" class="form-control input-sm" id="doc_domicilio"></div>
    </div>

    <div class="row">
        <div class="col-md-4">TELEFONO CONVENCIONAL <input type="text" class="form-control input-sm" id="doc_telef_convencional"></div>
        <div class="col-md-4">
            OPERADORA
            <select class="form-control input-sm" id="doc_operadora">
                <option value="ninguno">ninguno</option>
                <option value="cnt">CNT     </option>
                <option value="claro">CLARO </option>
                <option value="movistar">MOVISTAR</option>
                <option value="otros">OTROS</option>
            </select>
        </div>
        <div class="col-md-4">
            CELULAR
            <input type="text" class="form-control input-sm" id="doc_celular">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">EN CASO DE EMERGENCIAS LLAMAR A <input type="text" class="form-control input-sm" id="doc_emergencia_call_a"></div>
        <div class="col-md-6">TELEFONO <input type="text" class="form-control input-sm" id="doc_emergencia_telef"></div>
    </div>

    <div class="row">
        <div class="col-md-6">E-MAIL <input type="text" class="form-control input-sm" id="doc_email"></div>
        <div class="col-md-6">TWITER <input type="text" class="form-control input-sm" id="doc_twiter"></div>
    </div>

    <div class="row">
        <div class="col-md-6">LUGAR DE TRABAJO <input type="text" class="form-control input-sm" id="doc_lugar_trabajo"></div>
        <div class="col-md-6">TELEFONO <input type="text" class="form-control input-sm" id="doc_telef_trabajo"></div>
    </div>

    <div class="row">
        <div class="col-md-12">
            ¿QUÉ SEGURO POSEE? <input type="text" class="form-control input-sm" id="doc_q_seguro_posee">
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            MOTIVO DE LA CONSULTA <input type="text" class="form-control input-sm" id="doc_motivo_consulta">
        </div>
    </div>

    <br>
    <div style="width: 100%">
        <p class="text-center" style="background-color: black; color: #dddddd">ANTECEDENTES MEDICOS</p>
    </div>

    <div class="row">
        <div class="col-md-12">
            ¿TIENE CONFIRMADA ALGUNA(5) DE LAS SIGUIENTES ENFERMEDADES?
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="checkbox"><label><input type="checkbox" id="respiratoria"> RESPIRATORIA </label></div>
        </div>

        <div class="col-md-3">
            <div class="checkbox"><label><input type="checkbox" id="diabetes"> DIABETES </label></div>
        </div>

        <div class="col-md-3">
            <div class="checkbox"><label><input type="checkbox" id="sida"> SIDA (VIH) </label></div>
        </div>

        <div class="col-md-3">
            <div class="checkbox"><label><input type="checkbox"  id="renal"> RENAL </label></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="checkbox"><label><input type="checkbox" id="cardiaca"> CARDIACA </label></div>
        </div>

        <div class="col-md-3">
            <div class="checkbox"><label><input type="checkbox" id="sanguinia"> SANGUINIA </label></div>
        </div>

        <div class="col-md-3">
            <div class="checkbox"><label><input type="checkbox" id="hepatitis" > HEPATITIS </label></div>
        </div>

        <div class="col-md-3">
            <div class="checkbox"><label><input type="checkbox" id="gastritis"> GASTRICAS </label></div>
        </div>
    </div>

    <div class="row">
       <div class="col-md-12">  OTRAS ENFERMEDADES <input type="text" class="form-control input-sm" id="doc_otras_enferm"> </div>
    </div>

    <!--enfermedades 1-->
    <div class="row">

        <div class="col-md-4" style="border-left: 1px solid black">
            <div class="row">
                <div class="col-md-12"><p>¿ESTAS BAJO ALGUN TRATAMIENTO MEDICO?</p></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="text-left">
                        <div class="checkbox">
                            <label for="">
                                <input type="radio" name="tratamiento" id="doc_tratmient_si"> SI
                            </label>
                            <label for="">
                                <input type="radio" name="tratamiento" id="doc_tratmient_no">  NO
                            </label>
                        </div>
                        <div class="checkbox">
                            <label for="">Cual? <input type="text" class="form-control input-sm" id="doc_tratmient_descrip"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4" style="border-left: 1px solid black">
            <div class="row">
                <div class="col-md-12"><p>¿ES ALERGICO A ALGÚN MEDICAMENTO?</p></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="text-left">
                        <div class="checkbox">
                            <label for="">
                                <input type="radio" name="alergia" id="doc_alergia_si"> SI
                            </label>
                            <label for="">
                                <input type="radio" name="alergia" id="doc_alergia_no"> NO
                            </label>
                        </div>
                        <div class="checkbox">
                            <label for="">Cual? <input type="text" class="form-control input-sm" id="doc_descrip_alergia"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4"  style="border-left: 1px solid black">
            <div class="row">
                <div class="col-md-12"><p>¿ESTA EMBARAZADA? </p></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="text-left">
                        <div class="checkbox">
                            <label for="">
                                <input type="radio" id="doc_embarazada_si" name="embarazada"> SI
                            </label>
                            <label for="">
                                <input type="radio" id="doc_embarazada_no" name="embarazada"> NO
                            </label>
                        </div>
                        <div class="checkbox">
                            <label for="">Cual? <input type="text" class="form-control input-sm" id="doc_descrip_embarazada"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--enfermedades 2-->
    <div class="row">

        <div class="col-md-4" style="border-left: 1px solid black">
            <div class="row">
                <div class="col-md-12"><p>¿TIENE PROBLEMAS HEMORRÁGICOS?</p></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="text-left">
                        <div class="checkbox">
                            <label for="">
                                <input type="radio" name="hemorragicos" id="doc_hemorragicos_si"> SI
                            </label>
                            <label for="">
                                <input type="radio" name="hemorragicos" id="doc_hemorragicos_no"> NO
                            </label>
                        </div>
                        <div class="checkbox">
                            <label for="">Cual? <input type="text" class="form-control input-sm" id="doc_descrip_hemorragicos"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4" style="border-left: 1px solid black">
            <div class="row">
                <div class="col-md-12"><p>¿TOMA ALGÚN MEDICAMENTO FRECUENTE?</p></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="text-left">
                        <div class="checkbox">
                            <label for="">
                                <input type="radio" name="medicamento_frecuente" id="doc_medicamento_si"> SI
                            </label>
                            <label for="">
                                <input type="radio" name="medicamento_frecuente" id="doc_medicamento_no"> NO
                            </label>
                        </div>
                        <div class="checkbox">
                            <label for="">Cual? <input type="text" class="form-control input-sm" id="doc_descrip_medicamento"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4"  style="border-left: 1px solid black">
            <div class="row">
                <div class="col-md-12"><p>¿TIENE ENFERMEDAD(ES) HEREDITARIAS? </p></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="text-left">
                        <div class="checkbox">
                            <label for="">
                                <input type="radio" name="enfer_hederitaria" id="doc_hereditaria_si"> SI
                            </label>
                            <label for="">
                                <input type="radio" name="enfer_hederitaria" id="doc_hereditaria_no"> NO
                            </label>
                        </div>
                        <div class="checkbox">
                            <label for="">Cual? <input type="text" class="form-control input-sm" id="doc_descript_hederitaria"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <br>
    <div style="width: 100%">
        <p class="text-center" style="background-color: black; color: #dddddd">ANTECEDENTES ODONTOLOGICOS</p>
    </div>

    <div class="row">
        <div class="col-md-12">
            ¿QUÉ MEDICINA TOMÓ EN LAS ÚLTIMAS 24 HORAS?
            <input type="text" class="form-control input-sm" id="doc_q_medicina_tomo_24h_ultima">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            ¿ES RESISTENTE A ALGÚN MEDICAMENTO?
            <input type="text" class="form-control input-sm" id="doc_resistente_medicamento">
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">

            <div class="row">
                <div class="col-md-6">
                    <label>¿HA TENIDO HEMORRAGIAS BUCALES?</label>
                    <div class="checkbox"><label for=""><input type="radio" name="hemorragias_bocales" id="doc_hemorragias_si">SI</label>&nbsp;  <label for=""><input type="radio" name="hemorragias_bocales" id="doc_hemorragias_no">NO</label></div>
                </div>
                <div class="col-md-6">
                    <label>¿COMPLICACIONES POR MASTICAR?</label>
                    <div class="checkbox"><label for=""><input type="radio" name="problemas_masticar" id="doc_problema_masticar_si">SI</label>&nbsp;  <label for=""><input type="radio" name="problemas_masticar" id="doc_problema_masticar_no">NO</label></div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6">
                    <label>¿TIENE LOS SIGUIENTES HÁBITOS DE CONSUMO?</label>
                    <div class="checkbox"><label for=""><input type="checkbox" id="doc_fumar">FUMAR</label>&nbsp; </div>
                    <div class="checkbox"><label for=""><input type="checkbox" id="doc_alchol">TOMAR ALCOHOL</label></div>
                    <div class="checkbox"><label for=""><input type="checkbox" id="doc_cafe">TOMAR CAFÉ</label>&nbsp; </div>
                    <div class="checkbox"><label for=""><input type="checkbox" id="doc_ninguno">NINGUNO</label></div>
                </div>

            </div>

        </div>

        <div class="col-md-6">

            <br>
            <p style="padding: 5px; text-align: center; border: 1px solid #00a157">
                DECLAROQUE HE RESPONDIDO TODAS LAS PREGUNTAS CON SINCERIDAD Y QUE NO RESPONSABILIZO A LA CLINICA POR LA INFORMACIÓN NO VERAZ
            </p>
            <p style="width: 100%; border: 1px solid #000000; height: 100px">

            </p>
        </div>

    </div>

    <div class="form-group">
        <button class="btn  btn-block " id="guardar_informacion_fichaclinica"> <i class="fa fa-save"></i> &nbsp; GUARDAR </button>
    </div>