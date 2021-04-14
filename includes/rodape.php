<div class="button-whats" >
    <a href="https://api.whatsapp.com/send?phone=<?= $whats ?>" id="whatsapp" target="_blank"
       title="Atendimento Whatsapp - Lucas Borges">
        <img src="img/whatsapp2.png" title="Atendimento Whatsapp - Lucas Borges" alt="Atendimento Whatsapp - Lucas Borges"></a>
</div>

<section id="footer">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-3 col-lg-3 about-card col-12">
                <a rel="nofollow" href="<?= $url ?>" title="<?= $nomeSite ?>">
                    <img src="img/grande/aguia.png"
                         alt="<?= $nomeSite ?>"
                         title="<?= $nomeSite ?>"/>
                </a>
            </div>


            <div class="footer-contato col-md-9 col-lg-7  col-12">
                <div class="row">
                    <div class="col-lg-5 col-md-5">
                        <div class="row">
                            
                        </div>

                    </div>
                    <div class="col-md-5 col-lg-7 col-12">
                        <div class="row">

                            <div class="col-md-10 col-lg-10 text-footer col-12">
                                <p><?= $email ?></p>
                                <br>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 text-footer col-12">
                                <p><?= $ddd . " " . $telefone?></p>
                            </div>
                            

                            <div class="col-md-10  text-footer col-10">
                                <p><?= $rua . " - " . $bairro . " - " . $cidadeUF ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
       


    </div>

</section>

<?php if ($exibirVoltarParaOTopo == true): ?> <a href="#" class="voltar-para-o-topo"></a> <?php endif ?>
<?php include 'scripts.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>


 <!-- <script>
    jQuery("input.telefone")
        .mask("(99) 9999-9999?9")
        .focusout(function (event) {
            var target, phone, element;
            target = (event.currentTarget) ? event.currentTarget : event.srcElement;
            phone = target.value.replace(/\D/g, '');
            element = $(target);
            element.unmask();
            if (phone.length > 10) {
                element.mask("(99) 99999-999?9");
            } else {
                element.mask("(99) 9999-9999?9");
            }
        });
</script>
<script>
    $(document).ready(function () {

        $("#unidade1").click(function () {
            $("#mapa1").show();
            $("#mapa2").hide();
        });
        $("#unidademob1").click(function () {
            $("#mapamob1").show();
            $("#mapamob2").hide();
        });
        $("#unidade2").click(function () {
            $("#mapa2").show();
            $("#mapa1").hide();
        });
        $("#unidademob2").click(function () {
            $("#mapamob2").show();
            $("#mapamob1").hide();
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.nav-button').click(function () {
            $('body').toggleClass('nav-open');
        });
        $('.remove-contato').click(function(){
            $('body').toggleClass('nav-open');
        });
    });
</script> -->

<script src="js/aos.js"></script>
<script>

    AOS.init({
        duration: 1200,
        easing: 'ease-in-out-back'
    });
</script> 

