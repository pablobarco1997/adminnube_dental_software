<div class="row">
    <div class="col-md-12">
        <div class="row">

            <div style="padding: 10px">

                <div class="col-md-12">

                    <div style="width: 100%; padding: 10px">
                        <div class="form-group">

<!--                            COmentario de los doctores-->
                            <h3>Comentarios administrativos</h3>
                            <div class="direct-chat-messages" id="mensajesInsert">


<!--                                MENSAJE ITEM #2-->
                                <?php for ($i = 0; $i <= 0; $i++){ ?>

                                    <div class="direct-chat-msg">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-left">Alexander Pierce</span>
                                            <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                                        </div>
                                        <!-- /.direct-chat-info -->
                                        <img class="direct-chat-img" src="https://icon-library.net/images/avatar-icon-images/avatar-icon-images-4.jpg" alt="message user image">
                                        <!-- /.direct-chat-img -->
                                        <div class="direct-chat-text">
                                            Is this template really for free? That's unbelievable!
                                        </div>
                                        <!-- /.direct-chat-text -->
                                    </div>

                                <?php }?>


                            </div>

                            <hr>

                            <div class="form-group">
                                <textarea class="form-control margenTopDiv"  id="texto_comment" placeholder="Comentario ..."></textarea>
<!--                                <input type="text" name="message" class="form-control">-->
                                <button type="button" id="comment" class="btn btn-success btn-block margenTopDiv"><i class="fa fa-commenting-o"></i>&nbsp;&nbsp;Comment</button>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>