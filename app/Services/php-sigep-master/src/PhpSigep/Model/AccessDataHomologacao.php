<?php
namespace PhpSigep\Model;

/**
 * @author: Stavarengo
 */
class AccessDataHomologacao extends AccessData
{
    /**
     * Atalho para criar uma {@link AccessData} com os dados do ambiente de homologação.
     */
    public function __construct()
    {
        parent::__construct(
            array(
                'usuario'           => 'livraria.cdju@stf.jus.br',
                'senha'             => 'vzvavs',
                'numeroContrato'    => '9912562235',
                'cartaoPostagem'    => '0076903338',
                'cnpjEmpresa'       => '00531640000128', // Obtido no método 'buscaCliente'.
                'anoContrato'       => null, // Não consta no manual.
                'diretoria'         => new Diretoria(Diretoria::DIRETORIA_DR_BRASILIA), // Obtido no método 'buscaCliente'.
                'codAdministrativo' => '21456950',
            )
        );
        try {\PhpSigep\Bootstrap::getConfig()->setEnv(\PhpSigep\Config::ENV_DEVELOPMENT);} catch (\Exception $e) {}
    }
}
