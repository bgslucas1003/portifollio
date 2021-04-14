<?php
if (!$mapasite && !$menuRodape) { ?>

    <!-- Início do Menu-->
<div class="menu-principal">
    <nav id="nav-menu-container">
        <ul class="nav-menu">
            <?php } ?>
    
            <li class="nav-slow active-menu">
                <a class="nav-item " href="https://api.whatsapp.com/send?phone=5511952473849">Entre em contato</a>
            </li>

            <?
            if (isset($menu)) {
                ?>
                <li class="submenu">
                    <a href="<?= $url . $urlAtividadesEmpresa ?>"
                       title="<?= $AtividadesEmpresa ?> <?= $nomeSite ?>"><?= $AtividadesEmpresa ?></a>
                    <ul>
                        <?php echo retornaMenu("menuPrincipal"); ?>
                    </ul>
                </li>
                <?
            }
            ?>
            <?php
            if (!$mapasite && !$menuRodape) { ?>
        </ul>
    </nav><!-- #nav-menu-container -->


</div>

<?php } ?>
