@extends('backend.layouts.app')

@section('content')




<div class="card">
    <form class="" action="" id="sort_orders" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">Lista de Postagem</h5>
            </div>

            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                </div>
            </div
            
            <div class="col-auto">
                <div class="form-group mb-0">
                  <button type="button" class="btn btn-warning" onclick="imprimirTrechoHtml()"
                            title="correios">Imprimir
                    </button>
                </div>
            </div
            
        </div>
        
        <div class="printableArea" id="printableArea">
        
            <div class="container" style="display: flex;" >
                 <div class="" style="padding: 10px;margin-top: 10px;">
                    <img src="https://hoogli.dev.br/stf-ecommerce/declaracao/image/correios.svg" style="margin-right: 50px; width:150px" class="img img-responsive inv_logo" alt="logo">
                </div>
                 <div class=""><h4 style="margin-top: 29px;">Empresa Brasileira De Correios E Telégrafos</h4></div>
            </div>
            
            <div class="container" style="margin-top: 20px;">
                <div style="text-align: center; font-size: 16px;">
                    <p>LISTA DE POSTAGEM</p>
                </div>
                <div class="row" style="margin-top: 15px;padding: 10px">
                    <div class="col-sm-6">
                        <div style="display: flex;"><strong>Nº da Lista:</strong><p>{{config('numero_da_lista')}}</p></div>
                        <div style="display: flex;"><strong>Contrato:</strong><p>{{config('numero_contrato')}}</p></div>
                        <div style="display: flex;"><strong>Cód Adm:</strong><p>{{config('condigo_administrador')}}</p></div>
                        <div style="display: flex;"><strong>Cartão:</strong><p>{{config('cartao_postagem')}}</p></div>
                        <div style="display: flex;"><strong>Telefone:</strong><p>{{config('telefone')}}</p></div>
                    </div>
                    <div class="col-sm-6">
                        <div style="display: flex;"><strong>Remetente:</strong><p>{{config('nome_remetente')}}</p></div>
                        <div style="display: flex;"><strong>Cliente:</strong><p>{{config('cliente')}}</p></div>
                        <div style="display: flex;"><strong>Endereço:</strong><p>{{config('nome_remetente')}} - CEP: {{config('cep')}}</p></div>
                    </div>
                </div>
            </div>
    
            <div class="card-body">
                <table class="table aiz-table mb-0">
                        <tr>
                            <th>Nº do Objeto</th>
                            <th data-breakpoints="md">Destinatário</th>
                            <th data-breakpoints="md">CEP</th>
                            <th data-breakpoints="md">PESO</th>
                            <th data-breakpoints="md">AR</th>
                            <th data-breakpoints="md">MP</th>
                            <th data-breakpoints="md">VD</th>
                            <th data-breakpoints="md">EV</th>
                            <th data-breakpoints="md">V.Declarado</th>
                            <th data-breakpoints="md">N.Fiscal</th>
                            <th data-breakpoints="md">Serviço</th>
                        </tr>
                        @foreach ($postagens as $key => $postagem)
                        <tr>
                            <td>{{$postagem->n_objeto}}</td>
                            <td>{{$postagem->nome}}</td>
                            <td>{{$postagem->cep}}</td>
                            <td>{{$postagem->peso}}</td>
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
                            <td>{{'R$'.' '.$postagem->v_declarado}}</td>
                            <td>{{$postagem->n_fiscal}}</td>
                            <td style="font-size: 12px;">
                              <?php 
                                        if ($postagem->servico === "SEDEX Contrato Agência") {
                                            echo "03220 - SEDEX CONTRATO AG";
                                        } else {
                                            echo "03298 - PAC CONTRATO AG";
                                        }
                                    ?>
                            </td>
                        </tr>
                        @endforeach
                </table>
                <hr />
                <div class="container" style="padding: 10px margin-top: 20px">
                     <div class="panel-body">
                                 <div style="display: flex;justify-content: space-between;">
                                     <div style="display: flex;">
                                        <strong style="margin-right: 5px;">Quantidade de Objetos:</strong><p>{{ $qtd}}</P>
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
                                     <hr style="width: 60%;border: none;border-top: 1px solid black; margin: 10px 0;clear: both;margin-top: 30px;" />
                                 </div>
                                 <div style="margin-left: 115px;">
                                     <strong>Assinatura do Remetente</strong>
                                 </div>
                                 <div style="margin-left: 45px;">
                                     <strong>Obs: 1ª via unidade de Postagem e 2ª via Cliente</strong>
                                 </div>
                             </div>
                </div>
                <hr />
                
                <div class="panel-footer text-left" style="margin-top: 20px">
                    <div class="aiz-pagination">
                  	{{ $postagens->links() }}
                    </div>
                    
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

<script>
    function imprimirTrechoHtml() {
    // Oculta o botão de impressão
    document.querySelector(".panel-footer .aiz-pagination ").style.display = "none";

    // Cria uma nova janela temporária para impressão
    var janelaImprimir = window.open('', '_blank');
    janelaImprimir.document.write('<html><head><title>Imprimir</title>');
    janelaImprimir.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">');
    janelaImprimir.document.write('<style>@media print{.no-print, .no-print *{display:none!important}}</style>');
    janelaImprimir.document.write('</head><body>');
    janelaImprimir.document.write('<div id="printableArea">');
    janelaImprimir.document.write(document.getElementById("printableArea").innerHTML);
    janelaImprimir.document.write('</div>');
    janelaImprimir.document.write('</body></html>');
    janelaImprimir.document.close();

    // Espera até que o conteúdo seja carregado na janela temporária
    janelaImprimir.onload = function () {
        // Chama a função de impressão do navegador na janela temporária
        janelaImprimir.print();
        janelaImprimir.close();

        // Restaura o estado original após a impressão
        document.querySelector(".panel-footer .btn-info").style.display = "inline-block";
    };
}

</script>





