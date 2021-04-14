<script type="text/javascript">
	url="<?php echo $url;?>";
	popup="nao";
	nomeSite="<?php echo $nomeSite;?>";
	<?php $direcaoSubMenu=isset($direcaoSubMenu) && $direcaoSubMenu!=""?$direcaoSubMenu:"left";?>
	var direcao="<?php echo $direcaoSubMenu;?>";
	<?php
	$pastaJS = 'js/';
	if ($versaoJQuery == 1) {
		$arquivoJQuery = "jquery-1.11.3.min.js";
	} elseif ($versaoJQuery == 2) {
		$arquivoJQuery = "jquery-2.1.3.min.js";
	} elseif ($versaoJQuery == 3) {
		$arquivoJQuery = "jquery.js";
	} else {
		$arquivoJQuery = "";
	}
	$arquivosJS = array(
    // Insira os Arquivos JS abaixo (um por linha, mantenha o jQuery sempre em primeiro)
	                    $pastaJS.$arquivoJQuery,
	                    $pastaJS."jquery.magnific-popup.min.js",
	                    $pastaJS."slick.min.js",
	                    $pastaJS."scripts.js",
                        $pastaJS . "bootstrap.min.js",

	                    );
	for($i = 0; $i < count($arquivosJS); $i++) {
		echo arquivos_inline($arquivosJS[$i]);
	} ?>
</script>

<?
/*--------------------------------------------------------------
- SCHEMA.ORG
--------------------------------------------------------------*/

$filter = array("(", ")");
$ddd = str_replace($filter, "", $ddd);
$data = date("d/m/Y", filemtime($nomePagina));
$estrelas = '4.'.rand(1, 9);
$comentarios = rand(35, 35*1.5);
preg_match_all('/geo.position\" content="(.*?)\" \/>/s', $geolocation, $geolocation);
$geolocation = explode(";", $geolocation[1][0]);
$geo_longitude = $geolocation[0];
$geo_latitude = $geolocation[1];

?>
<script type="application/ld+json">
	{
		"@context": "http://www.schema.org",
		"@type": "Corporation",
		"name": "<?=$nomeSite;?>",
		"url": "<?=$url;?>",
		<?php if(file_exists($imagensPadrao.'logodata.svg')) { ?>
		"logo": "<?php echo $url.$imagensPadrao.'logodata.svg'; ?>",
		<?php } elseif(file_exists($imagensPadrao.'logodata.png')) { ?>
		"logo": "<?php echo $url.$imagensPadrao.'logodata.png'; ?>",
		<?php } elseif(file_exists($imagensPadrao.'logodata.jpg')) { ?>
		"logo": "<?php echo $url.$imagensPadrao.'logodata.jpg'; ?>",
		<?php } ?>

		<?php if(file_exists($pastaImagens.$urlGaleria.'-01.jpg')) { ?>
		"image": "<?php echo $url.$pastaImagens.$urlGaleria;?>-01.jpg",
		<?php } elseif(file_exists($imagensPadrao.'logodata.svg')) { ?>
		"image": "<?php echo $url.$imagensPadrao.'logodata.svg'; ?>",
		<?php } elseif(file_exists($imagensPadrao.'logodata.png')) { ?>
		"image": "<?php echo $url.$imagensPadrao.'logodata.png'; ?>",
		<?php } elseif(file_exists($imagensPadrao.'logodata.jpg')) { ?>
		"image": "<?php echo $url.$imagensPadrao.'logodata.jpg'; ?>",
		<?php } ?>

		"telephone": "55<?=$ddd.$telefone;?>",
		"email": "<?=$email;?>",
		"description": "<?=$description;?>",
		"address": {
			"@type": "PostalAddress",
			"streetAddress": "<?=$rua;?>",
			"addressLocality": "<?=$cidadeUF;?>",
			"addressRegion": "São Paulo",
			"postalCode": "<?=$cep;?>",
			"addressCountry": "BR"
		},

		"aggregateRating": {
			"@type": "aggregateRating",
			"ratingValue": "<?=$estrelas;?>",
			"reviewCount": "<?=$comentarios;?>"

		}
	}
