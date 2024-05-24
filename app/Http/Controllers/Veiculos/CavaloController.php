<?php

namespace App\Http\Controllers\Veiculos;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Empresas\TransportadoraController;
use App\Http\Controllers\Util\ApiIbgeController;
use App\Http\Controllers\Util\UploadController;
use App\Http\Controllers\Util\VerificarRegistroController;
use App\Models\admnistrativo\recebiveis\Fatura;
use App\Models\documentos\Crlv;
use App\Repositories\Veiculos\CavaloRepository;
use App\Models\util\ContaBancaria;
use App\Models\util\Endereco;
use Illuminate\Http\Request;
use App\Models\veiculos\Cavalo;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Validator;

class CavaloController extends Controller
{
    private $verificarRegistroController;
    private $cavaloRepository;
    private $uploadController;
    private $transportadoraController;
    private $apiIbgeController;
    protected $model;
    protected $table = 'cavalo';


    public function __construct(CavaloRepository $cavaloRepository, UploadController $uploadController, VerificarRegistroController $verificarRegistroController, TransportadoraController $transportadoraController, ApiIbgeController $apiIbgeController)
    {
        $this->cavaloRepository = $cavaloRepository;
        $this->uploadController = $uploadController;
        $this->verificarRegistroController = $verificarRegistroController;
        $this->transportadoraController = $transportadoraController;
        $this->apiIbgeController = $apiIbgeController;
    }

    public function index()
    {
        $cavalos = $this->cavaloRepository->index();
        return $cavalos;
    }

    public function storeOrUpdate(Request $request)
    {

        if ($request->input('id_cavalo') !== null) {
            $resultado = $this->update($request);

            if ($resultado == 'success') {
                return redirect('cadastro-cavalo')->with('success', 'Cavalo atualizado com sucesso!');
            } else {
                return redirect('cadastro-cavalo')->with('error', 'Erro! ' . $resultado);
            }
        } else {
            $resultado = $this->store($request);

            if ($resultado == 'success') {
                return redirect('cadastro-cavalo')->with('success', 'Cavalo cadatrado com sucesso!');
            } else {
                return redirect('cadastro-cavalo')->with('error', 'Erro! ' . $resultado);
            }
        }
    }

