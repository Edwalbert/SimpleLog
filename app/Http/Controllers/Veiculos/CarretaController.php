<?php

namespace App\Http\Controllers\Veiculos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Empresas\TransportadoraController;
use App\Http\Controllers\Util\ApiIbgeController;
use App\Http\Controllers\Util\UploadController;
use App\Models\documentos\Crlv;
use App\Repositories\Veiculos\CarretaRepository;
use App\Models\util\Endereco;
use Illuminate\Http\Request;
use App\Models\veiculos\Carreta;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CarretaController extends Controller
{
    private $carretaRepository;
    private $cavaloController;
    private $uploadController;
    private $transportadoraController;
    private $apiIbgeController;

    public function __construct(CarretaRepository $carretaRepository, UploadController $uploadController, CavaloController $cavaloController, TransportadoraController $transportadoraController, ApiIbgeController $apiIbgeController)
    {
        $this->cavaloController = $cavaloController;
        $this->carretaRepository = $carretaRepository;
        $this->uploadController = $uploadController;
        $this->transportadoraController = $transportadoraController;
        $this->apiIbgeController = $apiIbgeController;
    }

    public function storeOrUpdate(Request $request)
    {
        if ($request->input('id_carreta') !== null) {
            $resultado = $this->update($request);

            if ($resultado == 'success') {
                return redirect('cadastro-carreta')->with('success', 'Carreta atualizada com sucesso!');
            } else {
                return redirect('cadastro-carreta')->with('error', 'Erro! ' . $resultado);
            }
        } else {
            $resultado = $this->store($request);

            if ($resultado == 'success') {
                return redirect('cadastro-carreta')->with('success', 'Carreta cadatrada com sucesso!');
            } else {
                return redirect('cadastro-carreta')->with('error', 'Erro! ' . $resultado);
            }
        }
    }

    public function store(Request $request)
    {


        $id_carreta = $request->input('id_carreta');
        $id_crlv = $request->input('id_crlv');

        $validatedData = Validator::make($request->all(), [
            'placa' => 'required|string|max:7|unique:carretas,placa,' . $id_carreta . ',id_carreta',
            'renavam' => 'required|string|max:11|unique:crlvs,renavam,' . $id_crlv,
            'ano_fabricacao' => 'required|numeric',
            'ano_modelo' => 'required|numeric',
            'numero_crv' => 'required|string|max:12',
            'codigo_seguranca_cla' => 'required|string|max:11',
            'modelo' => 'required|string',
            'cor' => 'required|string',
            'chassi' => 'required|string|max:17',
            'rntrc' => 'required|string|max:9|unique:carretas',
            'cidade' => 'required|string|max:45',
            'uf' => 'required|string|max:2',
            'cnpj_crlv' => 'required|string|max:14',
            'cpf_crlv' => 'nullable|string|max:11',
            'emissao_crlv' => 'nullable|date',
            'vencimento_crlv' => 'nullable|date',
            'vencimento_opentech_minerva' => 'nullable|date',
            'vencimento_opentech_alianca' => 'nullable|date',
            'vencimento_opentech_seara' => 'nullable|date',
            'checklist_alianca' => 'nullable|date',
            'checklist_minera' => 'nullable|date',
            'status' => 'required|string|max:7',
            'motivo_desligamento' => 'nullable|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            $endereco = new Endereco();
            $endereco->setCidadeAttribute($request->input('cidade'));
            $endereco->setUfAttribute($request->input('uf'));
            $endereco->save();
            $id_endereco = $endereco->id;

            $crlv = new Crlv();
            $crlv->setIdEnderecoAttribute($id_endereco);
            $crlv->setRenavamAttribute($request->input('renavam'));
            $crlv->setAnoFabricacaoAttribute($request->input('ano_fabricacao'));
            $crlv->setAnoModeloAttribute($request->input('ano_modelo'));
            $crlv->setNumeroCrvAttribute($request->input('numero_crv'));
            $crlv->setCodigoSegurancaClaAttribute($request->input('codigo_seguranca_cla'));
            $crlv->setModeloAttribute($request->input('modelo'));
            $crlv->setCorAttribute($request->input('cor'));
            $crlv->setChassiAttribute($request->input('chassi'));
            $crlv->setCnpjCrlvAttribute($request->input('cnpj_crlv'));
            $crlv->setCpfCrlvAttribute($request->input('cpf_crlv'));
            $crlv->setEmissaoCrlvAttribute($request->input('emissao_crlv'));
            $crlv->setVencimentoCrlvAttribute($request->input('vencimento_crlv'));
            $crlv->setPathCrlvAttribute($this->uploadController->uploadCarreta($request, 'doc_crlv', 'crlv', '.pdf'));
            $crlv->save();
            $id_crlv = $crlv->id;

            $carreta = new Carreta;
            $carreta->setPlacaAttribute($request->input('placa'));
            $carreta->setStatusAttribute('Ativo');
            $carreta->setIdCavalo($request->input('vincular_cavalo'));
            $carreta->setIdCrlvAttribute($id_crlv);
            $carreta->setRntrcAttribute($request->input('rntrc'));
            $carreta->setIdTransportadoraAttribute($request->input('id_transportadora'));
            $carreta->setVencimentoOpentechMinervaAttribute($request->input('vencimento_opentech_minerva'));
            $carreta->setVencimentoOpentechAliancaAttribute($request->input('vencimento_opentech_alianca'));
            $carreta->setVencimentoOpentechSearaAttribute($request->input('vencimento_opentech_seara'));
            $carreta->setChecklistAliancaAttribute($request->input('checklist_alianca'));
            $carreta->setChecklistMinervaAttribute($request->input('checklist_minerva'));
            $carreta->setTipoAttribute($request->input('tipo'));
            $carreta->setPathRntrcAttribute($this->uploadController->uploadCarreta($request, 'doc_rntrc', 'rntrc', '.pdf'));
            $carreta->save();
            DB::commit();

            return 'success';
        } catch (QueryException $e) {

            $errorReason = $e->errorInfo[2];

            DB::rollback();

            return $errorReason;
        }
    }

    public function update(Request $request)
    {

        $validatedData = Validator::make($request->all(), [
            'renavam' => 'required|string|max:11',
            'ano_fabricacao' => 'required|numeric',
            'ano_modelo' => 'required|numeric',
            'numero_crv' => 'required|string|max:12',
            'codigo_seguranca_cla' => 'required|string|max:11',
            'modelo' => 'required|string',
            'cor' => 'required|string',
            'chassi' => 'required|string|max:17',
            'rntrc' => 'required|string|max:9|unique:carretas',
            'cidade' => 'required|string|max:45',
            'uf' => 'required|string|max:2',
            'cnpj_crlv' => 'required|string|max:14',
            'cpf_crlv' => 'nullable|string|max:11',
            'emissao_crlv' => 'nullable|date',
            'vencimento_crlv' => 'nullable|date',
            'vencimento_opentech_minerva' => 'nullable|date',
            'vencimento_opentech_alianca' => 'nullable|date',
            'vencimento_opentech_seara' => 'nullable|date',
            'checklist_alianca' => 'nullable|date',
            'checklist_minera' => 'nullable|date',
            'status' => 'required|string|max:7',
            'motivo_desligamento' => 'nullable|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            $carreta = Carreta::findOrFail($request->input('id_carreta'));
            $carreta->setStatusAttribute($request->input('status'));
            $carreta->setIdCavalo($request->input('vincular_cavalo'));
            $carreta->setIdCrlvAttribute($request->input('id_crlv'));
            $carreta->setRntrcAttribute($request->input('rntrc'));
            $carreta->setIdTransportadoraAttribute($request->input('id_transportadora'));
            $carreta->setVencimentoOpentechMinervaAttribute($request->input('vencimento_opentech_minerva'));
            $carreta->setVencimentoOpentechAliancaAttribute($request->input('vencimento_opentech_alianca'));
            $carreta->setVencimentoOpentechSearaAttribute($request->input('vencimento_opentech_seara'));
            $carreta->setChecklistAliancaAttribute($request->input('checklist_alianca'));
            $carreta->setChecklistMinervaAttribute($request->input('checklist_minerva'));
            $carreta->setTipoAttribute($request->input('tipo'));
            $carreta->setPathRntrcAttribute($this->uploadController->uploadCarreta($request, 'doc_rntrc', 'rntrc', '.pdf'));
            $carreta->save();

            $crlv = Crlv::findOrFail($request->input('id_crlv'));
            $crlv->setIdEnderecoAttribute($request->input('id_endereco_crlv'));
            $crlv->setRenavamAttribute($request->input('renavam'));
            $crlv->setAnoFabricacaoAttribute($request->input('ano_fabricacao'));
            $crlv->setAnoModeloAttribute($request->input('ano_modelo'));
            $crlv->setNumeroCrvAttribute($request->input('numero_crv'));
            $crlv->setCodigoSegurancaClaAttribute($request->input('codigo_seguranca_cla'));
            $crlv->setModeloAttribute($request->input('modelo'));
            $crlv->setCorAttribute($request->input('cor'));
            $crlv->setChassiAttribute($request->input('chassi'));
            $crlv->setCnpjCrlvAttribute($request->input('cnpj_crlv'));
            $crlv->setCpfCrlvAttribute($request->input('cpf_crlv'));
            $crlv->setEmissaoCrlvAttribute($request->input('emissao_crlv'));
            $crlv->setVencimentoCrlvAttribute($request->input('vencimento_crlv'));
            $crlv->setPathCrlvAttribute($this->uploadController->uploadCarreta($request, 'doc_crlv', 'crlv', '.pdf'));
            $crlv->save();

            $endereco = Endereco::findOrFail($request->input('id_endereco_crlv'));
            $endereco->setCidadeAttribute($request->input('cidade'));
            $endereco->setUfAttribute($request->input('uf'));
            $endereco->save();
            DB::commit();

            return 'success';
        } catch (QueryException $e) {

            $errorReason = $e->errorInfo[2];

            DB::rollback();

            return $errorReason;
        }
    }

    public function chamarIndex()
    {
        $cavalos = $this->cavaloController->index();
        $transportadoras = $this->transportadoraController->index();
        $uf = $this->apiIbgeController->consultarEstados();
        $title = 'Formulário Carreta';
        return view('cadastro.Formularios.formulario-carreta', compact('cavalos', 'transportadoras', 'uf', 'title'));
    }
}