</script>
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "LocalBusiness",
		"description": "<?=$description;?>",
		"name": "<?=$nomeSite;?>",
		<?php if(file_exists($pastaImagens.$urlGaleria.'-01.jpg')) { ?>
		"image": "<?php echo $url.$pastaImagens.$urlGaleria;?>-01.jpg",
		<?php } elseif(file_exists($imagensPadrao.'logodata.svg')) { ?>
		"image": "<?php echo $url.$imagensPadrao.'logodata.svg'; ?>",
		<?php } elseif(file_exists($imagensPadrao.'logodata.png')) { ?>
		"image": "<?php echo $url.$imagensPadrao.'logodata.png'; ?>",
		<?php } elseif(file_exists($imagensPadrao.'logodata.jpg')) { ?>
		"image": "<?php echo $url.$imagensPadrao.'logodata.jpg'; ?>",
		<?php } ?>
		"telephone": "55<?=$ddd.$telefone;?>",
		"address": {
			"@type": "PostalAddress",
			"streetAddress": "<?=$rua;?>",
			"addressLocality": "<?=$cidadeUF;?>",
			"addressRegion": "São Paulo", 
			"postalCode": "<?=$cep;?>",
			"addressCountry": "BR"
		},

		"geo": {
			"@type": "GeoCoordinates",
			"longitude": "<?=$geo_longitude;?>",
			"latitude": "<?=$geo_latitude;?>"
		}
	}
</script>
<script type='application/ld+json'>
	{
		"@context": "http://www.schema.org",
		"@type": "WebSite",
		"name": "<?=$nomeSite;?>",
		"url": "<?=$url;?>",
		"description": "<?=$description;?>",
		"publisher": "<?=$urlCreditos;?>"
	}
</script>
<script type='application/ld+json'>
	{
		"@context": "http://www.schema.org",
		"@type": "product",
		"brand": "<?=$nomeSite;?>",
		<?php if(file_exists($imagensPadrao.'logodata.svg')) { ?>
		"logo": "<?php echo $url.$imagensPadrao.'logodata.svg'; ?>",
		<?php } elseif(file_exists($imagensPadrao.'logodata.png')) { ?>
		"logo": "<?php echo $url.$imagensPadrao.'logodata.png'; ?>",
		<?php } elseif(file_exists($imagensPadrao.'logodata.jpg')) { ?>
		"logo": "<?php echo $url.$imagensPadrao.'logodata.jpg'; ?>",
		<?php } ?>
		"name": "<?=$h1;?>",
		"category": "Widgets",
		<?php if(file_exists($pastaImagens.$urlGaleria.'-01.jpg')) { ?>
		"image": "<?php echo $url.$pastaImagens.$urlGaleria;?>-01.jpg",
		<?php } elseif(file_exists($imagensPadrao.'logodata.svg')) { ?>
		"image": "<?php echo $url.$imagensPadrao.'logodata.svg'; ?>",
		<?php } elseif(file_exists($imagensPadrao.'logodata.png')) { ?>
		"image": "<?php echo $url.$imagensPadrao.'logodata.png'; ?>",
		<?php } elseif(file_exists($imagensPadrao.'logodata.jpg')) { ?>
		"image": "<?php echo $url.$imagensPadrao.'logodata.jpg'; ?>",
		<?php } ?>
		"description": "<?=$description;?>",
		"aggregateRating": {
			"@type": "aggregateRating",
			"ratingValue": "<?=$estrelas;?>",
			"reviewCount": "<?=$comentarios;?>"

		}
	}