    public function store(Request $request)
    {


        $validatedData = Validator::make($request->all(), [
            'placa' => 'required|string|max:7|unique:cavalos',
            'renavam' => 'required|string|max:11',
            'ano_fabricacao' => 'required|numeric',
            'ano_modelo' => 'required|numeric',
            'numero_crv' => 'required|string|max:12',
            'codigo_seguranca_cla' => 'required|string|max:11|unique:crlvs',
            'modelo' => 'required|string',
            'cor' => 'required|string',
            'chassi' => 'required|string|max:17',
            'rntrc' => 'required|string|max:9|unique:cavalos',
            'cidade' => 'required|string|max:45',
            'uf' => 'required|string|max:2',
            'cnpj_crlv' => 'required|string|max:14',
            'cpf_crlv' => 'nullable|string|max:11',
            'emissao_crlv' => 'nullable|date',
            'vencimento_crlv' => 'nullable|date',
            'vencimento_teste_fumaca' => 'nullable|date',
            'vencimento_cronotacografo' => 'nullable|date',
            'vencimento_opentech_minerva' => 'nullable|date',
            'vencimento_opentech_alianca' => 'nullable|date',
            'vencimento_opentech_seara' => 'nullable|date',
            'checklist_alianca' => 'nullable|date',
            'checklist_minerva' => 'nullable|date',
            'id_rastreador' => 'required|string|max:8',
            'tecnologia' => 'required|string|max:10',
            'tipo_pedagio' => 'required|string|max:6',
            'id_pedagio' => 'required|string|max:15',
            'grupo' => 'required|string|max:15',
            'status' => 'required|string|max:7',
            'motivo_desligamento' => 'nullable|string|max:100',
            'login_tecnologia' => 'nullable|string|max:45',
            'senha_tecnologia' => 'nullable|string|max:25',
            'certificado_cronotacografo' => 'nullable|string|max:15',
            'brasil_risk_klabin' => 'nullable|date',
            'conta_bancaria' => 'nullable|string|max:10',
            'tipo_conta' => 'nullable|string|max:2',
            'titularidade' => 'nullable|string|max:2',
            'agencia' => 'nullable|string|max:10',
            'codigo_banco' => 'nullable|string|max:10',
            'nome_banco' => 'nullable|string|max:10',
            'pix' => 'nullable|string|max:15',
        ]);


        try {

            DB::beginTransaction();
            $endereco = new Endereco();
            $endereco->setCidadeAttribute($request->input('cidade'));
            $endereco->setUfAttribute($request->input('uf'));
            $endereco->save();
            $id_endereco = $endereco->id;

            $conta_bancaria = new ContaBancaria();
            $conta_bancaria->setNumeroContaBancariaAttribute($request->input('numero_conta_bancaria'));
            $conta_bancaria->setTipoContaAttribute($request->input('tipo_conta'));
            $conta_bancaria->setTitularidadeAttribute($request->input('titularidade'));
            $conta_bancaria->setAgenciaAttribute($request->input('agencia'));
            $conta_bancaria->setCodigoBancoAttribute($request->input('codigo_banco'));
            $conta_bancaria->setNomeBancoAttribute($request->input('nome_banco'));
            $conta_bancaria->setPixAttribute($request->input('pix'));
            $conta_bancaria->setChavePixAttribute($request->input('chave_pix'));
            $conta_bancaria->save();
            $id_conta_bancaria = $conta_bancaria->id;

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
            $crlv->setPathCrlvAttribute($this->uploadController->uploadCavalo($request, 'doc_crlv', 'crlv', '.pdf'));

            $crlv->save();

            $id_crlv = $crlv->id;

            $cavalo = new Cavalo();
            $cavalo->setPlacaAttribute($request->input('placa'));
            $cavalo->setIdCrlvAttribute($id_crlv);
            $cavalo->setIdContaBancariaAttribute($id_conta_bancaria);
            $cavalo->setRntrcAttribute($request->input('rntrc'));
            $cavalo->setIdTransportadoraAttribute($request->input('id_transportadora'));
            $cavalo->setVencimentoTesteFumacaAttribute($request->input('vencimento_teste_fumaca'));
            $cavalo->setVencimentoCronotacografoAttribute($request->input('vencimento_cronotacografo'));
            $cavalo->setVencimentoOpentechMinervaAttribute($request->input('vencimento_opentech_minerva'));
            $cavalo->setVencimentoOpentechAliancaAttribute($request->input('vencimento_opentech_alianca'));
            $cavalo->setVencimentoOpentechSearaAttribute($request->input('vencimento_opentech_seara'));
            $cavalo->setChecklistAliancaAttribute($request->input('checklist_alianca'));
            $cavalo->setChecklistMinervaAttribute($request->input('checklist_minerva'));
            $cavalo->setIdRastreadorAttribute($request->input('id_rastreador'));
            $cavalo->setTecnologiaAttribute($request->input('tecnologia'));
            $cavalo->setTelemetriaAttribute($request->input('telemetria'));
            $cavalo->setTipoPedagioAttribute($request->input('tipo_pedagio'));
            $cavalo->setIdPedagioAttribute($request->input('id_pedagio'));
            $cavalo->setGrupoAttribute($request->input('grupo'));
            $cavalo->setStatusAttribute($request->input('status'));
            $cavalo->setMotivoDesligamentoAttribute($request->input('motivo_desligamento'));
            $cavalo->setLoginTecnologiaAttribute($request->input('login_tecnologia'));
            $cavalo->setSenhaTecnologiaAttribute($request->input('senha_tecnologia'));
            $cavalo->setCertificadoCronotacografoAttribute($request->input('certificado_cronotacografo'));
            $cavalo->setBrasilRiskKlabinAttribute($request->input('brasil_risk_klabin'));
            $cavalo->setPathRntrcAttribute($this->uploadController->uploadCavalo($request, 'doc_rntrc', 'rntrc', '.pdf'));
            $cavalo->setPathTesteFumacaAttribute($this->uploadController->uploadCavalo($request, 'doc_teste_fumaca', 'teste-fumaca', '.pdf'));
            $cavalo->setPathFotoCavaloAttribute($this->uploadController->uploadCavalo($request, 'doc_foto_cavalo', 'foto-cavalo', '.jpeg'));

            $cavalo->save();


            $id_cavalo = $cavalo->id;

            DB::commit();

            return ('success');
        } catch (QueryException $e) {
            $errorReason = $e->errorInfo[2];
            DB::rollback();
            return $errorReason;
        }
    }

