<?php
//Trata Letras Removendo acentos
require_once 'configuracoes.php';
function tratar_letras($string)
{
	$conversao = array('á' => 'a',
	                   'à' => 'a',
	                   'ã' => 'a',
	                   'â' => 'a',
	                   'é' => 'e',
	                   'ê' => 'e',
	                   'í' => 'i',
	                   'ï' => 'i',
	                   'ó' => 'o',
	                   'ô' => 'o',
	                   'õ' => 'o',
	                   "ö" => "o",
	                   'ú' => 'u',
	                   'ü' => 'u',
	                   'ç' => 'c',
	                   'ñ' => 'n',
	                   'Á' => 'A',
	                   'À' => 'A',
	                   'Ã' => 'A',
	                   'Â' => 'A',
	                   'É' => 'E',
	                   'Ê' => 'E',
	                   'Í' => 'I',
	                   'Ï' => 'I',
	                   "Ö" => "O",
	                   'Ó' => 'O',
	                   'Ô' => 'O',
	                   'Õ' => 'O',
	                   'Ú' => 'U',
	                   'Ü' => 'U',
	                   'Ç' => 'C',
	                   'N' => 'Ñ',
	                   'ý' => 'y',
	                   'ÿ' => 'y',
	                   'Ý' => 'Y'
	                   );
	foreach($conversao as $key=>$value)
	{
		$string=str_replace($key,$value,$string);
	}
	return $string;
}
function eComercial($string) {
	$string = str_replace('&', '&amp;', $string);
	return $string;
}
function telefone($telefone, $Param_ddd = false) {
    global $detect;
    global $ddd;
    global $prestadora;
    $dddLink = ($Param_ddd) ? $Param_ddd : $ddd;
    if($detect->isMobile()) {
        $telefone = str_replace(array('-', ' ', '(', ')', '_', '*', '.'), '', $telefone);
        $dddLink = str_replace(array('(',")"), '', $dddLink);
        $prestadora = str_replace(array('(',")"), '', $prestadora);
        $telefone =  preg_replace('/[^0-9]/', '', $telefone);

        $foneLink = '<a href="tel:'.$prestadora.$dddLink.$telefone.'" title="Ligue agora!">'.trim(substr($telefone, 0, (count($telefone)-5)).'-'.substr($telefone, (count($telefone)-5))).'</a>';
        return $foneLink;
    } else {
        return $telefone;
    }
}
function arquivos_inline($arquivo) {
	global $urlGaleria;
	if (file_exists($arquivo)) {
		$extensaoArquivo = explode('.', $arquivo);
		$extensaoArquivo = end($extensaoArquivo);
		$extensaoArquivo = strtolower($extensaoArquivo);
		if ($extensaoArquivo == "css") {
			$retornaCodigo = file_get_contents($arquivo);
			$retornaCodigo = str_replace(array("\n","\r","\t","\n\t"), "", $retornaCodigo);
			$retornaCodigo = str_replace(": ", ":", $retornaCodigo);
			$retornaCodigo = str_replace(", ", ",", $retornaCodigo);
			$retornaCodigo = str_replace("; ", ";", $retornaCodigo);
			$retornaCodigo = str_replace(";   ", ";", $retornaCodigo);
			$retornaCodigo = str_replace("{ ", "{", $retornaCodigo);
			$retornaCodigo = str_replace(" {", "{", $retornaCodigo);
			$retornaCodigo = str_replace(" { ", "{", $retornaCodigo);
			$retornaCodigo = str_replace("   {", "{", $retornaCodigo);
			$retornaCodigo = str_replace("} ", "}", $retornaCodigo);
			$retornaCodigo = str_replace(" }", "}", $retornaCodigo);
			$retornaCodigo = str_replace(" } ", "}", $retornaCodigo);
			$expressaoCSS = '!/\*[^*]*\*+([^/][^*]*\*+)*/!';
			$retornaCodigo = preg_replace($expressaoCSS, '', $retornaCodigo);
			return $retornaCodigo;
		} elseif ($extensaoArquivo == "js") {
			$retornaCodigo = '';
			if($arquivo=='js/scripts-formulario.min.js')
			{
				if(isset($_SESSION["camposObrigatoriosFormulario"][$urlGaleria]))
				{
					$retornaCodigo = file_get_contents($arquivo);
				}
			} else if($arquivo == 'js/scripts.js') {
				$retornaCodigo = file_get_contents($arquivo);
				$expressaoJS = '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\')\/\/.*))/';
				$retornaCodigo = preg_replace($expressaoJS, '', $retornaCodigo);
				$retornaCodigo = str_replace(array("\n","\t","\r","\n\t"), '', $retornaCodigo);
			}
			else
			{
				$retornaCodigo = file_get_contents($arquivo);
			}
			return $retornaCodigo;
		}
	}
}
/*Montar KEY WORD*/
function montarKey($pchave,$adicionarNoFinalDasKeysH1,$removeemKeys,$geralKeys){
	global $separarSegmentos;
	global $seguementoMenu;
	global $nomePagina;
	$segmentoChave="";
	$separadorKey=", ";
	$keyString="";
	$geralKeysString="";
	$removerPreposicoes=array('/', '!', ' a ',' e ',' i ',' o ',' de ',' da ',' do ',' em ',' para ',' com ');
	$removeemKeys=array_merge($removeemKeys,$removerPreposicoes);
	$pchave2=$pchave;
	#remove das palavras chaves os parametros passados para remover
	foreach($removeemKeys as $removeemKey){
		$pchave2=str_ireplace($removeemKey," ",$pchave2);
	}
	#remove das palavras chaves os parametros passados para efetuar prepend (Evitar repetição)
	foreach($adicionarNoFinalDasKeysH1 as $removeemKey){
		//echo $removeemKey;
		$pchave2=str_ireplace($removeemKey," ",$pchave2);
	}
	#cria um array- e adiciona   a palavra chave com as remoções
	$pchaveArr=explode(" ",$pchave2);
	#adiciona a array a palavra chave original
	array_push($pchaveArr,$pchave);
	#percorre a array com as palavras chaves adicionando a virgula antes da palavra chave e adicionando u a palavra chave todos os prepends
	foreach($pchaveArr as $pchaveArrItemGeral){
		if(trim($pchaveArrItemGeral)!=""){
			$keyString.=$separadorKey.$pchaveArrItemGeral;
			foreach($adicionarNoFinalDasKeysH1 as $prependKey){
				if(!stristr($pchaveArrItemGeral,$prependKey)){
					$keyString.=$separadorKey.$pchaveArrItemGeral." ".$prependKey;
				}
			}
		}
	}
	#remove espaços desnecessários
	$keyString=str_replace("     "," ",$keyString);
	$keyString=str_replace("    "," ",$keyString);
	$keyString=str_replace("   "," ",$keyString);
	$keyString=str_replace("  "," ",$keyString);
	#Adiciona as Keys Gerais
	#se foe um array entra aqui
	if(is_array($geralKeys)){
		if($separarSegmentos===true){
			#separador de segmento selecionado
			#percorre todo o array segmentoMenu procurando a página atual para verificar a qual segmento ela pertence.
			foreach($seguementoMenu as $chaveSegmentos=>$segmentos){
				echo "y";
				$nomePagina=trim(str_replace(".php","",$nomePagina));
				if(in_array($nomePagina,$segmentos)){
					$segmentoChave=$chaveSegmentos;
					break;
				}
			}
			#verifica se tem uma array com keys gerais para para o segmento desta página e adciona a string de KeyGerais
			if(isset($segmentoChave) && isset($geralKeys[$segmentoChave])){
				$geralKeysString=$geralKeys[$segmentoChave];
			}
		}else{
			#separador de segmento não selecionado
			foreach($geralKeys as $chaveSegmentoKey => $valorSegmentoKey){
				#percorre todo o arrays de Keys gerais acrescentando a string de keys gerais
				$geralKeysString.=$valorSegmentoKey.", ";
			}
		}
	}else if(is_string($geralKeys)){
		#se for uma string - inclui a mesma a uma string de keyGerais
		$geralKeysString=$geralKeys;
	}
	$keyString.=$keyString!=""?", ".$geralKeysString:$geralKeysString;
	#remove virgula no inicio da string de palavras chave
	if(substr($keyString,0,strlen($separadorKey))==$separadorKey){
		$keyString=substr($keyString,strlen($separadorKey));
	}
	#remove virgula no fim da string de palavras chave
	if(substr($keyString,-2)==$separadorKey){
		$keyString=substr($keyString,0,-2);
	}
	return $keyString;
}
##########################################################################################################################
##########################################################################################################################
#####|	                                        montar tags                                                     	|#####
##########################################################################################################################
##########################################################################################################################
function montarTags($key) {
	if(isset($key) && !empty($key) && is_string($key)) {
		$tagArr = explode(',',$key);
		$tagArr = array_slice($tagArr, 0, 5);
		$tags = implode(', ',$tagArr);
		return $tags;
	}
	return '';
}
##########################################################################################################################
##########################################################################################################################
#####|	"INICIO"-->Retorna Itens Relacionados ao Menu 																|#####
#####|	(MenuPrincipal,MenuLateral, MaisVisitados, Linkagem Interna, Produtos Relacionados, Informações, SiteMapa)	|#####
##########################################################################################################################
##########################################################################################################################
#LINKAGEM INTERNA
function exibirLinkagemInterna($listaLinks,$totalExibir=5)
{
	global $fraseLinkagemInterna;
	$linkagemInterna=array();
	$pageAtual=explode("/",$_SERVER['PHP_SELF']);
	$pageAtual=end($pageAtual);
	$pageAtualSemExtencao=str_replace(".php","",$pageAtual);
	$totalExibir=$totalExibir+1;
	$nomeSegmentoExibir="";
	$mensagemLinksInternos="";
	$url="";
	$linkagemInterna=$listaLinks;
	if(isset($linkagemInterna) && count($linkagemInterna)>1)
	{
		$plural=count($linkagemInterna)>2?"s":"";
		$mensagemLinksInternos="<div class=\"linkagem-interna\"><p>";
		$mensagemLinksInternos.="<span>".$fraseLinkagemInterna."</span>";
		$cont=0;
		$contador=0;
		foreach($linkagemInterna as $key1 => $valor1)
		{
			$cont++;
			if(($key1==$pageAtual || $key1==$pageAtualSemExtencao) || ($contador>0 && $contador<=$totalExibir))
			{
				$contador+=1;
				if($contador>1)
				{
					$virgulaLinkExterno=$contador>2?",":"";
					$valor1=mb_strtolower($valor1,'UTF-8');
					$mensagemLinksInternos.="{$virgulaLinkExterno} <a href='{$url}{$key1}' title='{$valor1}'>{$valor1}</a>";
					if($contador>=$totalExibir || count($linkagemInterna)==$cont)
					{
						break;
					}
				}
			}
		}
		if(($contador>=1 && $contador<$totalExibir))
		{
			foreach($linkagemInterna as $key2 => $valor2)
			{
				if(($key2!=$pageAtual || $key1==$pageAtualSemExtencao) && ($contador>=1 && $contador<$totalExibir))
				{
					$contador+=1;
					if($contador>1)
					{
						$virgulaLinkExterno=$contador>2?",":"";
						$valor2=mb_strtolower($valor2,'UTF-8');
						$mensagemLinksInternos.="{$virgulaLinkExterno} <a href='{$url}{$key2}' title='{$valor2}'>{$valor2}</a>";
						if($contador>=$totalExibir)
						{
							break;
						}
					}
				}
				else
				{
					break;
				}
			}
		}
		if($contador==0)
		{
			foreach($linkagemInterna as $key1 => $valor1)
			{
				$cont++;
				$contador+=1;
				if($contador>0)
				{
					$virgulaLinkExterno=$contador>2?",":"";
					$valor1=mb_strtolower($valor1,'UTF-8');
					$mensagemLinksInternos.="{$virgulaLinkExterno} <a href='{$url}{$key1}' title='{$valor1}'>{$valor1}</a>";
					if($contador>=$totalExibir || count($linkagemInterna)==$cont)
					{
						break;
					}
				}
			}
		}
		$mensagemLinksInternos.=".";
		$mensagemLinksInternos.="</p></div>";
		if($contador>0)
		{
			return $mensagemLinksInternos;
		}
	}
}
#Ordenar Array (Sem Levar em Consideração Maiusculos e minusculos)
function acasesort($array,$array2=array("vazia"))
{
	foreach($array as $itemKey=>$itemValue){
		$itemValue=tratar_letras($itemValue);
		$arrayLower[$itemKey]=mb_strtolower($itemValue,'UTF-8');
	}
	asort($arrayLower);
	if(isset($array2[0]) && $array2[0]=="vazia"){
		foreach($arrayLower as $arrayLowerItemKey=>$arrayLowerItemValue){
			$arrayLower[$arrayLowerItemKey]=$array[$arrayLowerItemKey];
		}
		return $arrayLower;
	}else if(isset($array2) && count($array2)>0){
		$arrayNova=array();
		foreach($arrayLower as $arrayLowerItemKey=>$arrayLowerItemValue){
			if(in_array($arrayLowerItemKey,$array2)){
				array_push($arrayNova,$arrayLowerItemKey);
			}
		}
		if(isset($arrayNova) && count($arrayNova)>0){
			return $arrayNova;
		}else{
			return asort($array2);
		}
	}
}
#Produtos Relacionados
function produtosRelacionados($menuRelacionadosRandom){
	global $menu;
	global $url;
	global $pastaImagensThumbs;
	global $pastaImagensDigitall;
	global $pastaImagens;
	global $nomePagina;
	global $urlGaleria;
	$retorno="";
	if(isset($menuRelacionadosRandom) && count($menuRelacionadosRandom)>0){
		foreach($menuRelacionadosRandom as $linkPagina)
		{
			$palavraChave=$menu[$linkPagina];
			$nomeImagem = str_replace( ".php", "", $linkPagina );
			$retorno.="<div>";
			$retorno.="<a href=\"".$url.$linkPagina."\" title=\"".$palavraChave."\">";
			if(file_exists($pastaImagensThumbs.$nomeImagem."-01.jpg"))
			{
				$retorno.="<img src=\"".$url.$pastaImagensThumbs.$nomeImagem."-01.jpg\" alt=\"".$palavraChave."\" title=\"".$palavraChave."\" />";
			}
			else
			{
				$retorno.="<img src=\"".$url."img/img-padrao.jpg\" alt=\"".$palavraChave."\" title=\"".$palavraChave."\" />";
			}
			$retorno.="</a>";
			$retorno.="<p><a href=\"".$url.$linkPagina."\" title=\"".$palavraChave."\">".$palavraChave."</a></p>";
			$retorno.="</div>";
		}
		return $retorno;
	}
}
#informações
function paginaGeral($menuLinkSubMenu,$menuTextoSubMenu){
	global $url;
	global $pastaImagensThumbs;
	global $pastaImagens;
	global $pastaImagensDigitall;
	$retorno="";
	$nomeImagem = str_replace( ".php", "", $menuLinkSubMenu );
	$retorno.="<div class=\"galeria-imagens-box\">";
	$retorno.="<div class=\"galeria-imagens-box-responsivo\">";
	$retorno.="<a href=\"".$url.$menuLinkSubMenu."\" title=\"".$menuTextoSubMenu."\">";
	if(file_exists($pastaImagensThumbs.$nomeImagem."-01.jpg"))
	{
		$retorno.="<img src=\"".$url.$pastaImagensThumbs.$nomeImagem."-01.jpg\" alt=\"".$menuTextoSubMenu."\" title=\"".$menuTextoSubMenu."\" />";
	}
	else
	{
		$retorno.="<img src=\"".$url."img/img-padrao.jpg\" alt=\"".$menuTextoSubMenu."\" title=\"".$menuTextoSubMenu."\" />";
	}
	$retorno.="</a>";
	$retorno.="<h5><a href=\"".$url.$menuLinkSubMenu."\" title=\"".$menuTextoSubMenu."\">".$menuTextoSubMenu."</a></h5>";
	$retorno.="</div>";
	$retorno.="</div>";
	return $retorno;
}
#mais visitados
function maisVisitados($maisVisitadosRandom)
{
	global $menu;
	global $url;
	global $nomePagina;
	$retorno="";
	if(isset($maisVisitadosRandom) && count($maisVisitadosRandom)>0){
		foreach($maisVisitadosRandom as $linkPagina)
		{
			$palavraChave=$menu[$linkPagina];
			$retorno.='<a href="'.$url.$linkPagina.'" title="'.$palavraChave.'">'.$palavraChave.'</a>';
		}
		return $retorno;
	}
}
#retornaMenu
function retornaMenu($destinoFinal){
	global $separarSegmentos;
	global $url;
	global $menu;
	global $seguementoMenu;
	global $pastaImagensDigitall;
	global $pastaImagensThumbs;
	global $nomePagina;
	global $urlGaleria;
	global $getSegmento;
	global $urlAtividadesEmpresa;
	$menuSegmentoLinkagemInterna=array();
	$menuSegmentoProdutosRelacionados=array();
	$tatalItensSegmento=0;
	$contarItensEmSegmento=0;
	$retorno="";
	$paginaEmSegmento=false;
	ksort($seguementoMenu);#ordena segmento
	if($separarSegmentos){
		#se for escolhido separar segmento em principal.php entra aqui...
		#verifica se a página atual esta em algum segmento
		foreach($seguementoMenu as $seguementoMenuItem){
			if(in_array($nomePagina, $seguementoMenuItem) || in_array(str_replace(".php","",$nomePagina), $seguementoMenuItem)){
				$paginaEmSegmento=true;
			}
		}
		if($paginaEmSegmento==false && (isset($destinoFinal) && ($destinoFinal=="produtosRelacionados" || $destinoFinal=="linkagemInterna" || $destinoFinal=="maisVisitados" || $destinoFinal=="menuLateral"))){
			#se a página atual não estiver em nenhum segmento...
			if(isset($destinoFinal) && $destinoFinal=="produtosRelacionados"){
				$totalMenuRelacionadosExibir=count($menu)>5?5:count($menu);
				$menuRelacionadosRandom=array_rand($menu,$totalMenuRelacionadosExibir);
				$retorno.=produtosRelacionados($menuRelacionadosRandom);
			}else if(isset($destinoFinal) && $destinoFinal=="linkagemInterna"){
				$retorno.=exibirLinkagemInterna($menu);
			} else if(isset($destinoFinal) && $destinoFinal=="maisVisitados"){
				$totalMaisVisitadosExibir=round(count($menu)/2);
				if($totalMaisVisitadosExibir>=1)
				{
					$maisVisitadosRandom=array_rand($menu,$totalMaisVisitadosExibir);
					$retorno.=maisVisitados($maisVisitadosRandom);
				}
			} else if(isset($destinoFinal) && $destinoFinal=="menuLateral"){
				foreach($menu as $menuLinkSubMenu=>$menuTextoSubMenu)
				{
					$retorno.="<li><a href='{$url}{$menuLinkSubMenu}' title='{$menuTextoSubMenu}'>{$menuTextoSubMenu}</a></li>";
				}
			}
		}else{
			#se a página atual estiver em algum segmento...
			foreach($seguementoMenu as $seguementoMenuNome=>$seguementoMenuPages){
				$contarItensEmSegmento=0;
				$seguementoMenuPages=acasesort($menu,$seguementoMenuPages);#ordena a Lista de Menu Agregado ao Sub Menu Levando em Consideração o Menu Atual
				$tatalItensSegmento=count($seguementoMenu[$seguementoMenuNome]);
				if(isset($seguementoMenuPages) && count($seguementoMenuPages)){
					if(is_array($seguementoMenuPages))
					{
						foreach($seguementoMenuPages as $seguementoMenuPagesLink)
						{
							if(isset($destinoFinal) && ($destinoFinal=="menuPrincipal")){
								$retorno.=isset($contarItensEmSegmento) && $contarItensEmSegmento==0?"<li><a href='".$url.$urlAtividadesEmpresa."?segmento=".urlencode($seguementoMenuNome)."' title=''>{$seguementoMenuNome}</a><ul>":"";
								$retorno.="<li><a href='{$url}{$seguementoMenuPagesLink}' title='{$menu[$seguementoMenuPagesLink]}'>{$menu[$seguementoMenuPagesLink]}</a></li>";
								$retorno.=($tatalItensSegmento-1)==$contarItensEmSegmento?"</ul></li>":"";
								$contarItensEmSegmento++;
							}else if(isset($destinoFinal) && ($destinoFinal=="menuLateral")){
								if(in_array($nomePagina, $seguementoMenuPages) || in_array(str_replace(".php","",$nomePagina), $seguementoMenuPages)){
									$retorno.=isset($contarItensEmSegmento) && $contarItensEmSegmento==0?"<li><a class=\"barra-lateral-segmento\" href='".$url.$urlAtividadesEmpresa."?segmento=".urlencode($seguementoMenuNome)."' title=''><h5>{$seguementoMenuNome}</h5></a><ul>":"";
									$retorno.="<li><a href='{$url}{$seguementoMenuPagesLink}' title='{$menu[$seguementoMenuPagesLink]}'>{$menu[$seguementoMenuPagesLink]}</a></li>";
									$retorno.=($tatalItensSegmento-1)==$contarItensEmSegmento?"</ul></li>":"";
									$contarItensEmSegmento++;
								}
							}else if(isset($destinoFinal) && $destinoFinal=="maisVisitados"){
								if(in_array($nomePagina, $seguementoMenuPages) || in_array(str_replace(".php","",$nomePagina), $seguementoMenuPages)){
									$contarItensEmSegmento+=1;
									$menuSegmentoMaisVisitados[$seguementoMenuPagesLink]=$menu[$seguementoMenuPagesLink];
									if($tatalItensSegmento===$contarItensEmSegmento && isset($menuSegmentoMaisVisitados) && count($menuSegmentoMaisVisitados)>0){
										$totalMaisVisitadosExibir=round(count($menuSegmentoMaisVisitados)/2);
										if($totalMaisVisitadosExibir>=1)
										{
											$maisVisitadosRandom=array_rand($menuSegmentoMaisVisitados,$totalMaisVisitadosExibir);
											$retorno.=maisVisitados($maisVisitadosRandom);
										}
									}
								}
							}elseif(isset($destinoFinal) && $destinoFinal=="linkagemInterna"){
								if(in_array($nomePagina, $seguementoMenuPages) || in_array(str_replace(".php","",$nomePagina), $seguementoMenuPages)){
									#Vai retornar apenas as páginas que estão no mesmo segmento
									$contarItensEmSegmento+=1;
									$menuSegmentoLinkagemInterna[$seguementoMenuPagesLink]=$menu[$seguementoMenuPagesLink];
									if($tatalItensSegmento===$contarItensEmSegmento && isset($menuSegmentoLinkagemInterna) && count($menuSegmentoLinkagemInterna)>0){
										$retorno.=exibirLinkagemInterna($menuSegmentoLinkagemInterna);
									}
								}
							}else if(isset($destinoFinal) && $destinoFinal=="produtosRelacionados"){
								if(in_array($nomePagina, $seguementoMenuPages) || in_array(str_replace(".php","",$nomePagina), $seguementoMenuPages)){
									#(Vai retornar apenas os que estão no mesmo segmento)
									$contarItensEmSegmento+=1;
									$menuSegmentoProdutosRelacionados[$seguementoMenuPagesLink]=$menu[$seguementoMenuPagesLink];
									if($tatalItensSegmento===$contarItensEmSegmento && isset($menuSegmentoProdutosRelacionados) && count($menuSegmentoProdutosRelacionados)>0){
										$totalMenuRelacionadosExibir=count($menuSegmentoProdutosRelacionados)>5?5:count($menuSegmentoProdutosRelacionados);
										$menuRelacionadosRandom=array_rand($menuSegmentoProdutosRelacionados,$totalMenuRelacionadosExibir);
										$retorno.=produtosRelacionados($menuRelacionadosRandom);
									}
								}
							}else if(isset($destinoFinal) && $destinoFinal=="paginaGeral"){
								if((isset($getSegmento) && $getSegmento!="")){
									#exibi especifico de determinado segmento ($getSegmento é passado via url)
									if($getSegmento==$seguementoMenuNome){
										$retorno.=isset($contarItensEmSegmento) && $contarItensEmSegmento==0?"<h1 class=\"informacoes-titulo-segmento\"><a href='{$url}{$nomePagina}?segmento=".urlencode($seguementoMenuNome)."' title='{$seguementoMenuNome}'>{$seguementoMenuNome}</a></h1>":"";
										$retorno.=paginaGeral($seguementoMenuPagesLink,$menu[$seguementoMenuPagesLink]);
										$contarItensEmSegmento++;
									}
								} else {
									#exibi todos
									$retorno.=isset($contarItensEmSegmento) && $contarItensEmSegmento==0?"<h2 class=\"informacoes-titulo-segmento\">{$seguementoMenuNome}</h2>":"";
									$retorno.=paginaGeral($seguementoMenuPagesLink,$menu[$seguementoMenuPagesLink]);
									$contarItensEmSegmento++;
								}
							}
						}
					}
				}
			}
		}
	}else{
		#se for escolhido não separar segmento em principal.php entra aqui...
		if(isset($destinoFinal) && $destinoFinal=="produtosRelacionados"){
			$totalMenuRelacionadosExibir=count($menu)>5?5:count($menu);
			$menuRelacionadosRandom=array_rand($menu,$totalMenuRelacionadosExibir);
			$retorno.=produtosRelacionados($menuRelacionadosRandom);
		}else if(isset($destinoFinal) && $destinoFinal=="linkagemInterna"){
			$retorno.=exibirLinkagemInterna($menu);
		}else if(isset($destinoFinal) && $destinoFinal=="maisVisitados"){
			$totalMaisVisitadosExibir=round(count($menu)/2);
			if($totalMaisVisitadosExibir>=1)
			{
				$maisVisitadosRandom=array_rand($menu,$totalMaisVisitadosExibir);
				$retorno.=maisVisitados($maisVisitadosRandom);
			}
		}else{
			# Para exibir apenas na pagina de exemplo (para fins de layout)
			foreach($menu as $menuLinkSubMenu=>$menuTextoSubMenu)
			{
				if(isset($destinoFinal) && ($destinoFinal=="menuPrincipal" || $destinoFinal=="menuLateral")){
					$retorno.="<li><a href='{$url}{$menuLinkSubMenu}' title='{$menuTextoSubMenu}'>{$menuTextoSubMenu}</a></li>";
				}else if(isset($destinoFinal) && $destinoFinal=="paginaGeral"){
					$retorno.=paginaGeral($menuLinkSubMenu,$menuTextoSubMenu);
				}
			}
		}
	}
	return $retorno;
}
##########################################################################################################################
##########################################################################################################################
#####|	"FIM"-->Retorna Itens Relacionados ao Menu 																	|#####
#####|	(MenuPrincipal,MenuLateral, MaisVisitados, Linkagem Interna, Produtos Relacionados, Informações, SiteMapa)	|#####
##########################################################################################################################
##########################################################################################################################
##########################################################################################################################
######	breadcrumb
##########################################################################################################################
function breadcrumb(){
	global $exibirBreadcrumb;
	global $h1;
	global $menu;
	global $nomePagina;
	global $urlGaleria;
	global $url;
	global $urlAtividadesEmpresa;
	global $AtividadesEmpresa;
	global $separarSegmentos;
	global $seguementoMenu;
	$breadcrumb = '';
	if ($exibirBreadcrumb == true) {
		$tituloPaginaAtual=isset($h1)?$h1:'';
		$breadcrumb .= '<div class="breadcrumb">';
			// $breadcrumb .= 'Você esta aqui: ';  Opcional, elimina parte do texto.
		$breadcrumb .= '<a rel="nofollow" href="'.$url.'" title="Voltar a página inicial">Home</a> ';
		if(isset($menu) && (array_key_exists($nomePagina,$menu) || array_key_exists($urlGaleria,$menu))) {
			if($separarSegmentos==true){
				foreach($seguementoMenu as $segmento=>$subMenu) {
					if(in_array($nomePagina,$subMenu) || in_array($urlGaleria,$subMenu)) {
						$segmentoExibir=$segmento;
						break;
					}
				}
				$breadcrumb .= '» <a href="'.$url.$urlAtividadesEmpresa.'?segmento='.urlencode($segmentoExibir).'" title="'.$segmentoExibir.'">'.$segmentoExibir.'</a> ';
			} else {
				$breadcrumb .= '» <a href="'.$url.$urlAtividadesEmpresa.'" title="'.$AtividadesEmpresa.'">'.$AtividadesEmpresa.'</a> ';
			}
		}
		$breadcrumb .= '» <strong>'.$h1.'</strong>';
		$breadcrumb .= '</div>';
	}
	return $breadcrumb;
}
/*----------------------------------------
-- verificação de existencia das paginas -
----------------------------------------*/
function keysExist(){
	global $url;
	global $menu;
	$i       = 0;
	$qtdMenu = count($menu);
	foreach ($menu as $key => $value){
		if(!file_exists($key.'.php') && !file_exists($key)){
			$i++;
		}
	}
	if($i == $qtdMenu){
		return false;
	}
	else{ return true; }
}