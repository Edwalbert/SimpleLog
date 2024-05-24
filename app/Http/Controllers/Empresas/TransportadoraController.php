<?php

namespace App\Http\Controllers\Empresas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Util\UploadController;
use App\Models\empresas\Transportadora;
use App\Models\util\ContaBancaria;
use App\Models\util\Contato;
use App\Models\util\Endereco;
use App\Repositories\empresas\TransportadoraRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class TransportadoraController extends Controller
{
    private $uploadController;
    private $transportadoraRepository;

    public function __construct(UploadController $uploadController, TransportadoraRepository $transportadoraRepository)
    {
        $this->uploadController = $uploadController;
        $this->transportadoraRepository = $transportadoraRepository;
    }

    public function index()
    {
        $transportadoras = $this->transportadoraRepository->index();
        return $transportadoras;
    }

    public function storeOrUpdate(Request $request)
    {

        if ($request->input('id_transportadora') !== null) {

            $resultado = $this->update($request);

            if ($resultado == 'success') {
                return redirect('cadastro-transportadora')->with('success', 'Transportadora atualizada com sucesso!');
            } else {
                return redirect('cadastro-transportadora')->with('error', 'Erro! ' . $resultado);
            }
        } else {
            $resultado = $this->store($request);

            if ($resultado == 'success') {
                return redirect('cadastro-transportadora')->with('success', 'Transportadora cadatrada com sucesso!');
            } else {
                return redirect('cadastro-transportadora')->with('error', 'Erro! ' . $resultado);
            }
        }

        return redirect('cadastro-transportadora');
    }

    public function store(Request $request)
    {


        $validatedData = Validator::make($request->all(), [
            'cnpj' => 'required|string|max:14|unique:transportadoras',
            'razao_social' => 'required|string|max:50',
            'cep' => 'required|numeric',
            'endereco' => 'required|string|max:45',
            'numero' => 'required|numeric',
            'bairro' => 'required|string|max:45',
            'cidade' => 'required|string|max:45',
            'uf' => 'required|string|max:2',
            'inscricao_estadual' => 'required|numeric',
            'codigo_transportador' => 'required|numeric|unique:transportadoras',
            'codigo_cliente' => 'required|numeric|unique:transportadoras',
            'codigo_fornecedor' => 'required|numeric|unique:transportadoras',
            'nome_responsavel' => 'required|string|max:45',
            'email_1' => 'required|string|max:45',
            'email_2' => 'required|string|max:45',
            'telefone_1' => 'required|string|max:12',
            'telefone_2' => 'string|max:12',
            'contador' => 'required|string|max:45',
            'email_contador_1' => 'required|string|max:45',
            'email_contador_2' => 'string|max:45',
            'telefone_contador_1' => 'required|string|max:12',
            'telefone_contador_2' => 'string|max:12',
            'numero_conta' => 'nullable|string|max:10',
            'tipo_conta' => 'nullable|string|max:2',
            'titularidade' => 'nullable|string|max:2',
            'agencia' => 'nullable|string|max:10',
            'codigo_banco' => 'nullable|string|max:10',
            'nome_banco' => 'nullable|string|max:45',
            'pix' => 'nullable|string|max:15',
            'chave_pix' => 'nullable|string|max:100',
            'situacao' => 'required|string|max:8',
            'comissao' => 'required|string|max:5',
        ]);

        try {
            DB::beginTransaction();

            $endereco = new Endereco;

            $endereco->setCidadeAttribute($request->input('cidade'));
            $endereco->setUfAttribute($request->input('uf'));
            $endereco->setCepAttribute($request->input('cep'));
            $endereco->setRuaAttribute($request->input('endereco'));
            $endereco->setNumeroAttribute($request->input('numero'));
            $endereco->setBairroAttribute($request->input('bairro'));
            $endereco->save();
            $id_endereco = $endereco->id;

            $conta_bancaria = new ContaBancaria();
            $conta_bancaria->setNumeroContaBancariaAttribute($request->input('numero_conta'));
            $conta_bancaria->setTipoContaAttribute($request->input('tipo_conta'));
            $conta_bancaria->setTitularidadeAttribute($request->input('titularidade'));
            $conta_bancaria->setAgenciaAttribute($request->input('agencia'));
            $conta_bancaria->setCodigoBancoAttribute($request->input('codigo_banco'));
            $conta_bancaria->setNomeBancoAttribute($request->input('nome_banco'));
            $conta_bancaria->setPixAttribute($request->input('pix'));
            $pix = $request->input('pix');

            switch ($pix) {
                case 'CNPJ':
                    $conta_bancaria->setChavePixAttribute($request->input('cnpj'));
                    break;
                case 'Email 1':
                    $conta_bancaria->setChavePixAttribute($request->input('email_1'));
                    break;
                case 'Email 2':
                    $conta_bancaria->setChavePixAttribute($request->input('email_2'));
                    break;
                case 'Tel 1':
                    $conta_bancaria->setChavePixAttribute($request->input('telefone_1'));
                    break;
                case 'Tel 2':
                    $conta_bancaria->setChavePixAttribute($request->input('telefone_2'));
                    break;
            }

            $conta_bancaria->save();
            $id_conta_bancaria = $conta_bancaria->id;

            $responsavel = new Contato();
            $responsavel->setNomeAttribute($request->input('nome_responsavel'));
            $responsavel->setEmail1Attribute($request->input('email_1'));
            $responsavel->setEmail2Attribute($request->input('email_2'));
            $responsavel->setTelefone1Attribute($request->input('telefone_1'));
            $responsavel->setTelefone2Attribute($request->input('telefone_2'));
            $responsavel->save();
            $id_responsavel = $responsavel->id;

            $contador = new Contato();
            $contador->setNomeAttribute($request->input('contador'));
            $contador->setEmail1Attribute($request->input('email_contador_1'));
            $contador->setEmail2Attribute($request->input('email_contador_2'));
            $contador->setTelefone1Attribute($request->input('telefone_contador_1'));
            $contador->setTelefone2Attribute($request->input('telefone_contador_2'));
            $contador->save();
            $id_contador = $contador->id;

            $transportadora = new Transportadora();
            $transportadora->setCnpjAttribute($request->input('cnpj'));
            $transportadora->setPathCnpjAttribute($this->uploadController->uploadTransportadora($request, 'doc_cnpj', 'cnpj', '.pdf'));
            $transportadora->setRazaoSocialAttribute($request->input('razao_social'));
            $transportadora->setInscricaoEstadualAttribute($request->input('inscricao_estadual'));
            $transportadora->setCodigoTransportadoraAttribute($request->input('codigo_transportadora'));
            $transportadora->setCodigoClienteAttribute($request->input('codigo_cliente'));
            $transportadora->setCodigoFornecedorAttribute($request->input('codigo_fornecedor'));
            $transportadora->setRntrcAttribute($request->input('rntrc'));
            $transportadora->setPathRntrcAttribute($this->uploadController->uploadTransportadora($request, 'doc_rntrc', 'rntrc', '.pdf'));
            $transportadora->setSituacaoAttribute($request->input('situacao'));
            $transportadora->setComissaoAttribute($request->input('comissao'));
            $transportadora->setIdResponsavelAttribute($id_responsavel);
            $transportadora->setIdContadorAttribute($id_contador);
            $transportadora->setIdContaBancariaAttribute($id_conta_bancaria);
            $transportadora->setIdEnderecoAttribute($id_endereco);
            $transportadora->setStatusAttribute('Ativo');
            $transportadora->setMotivoDesligamentoAttribute($request->input('motivo_desligamento'));
            $transportadora->save();
            $id_transportadora = $transportadora->id;

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
            'cnpj' => 'required|string|max:14|unique:transportadoras',
            'razao_social' => 'required|string|max:50',
            'cep' => 'required|numeric',
            'endereco' => 'required|string|max:45',
            'numero' => 'required|numeric',
            'bairro' => 'required|string|max:45',
            'cidade' => 'required|string|max:45',
            'uf' => 'required|string|max:2',
            'inscricao_estadual' => 'required|numeric',
            'codigo_transportador' => 'required|numeric|unique:transportadoras',
            'codigo_cliente' => 'required|numeric|unique:transportadoras',
            'codigo_fornecedor' => 'required|numeric|unique:transportadoras',
            'nome_responsavel' => 'required|string|max:45',
            'email_1' => 'required|string|max:45',
            'email_2' => 'required|string|max:45',
            'telefone_1' => 'required|string|max:12',
            'telefone_2' => 'string|max:12',
            'contador' => 'required|string|max:45',
            'email_contador_1' => 'required|string|max:45',
            'email_contador_2' => 'string|max:45',
            'telefone_contador_1' => 'required|string|max:12',
            'telefone_contador_2' => 'string|max:12',
            'numero_conta' => 'nullable|string|max:10',
            'tipo_conta' => 'nullable|string|max:2',
            'titularidade' => 'nullable|string|max:2',
            'agencia' => 'nullable|string|max:10',
            'codigo_banco' => 'nullable|string|max:10',
            'nome_banco' => 'nullable|string|max:45',
            'pix' => 'nullable|string|max:15',
            'situacao' => 'required|string|max:8',
            'comissao' => 'required|string|max:5',
        ]);

        try {
            DB::beginTransaction();
            $endereco = Endereco::findOrFail($request->input('id_endereco'));
            $endereco->setCidadeAttribute($request->input('cidade'));
            $endereco->setUfAttribute($request->input('uf'));
            $endereco->setCepAttribute($request->input('cep'));
            $endereco->setRuaAttribute($request->input('endereco'));
            $endereco->setNumeroAttribute($request->input('numero'));
            $endereco->setBairroAttribute($request->input('bairro'));
            $endereco->save();

            $conta_bancaria = ContaBancaria::findOrFail($request->input('id_conta_bancaria'));
            $conta_bancaria->setNumeroContaBancariaAttribute($request->input('numero_conta'));
            $conta_bancaria->setTipoContaAttribute($request->input('tipo_conta'));
            $conta_bancaria->setTitularidadeAttribute($request->input('titularidade'));
            $conta_bancaria->setAgenciaAttribute($request->input('agencia'));
            $conta_bancaria->setCodigoBancoAttribute($request->input('codigo_banco'));
            $conta_bancaria->setNomeBancoAttribute($request->input('nome_banco'));
            $conta_bancaria->setPixAttribute($request->input('pix'));

            $pix = $request->input('pix');

            switch ($pix) {
                case 'CNPJ':
                    $conta_bancaria->setChavePixAttribute($request->input('cnpj'));

                    break;
                case 'Email 1':
                    $conta_bancaria->setChavePixAttribute($request->input('email_1'));
                    break;
                case 'Email 2':
                    $conta_bancaria->setChavePixAttribute($request->input('email_2'));
                    break;
                case 'Tel 1':
                    $conta_bancaria->setChavePixAttribute($request->input('telefone_1'));
                    break;
                case 'Tel 2':
                    $conta_bancaria->setChavePixAttribute($request->input('telefone_2'));
                    break;
            }

            $conta_bancaria->save();

            $responsavel = Contato::findOrFail($request->input('id_responsavel'));
            $responsavel->setNomeAttribute($request->input('nome_responsavel'));
            $responsavel->setEmail1Attribute($request->input('email_1'));
            $responsavel->setEmail2Attribute($request->input('email_2'));
            $responsavel->setTelefone1Attribute($request->input('telefone_1'));
            $responsavel->setTelefone2Attribute($request->input('telefone_2'));
            $responsavel->save();

            $contador = Contato::findOrFail($request->input('id_contador'));
            $contador->setNomeAttribute($request->input('contador'));
            $contador->setEmail1Attribute($request->input('email_contador_1'));
            $contador->setEmail2Attribute($request->input('email_contador_2'));
            $contador->setTelefone1Attribute($request->input('telefone_contador_1'));
            $contador->setTelefone2Attribute($request->input('telefone_contador_2'));
            $contador->save();

            $transportadora = Transportadora::findOrFail($request->input('id_transportadora'));
            $transportadora->setCnpjAttribute($request->input('cnpj'));
            $transportadora->setPathCnpjAttribute($this->uploadController->uploadTransportadora($request, 'doc_cnpj', 'cnpj', '.pdf'));
            $transportadora->setRazaoSocialAttribute($request->input('razao_social'));
            $transportadora->setInscricaoEstadualAttribute($request->input('inscricao_estadual'));
            $transportadora->setCodigoTransportadoraAttribute($request->input('codigo_transportadora'));
            $transportadora->setCodigoClienteAttribute($request->input('codigo_cliente'));
            $transportadora->setCodigoFornecedorAttribute($request->input('codigo_fornecedor'));
            $transportadora->setRntrcAttribute($request->input('rntrc'));
            $transportadora->setPathRntrcAttribute($this->uploadController->uploadTransportadora($request, 'doc_rntrc', 'rntrc', '.pdf'));
            $transportadora->setSituacaoAttribute($request->input('situacao'));
            $transportadora->setComissaoAttribute($request->input('comissao'));
            $transportadora->setStatusAttribute('Ativo');
            $transportadora->setMotivoDesligamentoAttribute($request->input('motivo_desligamento'));
            $transportadora->save();

            DB::commit();

            return 'success';
        } catch (QueryException $e) {
            $errorReason = $e->errorInfo[2];
            DB::rollback();
            return $errorReason;
        }
    }

    public function destroy(Transportadora $transportadora)
    {
        //
    }
}