    public function update(Request $request)
    {
        $placa = $request->input('placa');

        $validatedData = Validator::make($request->all(), [
            'placa' => 'required|string|max:7|unique:cavalos',
            'renavam' => 'required|string|max:11',
            'ano_fabricacao' => 'required|numeric',
            'ano_modelo' => 'required|numeric',
            'numero_crv' => 'required|string|max:12',
            'codigo_seguranca_cla' => 'required|string|max:11',
            'modelo' => 'required|string',
            'cor' => 'required|string',
            'chassi' => 'required|string|max:17',
            'rntrc' => 'required|string|max:9|unique:cavalos',
            'cidade' => 'required|string|max:45',
            'uf' => 'required|string|max:2',
            'cnpj_crlv' => 'required|string|max:14',
            'cpf_crlv' => 'nullable|string|max:11',
            'emissao_crlv' => 'nullable|date',
            'vencimento_crlv' => 'nullable|date',
            'vencimento_teste_fumaca' => 'nullable|date',
            'vencimento_cronotacografo' => 'nullable|date',
            'vencimento_opentech_minerva' => 'nullable|date',
            'vencimento_opentech_alianca' => 'nullable|date',
            'vencimento_opentech_seara' => 'nullable|date',
            'checklist_alianca' => 'nullable|date',
            'checklist_minerva' => 'nullable|date',
            'id_rastreador' => 'required|string|max:8',
            'tecnologia' => 'required|string|max:10',
            'tipo_pedagio' => 'required|string|max:6',
            'id_pedagio' => 'required|string|max:15',
            'grupo' => 'required|string|max:15',
            'status' => 'required|string|max:7',
            'motivo_desligamento' => 'nullable|string|max:100',
            'login_tecnologia' => 'nullable|string|max:45',
            'senha_tecnologia' => 'nullable|string|max:25',
            'certificado_cronotacografo' => 'nullable|string|max:15',
            'brasil_risk_klabin' => 'nullable|date',
            'conta_bancaria' => 'nullable|string|max:10',
            'tipo_conta' => 'nullable|string|max:2',
            'titularidade' => 'nullable|string|max:2',
            'agencia' => 'nullable|string|max:10',
            'codigo_banco' => 'nullable|string|max:10',
            'nome_banco' => 'nullable|string|max:10',
            'pix' => 'nullable|string|max:15',
            'chave_pix' => 'nullable|string|max:100',
        ]);



        try {
            $path_rntrc = $this->uploadController->uploadCavalo($request, 'doc_rntrc', 'rntrc', '.pdf');
            $path_teste_fumaca = $this->uploadController->uploadCavalo($request, 'doc_teste_fumaca', 'teste-fumaca', '.pdf');
            $path_foto_cavalo = $this->uploadController->uploadCavalo($request, 'doc_foto_cavalo', 'foto-cavalo', '.jpeg');
            $path_crlv = $this->uploadController->uploadCarreta($request, 'doc_crlv', 'crlv', '.pdf');

            DB::beginTransaction();
            $endereco = Endereco::findOrFail($request->input('id_endereco_crlv'));
            $endereco->setCidadeAttribute($request->input('cidade'));
            $endereco->setUfAttribute($request->input('uf'));
            $endereco->save();

            $conta_bancaria = ContaBancaria::findOrFail($request->input('id_conta_bancaria'));
            $conta_bancaria->setNumeroContaBancariaAttribute($request->input('numero_conta_bancaria'));
            $conta_bancaria->setTipoContaAttribute($request->input('tipo_conta'));
            $conta_bancaria->setTitularidadeAttribute($request->input('titularidade'));
            $conta_bancaria->setAgenciaAttribute($request->input('agencia'));
            $conta_bancaria->setCodigoBancoAttribute($request->input('codigo_banco'));
            $conta_bancaria->setNomeBancoAttribute($request->input('nome_banco'));
            $conta_bancaria->setPixAttribute($request->input('pix'));
            $conta_bancaria->setChavePixAttribute($request->input('chave_pix'));
            $conta_bancaria->save();

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
            $crlv->setPathCrlvAttribute($path_crlv);
            $crlv->save();

            $cavalo = Cavalo::findOrFail($request->input('id_cavalo'));
            $cavalo->setPlacaAttribute($request->input('placa'));
            $cavalo->setRntrcAttribute($request->input('rntrc'));
            $cavalo->setIdTransportadoraAttribute($request->input('id_transportadora'));
            $cavalo->setVencimentoTesteFumacaAttribute($request->input('vencimento_teste_fumaca'));
            $cavalo->setVencimentoCronotacografoAttribute($request->input('vencimento_cronotacografo'));
            $cavalo->setVencimentoOpentechMinervaAttribute($request->input('vencimento_opentech_minerva'));
            $cavalo->setVencimentoOpentechAliancaAttribute($request->input('vencimento_opentech_alianca'));
            $cavalo->setVencimentoOpentechSearaAttribute($request->input('vencimento_opentech_seara'));
            $cavalo->setChecklistAliancaAttribute($request->input('checklist_alianca'));
            $cavalo->setChecklistMinervaAttribute($request->input('checklist_minerva'));
            $cavalo->setIdRastreadorAttribute($request->input('id_rastreador'));
            $cavalo->setTecnologiaAttribute($request->input('tecnologia'));
            $cavalo->setTelemetriaAttribute($request->input('telemetria'));
            $cavalo->setTipoPedagioAttribute($request->input('tipo_pedagio'));
            $cavalo->setIdPedagioAttribute($request->input('id_pedagio'));
            $cavalo->setGrupoAttribute($request->input('grupo'));
            $cavalo->setStatusAttribute($request->input('status'));
            $cavalo->setMotivoDesligamentoAttribute($request->input('motivo_desligamento'));
            $cavalo->setLoginTecnologiaAttribute($request->input('login_tecnologia'));
            $cavalo->setSenhaTecnologiaAttribute($request->input('senha_tecnologia'));
            $cavalo->setCertificadoCronotacografoAttribute($request->input('certificado_cronotacografo'));
            $cavalo->setBrasilRiskKlabinAttribute($request->input('brasil_risk_klabin'));
            $cavalo->setPathRntrcAttribute($path_rntrc);
            $cavalo->setPathTesteFumacaAttribute($path_teste_fumaca);
            $cavalo->setPathFotoCavaloAttribute($path_foto_cavalo);
            $cavalo->save();

            DB::commit();


            return ('success');
        } catch (QueryException $e) {

            $errorReason = $e->errorInfo[2];

            DB::rollback();
            \dd($e);

            return $errorReason;
        }
    }

    public function chamarIndex()
    {
        $transportadoras = $this->transportadoraController->index();
        $uf = $this->apiIbgeController->consultarEstados();
        $title = 'Formulário Cavalo';
        return view('cadastro.Formularios.formulario-cavalo', compact('transportadoras', 'uf', 'title'));
    }
}