</script>
<script type="application/ld+json">
	{
		"@context": "http://schema.org/",
		"@type": "Recipe",
		"mainEntityOfPage": "<?=$url.$nomePagina;?>",
		"name": "<?=$h1;?>",
		<?php if(file_exists($pastaImagens.$urlGaleria.'-01.jpg')) { ?>
		"image": "<?php echo $url.$pastaImagens.$urlGaleria;?>-01.jpg",
		<?php } elseif(file_exists($imagensPadrao.'logodata.svg')) { ?>
		"image": "<?php echo $url.$imagensPadrao.'logodata.svg'; ?>",
		<?php } elseif(file_exists($imagensPadrao.'logodata.png')) { ?>
		"image": "<?php echo $url.$imagensPadrao.'logodata.png'; ?>",
		<?php } elseif(file_exists($imagensPadrao.'logodata.jpg')) { ?>
		"image": "<?php echo $url.$imagensPadrao.'logodata.jpg'; ?>",
		<?php } ?>
		"author": {
			"@type":"Person",
			"name":"<?=$nomeSite;?>"
		},
		"datePublished": "<?=$data;?>",
		"description": "<?=$description;?>",
		"aggregateRating": {
			"@type": "AggregateRating",
			"ratingValue": "<?=$estrelas;?>",
			"reviewCount": "<?=$comentarios;?>"

		},
		"publisher": {
			"@type": "Organization",
			"name": "<?=$textoCreditos;?>",
			<?php if(file_exists($imagensPadrao.'logodata.svg')) { ?>
			"logo": "<?php echo $url.$imagensPadrao.'logodata.svg'; ?>"
			<?php } elseif(file_exists($imagensPadrao.'logodata.png')) { ?>
			"logo": "<?php echo $url.$imagensPadrao.'logodata.png'; ?>"
			<?php } elseif(file_exists($imagensPadrao.'logodata.jpg')) { ?>
			"logo": "<?php echo $url.$imagensPadrao.'logodata.jpg'; ?>"
			<?php } ?>
			}
	}
</script>
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "TechArticle",
		"headline": "<?=$h1;?>",
		"alternativeHeadline": "<?=$h1;?> - <?=$nomeSite;?>",
		"proficiencyLevel": "Expert",
		<?php if(file_exists($pastaImagens.$urlGaleria.'-01.jpg')) { ?>
		"image": "<?php echo $url.$pastaImagens.$urlGaleria;?>-01.jpg",
		<?php } elseif(file_exists($imagensPadrao.'logodata.svg')) { ?>
		"image": "<?php echo $url.$imagensPadrao.'logodata.svg'; ?>",
		<?php } elseif(file_exists($imagensPadrao.'logodata.png')) { ?>
		"image": "<?php echo $url.$imagensPadrao.'logodata.png'; ?>",
		<?php } elseif(file_exists($imagensPadrao.'logodata.jpg')) { ?>
		"image": "<?php echo $url.$imagensPadrao.'logodata.jpg'; ?>",
		<?php } ?>
		"author": "<?=$nomeSite;?>",
		"genre": "<?=$classificacao;?>",
		"keywords": "<?=$key;?>",
		"publisher": "<?=$textoCreditos;?>",
		"url": "<?=$url.$nomePagina;?>",
		"datePublished": "<?=$data;?>",
		"description": "<?=$description;?>",
		"articleBody": "<?=$description;?> - <?=$nomeSite;?>"
	}
</script>
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "BreadcrumbList",
		"itemListElement":[
		{
			"@type":"ListItem",
			"position":1,
			"item": { "@id":"<?=$url;?>", "name":"<?=$nomeSite;?>", "url":"<?=$url;?>" }
		},
		{
			"@type":"ListItem",
			"position":2,
			"item": { "@id":"<?=$url.$urlAtividadesEmpresa;?>", "name":"<?=$AtividadesEmpresa;?>", "url":"<?=$url.$urlAtividadesEmpresa;?>" }
		},
		{
			"@type":"ListItem",
			"position":3,
			"item": { "@id":"<?=$url.$nomePagina;?>", "name":"<?=$h1;?>", "url":"<?=$url.$nomePagina;?>" }
		}
		]
	}
