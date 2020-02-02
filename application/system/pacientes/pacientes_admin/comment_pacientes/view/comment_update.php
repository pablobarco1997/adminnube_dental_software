<?php

$data_comment = array();

$sql1   = "SELECT (select concat(o.nombre_doc , ' ' , o.apellido_doc) from tab_odontologos o where o.rowid = c.fk_odontologos) doc , c.comentario FROM tab_comentarios_odontologos c WHERE c.fk_paciente = $idPaciente order by  c.rowid asc ";
$acce   = $db->query($sql1);

if($acce->rowCount() > 0)
{
    while ($obj = $acce->fetchObject())
    {
        $data_comment[] = (object)array(
            "doctor" => $obj->doc,
            "text"   => $obj->comentario,
        );
    }

}

?>

<?php
    foreach ($data_comment as $key => $val){
?>
<!--                                MENSAJE ITEM #2-->
        <div class="direct-chat-msg">
            <div class="direct-chat-info clearfix">
                <span class="direct-chat-name pull-left"><?= $val->doctor ?></span>
            <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
            </div>
            <!-- /.direct-chat-info -->
            <img class="direct-chat-img" src="https://icon-library.net/images/avatar-icon-images/avatar-icon-images-4.jpg" alt="message user image">
                <!-- /.direct-chat-img -->
            <div class="direct-chat-text">
                <?= $val->comentario; ?>
            </div>
                <!-- /.direct-chat-text -->
        </div>

<?php } ?>