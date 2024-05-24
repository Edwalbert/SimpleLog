<?php

namespace App\Http\Controllers\Empresas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Util\ApiIbgeController;
use App\Models\empresas\Butuca;
use App\Models\util\ContaBancaria;
use App\Models\util\Contato;
use App\Models\util\Endereco;
use App\Repositories\empresas\ButucaRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ButucaController extends Controller
{
    private $apiIbgeController;
    private $butucaRepository;

    public function __construct(
        ApiIbgeController $apiIbgeController,
        ButucaRepository $butucaRepository,
    ) {
        $this->apiIbgeController = $apiIbgeController;
        $this->butucaRepository = $butucaRepository;
    }



    public function storeOrUpdate(Request $request)
    {
        if ($request->input('id_butuca') !== null) {
            $resultado = $this->update($request);
            $successMessage = 'Butuca atualizada com sucesso! ';
        } else {
            $resultado = $this->store($request);
            $successMessage = 'Butuca cadastrada com sucesso! ';
        }

        $redirectRoute = 'cadastro-butucas';
        $errorMessage = 'Erro! ';

        if ($resultado === 'success') {
            return redirect($redirectRoute)->with('success', $successMessage);
        } else {
            return redirect($redirectRoute)->with('error', $errorMessage . $resultado);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $endereco = new Endereco;
            $endereco->setUfAttribute($request->input('uf'));
            $endereco->setCidadeAttribute($request->input('cidade'));
            $endereco->save();
            $id_endereco = $endereco->id;

            $contato = new Contato;
            $contato->setEmail1Attribute($request->input('email'));
            $contato->save();
            $id_contato = $contato->id;

            $conta_bancaria = new ContaBancaria;
            $conta_bancaria->setNumeroContaBancariaAttribute($request->input('numero_conta_bancaria'));
            $conta_bancaria->setAgenciaAttribute($request->input('agencia'));
            $conta_bancaria->setCodigoBancoAttribute($request->input('codigo_banco'));
            $conta_bancaria->setNomeBancoAttribute($request->input('nome_banco'));
            $conta_bancaria->setTitularidadeAttribute($request->input('titularidade'));
            $conta_bancaria->setTipoContaAttribute($request->input('tipo_conta'));
            $conta_bancaria->setPixAttribute($request->input('pix'));
            $conta_bancaria->setChavePixAttribute($request->input('chave_pix'));
            $conta_bancaria->save();
            $id_conta_bancaria = $conta_bancaria->id;

            $butuca = new Butuca;
            $butuca->setNomeAttribute($request->input('nome'));
            $butuca->setIdEnderecoAttribute($id_endereco);
            $butuca->setIdContatoAttribute($id_contato);
            $butuca->setIdContaBancariaAttribute($id_conta_bancaria);
            $butuca->setButucaAttribute($request->input('butuca'));
            $butuca->setTerminalAttribute($request->input('terminal'));
            $butuca->setDepotAttribute($request->input('depot'));
            $butuca->save();

            DB::commit();

            return ('success');
        } catch (Exception $e) {
            DB::rollBack();
            return ($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $id_butuca = $request->input('id_butuca');
            $butuca = Butuca::findOrFail($id_butuca);
            $butuca->setNomeAttribute($request->input('nome'));
            $butuca->setButucaAttribute($request->input('butuca'));
            $butuca->setTerminalAttribute($request->input('terminal'));
            $butuca->setDepotAttribute($request->input('depot'));
            $butuca->save();
            $id_endereco = $butuca->id_endereco;
            $id_contato = $butuca->id_contato;
            $id_conta_bancaria = $butuca->id_conta_bancaria;

            $endereco = Endereco::findOrFail($id_endereco);
            $endereco->setUfAttribute($request->input('uf'));
            $endereco->setCidadeAttribute($request->input('cidade'));
            $endereco->save();

            $contato = Contato::findOrFail($id_contato);
            $contato->setEmail1Attribute($request->input('email'));
            $contato->save();

            $conta_bancaria = ContaBancaria::findOrFail($id_conta_bancaria);
            $conta_bancaria->setNumeroContaBancariaAttribute($request->input('numero_conta_bancaria'));
            $conta_bancaria->setAgenciaAttribute($request->input('agencia'));
            $conta_bancaria->setCodigoBancoAttribute($request->input('codigo_banco'));
            $conta_bancaria->setNomeBancoAttribute($request->input('nome_banco'));
            $conta_bancaria->setTitularidadeAttribute($request->input('titularidade'));
            $conta_bancaria->setTipoContaAttribute($request->input('tipo_conta'));
            $conta_bancaria->setPixAttribute($request->input('pix'));
            $conta_bancaria->setChavePixAttribute($request->input('chave_pix'));
            $conta_bancaria->save();

            DB::commit();

            return ('success');
        } catch (Exception $e) {
            DB::rollBack();
            return ($e->getMessage());
        }
    }

    public function index()
    {
        $butucas = $this->butucaRepository->index();
        return $butucas;
    }

    public function butucas()
    {
        $butucas = $this->butucaRepository->butucas();
        return $butucas;
    }

    public function depots()
    {
        $depots = $this->butucaRepository->depots();
        return $depots;
    }

    public function terminais()
    {
        $terminais = $this->butucaRepository->terminais();
        return $terminais;
    }


    public function chamarIndex()
    {
        $uf = $this->apiIbgeController->consultarEstados();
        $butucas = $this->index();
        return view('administrativo.Formularios.formulario-cadastro-butuca', compact('uf', 'butucas'));
    }
}
