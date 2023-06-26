<!DOCTYPE html>

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
<html>
<head>
    <title>Declaração de Conteúdo dos Correios</title>
   <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 100%;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        .logo {
            margin-bottom: 20px;
        }
        .logo img {
            width: 200px;
            float: left;
            margin-right: 150px;
        }
        h4 {
            margin-top: 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
            margin-top:-15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 3px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f5f5f5;
        }

        hr {
            margin: 0;
            border: none;
            border-top: 1px solid black;
            width: 250px;
        }
        .text-align-right{
            text-align: -webkit-match-parent;
        }
        .align-center{
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="https://hoogli.dev.br/stf-ecommerce/declaracao/image/correios.svg" alt="Logo dos Correios">
        </div>
        <h4>Declaração de Conteúdo dos Correios</h4>
        <table>
            <tr>
                <th class="text-align-right">REMETENTE:</th>
                <td colspan="4"><?php echoconfig('correios.nome_remetente')?></td>
            </tr>
            <tr>
                <th class="text-align-right">CPF/CNPJ:</th>
                <td colspan="4"><?php echo config('correios.cnpj')?></td>
            </tr>
            <tr>
                <th class="text-align-right">ENDEREÇO:</th>
                <td colspan="4"><?php echo config('correios.logradouro')?></td>
            </tr>
            <tr>
                <th class="text-align-right">CIDADE/UF:</th>
                <td><?php echo config('correios.cidade')?> - <?php echo config('correios.uf')?></td>
                <th class="text-align-right">CEP:</th>
                <td><?php echo config('correios.cep')?></td>
            </tr>
        </table>
        <br>
        <table>
             <?php
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
            ?>
            <tr>
                <th class="text-align-right" style="width: 33%;">DESTINATÁRIO:</th>
                <td colspan="4"><?php echo $address->name ?></td>
            </tr>
            <tr>
                <th class="text-align-right">CPF/CNPJ:</th>
                <td colspan="4"><?php echo config('correios.cnpj_empresa') ?></td>
            </tr>
            <tr>
                <th class="text-align-right">ENDEREÇO:</th>
                <td colspan="4"><?php $address->address ?></td>
            </tr>
            <tr>
                <th class="text-align-right">CIDADE/UF:</th>
                <td><?php echo $address->city?> - <?php echo $state?></td>
                <th class="text-align-right">CEP:</th>
                <td><?php echo $address->postal_code ?></td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <th colspan="4">IDENTIFICAÇÃO DOS BENS</th>
            </tr>
            <tr>
                <th>Descrição do Conteúdo</th>
                <th>Quantidade</th>
                <th>Peso</th>
            </tr>
            <?php foreach ($order->orderDetails as $key => $orderDetail){?>
           
            <tr>
                <td class="align-center"><?php echo $orderDetail->product->name?></td>
                <td class="align-center"><?php $orderDetail->quantity?></td>
                <td class="align-center">10kg</td>
            </tr>
               <?php } ?>
            <tr>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td class="align-center">R$ 200,00</td>
            </tr>
        </table>
        <br>
        <table>
          <tr>
            <th colspan="4">DECLARAÇÃO</th>
          </tr>
          <tr>
            <td colspan="4">
              &nbsp;&nbsp;&nbsp;Declaro não ser pessoa física ou jurídica que realiza, com habitualidade ou em volume que caracterize intuito comercial,
              operações de circulação de mercadoria, ainda que estas se iniciem no exterior, que o conteúdo declarado não está sujeito à tributação,
              e que sou o único responsável por eventuais penalidades ou danos decorrentes de informações inverídicas.<br><br>
              Brasília - DF, <?php $dataAtual = date('d')." de ".$meses[date('n')]." de ".date('Y');
echo $dataAtual; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><span style="display: flex;flex-direction: column;align-items: flex-end;margin-right: 100px;">
              <hr><span style=" display: flex; text-align: -webkit-center; margin-right: 40px;">Assinatura do<br>Declarante/Remetente</span></span>
            </td>
          </tr>
        </table>
        <br>
        <table>
            <tr>
                <th colspan="4">Atenção: O declarante/remetente é responsável exclusivamente pelas informações declaradas.</th>
            </tr>
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
        </table>
    </div>
</body>
</html>

