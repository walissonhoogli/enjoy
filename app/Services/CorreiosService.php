<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CorreiosService
{
    public function calcularFrete($request)
    {
        $cep = config('correios.cep');
        
        $cepOrigem = $cep;
        $cepDestino = $request['cep'];
        $peso = $request['peso'];
        $formato = 1;
        $comprimento = 30;
        $altura = 16;
        $largura = 24;
        $diametro = 0;

        // Faz a requisição para o SEDEX
        $sedexResponse = $this->fazerRequisicaoCorreios($cepOrigem, $cepDestino, $peso, $formato, $comprimento, $altura, $largura, $diametro, '40010');
        // Faz a requisição para o PAC
        $pacResponse = $this->fazerRequisicaoCorreios($cepOrigem, $cepDestino, $peso, $formato, $comprimento, $altura, $largura, $diametro, '41106');

        if ($sedexResponse && $pacResponse) {
            // Retorna os valores de sedex e pac em formato JSON
            return response()->json([
                'sedex' => $sedexResponse,
                'pac' => $pacResponse
            ]);
        } else {
            // Caso a requisição falhe, retorna uma resposta de erro
            return response()->json(['error' => 'Erro ao calcular o frete'], 500);
        }
    }

    private function fazerRequisicaoCorreios($cepOrigem, $cepDestino, $peso, $formato, $comprimento, $altura, $largura, $diametro, $codigoServico)
    {
        $response = Http::get("http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx", [
            'nCdEmpresa' => '',
            'sDsSenha' => '',
            'sCepOrigem' => $cepOrigem,
            'sCepDestino' => $cepDestino,
            'nVlPeso' => $peso,
            'nCdFormato' => $formato,
            'nVlComprimento' => $comprimento,
            'nVlAltura' => $altura,
            'nVlLargura' => $largura,
            'nVlDiametro' => $diametro,
            'sCdMaoPropria' => 'N',
            'nVlValorDeclarado' => '0',
            'sCdAvisoRecebimento' => 'N',
            'nCdServico' => $codigoServico,
            'nVlDiametro' => '0',
            'StrRetorno' => 'xml'
        ]);

        if ($response->successful()) {
            $xml = simplexml_load_string($response->body());
            $valor = (float)$xml->cServico->Valor;
            $prazoEntrega = (int)$xml->cServico->PrazoEntrega;

            return [
                'valor' => $valor,
                'prazoEntrega' => $prazoEntrega
            ];
        } else {
            return null;
        }
    }
    
    
    public function gerarEtiqueta($request)
   {
    
        require_once __DIR__ . '/php-sigep-master/src/PhpSigep/Bootstrap.php';
        $config = new \PhpSigep\Config();
        $config->setEnv(\PhpSigep\Config::ENV_PRODUCTION);
        $config->setWsdlAtendeCliente('https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente?wsdl');

        $config->setCacheOptions(
            array(
                'storageOptions' => array(
                    // Qualquer valor setado neste atributo ser�� mesclado ao atributos das classes 
                    // "\PhpSigep\Cache\Storage\Adapter\AdapterOptions" e "\PhpSigep\Cache\Storage\Adapter\FileSystemOptions".
                    // Por tanto as chaves devem ser o nome de um dos atributos dessas classes.
                    'enabled' => false,
                    'ttl' => 10,// "time to live" de 10 segundos
                    'cacheDir' => sys_get_temp_dir(), // Opcional. Quando n�0�0o inforado �� usado o valor retornado de "sys_get_temp_dir()"
                ),
            )
        );

        \PhpSigep\Bootstrap::start($config);
        
        $numeroContrato = config('correios.numero_contrato');
        $cartaoPostagem = config('correios.cartao_postagem');
        $usuario = config('correios.usuario');
        $senha = config('correios.senha');
        


        // Dados de Acesso
        $accessData = new \PhpSigep\Model\AccessData();
        $accessData->setNumeroContrato($numeroContrato);
        $accessData->setCartaoPostagem($cartaoPostagem);
        $accessData->setUsuario($cartaoPostagem);
        $accessData->setSenha($senha);

        $phpSigep = new \PhpSigep\Services\SoapClient\Real();
        $result = $phpSigep->buscaCliente($accessData);

        if (!$result->hasError()) {
            /** @var $buscaClienteResult \PhpSigep\Model\BuscaClienteResult */
            $buscaClienteResult = $result->getResult();

            // Anula as chancelas antes de imprimir o resultado, porque as chancelas n�0�0o est�0�0o �� liguagem humana
            $servicos = $buscaClienteResult->getContratos()->cartoesPostagem->servicos;
            foreach ($servicos as &$servico) {
                $servico->servicoSigep->chancela->chancela = 'Chancelas anulada via c��digo.';
            }
        }
        
        
        $comprimento = 30;
        $altura = 16;
        $largura = 24;
        
        $dimensao = new \PhpSigep\Model\Dimensao();
        $dimensao->setAltura($altura);
        $dimensao->setLargura($largura);
        $dimensao->setComprimento($comprimento);
        $dimensao->setDiametro(0);
        $dimensao->setTipo(\PhpSigep\Model\Dimensao::TIPO_PACOTE_CAIXA);


        $destinatario = new \PhpSigep\Model\Destinatario();
        $destinatario->setNome($request['customer_name']);
        $destinatario->setLogradouro($request['customer_address']);
        $destinatario->setNumero('');
        $destinatario->setComplemento("");


        $destino = new \PhpSigep\Model\DestinoNacional();
        // $destino->setBairro("");
        $destino->setCep($request['zip']);
        // $destino->setCep('70340-901');
        
        $destino->setCidade($request['city']);
        $destino->setUf($request['uf']);
        $destino->setNumeroNotaFiscal($request['protocolo']);
        $destino->setNumeroPedido($request['nPedido']);


        
        //ETIQUETA    

        $params = new \PhpSigep\Model\SolicitaEtiquetas();
        $params->setQtdEtiquetas(1);

        if ($request['correios'] == 4510) {
            $params->setServicoDePostagem(\PhpSigep\Model\ServicoDePostagem::SERVICE_SEDEX_CONTRATO_AGENCIA);
        } elseif ($request['correios'] == 4014) {
            $params->setServicoDePostagem(\PhpSigep\Model\ServicoDePostagem::SERVICE_PAC_CONTRATO_AGENCIA);
        }

        $params->setAccessData(new \PhpSigep\Model\AccessData());
        
        $idServico = config('correios.id_servico');
        $tipoDestinatario = config('correios.tipo_destinatario');
        $identificador = config('correios.identificador');
        $cnpjEmpresa = config('correios.cnpj_empresa');
        $cartaoPostagem = config('correios.cartao_postagem');

        $params->setIdServico($idServico);
        $params->setTipoDestinatario($tipoDestinatario);
        $params->setIdentificador($identificador);

        $accessData = new \PhpSigep\Model\AccessData();
        $accessData->setUsuario($usuario);
        $accessData->setSenha($senha);
        $accessData->setCnpjEmpresa($cnpjEmpresa);
        $accessData->setCartaoPostagem($cartaoPostagem);
        $accessData->setNumeroContrato($numeroContrato);


        $params->setAccessData($accessData);
        

        // $params->setServicoDePostagem('03220');

        $phpSigep = new \PhpSigep\Services\SoapClient\Real();
        $etiqueta = $phpSigep->solicitaEtiquetas($params);

        
        if ($request['correios'] == 4510) {
            $idServicoEtq = '162022';
        } elseif ($request['correios'] == 4014) {
            $idServicoEtq = '162026';
        }


        $client = new \SoapClient('https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente?wsdl');
        $function = 'solicitaEtiquetas';
        $arguments = array('solicitaEtiquetas' => array(
            'tipoDestinatario' => $tipoDestinatario,
            'identificador' => $identificador,
            'idServico' => $idServicoEtq,
            'qtdEtiquetas' => '1',
            'usuario' => $usuario,
            'senha' => $senha
        ));
        
        

        $result = $client->__soapCall($function, $arguments);
        
        
        
        $resultado = substr($result->return, -13);

        $etiquetaTratada = str_replace(" ", "", "$resultado");

        
        $servicoAdicional = new \PhpSigep\Model\ServicoAdicional();
        $servicoAdicional->setCodigoServicoAdicional(\PhpSigep\Model\ServicoAdicional::SERVICE_REGISTRO);
        // Se n�0�0o tiver valor declarado informar 0 (zero)
        $servicoAdicional->setCodigoServicoAdicional(\PhpSigep\Model\ServicoAdicional::SERVICE_AVISO_DE_RECEBIMENTO);

        $servicoAdicional2 = new \PhpSigep\Model\ServicoAdicional();
        $servicoAdicional2->setCodigoServicoAdicional(\PhpSigep\Model\ServicoAdicional::SERVICE_REGISTRO);
        $servicoAdicional2->setCodigoServicoAdicional(\PhpSigep\Model\ServicoAdicional::SERVICE_VALOR_DECLARADO_PAC);
        $servicoAdicional2->setValorDeclarado(0);
        
        $observacao = '';
        $encomenda = new \PhpSigep\Model\ObjetoPostal();
        $encomenda->setServicosAdicionais(array($servicoAdicional, $servicoAdicional2));
        $encomenda->setDestinatario($destinatario);
        $encomenda->setDestino($destino);
        $encomenda->setDimensao($dimensao);
        $encomenda->setEtiqueta($etiquetaTratada);
        $encomenda->setPeso($request['peso']);// 500 gramas
        $encomenda->setObservacao($observacao);
        
        
      

        if ($request['correios'] == 4510) {
            $encomenda->setServicoDePostagem(new \PhpSigep\Model\ServicoDePostagem(\PhpSigep\Model\ServicoDePostagem::SERVICE_SEDEX_CONTRATO_AGENCIA));
        } elseif ($request['correios'] == 4014) {
            $encomenda->setServicoDePostagem(new \PhpSigep\Model\ServicoDePostagem(\PhpSigep\Model\ServicoDePostagem::SERVICE_PAC_CONTRATO_AGENCIA));
        }
        
        ;
        // ***  FIM DOS DADOS DA ENCOMENDA QUE SER�0�9 DESPACHADA *** //

        // *** DADOS DO REMETENTE *** //
        $remetente = new \PhpSigep\Model\Remetente();
        $remetente->setNome('SUPREMO TRIBUNAL FEDERAL - SAE');


        $plp = new \PhpSigep\Model\PreListaDePostagem();
        $plp->setAccessData($accessData);
        $plp->setEncomendas([$encomenda, $encomenda, $encomenda, $encomenda]);
        $plp->setRemetente($remetente);

        $logoFile = __DIR__ . '/logo-cliente.png';

        //Parametro opcional indica qual layout utilizar para a chancela. Ex.: CartaoDePostagem::TYPE_CHANCELA_CARTA, CartaoDePostagem::TYPE_CHANCELA_CARTA_2016
        $layoutChancela = array(\PhpSigep\Pdf\CartaoDePostagem::TYPE_CHANCELA_CARTA);

        $pdf = new \PhpSigep\Pdf\CartaoDePostagem2018($plp, time(), $logoFile, $layoutChancela);
        
                $nomeDestinatario = $destinatario->getNome();
                $cepDestino = $destino->getCep();
                $peso = $encomenda->getPeso();
                $etiqueta = $encomenda->getEtiqueta();
                
                $servicoDePostagem = $encomenda->getServicoDePostagem();
                $nomeServico = $servicoDePostagem->getNome();
                $valor_total = $request['total_price'];
                $dataAtual = date("Y-m-d");
                $id = $request['id'];
                
                $data_postagem = array(
                    "n_objeto" => $etiqueta,
                    "cep" => $cepDestino,
                    "nome" =>  $nomeDestinatario,
                    "peso" => $peso,
                    "v_declarado" => $valor_total,
                    "n_fiscal" => '123123',
                    "servico" =>  $nomeServico,
                    "order_id" => $id,
                    "data" =>  $dataAtual
                    );
                    
                $posts = DB::table('postagem')->where('order_id', $id)->get();

                if ($posts->isEmpty()) {
                    DB::table('postagem')->insert($data_postagem);
                }
        
                $pdf->render();
   }
}