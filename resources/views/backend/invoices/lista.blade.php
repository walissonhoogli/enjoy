<div id="printableArea">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6 cominfo_div" style="display: flex; align-items: center;">
                                    <img src="https://hoogli.dev.br/stf-ecommerce/declaracao/image/correios.svg" style="margin-right: 10px;" class="img img-responsive inv_logo" alt="logo">
                                </div>
                                <div class="col-sm-8"><h4 style="margin: 0;margin-top: 23px">Empresa Brasileira De Correios E Telégrafos</h4></div>
                            </div>
                        </div>
                    
                        <div class="panel-body" style="border: 1px solid black;">
                            <h1 style="text-align: center;font-size: 20px; margin-top: -2px;">Lista de Postagem</h1>
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-sm-6">
                                    <div style="display: flex;"><strong>Nº da Lista:</strong><p>711912564</p></div>
                                    <div style="display: flex;"><strong>Contrato:</strong><p>9912562235</p></div>
                                    <div style="display: flex;"><strong>Cód Adm:</strong><p>21456950</p></div>
                                    <div style="display: flex;"><strong>Cartão:</strong><p>0076903338</p></div>
                                    <div style="display: flex;"><strong>Telefone:</strong><p>6132174780</p></div>
                                </div>
                                <div class="col-sm-6">
                                    <div style="display: flex;"><strong>Remetente:</strong><p>SUPREMO TRIBUNAL FEDERAL</p></div>
                                    <div style="display: flex;"><strong>Cliente:</strong><p>STF DIRETORIA GERAL</p></div>
                                    <div style="display: flex;"><strong>Endereço:</strong><p>Praça dos Três Poderes Lote Único, sn Anexo II-A - sala C, 624 
                                    Zona Cívico-Administrativa Brasília/DF - CEP: 70155900</p></div>
                                </div>
                            </div>
                        </div>
                        
                        <table style="width: 100%;margin: 10px 0px; margin-left: 10px;">
                          <tr>
                            <th>Nº do Objeto</th>
                            <th>CEP</th>
                            <th>Peso</th>
                            <th>AR</th>
                            <th>MP</th>
                            <th>VD</th>
                            <th>EV</th>
                            <th>V.Declarado</th>
                            <th>N.Fiscal</th>
                            <th>Serviço</th>
                          </tr>
                          <?php foreach($requests  as $postagem) { ?>
                          <tr>
                            <td><?php echo $postagem["n_objeto"];?></td>
                            <td><?php echo $postagem["cep"]?></td>
                            <td><?php echo $postagem["peso"]?></td>
                            <td>
                                <select>
                                  <option value="N" selected>N</option>
                                  <option value="S">S</option>
                                </select>
                            </td>
                            <td>
                                <select>
                                  <option value="N" selected>N</option>
                                  <option value="S">S</option>
                                </select>
                            </td>
                            <td>
                                <select>
                                  <option value="N" selected>N</option>
                                  <option value="S">S</option>
                                </select>
                            </td>
                            <td>
                                <select>
                                  <option value="N" selected>N</option>
                                  <option value="S">S</option>
                                </select>
                            </td>
                            <td><?php  $v_declarado = $postagem["v_declarado"];
                                        $v_declarado_formatado = number_format($v_declarado, 2, ',', '.');
                                        echo "R$ " . $v_declarado_formatado; ?>
                            </td>
                            <td>123123</td>
                            <td style="font-size: 12px;">
                                <?php 
                                    if ($postagem["servico"] === "SEDEX Contrato Agência") {
                                        echo "03220 - SEDEX CONTRATO AG";
                                    } else {
                                        echo "03298 - PAC CONTRATO AG";
                                    }
                                ?>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="10"><strong style="margin-right: 5px;">Destinatário:</strong><?php echo $postagem["nome"]?></td>
                          </tr>
                          <?php } ?>
                          <!-- Adicione mais linhas conforme necessário -->
                    </table>
                        
                        <div class="panel-body" style="border: 1px solid black;">
                             <div style="display: flex;justify-content: space-between;">
                                 <div style="display: flex;">
                                    <strong style="margin-right: 5px;">Quantidade de Objetos:</strong><p>3</P>
                                 </div>
                                 <div>
                                     <strong>Carimbo e Assinatura / Matricula dos Correios</strong>
                                 </div>
                             </div>
                             <div style="display: flex;">
                                 <p style="margin-right: 5px;">Data de fechamento:</p><p><?php
                                                                $dataAtual = date("d/m/Y");
                                                                echo $dataAtual;
                                                               ?></p>
                             </div>
                             <div>
                                 <strong style="font-size: 12px;">APRESENTAR ESTA LISTA EM CASO DE PEDIDO DE INFORMAÇÕES</strong>
                             </div>
                             <div>
                                 <strong style="font-size: 10px;">Estou ciente do disposto na cláusula terceira do contrato de prestação de Serviços.</strong>
                             </div>
                             <div>
                                 <hr style="width: 60%;border: none;border-top: 1px solid black;margin: 10px 0;clear: both;margin-top: 30px;"/>
                             </div>
                             <div style="margin-left: 115px;">
                                 <strong>Assinatura do Remetente</strong>
                             </div>
                             <div style="margin-left: 45px;">
                                 <strong>Obs: 1ª via unidade de Postagem e 2ª via Cliente</strong>
                             </div>
                         </div>
                    </div>