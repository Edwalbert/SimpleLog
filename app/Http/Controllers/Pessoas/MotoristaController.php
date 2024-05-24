<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Empresas\TransportadoraController;
use App\Http\Controllers\Util\ApiIbgeController;
use App\Http\Controllers\Veiculos\CavaloController;
use App\Models\util\Endereco;
use App\Http\Controllers\Util\UploadController;
use App\Models\pessoas\Motorista;
use App\Models\util\Contato;
use App\Repositories\Pessoas\MotoristaRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class MotoristaController extends Controller
{
    private $cavaloController;
    private $uploadController;
    private $transportadoraController;
    private $apiIbgeController;
    private $motoristaRepository;

    public function __construct(
        CavaloController $cavaloController,
        UploadController $uploadController,
        TransportadoraController $transportadoraController,
        ApiIbgeController $apiIbgeController,
        MotoristaRepository $motoristaRepository
    ) {
        $this->cavaloController = $cavaloController;
        $this->uploadController = $uploadController;
        $this->transportadoraController = $transportadoraController;
        $this->apiIbgeController = $apiIbgeController;
        $this->motoristaRepository = $motoristaRepository;
    }

    public function index()
    {
        $motoristas = $this->motoristaRepository->index();
        return $motoristas;
    }

    public function storeOrUpdate(Request $request)
    {
        if ($request->input('id_motorista') !== null) {
            $resultado = $this->update($request);
            if ($resultado == 'success') {
                return redirect('cadastro-motorista')->with('success', 'Motorista atualizado com sucesso!');
            } else {
                return redirect('cadastro-motorista')->with('error', 'Erro! ' . $resultado);
            }
        } else {
            $resultado = $this->store($request);
            if ($resultado == 'success') {
                return redirect('cadastro-motorista')->with('success', 'Motorista cadatrado com sucesso!');
            } else {
                return redirect('cadastro-motorista')->with('error', 'Erro! ' . $resultado);
            }
        }
        return redirect('cadastro-motorista');
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'nome' => 'nullable|string|max:45',
            'cpf' => 'nullable|string|max:11',
            'numero_rg' => 'nullable|string|max:11',
            'nome_pai' => 'nullable|string|max:45',
            'nome_mae' => 'nullable|string|max:45',
            'municipio_nascimento' => 'nullable|string|max:45',
            'uf_nascimento' => 'nullable|string|max:2',
            'data_nascimento' => 'nullable|date',
            'id_cavalo' => 'nullable|integer|exists:cavalos,id',
            'id_transportadora' => 'nullable|integer|exists:transportadoras,id',
            'codigo_senior' => 'nullable|string|max:6',
            'integracao_cotramol' => 'nullable|date',
            'registro_cnh' => 'nullable|string|max:11',
            'espelho_cnh' => 'nullable|string|max:10',
            'emissao_cnh' => 'nullable|date',
            'vencimento_cnh' => 'nullable|date',
            'primeira_cnh' => 'nullable|date',
            'renach' => 'nullable|numeric',
            'categoria_cnh' => 'nullable|string|max:3',
            'admissao' => 'nullable|date',
            'vencimento_aso' => 'nullable|date',
            'vencimento_tox' => 'nullable|date',
            'vencimento_dd' => 'nullable|date',
            'ear' => 'nullable|string|max:5',
            'vencimento_opentech_brf' => 'nullable|date',
            'vencimento_opentech_alianca' => 'nullable|date',
            'vencimento_opentech_minerva' => 'nullable|date',
            'vencimento_opentech_seara' => 'nullable|date',
            'brasil_risk_klabin' => 'nullable|date',
            'telefone' => 'nullable|string|max:11',
            'contato_pessoal_1' => 'nullable|numeric',
            'contato_pessoal_1_nome' => 'nullable|string|max:45',
            'contato_pessoal_1_parentesco' => 'nullable|string|max:45',
            'contato_pessoal_2' => 'nullable|numeric',
            'contato_pessoal_2_nome' => 'nullable|string|max:45',
            'contato_pessoal_2_parentesco' => 'nullable|string|max:45',
            'contato_pessoal_3' => 'nullable|numeric',
            'contato_pessoal_3_nome' => 'nullable|string|max:45',
            'contato_pessoal_3_parentesco' => 'nullable|string|max:45',
            'status' => 'nullable|string|max:7',
            'motivo_desligamento' => 'nullable|string|max:100',
            'obs_desligamento' => 'nullable|string|max:200',
        ]);

        try {
            DB::beginTransaction();

            $local_residencia = new Endereco();
            $local_residencia->setCepAttribute($request->input('cep'));
            $local_residencia->setRuaAttribute($request->input('rua'));
            $local_residencia->setNumeroAttribute($request->input('numero'));
            $local_residencia->setBairroAttribute($request->input('bairro'));
            $local_residencia->setCidadeAttribute($request->input('cidade'));
            $local_residencia->setUfAttribute($request->input('uf'));
            $local_residencia->save();
            $id_local_residencia = $local_residencia->id;

            $contato_pessoal_1 = new Contato();
            $contato_pessoal_1->setNomeAttribute($request->input('contato_pessoal_1_nome'));
            $contato_pessoal_1->setTelefone1Attribute($request->input('contato_pessoal_1'));
            $contato_pessoal_1->save();
            $id_contato_pessoal_1 = $contato_pessoal_1->id;

            $contato_pessoal_2 = new Contato();
            $contato_pessoal_2->setNomeAttribute($request->input('contato_pessoal_2_nome'));
            $contato_pessoal_2->setTelefone1Attribute($request->input('contato_pessoal_2'));
            $contato_pessoal_2->save();
            $id_contato_pessoal_2 = $contato_pessoal_2->id;

            $contato_pessoal_3 = new Contato();
            $contato_pessoal_3->setNomeAttribute($request->input('contato_pessoal_3_nome'));
            $contato_pessoal_3->setTelefone1Attribute($request->input('contato_pessoal_3'));
            $contato_pessoal_3->save();
            $id_contato_pessoal_3 = $contato_pessoal_3->id;

            $motorista = new Motorista();
            $motorista->setNomeAttribute($request->input('nome'));
            $motorista->setIntegracaoCotramolAttribute($request->input('integracao_cotramol'));
            $motorista->setAdmissaoAttribute($request->input('admissao'));
            $motorista->setVencimentoAsoAttribute($request->input('vencimento_aso'));
            $motorista->setVencimentoToxAttribute($request->input('vencimento_tox'));
            $motorista->setVencimentoTddAttribute($request->input('vencimento_tdd'));
            $motorista->setVencimentoOpentechBrfAttribute($request->input('vencimento_opentech_brf'));
            $motorista->setCodigoSeniorAttribute($request->input('codigo_senior'));
            $motorista->setVencimentoOpentechAliancaAttribute($request->input('vencimento_opentech_alianca'));
            $motorista->setVencimentoOpentechMinervaAttribute($request->input('vencimento_opentech_minerva'));
            $motorista->setVencimentoOpentechSearaAttribute($request->input('vencimento_opentech_seara'));
            $motorista->setBrasilRiskKlabinAttribute($request->input('brasil_risk_klabin'));
            $motorista->setStatusAttribute($request->input('status'));
            $motorista->setRescisaoAttribute($request->input('rescisao'));
            $motorista->setMotivoDesligamentoAttribute($request->input('motivo_desligamento'));
            $motorista->setObsDesligamentoAttribute($request->input('obs_desligamento'));
            $motorista->setRegistroCnhAttribute($request->input('registro_cnh'));
            $motorista->setEspelhoCnhAttribute($request->input('espelho_cnh'));
            $motorista->setEmissaoCnhAttribute($request->input('emissao_cnh'));
            $motorista->setVencimentoCnhAttribute($request->input('vencimento_cnh'));
            $motorista->setPrimeiraCnhAttribute($request->input('primeira_cnh'));
            $motorista->setMunicipioCnhAttribute($request->input('municipio_cnh'));
            $motorista->setUfCnhAttribute($request->input('uf_cnh'));
            $motorista->setRenachAttribute($request->input('renach'));
            $motorista->setCategoriaCnhAttribute($request->input('categoria_cnh'));
            $motorista->setEarAttribute($request->input('ear'));
            $motorista->setNumeroRgAttribute($request->input('numero_rg'));
            $motorista->setCpfAttribute($request->input('cpf'));
            $motorista->setTelefoneAttribute($request->input('telefone'));
            $motorista->setNomePaiAttribute($request->input('nome_pai'));
            $motorista->setNomeMaeAttribute($request->input('nome_mae'));
            $motorista->setDataNascimentoAttribute($request->input('data_nascimento'));
            $motorista->setMunicipioNascimentoAttribute($request->input('municipio_nascimento'));
            $motorista->setUfNascimentoAttribute($request->input('uf_nascimento'));
            $motorista->setIdCavaloAttribute($request->input('vincular_cavalo'));
            $motorista->setIdLocalResidencia($id_local_residencia);
            $motorista->setIdTransportadoraAttribute($request->input('id_transportadora'));
            $motorista->setIdContatoPessoal1Attribute($id_contato_pessoal_1);
            $motorista->setContatoPessoal1ParentescoAttribute($request->input('contato_pessoal_1_parentesco'));
            $motorista->setIdContatoPessoal2Attribute($id_contato_pessoal_2);
            $motorista->setContatoPessoal2ParentescoAttribute($request->input('contato_pessoal_2_parentesco'));
            $motorista->setIdContatoPessoal3Attribute($id_contato_pessoal_3);
            $motorista->setContatoPessoal3ParentescoAttribute($request->input('contato_pessoal_3_parentesco'));
            $motorista->setIdTransportadoraAttribute($request->input('id_transportadora'));

            //Upload dos documentos
            $motorista->setPathCnhAttribute($this->uploadController->uploadMotorista($request, 'doc_cnh', 'cnh', '.pdf'));
            $motorista->setPathFotoMotoristaAttribute($this->uploadController->uploadMotorista($request, 'foto_motorista', 'foto-motorista', '.jpeg'));
            $motorista->setPathFichaRegistroAttribute($this->uploadController->uploadMotorista($request, 'doc_ficha_registro', 'ficha-registro', '.pdf'));
            $motorista->setPathAsoAttribute($this->uploadController->uploadMotorista($request, 'doc_aso', 'aso', '.pdf'));
            $motorista->setPathToxAttribute($this->uploadController->uploadMotorista($request, 'doc_tox', 'tox', '.pdf'));
            $motorista->setPathTddAttribute($this->uploadController->uploadMotorista($request, 'doc_tdd', 'tdd', '.pdf'));
            $motorista->setPathIntegracaoBrfAttribute($this->uploadController->uploadMotorista($request, 'doc_integracao_brf', 'integracao-brf', '.pdf'));
            $motorista->setPathComprovanteResidenciaAttribute($this->uploadController->uploadMotorista($request, 'doc_comprovante_residencia', 'comprovante-residencia', '.pdf'));
            $motorista->setPathTreinamentoAntiTombamentoAttribute($this->uploadController->uploadMotorista($request, 'doc_treinamento_anti_tombamento', 'treinamento-anti-tombamento', '.pdf'));
            $motorista->setPathTreinamento3psAttribute($this->uploadController->uploadMotorista($request, 'doc_treinamento_3ps', 'treinamento-3ps', '.pdf'));

            $motorista->setStatusAttribute('Ativo');
            $motorista->save();

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
        $id_motorista = $request->input('id_motorista');

        $validatedData = Validator::make($request->all(), [
            'nome' => 'nullable|string|max:45',
            'numero_rg' => 'nullable|string|max:11',
            'nome_pai' => 'nullable|string|max:45',
            'nome_mae' => 'nullable|string|max:45',
            'municipio_nascimento' => 'nullable|string|max:45',
            'uf_nascimento' => 'nullable|string|max:2',
            'data_nascimento' => 'nullable|date',
            'id_cavalo' => 'nullable|integer|exists:cavalos,id',
            'id_transportadora' => 'nullable|integer|exists:transportadoras,id',
            'codigo_senior' => 'nullable|string|max:6',
            'integracao_cotramol' => 'nullable|date',
            'registro_cnh' => 'nullable|string|max:11',
            'espelho_cnh' => 'nullable|string|max:10',
            'emissao_cnh' => 'nullable|date',
            'vencimento_cnh' => 'nullable|date',
            'primeira_cnh' => 'nullable|date',
            'renach' => 'nullable|numeric',
            'categoria_cnh' => 'nullable|string|max:3',
            'admissao' => 'nullable|date',
            'vencimento_aso' => 'nullable|date',
            'vencimento_tox' => 'nullable|date',
            'vencimento_dd' => 'nullable|date',
            'ear' => 'nullable|string|max:5',
            'vencimento_opentech_brf' => 'nullable|date',
            'vencimento_opentech_alianca' => 'nullable|date',
            'vencimento_opentech_minerva' => 'nullable|date',
            'vencimento_opentech_seara' => 'nullable|date',
            'brasil_risk_klabin' => 'nullable|date',
            'telefone' => 'nullable|string|max:11',
            'contato_pessoal_1' => 'nullable|numeric',
            'contato_pessoal_1_nome' => 'nullable|string|max:45',
            'contato_pessoal_1_parentesco' => 'nullable|string|max:45',
            'contato_pessoal_2' => 'nullable|numeric',
            'contato_pessoal_2_nome' => 'nullable|string|max:45',
            'contato_pessoal_2_parentesco' => 'nullable|string|max:45',
            'contato_pessoal_3' => 'nullable|numeric',
            'contato_pessoal_3_nome' => 'nullable|string|max:45',
            'contato_pessoal_3_parentesco' => 'nullable|string|max:45',
            'status' => 'nullable|string|max:7',
            'motivo_desligamento' => 'nullable|string|max:100',
            'obs_desligamento' => 'nullable|string|max:200',
        ]);

        try {
            DB::beginTransaction();

            $motorista = Motorista::findOrFail($id_motorista);
            $cpf = $request->input('cpf');
            $motorista->setNomeAttribute($request->input('nome'));
            $motorista->setIntegracaoCotramolAttribute($request->input('integracao_cotramol'));
            $motorista->setAdmissaoAttribute($request->input('admissao'));
            $motorista->setVencimentoAsoAttribute($request->input('vencimento_aso'));
            $motorista->setVencimentoToxAttribute($request->input('vencimento_tox'));
            $motorista->setVencimentoTddAttribute($request->input('vencimento_tdd'));
            $motorista->setVencimentoOpentechBrfAttribute($request->input('vencimento_opentech_brf'));
            $motorista->setCodigoSeniorAttribute($request->input('codigo_senior'));
            $motorista->setVencimentoOpentechAliancaAttribute($request->input('vencimento_opentech_alianca'));
            $motorista->setVencimentoOpentechMinervaAttribute($request->input('vencimento_opentech_minerva'));
            $motorista->setVencimentoOpentechSearaAttribute($request->input('vencimento_opentech_seara'));
            $motorista->setBrasilRiskKlabinAttribute($request->input('brasil_risk_klabin'));
            $motorista->setStatusAttribute($request->input('status'));
            $motorista->setRescisaoAttribute($request->input('rescisao'));
            $motorista->setMotivoDesligamentoAttribute($request->input('motivo_desligamento'));
            $motorista->setObsDesligamentoAttribute($request->input('obs_desligamento'));
            $motorista->setRegistroCnhAttribute($request->input('registro_cnh'));
            $motorista->setEspelhoCnhAttribute($request->input('espelho_cnh'));
            $motorista->setEmissaoCnhAttribute($request->input('emissao_cnh'));
            $motorista->setVencimentoCnhAttribute($request->input('vencimento_cnh'));
            $motorista->setPrimeiraCnhAttribute($request->input('primeira_cnh'));
            $motorista->setMunicipioCnhAttribute($request->input('municipio_cnh'));
            $motorista->setUfCnhAttribute($request->input('uf_cnh'));
            $motorista->setRenachAttribute($request->input('renach'));
            $motorista->setCategoriaCnhAttribute($request->input('categoria_cnh'));
            $motorista->setEarAttribute($request->input('ear'));
            $motorista->setNumeroRgAttribute($request->input('numero_rg'));
            $motorista->setTelefoneAttribute($request->input('telefone'));
            $motorista->setNomePaiAttribute($request->input('nome_pai'));
            $motorista->setNomeMaeAttribute($request->input('nome_mae'));
            $motorista->setDataNascimentoAttribute($request->input('data_nascimento'));
            $motorista->setMunicipioNascimentoAttribute($request->input('municipio_nascimento'));
            $motorista->setUfNascimentoAttribute($request->input('uf_nascimento'));
            $motorista->setIdCavaloAttribute($request->input('vincular_cavalo'));
            $motorista->setIdLocalResidencia($request->input('id_local_residencia'));
            $motorista->setIdTransportadoraAttribute($request->input('id_transportadora'));
            $motorista->setIdContatoPessoal1Attribute($request->input('id_contato_pessoal_1'));
            $motorista->setContatoPessoal1ParentescoAttribute($request->input('contato_pessoal_1_parentesco'));
            $motorista->setIdContatoPessoal2Attribute($request->input('id_contato_pessoal_2'));
            $motorista->setContatoPessoal2ParentescoAttribute($request->input('contato_pessoal_2_parentesco'));
            $motorista->setIdContatoPessoal3Attribute($request->input('id_contato_pessoal_3'));
            $motorista->setContatoPessoal3ParentescoAttribute($request->input('contato_pessoal_3_parentesco'));
            $motorista->setIdTransportadoraAttribute($request->input('id_transportadora'));
            $motorista->setStatusAttribute($request->input('status'));


            //Upload dos documentos

            $motorista->setPathCnhAttribute($this->uploadController->uploadMotorista($request, 'doc_cnh', 'cnh', '.pdf'));
            $motorista->setPathFotoMotoristaAttribute($this->uploadController->uploadMotorista($request, 'foto_motorista', 'foto-motorista', '.jpeg'));
            $motorista->setPathFichaRegistroAttribute($this->uploadController->uploadMotorista($request, 'doc_ficha_registro', 'ficha-registro', '.pdf'));
            $motorista->setPathAsoAttribute($this->uploadController->uploadMotorista($request, 'doc_aso', 'aso', '.pdf'));
            $motorista->setPathToxAttribute($this->uploadController->uploadMotorista($request, 'doc_tox', 'tox', '.pdf'));
            $motorista->setPathTddAttribute($this->uploadController->uploadMotorista($request, 'doc_tdd', 'tdd', '.pdf'));
            $motorista->setPathIntegracaoBrfAttribute($this->uploadController->uploadMotorista($request, 'doc_integracao_brf', 'integracao-brf', '.pdf'));
            $motorista->setPathComprovanteResidenciaAttribute($this->uploadController->uploadMotorista($request, 'doc_comprovante_residencia', 'comprovante-residencia', '.pdf'));
            $motorista->setPathTreinamentoAntiTombamentoAttribute($this->uploadController->uploadMotorista($request, 'doc_treinamento_anti_tombamento', 'treinamento-anti-tombamento', '.pdf'));
            $motorista->setPathTreinamento3psAttribute($this->uploadController->uploadMotorista($request, 'doc_treinamento_3ps', 'treinamento-3ps', '.pdf'));

            $motorista->save();

            $contato_pessoal_1 = Contato::findOrFail($request->input('id_contato_pessoal_1'));
            $contato_pessoal_1->setNomeAttribute($request->input('contato_pessoal_1_nome'));
            $contato_pessoal_1->setTelefone1Attribute($request->input('contato_pessoal_1'));
            $contato_pessoal_1->save();
            $id_contato_pessoal_1 = $contato_pessoal_1->id;

            $contato_pessoal_2 = Contato::findOrFail($request->input('id_contato_pessoal_2'));
            $contato_pessoal_2->setNomeAttribute($request->input('contato_pessoal_2_nome'));
            $contato_pessoal_2->setTelefone1Attribute($request->input('contato_pessoal_2'));
            $contato_pessoal_2->save();
            $id_contato_pessoal_2 = $contato_pessoal_2->id;

            $contato_pessoal_3 = Contato::findOrFail($request->input('id_contato_pessoal_3'));
            $contato_pessoal_3->setNomeAttribute($request->input('contato_pessoal_3_nome'));
            $contato_pessoal_3->setTelefone1Attribute($request->input('contato_pessoal_3'));
            $contato_pessoal_3->save();
            $id_contato_pessoal_3 = $contato_pessoal_3->id;

            $endereco = Endereco::findOrFail($request->input('id_local_residencia'));
            $endereco->setCepAttribute($request->input('cep'));
            $endereco->setRuaAttribute($request->input('rua'));
            $endereco->setNumeroAttribute($request->input('numero'));
            $endereco->setBairroAttribute($request->input('bairro'));
            $endereco->setCidadeAttribute($request->input('cidade'));
            $endereco->setUfAttribute($request->input('uf'));
            try {
                $endereco->save();
            } catch (Exception $e) {
                dd($e);
            }
            DB::commit();

            return 'success';
        } catch (QueryException $e) {
            $errorReason = $e->errorInfo[2];
            DB::rollback();
            return $errorReason;
        }

        return $this->chamarIndex();
    }

    public function chamarIndex()
    {
        $motoristas = $this->index();
        $cavalos = $this->cavaloController->index();
        $transportadoras = $this->transportadoraController->index();
        $uf = $this->apiIbgeController->consultarEstados();
        return view('cadastro.Formularios.formulario-motorista', compact('cavalos', 'transportadoras', 'uf', 'motoristas'));
    }
}
