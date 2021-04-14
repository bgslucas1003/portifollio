<?php
session_start();
if(isset($_SESSION["persissoesFormulario"])){
	unset($_SESSION["persissoesFormulario"]);
}
include 'includes/principal.php';
require_once("phpmailer/PHPMailerAutoload.php");

if ($exibirLinksEImagensDeExemplo) {
	if(!isset($menu) || (count($menu)<=1 && (isset($menu['_exemplo.php']) || isset($menu['_exemplo']))))
	{
		$seguementoMenu=array("Segmento 1"=>array(),"Segmento 2"=>array());
		$menu=array("pagina-conversao.php" => "Pagina de Conversao");
		$menu=acasesort($menu);
		$totalSegmentoMenuExemplo=count($seguementoMenu);
		$totalMenuExemplo=count($menu);
		#se tiver conteudo nas variaveis menu e segmentoMenu
		if($totalMenuExemplo>0 && $totalSegmentoMenuExemplo>0 && $totalMenuExemplo>$totalSegmentoMenuExemplo)
		{
			$sobraExemploMenuPorSegmentoMenu=$totalMenuExemplo%$totalSegmentoMenuExemplo;
			$totalExemploMenuPorSegmentoMenu=($totalMenuExemplo-$sobraExemploMenuPorSegmentoMenu)/$totalSegmentoMenuExemplo;
			$segmentoAtualMontarSegmentoExemplo=0;
			foreach($seguementoMenu as $segmentoExemplo=>$segmentoExemplo)
			{
				++$segmentoAtualMontarSegmentoExemplo;
				$paginasAtualMontarSegmentoExemplo=0;
				#se for o último segmento acrescenta os menus que sobraram
				$acressentarSobra=$segmentoAtualMontarSegmentoExemplo==$totalSegmentoMenuExemplo && isset($sobraExemploMenuPorSegmentoMenu) && $sobraExemploMenuPorSegmentoMenu>0?$sobraExemploMenuPorSegmentoMenu:0;
				foreach($menu as $linkExemplo=>$pageExemplo)
				{
					++$paginasAtualMontarSegmentoExemplo;
					if($paginasAtualMontarSegmentoExemplo>($segmentoAtualMontarSegmentoExemplo*$totalExemploMenuPorSegmentoMenu)+$acressentarSobra)
					{
						#passa para o próximo segmento
						continue 2;
					}
					else if($paginasAtualMontarSegmentoExemplo>(($segmentoAtualMontarSegmentoExemplo-1)*$totalExemploMenuPorSegmentoMenu))
					{
						#acrescenta o menu ao segmento
						array_push($seguementoMenu[$segmentoExemplo],$linkExemplo);
					}
				}
			}
		}
	}
}
/*--------------------------------------------------------------
- Definir Cookie com URL da página para usar no erro.php
--------------------------------------------------------------*/
setcookie("ultima_pagina", $url.$nomePagina, time()+3600);  /* expira em 1 hora */
/*----------------------------------------------------------
- Chama função para montar Key
-----------------------------------------------------------*/
if(isset($h1) && $h1!=""){
	// $montagemKey=!in_array($nomePagina,$paginasNaoAplicar)?montarKey($h1,$adicionarNoFinalDasKeysH1,$naoMontarKeysComEssasPalavras,$adicionarEssasKeysEmTodasAsPaginas):'';
	$keyMontar = array();
	array_push($keyMontar, $h1);
	if (isset($key) && !empty($key)) {
		array_push($keyMontar, $key);
	}
	if (isset($montagemKey) && !empty($montagemKey)) {
		array_push($keyMontar, $montagemKey);
	}
	$key = implode($keyMontar,', ');
}
/*----------------------------------------------------------
- Habilita a detecção de mobile (http://mobiledetect.net/)
-----------------------------------------------------------*/
include('includes/mobile_detect.php');
$detect = new Mobile_Detect;
?><!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta name="viewport" content="initial-scale=1" />
	<meta charset="UTF-8" />
	<?php
	if($exibirCreditosNaHead) {
		echo "
		<!--
		Site desenvolvido por $textoCreditos
		$urlCreditos
		Cliente: $nomeSite
	-->";
}
?>
<title><?=$h1?> - <?=$nomeSite?></title>
<link rel="canonical" href="<?=$urlCanonical?>" />
<meta name="robots" content="index,follow" />
<meta name="description" content="<?=$h1.". ".$description?>" />
<meta name="keywords" content="<?=$key?>" />
<?php echo $geolocation; ?>
<meta name="classification" content="<?=$classificacao?>" />
<meta property="publisher" content="<?=$textoCreditos?>" />
<meta property="og:type" content="website" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:region" content="Brasil" />
<meta property="og:title" content="<?=$h1?> - <?=$nomeSite?>" />
<meta property="og:author" content="<?=$nomeSite?>" />
<meta property="og:url" content="<?=$urlCanonical;?>" />
<meta property="og:description" content="<?=$description;?>" />
<meta property="og:site_name" content="<?=$nomeSite?>" />
    <meta name="thumbnail" content="<?php echo $url.$imagensPadrao.'logodata2.png' ?>" />
    <meta property="og:image" content="<?php echo $url.$imagensPadrao.'logodata2.png' ?>" />
