# Alterações feita no BD enjoy

Nome do BD: hoog1698_enjoy

Segue a lista de Alterações: 

1- Na tabela addresses foi adicionado dois campos ['correios'] ,['valor_correios']
</br>
    O campo "correios" => grava o tipo de serviço se é PAC ou SEDEX, 
</br>
    O campo "valor_correios" => grava o valor do frete. 

</br>
</br>

2- Foi criado uma Tabela de ['postagem'].

    A tabela tem os seguintes campos:

    "id" => grava o id do registro de postagem,

    "n_objeto" => grava o numero da etiqueta
 
    "cep" => grava o cep do usuário

    "nome" => grava o nome do usuário
 
    "peso" => grava o peso do produto
  
    "v_declarado" => grava o valor do produto
    
    "n_fiscal" => grava a número  nota fiscal

    "servico" => grava o tipo de serviço se é PAC ou SEDEX

    "order_id" => numero do pedido 
    
    "data" => quando foi gerado a etiqueta
    </br>
3- Na tabela users foi adicionado um campo ['cpf']

    O campo "cpf" => grava o cpf do usuário. 
