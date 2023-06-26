<html>
    <?php 
$meses = array(
    1 => 'janeiro',
    2 => 'fevereiro',
    3 => 'março',
    4 => 'abril',
    5 => 'maio',
    6 => 'junho',
    7 => 'julho',
    8 => 'agosto',
    9 => 'setembro',
    10 => 'outubro',
    11 => 'novembro',
    12 => 'dezembro'
    );
?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{  translate('INVOICE') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <style media="all">
        @page {
            margin: 0;
            padding: 0;
        }

        body {
            font-size: 0.875rem;
            font-family: '<?php echo  $font_family ?>';
            font-weight: normal;
            direction: <?php echo  $direction ?>;
            text-align: <?php echo  $text_align ?>;
            padding: 0;
            margin: 0;
        }
        
        hr {
            width: 30%;
        }
        
        .gry-color *,
        .gry-color {
            color: #000;
        }

        table {
            width: 100%;
        }

        table th {
            font-weight: normal;
        }

        table.padding th {
            padding: .25rem .7rem;
        }

        table.padding td {
            padding: .25rem .7rem;
        }

        table.sm-padding td {
            padding: .1rem .7rem;
        }

        .border-bottom td,
        .border-bottom th {
            border-bottom: 1px solid #eceff4;
        }

        .text-left {
            text-align: <?php echo  $text_align ?>;
        }

        .text-right {
            text-align: <?php echo  $not_text_align ?>;
        }
    </style>
</head>
<body>
<div>

    @php
        $logo = get_setting('header_logo');
    @endphp

    <div style="background: #eceff4;padding: 1rem;">
        <table>
            <tr>
                <td>
                    @if($logo != null)
                        <img src="https://hoogli.dev.br/stf-ecommerce/declaracao/image/correios.svg" height="30" style="display:inline-block;">
                    @else
                        <img src="https://hoogli.dev.br/stf-ecommerce/declaracao/image/correios.svg" height="30" style="display:inline-block;">
                    @endif
                </td>
                <td style="font-size: 1.5rem;" class="text-right strong">Declaração de Conteúdo</td>
            </tr>
        </table>
        <div style="padding: 1rem;padding-bottom: 0">
            <table>
                @php
                    $shipping_address = json_decode($order->shipping_address);
                @endphp
                <tr>
                    <td class="strong">REMETENTE: <span>{{ ' '.config('correios.nome_remetente') }}</span></td>
                </tr>
                <tr>
                    <td class="strong">CPF/CNPJ: <span>{{ ' '.config('correios.nome_remetente') }}</span></td>
                </tr>
                <tr>
                    <td class="strong">ENDEREÇO: <span>{{ ' '.config('correios.logradouro') }}</span></td>
                </tr>
                <tr>
                    <td class="strong">CIDADE/UF: <span>{{ ' '.config('correios.cidade').' '.'-'.' '.config('correios.uf') }}</span>
                </tr>
                <tr>
                    <td class="strong">CEP: <span>{{ ' '.config('correios.cep') }}</span>
                </tr>
            </table>
        </div>

    </div>

    <div style="padding: 1rem;padding-bottom: 0">
            <table>
                @php
                $shipping_address = $order->shipping_address;
                $address = json_decode($shipping_address);
                $state = $address->state;
                switch ($state) {
            case 'Acre':
                $state = 'AC';
                break;
            case 'Alagoas':
                $state = 'AL';
                break;
            case 'Amapa':
                $state = 'AP';
                break;
            case 'Amazonas':
                $state = 'AM';
                break;
            case 'Bahia':
                $state = 'DBA';
                break;
            case 'Ceara':
                $state = 'CE';
                break;
            case 'Distrito Federal':
                $state = 'DF';
                break;
            case 'Espirito Santo':
                $state = 'ES';
                break;
            case 'Goias':
                $state = 'GO';
                break;
            case 'Maranhao':
                $state = 'MA';
                break;
            case 'Mato Grosso':
                $state = 'MT';
                break;
            case 'Mato Grosso do Sul':
                $state = 'MS';
                break;
            case 'Minas Gerais':
                $state = 'MG';
                break;
            case 'Para':
                $state = 'PA';
                break;
            case 'Paraiba':
                $state = 'PB';
                break;
            case 'Parana':
            case 'PARANA':
                $state = 'PR';
                break;
            case 'Pernambuco':
                $state = 'PE';
                break;
            case 'Piaui':
                $state = 'PI';
                break;
            case 'Rio Grande do Norte':
                $state = 'RN';
                break;
            case 'Rio Grande do Sul':
                $state = 'RS';
                break;
            case 'Rio de Janeiro':
                $state = 'RJ';
                break;
            case 'Rondonia':
                $state = 'RO';
                break;
            case 'Roraima':
                $state = 'RR';
                break;
            case 'Santa Catarina':
                $state = 'SC';
                break;
            case 'S�0�0o Paulo':
            case 'Estado de S�0�0o Paulo':
                $state = 'SP';
                break;
            case 'Sergipe':
                $state = 'SE';
                break;
            case 'Tocantins':
                $state = 'TO';
                break;
            default:
                $state = 'UF';
                break;
        }
            @endphp
                <tr>
                    <td class="strong">DESTINATÁRIO: <span>{{ ' '.$address->name }}</span></td>
                </tr>
                <tr>
                    <td class="strong">CPF/CNPJ: <span>{{ ' '.$user->cpf }}</span></td>
                </tr>
                <tr>
                    <td class="strong">ENDEREÇO: <span>{{ ' '.$address->address }}</span></td>
                </tr>
                <tr>
                    <td class="strong">CIDADE/UF: <span>{{ ' '.$address->city.' '.'-'.' '.$state }}</span>
                </tr>
                <tr>
                    <td class="strong">CEP: <span>{{ ' '.$address->postal_code }}</span>
                </tr>
            </table>
        </div>
        
     <div style="padding: 1rem;">
        <table class="padding text-left small border-bottom">
            <thead>
            <tr class="gry-color" style="background: #eceff4;">
                <th width="35%" class="text-left" style="text-align: center">IDENTIFICAÇÂO DOS BENS</th>
            </tr>
            </thead>
        </table>
    </div>

    <div style="padding: 1rem;">
        <table class="padding text-left small border-bottom">
            <thead>
            <tr class="gry-color" style="background: #eceff4;">
                <th width="35%" class="text-left">DISCRIMINAÇÂO DO CONTEÚDO</th>
                <th width="10%" class="text-left">{{ translate('Qty') }}</th>
                <th width="15%" class="text-left">PESO</th>
            </tr>
            </thead>
            <tbody class="strong">
            @foreach ($order->orderDetails as $key => $orderDetail)
                
                @if ($orderDetail->product != null)
                    <tr class="">
                        <td>
                            {{ $orderDetail->product->name }}
                            @if($orderDetail->variation != null)
                                ({{ $orderDetail->variation }})
                            @endif
                            <br>
                            <small>
                                @php
                                    $product_stock = json_decode($orderDetail->product->stocks->first(), true);
                                @endphp
                            </small>
                        </td>
                        <td class="">{{ $orderDetail->quantity }}</td>
                        @endif
                        @endforeach
                        <td class="currency">{{$peso.' '.'g'}}</td>
                    </tr>
                
            <tr class="gry-color" style="background: #eceff4;">
                <td colspan="2"></td>
                <td class="currency">{{'R$'.' '.$total}}</td>
            </tr>
            </tbody>
        </table>
    </div>
    
    <div style="padding: 1rem;">
        <table class="padding text-left small border-bottom">
            <thead>
            <tr class="gry-color" style="background: #eceff4;">
                <th width="100%" class="text-left" style="text-align: center">DECLARAÇÃO</th>
            </tr>
            </thead>
            <tbody>
                <tr>
            <td colspan="4">
              &nbsp;&nbsp;&nbsp;Declaro não ser pessoa física ou jurídica que realiza, com habitualidade ou em volume que caracterize intuito comercial,
              operações de circulação de mercadoria, ainda que estas se iniciem no exterior, que o conteúdo declarado não está sujeito à tributação,
              e que sou o único responsável por eventuais penalidades ou danos decorrentes de informações inverídicas.<br><br>
              Brasília - DF, <?php $dataAtual = date('d')." de ".$meses[date('n')]." de ".date('Y');
              echo $dataAtual; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <br />
              <br />
              <div>
                  <hr class="text-left" />
                   <p>Assinatura do<br>Declarante/Remetente</p>
              </div>
              
            </td>
          </tr>
            </tbody>
        </table>
    </div>
    
     <div style="padding: 1rem;">
        <table class="padding text-left small border-bottom">
            <thead>
            <tr class="gry-color" style="background: #eceff4;">
                <th width="100%" class="text-left" style="text-align: center">Atenção: O declarante/remetente é responsável exclusivamente pelas informações declaradas.</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4">
                OBSERVAÇÕES:
                <br><br>
                I. É Contribuinte de ICMS qualquer pessoa física ou jurídica que realize, com habitualidade ou em volume que caracterize intuito comercial,
                operações de circulação de mercadoria ou prestações de serviços de transportes interestadual e intermunicipal e de comunicação, 
                ainda que as operações e prestações se iniciem no exterior (Lei complementar nº 87/96 Art. 4º).
                <br><br>
                II. Constitui crime contra a ordem tributária suprimir ou reduzir tributo ou contribuição social e qualquer acessório, quando negar ou deixar de fornecer, 
                quando obrigatório, nota fiscal ou documento equivalente, relativa a venda de mercadoria ou prestação de serviço, 
                efetivamente realizada, ou fornecê-la em desacordo com a legislação. Sob pena de reclusão de 2 (dois) a 5 (cinco) anos e multa (Lei 8.137/90 Art. 1º, V).
            </td>
                </tr>
            </tbody>
        </table>
    </div>

	</div>
</body>
</html>
