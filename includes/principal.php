<?
ini_set('display_errors',0);
error_reporting(E_ALL);
// URL Automática
$pastaEPagina = explode("/",$_SERVER['PHP_SELF']);
$pastaDominio = "";
for($i=0; $i < count($pastaEPagina); $i++){
	if(substr_count($pastaEPagina[$i], ".") == 0){
		$pastaDominio .= $pastaEPagina[$i]."/";
	}
}
$url = "http://".$_SERVER['HTTP_HOST'].$pastaDominio;
include('functions.php');
if (!isset($h1)) { $h1 = ''; } 
if (!isset($description)) { $description = ''; }
if (!isset($key)) { $key = ''; }
/*--------------------------------------------------------------
- Configurações Gerais
--------------------------------------------------------------*/
$exibirPreenchimentoObrigatorio = false;
$textoCreditos              = '';
$urlCreditos                = '';
$nomeSite                   = 'Lucas Borges';
$slogan                     = 'slogan';
$classificacao              = '';
$ddd                        = '(11)';
$prestadora					= '(021)'; /*----Opcional de quem vai ligar 'Apenas Mobile'----*/
// $whatsapp					= '<img src="img/icones/logo-whatsapp.png" alt="" title="" />'; /*Deixar em branco caso o cliente não tenha whatsapp*/
$telefone                   = '95247-3849';
$telefone2                  = '';
$telefone3                  = '';
$telefone4                  = '';
$email                      = 'lucasuilherme389@gmail.com';
$rua                        = 'R. Pacujá, 16';
$bairro                     = 'JD. Gonzaga';
$cidadeUF                   = 'SP';
$cep                        = 'CEP: ';
$AtividadesEmpresa          = 'Serviços';
$urlAtividadesEmpresa       = 'servicos.php';
$fraseLinkagemInterna       = 'Veja Também: ';
$saibaMaisLinkPaginaContato = 'contato.php';
$IDFacebook                 = '';
$whats = '5511952473849';
$urlagradecimento = "agradecimento.php";

/*--------------------------------------------------------------
- Ativar e desativar partes do site
--------------------------------------------------------------*/
// true = sim  /  false = não
// Exibe links e Imagens de exeplo apenas para fins de layout
// Deve ser marcado como false ao finalizar a criação do site
$exibirLinksEImagensDeExemplo = true;
$exibirBarraLateral = false;
$exibirBarraLateralInformacoes = false;
$exibirBarraLateralIndex = false;
$exibirBreadcrumb = true;
$exibirRedesSociaisConteudo = true;
$exibirGaleria = true;
$exibirRegioes = false;
$exibirLinkagemInterna = true;
$exibirProdutosRelacionados = true;
$exibirTags = true;
$exibirMaisVisitados = true;
$exibirTextoDireitosAutorais = true;
$exibirVoltarParaOTopo = true;
$exibirPopupAviso = false;

// Créditos Digitall
$exibirCreditosNaHead = true;
$exibirSelosDigitall = true;

// Saiba Mais Sobre
$exibirSaibaMaisSobre = true;

// Redes sociais Rodapé
$exibirRedesSociaisRodape = false;
$urlFacebook   = '#'; // Insira a URL ou remova o #
$urlTwitter    = '#';
$urlGooglePlus = '#';
$urlLinkedin   = '#';
$urlYouTube    = '#';
$urlPinterest  = '#';
$urlRSS        = '#';

// Texto imagme Ulustrativa
$exibirGaleriaTextoImagemIlustrativa = true;
$descricaoImagemIlustrativa          = 'Imagem ilustrativa para <strong>'.$h1.'</strong>';
// Direção Sub Menu
$direcaoSubMenu = 'right'; // valores: 'right' ou 'left'
/*--------------------------------------------------------------
- Bibliotecas e Plugins
--------------------------------------------------------------*/
$versaoJQuery = 1; // 0 = Sem jQuery (não recomendado)  |  1 = jquery-1.11.3.min.js  |  2 = jquery-2.1.3.min.js  |  3 = jquery.js (arquivo personalizado do jQuery)
/*--------------------------------------------------------------
- Configurações de Pastas e URLs
--------------------------------------------------------------*/
// Pastas
$imagensPadrao      = 'img/';
$pastaImagens       = $imagensPadrao.'grande/';
$pastaImagensDigitall = $imagensPadrao.'icones/';
$pastaImagensThumbs = $pastaImagens.'pequena/';
$pastaInc           = 'includes/';
$pastaJS            = 'js/';
$pastaCSS           = 'css/';
$pastaCaptcha       = 'captcha/';
$pastaFonts         = 'font/';
$pastaPhpMailer     = 'phpmailer/';
$pastaAjax          = 'ajax/';
$pastaDocumentos    = 'docs/';
$pastaGerador       = '_gerador';
$pastaTemporario    = '_temporario';
// URLs
$nomePagina           = explode("/", $_SERVER['PHP_SELF']); // com .php
$nomePagina           = end($nomePagina);
$urlGaleria           = str_replace( '.php', '', $nomePagina ); // sem .php
// Pega o nome do arquivo/página atual
if ( $nomePagina == 'index.php' || '') {
	$nomePagina = '';
	$urlCanonical = $url;
} else {
	$urlCanonical = $url.$nomePagina;
}

// ---------------------------------------------------
// Configurações do formulário
// ---------------------------------------------------
/*$titulo_email = 'Contato via site '.$nomeSite;
$nome_pagina_formulario = 'contato-telefone-email';
$redirecionar_pagina_apos_envio = true;
$scroll_top_aviso_erro = true;
$url_parametro_enviado_com_sucesso = '?email-enviado-com-sucesso';
$nome_arquivo_request = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];

$formularioHabilitarAnexo = false;
$tempoUsuarioReportarErroDenovo = 600; // em minutos (sem aspas)

$dominio = '';
$port = '';
$emailRemetente = ''; 
$senhaEmail = '';
$emailContato = ''; */

/*--------------------------------------------------------------
- Configurações necessárias (Não remover)
--------------------------------------------------------------*/
$mapasite                       = false;
$menuRodape                     = false;
/*--------------------------------------------------------------
- Palavras Chaves (Utilizar o gerador)
--------------------------------------------------------------*/
$separarSegmentos = false;
$seguementoMenu = array();
$seguementoMenu["Informações"] = array();
$menu["venda-de-tapetes"]="Venda de Tapetes";
array_push($seguementoMenu["Informações"],"venda-de-tapetes");
$menu=acasesort($menu);
/*-------------------------------------------------------------------
- verifica o menu e tira as palavras chave
-------------------------------------------------------------------*/
/* Chama a função de verificação */
$arrayMenuStark = $menu;
/* Funcao verifica se as paginas existem */
if(keysExist() == false){
	/* destrói a variavel menu. */
	unset($menu);
}