<?php if ( $IDFacebook != '' ) { ?>
<meta property="fb:admins" content="<?$IDFacebook?>" />
<?php }	?>
<?php
	/*--------------------------------------------------------------
	- Meta tag que exibe miniaturas do lado dos resultados de busca
	--------------------------------------------------------------*/
	if ($nomePagina == 'index.php' || $nomePagina == 'index' || $nomePagina == 'informacoes.php' || $nomePagina == 'informacoes' || $nomePagina == 'servicos.php' || $nomePagina == 'servicos' || $nomePagina == 'contato-telefone-email.php' || $nomePagina == 'contato-telefone-email') {
		if (file_exists($imagensPadrao.'logodata.jpg')) { ?>
		<meta name="thumbnail" content="<?php echo $url.$imagensPadrao.'logodata.jpg' ?>" />
		<meta property="og:image" content="<?php echo $url.$imagensPadrao.'logodata.jpg' ?>" />
		<?php } elseif (file_exists($imagensPadrao.'logodata.png')) { ?>
		<meta name="thumbnail" content="<?php echo $url.$imagensPadrao.'logodata.png' ?>" />
		<meta property="og:image" content="<?php echo $url.$imagensPadrao.'logodata.png' ?>" />
		<?php }
	} else {
		if (file_exists($pastaImagensThumbs.$urlGaleria.'-01.jpg')) { ?>
		<meta name="thumbnail" content="<?php echo $url.$pastaImagensThumbs.$urlGaleria.'-01.jpg' ?>" />
		<meta property="og:image" content="<?php echo $url.$pastaImagensThumbs.$urlGaleria.'-01.jpg' ?>" />
		<?php } elseif (file_exists($pastaImagensThumbs.$urlGaleria.'-01.png')) { ?>
		<meta name="thumbnail" content="<?php echo $url.$pastaImagensThumbs.$urlGaleria.'-01.png' ?>" />
		<meta property="og:image" content="<?php echo $url.$pastaImagensThumbs.$urlGaleria.'-01.png' ?>" />
		<?php }
	}
	?>
	<?php
	/*--------------------------------------------------------------
	- Folhas de Estilo
	--------------------------------------------------------------*/
	?>
	<style type="text/css">
		<?php
		$pastaCSS = 'css/';
		$arquivosCSS = array(
			// Insira os Arquivos CSS abaixo (um por linha)
			$pastaCSS.'style.css',
			$pastaCSS.'magnific-popup.css',
			$pastaCSS.'slick-theme.css',
			$pastaCSS.'slick.css',
			$pastaCSS.'normalize.css',
			$pastaCSS.'bootstrap.min.css',
			$pastaCSS.'aos.css',
			$cssValidacaoPreenchimento // Arquivo Temporario de verificação de campos
			);
		for ($i=0; $i < count($arquivosCSS); $i++) {
			echo arquivos_inline($arquivosCSS[$i]);
		}
		?>
	</style>
	<?php
	/*--------------------------------------------------------------
	- Outros Arquivos / Configurações
	--------------------------------------------------------------*/
	?>
    <link rel="shortcut icon" href="<?=$url?>" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    