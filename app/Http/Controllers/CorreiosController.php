<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CorreiosService;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Str;

class CorreiosController extends Controller
{
    
    protected $correiosService;

    public function __construct(CorreiosService $correiosService)
    {
        $this->correiosService = $correiosService;
    }
    
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {     
          $order = Order::find($id);
          
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
          $protocolo = Str::random(15);
           
         
          $peso = 0;

            foreach($order->orderDetails as $orderDetail)
            {
                $product = Product::find($orderDetail->product_id);
                
                if ($product) {
                    $peso += $product->weight;
                }
            }
          
          
          if($address->correios === 'PAC'){
              $correios = 4014;
          }elseif($address->correios === 'SEDEX'){
              $correios = 4510;
          }
          
          
          $frete = $this->correiosService->gerarEtiqueta(
              [
                  'customer_name' => $address->name,
                  'customer_address' => $address->address,
                  'zip' =>  $address->postal_code,
                  'city' => $address->city,
                  'uf' => $state,
                  'protocolo' => $protocolo,
                  'nPedido' => $order->id,
                  'correios' => $correios,
                  'peso' => $peso,
                  'total_price' => $order->grand_total,
                  'id' => $order->id,
              ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //
    }
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
}
