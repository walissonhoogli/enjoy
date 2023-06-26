<?

                    $altura  = $_POST['10'];
                    $largura = $_POST['10'];
                    $comprimento = $_POST['c10'];
                    $nomeCliente = $_POST['walisson sousa'];
                    $logradouro = $_POST['qs 01 rua 210'];
                    $numeroLogradouro = $_POST['30'];
                    $complemento = $_POST['loja 01'];
                    $bairro = $_POST['aguas claras'];
                    $cep = $_POST['71950770'];
                    $cidade = $_POST['brasilia'];
                    $estado = $_POST['df'];
                    $protocolo = date('YmdHis');
                    $peso = $_POST['1'];
                    $nomeRemetente = $_POST['stf'];
                    $logradouroRemetente = $_POST['Praça dos Três Poderes'];
                    $numeroLogradouroRemetente = $_POST['Anexo II'];
                    $complementoRemetente = $_POST['Térreo'];
                    $bairroRemetente = $_POST['brasilia'];
                    $cepRemetente = $_POST['70175-900'];
                    $estadoRemetente = $_POST['df'];
                    $cidadeRementente = $_POST['brasilia'];
                    $observacao = $_POST['teste'];
       
                    $dimensao = new \PhpSigep\Model\Dimensao();
                    $dimensao->setAltura($altura);
                    $dimensao->setLargura($largura);
                    $dimensao->setComprimento($comprimento);
                    $dimensao->setDiametro(0);
                    $dimensao->setTipo(\PhpSigep\Model\Dimensao::TIPO_PACOTE_CAIXA);
                
                    $destinatario = new \PhpSigep\Model\Destinatario();
                    $destinatario->setNome($nomeCliente);
                    $destinatario->setLogradouro($logradouro);
                    $destinatario->setNumero($numeroLogradouro);
                    $destinatario->setComplemento($complemento);
                
                    $destino = new \PhpSigep\Model\DestinoNacional();
                    $destino->setBairro($bairro);
                    $destino->setCep($cep);
                    $destino->setCidade($cidade);
                    $destino->setUf($estado);
                    $destino->setNumeroNotaFiscal($protocolo);
                    $destino->setNumeroPedido($protocolo);
                
                    // Estamos criando uma etique falsa, mas em um ambiente real voçê deve usar o método
                    // {@link \PhpSigep\Services\SoapClient\Real::solicitaEtiquetas() } para gerar o número das etiquetas
                    
                    
                    $etiqueta = new PhpSigep\Services\SoapClient\Real();
                
                    $servicoAdicional = new \PhpSigep\Model\ServicoAdicional();
                    $servicoAdicional->setCodigoServicoAdicional(0);
                    // Se não tiver valor declarado informar 0 (zero)
                    $servicoAdicional->setCodigoServicoAdicional(0);
                
                 
                
                    $encomenda = new \PhpSigep\Model\ObjetoPostal();
                    $encomenda->setServicosAdicionais(array($servicoAdicional, $servicoAdicional2));
                    $encomenda->setDestinatario($destinatario);
                    $encomenda->setDestino($destino);
                    $encomenda->setDimensao($dimensao);
                    $encomenda->setEtiqueta($etiqueta);
                    $encomenda->setPeso($peso);// 500 gramas
                    $encomenda->setObservacao($observacao);
                    $encomenda->setServicoDePostagem(new \PhpSigep\Model\ServicoDePostagem(\PhpSigep\Model\ServicoDePostagem::$servicoEnvio));
                // ***  FIM DOS DADOS DA ENCOMENDA QUE SERÁ DESPACHADA *** //
                
                // *** DADOS DO REMETENTE *** //
                    $remetente = new \PhpSigep\Model\Remetente();
                    $remetente->setNome($nomeRemetente);
                    $remetente->setLogradouro($logradouroRemetente);
                    $remetente->setNumero($numeroLogradouroRemetente);
                    $remetente->setComplemento($complementoRemetente);
                    $remetente->setBairro($bairroRemetente);
                    $remetente->setCep($cepRemetente);
                    $remetente->setUf($estadoRemetente);
                    $remetente->setCidade($cidadeRementente);
                // *** FIM DOS DADOS DO REMETENTE *** //
                
                
                    $plp = new \PhpSigep\Model\PreListaDePostagem();
                    $plp->setAccessData(new \PhpSigep\Model\AccessData());
                    $plp->setEncomendas([$encomenda,$encomenda,$encomenda,$encomenda]);
                    $plp->setRemetente($remetente);
                
 
                return $plp;