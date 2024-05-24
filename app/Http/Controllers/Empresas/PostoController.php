<?php

namespace App\Http\Controllers\Empresas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Util\ApiIbgeController;
use App\Models\empresas\Posto;
use App\Models\util\Contato;
use App\Models\util\Endereco;
use App\Repositories\empresas\PostoRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostoController extends Controller
{
    private $apiIbgeController;
    private $postoRepository;

    public function __construct(
        ApiIbgeController $apiIbgeController,
        PostoRepository $postoRepository,
    ) {
        $this->apiIbgeController = $apiIbgeController;
        $this->postoRepository = $postoRepository;
    }

    public function storeOrUpdate(Request $request)
    {
        if ($request->input('id_posto') !== null) {
            $resultado = $this->update($request);
        } else {
            $resultado = $this->store($request);
        }

        $redirectRoute = 'cadastro-postos';
        $successMessage = 'Posto ';
        $errorMessage = 'Erro! ';

        if ($resultado === 'success') {
            return redirect($redirectRoute)->with('success', $successMessage . 'atualizado com sucesso!');
        } else {
            return redirect($redirectRoute)->with('error', $errorMessage . $resultado);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $contato = new Contato();
            $contato->setTelefone1Attribute($request->input('telefone_1'));
            $contato->setTelefone2Attribute($request->input('telefone_2'));
            $contato->setTelefone3Attribute($request->input('telefone_3'));
            $contato->setTelefone4Attribute($request->input('telefone_4'));
            $contato->setEmail1Attribute($request->input('email_1'));
            $contato->setEmail2Attribute($request->input('email_2'));
            $contato->setEmail3Attribute($request->input('email_3'));
            $contato->setEmail4Attribute($request->input('email_4'));
            $contato->save();
            $id_contato = $contato->id;

            $endereco = new Endereco();
            $endereco->setCepAttribute($request->input('cep'));
            $endereco->setRuaAttribute($request->input('rua'));
            $endereco->setBairroAttribute($request->input('bairro'));
            $endereco->setUfAttribute($request->input('uf'));
            $endereco->setCidadeAttribute($request->input('cidade'));
            $endereco->setNumeroAttribute($request->input('numero'));
            $endereco->setComplementoAttribute($request->input('complemento'));
            $endereco->save();
            $id_endereco = $endereco->id;

            $posto = new Posto();
            $posto->setNomePostoAttribute($request->input('nome'));
            $posto->setRedeAttribute($request->input('rede'));
            $posto->setIdContatoAttribute($id_contato);
            $posto->setIdEnderecoAttribute($id_endereco);
            $posto->save();

            DB::commit();
        } catch (QueryException $e) {

            $errorReason = $e->errorInfo[2];

            DB::rollback();

            return response()->json(['error' => 'Erro ao salvar os dados ' . $errorReason], 500);
        }
    }




    public function update(Request $request)
    {
    }

    public function index()
    {
        $postos = $this->postoRepository->index();
        return $postos;
    }

    public function chamarIndex()
    {
        $uf = $this->apiIbgeController->consultarEstados();
        $title = 'Solicitar Adiantamento';
        return view('cadastro.Formularios.formulario-postos', compact('uf', 'title'));
    }

    public function consultaPostos(Request $request)
    {
        $filtro = $request->input('pesquisar');
        $postos = $this->postoRepository->consultaGeralPosto($filtro);
        return view('administrativo.Consultas.consulta-postos', compact('postos'));
    }
}