</script>
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "Organization",
		"url": "<?php echo $url; ?>",
		<?php if(file_exists($imagensPadrao.'logodata.svg')) { ?>
			"logo": "<?php echo $url.$imagensPadrao.'logodata.svg'; ?>",
		<?php } elseif(file_exists($imagensPadrao.'logodata.png')) { ?>
			"logo": "<?php echo $url.$imagensPadrao.'logodata.png'; ?>",
		<?php } elseif(file_exists($imagensPadrao.'logodata.jpg')) { ?>
			"logo": "<?php echo $url.$imagensPadrao.'logodata.jpg'; ?>",
		<?php } ?>
		"description": "<?php echo $classificacao; ?>",
		"contactPoint" : [
			{
				"@type" : "ContactPoint",
				"telephone" : "+55 (11) <?php echo $telefone; ?>",
				"contactType" : "customer service"
			} ]},
		"location" : {
			"@type" : "Place",
			"name" : "<?php echo $nomeSite; ?>",
				"address" : "<?php echo $rua.' - '.$bairro.' - '.$cidadeUF;?>"
		},
		<?php if((isset($urlFacebook) && $urlFacebook != "#" && $urlFacebook != '') || (isset($urlTwitter) && $urlTwitter != "#" && $urlTwitter != '') || (isset($urlGooglePlus) && $urlGooglePlus != "#" && $urlGooglePlus != '')) { ?>
			"sameAs" : [
			<?php if(isset($urlFacebook) && $urlFacebook != "#") { ?>
				"<?php echo $urlFacebook; ?>",
			<?php } ?>
			<?php if(isset($urlTwitter) && $urlTwitter != "#") { ?>
				"<?php echo $urlTwitter; ?>",
			<?php } ?>
			<?php if(isset($urlGooglePlus) && $urlGooglePlus != "#") { ?>
				"<?php echo $urlGooglePlus; ?>"
			<?php } ?>
			]
		<?php } ?>
	}
</script>

<?php
/*--------------------------------------------------------------
- Popup
--------------------------------------------------------------*/
if ($exibirPopupAviso == true) {
	if(!(isset($_SESSION['popup']) && $_SESSION['popup']=="Visualizado")){
		?>
		<script type="text/javascript">
			popup="sim";
		</script>
		<?php
		$_SESSION["popup"]="Visualizado";
	}
}

/* VARIAVEIS SCHEMA.ORG */
$filter = array("(", ")");
$ddd = str_replace($filter, "", $ddd);
$data = date("d/m/Y", filemtime($nomePagina));
$estrelas = '4.'.rand(1, 9);
$comentarios = rand(35, 35*1.5);
preg_match_all('/geo.position\" content="(.*?)\" \/>/s', $geolocation, $geolocation);
$geolocation = explode(";", $geolocation[1][0]);
$geo_longitude = $geolocation[0];
$geo_latitude = $geolocation[1];
?>



