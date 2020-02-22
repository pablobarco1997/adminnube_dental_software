

<style>

    /* Custom checkbox */
    .custom-checkbox-myStyle {
        position: relative;
    }
    .custom-checkbox-myStyle input[type="checkbox"] {
        opacity: 0;
        position: absolute;
        margin: 5px 0 0 3px;
        z-index: 9;
    }
    .custom-checkbox-myStyle label:before{
        width: 18px;
        height: 18px;
    }
    .custom-checkbox-myStyle label:before {
        content: '';
        margin-right: 10px;
        display: inline-block;
        vertical-align: text-top;
        background: white;
        border: 1px solid #bbb;
        border-radius: 2px;
        box-sizing: border-box;
        z-index: 2;
    }
    .custom-checkbox-myStyle input[type="checkbox"]:checked + label:after {
        content: '';
        position: absolute;
        left: 6px;
        top: 3px;
        width: 6px;
        height: 11px;
        border: solid #000;
        border-width: 0 3px 3px 0;
        transform: inherit;
        z-index: 3;
        transform: rotateZ(45deg);
    }
    .custom-checkbox-myStyle input[type="checkbox"]:checked + label:before {
        border-color: #212f3d;
        background: #15528A;
    }
    .custom-checkbox-myStyle input[type="checkbox"]:checked + label:after {
        border-color: #fff;
    }
    .custom-checkbox-myStyle input[type="checkbox"]:disabled + label:before {
        color: #b8b8b8;
        cursor: auto;
        box-shadow: none;
        background: #ddd;
    }

    .custom-checkbox-myStyle input[type="checkbox"]{
        cursor: pointer;
    }

</style>


<div class="row">
    <div class="form-group col-md-12 col-xs-12" >
       <div class="table-responsive">
           <table class="table table-striped" id="tableAgenda" width="100%" >
               <thead>
                   <tr>
                       <th class="text-left" width="5%">
                           <span class="custom-checkbox-myStyle">
								<input type="checkbox" id="checkeAllCitas" >
								<label for="checkeAllCitas"></label>
							</span>
                       </th>
                       <th class="text-center" width="15%">N.- CITA</th>
                       <th class="text-center" width="10%">HORA</th>
                       <th class="text-center" width="14%">PACIENTE</th>
                       <th class="text-center" width="15%">DOCTOR</th>
                       <th class="text-center" width="30%">ESTADO CITA</th>
                       <th class="text-center" width="15%">SITUACIÓN</th>
                   </tr>
               </thead>
           </table>

       </div>
    </div>

</div>