<?php if(isset($ativar_script_formulario) && $ativar_script_formulario == true) {
/*--------------------------------------------------------------
-- Configurações do formulário para o sistema de emails
--------------------------------------------------------------*/
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') { $HTTP = 'http://'; } else { $HTTP = 'https://'; }
$url_redirecionar = $HTTP.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'].$url_parametro_enviado_com_sucesso;
$quantidade_campo = count($campos_obrigatorios);
array_push($campos_obrigatorios, $quantidade_campo);
if($quantidade_campo > 0) {
	for($i = 0; $i < count($campos_obrigatorios); $i++) {
		if($i == (count($campos_obrigatorios)-1)) {
			$campos_obrigatorios[$i]=base64_encode($campos_obrigatorios[$i]);
			continue;
		}
		for($j = 0; $j < count($campos_obrigatorios[$i]); $j++) {
			$campos_obrigatorios[$i][$j]=base64_encode($campos_obrigatorios[$i][$j]);
		}
	}
} else {
	$campos_obrigatorios = base64_encode('nao_tem_campos_obrigatorios');
}
$campos_obrigatorios = serialize($campos_obrigatorios);
?>
<script type="text/javascript">
	$(window).load(function(){
		$('body').prepend('<div class="popup-overlay"><div class="popup-mensagem"><div class="popup"><span class="fechar-popup"></span><div class="popup-texto-enviando-email"><div>Seu email está sendo enviado</div><div>Por favor aguarde...</div></div><div class="popup-texto-enviado-sucesso"></div></div></div><div>');
		$('form').prepend('<div class="mensagem-formulario-erro"></div>');
		<?php if(isset($_GET['email-enviado-com-sucesso'])) { ?>
			$('.fechar-popup').fadeIn(400);
			$('.popup-texto-enviado-sucesso').text('Email enviado com sucesso!');
			$('.popup-overlay').fadeIn(400);
			<?php
		} ?>
		$('body').on('click', '.fechar-popup', function() {
			$('.popup-overlay').fadeOut(400);
		});
		$('.btn-enviar-dados-formulario').click(function(){
			$('.popup-overlay').fadeIn(400);
			$('.popup-texto-enviando-email').css('display', 'table-cell');
			$('.fechar-popup').hide();
			$('.popup-texto-enviado-sucesso').hide();
			form = $(this).parents('form');
			formulario = new FormData($(form)[0]);
			site = document.location.hostname;
			formulario.append('ajax_site', site);
			formulario.append('nome_site', '<?php echo base64_encode($nomeSite); ?>');
			formulario.append('titulo_email', '<?php echo base64_encode($titulo_email); ?>');
			formulario.append('campos_obrigatorios', '<?php echo $campos_obrigatorios; ?>');
			formulario.append('nome_pagina_formulario', '<?php echo base64_encode($nome_pagina_formulario); ?>');
			formulario.append('ip', '<?php echo base64_encode($_SERVER['REMOTE_ADDR']); ?>');
			formulario.append('nome_arquivo_request', '<?php echo base64_encode($nome_arquivo_request); ?>');
			formulario.append('navegador_do_visitante', '<?php echo base64_encode($_SERVER['HTTP_USER_AGENT']); ?>');
			$.ajax({
				url: '<?php echo $url_yaslipmail;?>',
				type: 'POST',
				data: formulario,
				processData: false,
				contentType: false,
				timeout: 30000,
				error: function(x, t, m) {
					if(t==="timeout") {
						timeout_request = true;
					} else {
						timeout_request = false;
					}
				}
			})
			.done(function(retorno) {
				console.log(retorno);
				retornoJson=JSON.parse(retorno);
				if(retornoJson.erro != "") {
					$('.mensagem-formulario-erro').text(retornoJson.erro).slideDown(400);
					$('.mensagem-formulario-sucesso').slideUp(400);
					$('.popup-overlay').fadeOut(400);
					<?php if($scroll_top_aviso_erro) { ?>
						distancia_topo = form.position(top);
						distancia_topo = distancia_topo.top;
						$('body, html').animate({scrollTop: distancia_topo}, 500);
						<?php } ?>
					} else {
						<?php if($redirecionar_pagina_apos_envio) { ?>
							location.href="<?php echo $url_redirecionar ?>";
							<?php } else { ?>
								$('.fechar-popup').fadeIn(400);
								$('.popup-texto-enviado-sucesso').text(retornoJson.success).fadeIn(400);
								$('.popup-texto-enviando-email').hide();
								$('.popup-overlay').fadeIn(400);
								$('.mensagem-formulario-erro').slideUp(400);
								$('input[type="text"], textarea, input[type="telefone"], input[type="email"]').val('');
								<?php } ?>
							}
							console.log("done");
						})
			.fail(function(retorno) {
				if(timeout_request) {
					$('.mensagem-formulario-erro').text('Não foi possível enviar o email, tente novamente mais tarde...').slideDown(400);
					$('.mensagem-formulario-sucesso').slideUp(400);
					$('.popup-overlay').fadeOut(400);
				}
				console.log("fail");
			})
			.always(function(retorno) {
				console.log("finalizado");
			});
			return false;
		});
		$('input[type="text"], input[type="email"], input[type="password"]').keypress(function(tecla){
			if(tecla.keyCode == 13) {
				$(this).parents('form').find('.btn-enviar-dados-formulario').trigger('click');
			}
		});
	});
</script>
<?php } ?>