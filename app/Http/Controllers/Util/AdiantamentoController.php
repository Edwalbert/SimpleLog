<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Empresas\PostoController;
use App\Http\Controllers\Veiculos\CavaloController;
use App\Models\empresas\Posto;
use App\Models\empresas\Transportadora;
use App\Models\User;
use App\Models\util\Adiantamento;
use App\Models\util\Banco;
use App\Models\util\ContaBancaria;
use App\Models\util\Contato;
use App\Models\veiculos\Cavalo;
use App\Repositories\Util\AdiantamentoRepository;
use App\Services\TrataDadosService;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Break_;

class AdiantamentoController extends Controller
{
    private $cavaloController;
    private $apiIbgeController;
    private $postoController;
    private $consultaController;
    private  $rotaController;

    public function __construct(
        CavaloController $cavaloController,
        ApiIbgeController $apiIbgeController,
        PostoController $postoController,
        ConsultaController $consultaController,
        RotaController $rotaController
    ) {
        $this->cavaloController = $cavaloController;
        $this->apiIbgeController = $apiIbgeController;
        $this->postoController = $postoController;
        $this->consultaController = $consultaController;
        $this->rotaController = $rotaController;
    }

    public function storeOrUpdate(Request $request)
    {
        $status = $request->input('status');
        if ($status == 'Criado') {

            if ($request->input('id_adiantamento') !== null) {
                $this->update($request);
                return 'success';
            } else {
                $this->store($request);
                return 'success';
            }
        } else {
            return redirect()->back()->with('error', 'Impossível editar. Status: ' . $status);
        }
    }

    public function store(Request $request, $codigo_autorizacao = null, $status = null)
    {

        try {
            DB::beginTransaction();
            $rota = $request->input('local_coleta') . '/' . $request->input('local_carregamento') . '/' . $request->input('local_entrega');
            $id_cavalo = $request->input('id_cavalo');
            $result = Cavalo::with('motoristas', 'transportadoras')->where('cavalos.id', '=', "$id_cavalo")->get();
            $id_motorista = $result[0]->motoristas[0]->id;
            $id_transportadora = $result[0]->transportadoras->id;
            $adiantamento = new Adiantamento();

            if (auth()->check()) {
                $id_user = auth()->user()->id;
                $adiantamento->setIdUserAttribute($id_user);
            }

            $adiantamento->setIdCavaloAttribute($request->input('id_cavalo'));
            $adiantamento->setIdPostoAttribute($request->input('id_posto'));
            $adiantamento->setIdMotoristaAttribute($id_motorista);
            $adiantamento->setIdTransportadoraAttribute($id_transportadora);
            $adiantamento->setRotaAttribute($rota);
            $adiantamento->setDataCarregamentoAttribute($request->input('data_carregamento'));
            $adiantamento->setValorAttribute($request->input('valor'));
            $tipo = $request->input('tipo');
            if ($tipo == 'scf') {
                $adiantamento->setObservacaoAttribute($request->input('observacao'));
                $adiantamento->setStatusAttribute($request->input('status'));
            } elseif ($tipo == 'acf') {
                $adiantamento->setObservacaoAttribute(trim($codigo_autorizacao . ' ' . $request->input('observacao')));
                $adiantamento->setStatusAttribute($status);
            }

            $adiantamento->setTipoAttribute($request->input('tipo'));
            $adiantamento->setEmMaosAttribute($request->input('em_maos'));
            $adiantamento->save();

            DB::commit();
        } catch (QueryException $e) {

            $errorReason = $e->errorInfo[2];

            DB::rollback();
            return redirect('adiantamentos-solicitados')->with('error', 'Erro ao salvar os dados ' . $errorReason);
        }
    }


    public function update(Request $request)
    {
        try {

            DB::beginTransaction();
            $rota = $request->input('local_coleta') . '/' . $request->input('local_carregamento') . '/' . $request->input('local_entrega');
            $id_cavalo = $request->input('id_cavalo');
            $result = Cavalo::with('motoristas', 'transportadoras')->where('cavalos.id', '=', "$id_cavalo")->get();
            $id_motorista = $result[0]->motoristas[0]->id;
            $id_transportadora = $result[0]->transportadoras->id;

            $id_adiantamento = $request->input('id_adiantamento');
            $adiantamento = Adiantamento::findOrFail($id_adiantamento);

            if ($adiantamento->status == 'Criado') {
                $adiantamento->setIdCavaloAttribute($request->input('id_cavalo'));
                $adiantamento->setIdPostoAttribute($request->input('id_posto'));
                $adiantamento->setIdMotoristaAttribute($id_motorista);
                $adiantamento->setIdTransportadoraAttribute($id_transportadora);
                $adiantamento->setRotaAttribute($rota);
                $adiantamento->setDataCarregamentoAttribute($request->input('data_carregamento'));
                $adiantamento->setValorAttribute($request->input('valor'));
                $adiantamento->setObservacaoAttribute($request->input('observacao'));
                $adiantamento->setEmMaosAttribute($request->input('em_maos'));
                $adiantamento->update();
            } else {
                return redirect('adiantamentos-solicitados')->with('success', 'Adiantamento atualizado com sucesso!');
            }

            DB::commit();
        } catch (QueryException $e) {

            $errorReason = $e->errorInfo[2];

            DB::rollback();

            return redirect('adiantamentos-solicitados')->with('error', 'Impossível excluir. Status: ' . $errorReason);
        }
    }

    public function chamarIndex($id = null)
    {
        $cavalos = $this->cavaloController->index();
        $postos = $this->postoController->index();
        $rotas = $this->rotaController->index();

        if ($id !== null) {
            $adiantamento = Adiantamento::findOrFail($id);
            if ($adiantamento->status == 'Criado') {
            } else {
                return redirect('adiantamentos-solicitados')->with('error', 'Impossível editar. Status: ' . $adiantamento->status);
            }
        }
        $title = 'Solicitar Adiantamento';
        return view('administrativo.Formularios.formulario-solicitar-adiantamento', compact('cavalos', 'postos', 'rotas', 'title'));
    }

    public function chamarIndexAutAdiantamento()
    {
        $cavalos = $this->cavaloController->index();
        $postos = $this->postoController->index();
        $postos = $postos->reject(function ($posto) {
            return $posto->nome_posto === 'Depósito';
        });
        $rotas = $this->rotaController->index();

        $title = 'Autorizar Adiantamento';
        return view('administrativo.Formularios.formulario-autorizar-adiantamento', compact('cavalos', 'postos', 'rotas', 'title'));
    }

    public function processarSolicitacoes(Request $request)
    {

        $tipo = $request->input('tipo');

        if ($tipo == 'scf') {
            $resultado = $this->storeOrUpdate($request);
            if ($resultado == 'success') {
                return redirect('adiantamentos-solicitados')->with('success', 'Adiantamento inserido!');
            } else {
                return redirect('adiantamentos-solicitados')->with('error', 'Erro! ' . $resultado);
            }
        } elseif ($tipo == 'acf') {

            $resultado = $this->autorizarAdiantamento($request);

            if ($resultado == 'success') {
                return redirect('adiantamentos-solicitados')->with('success', 'Autorização enviada!');
            } else {
                return redirect('adiantamentos-solicitados')->with('error', 'Erro! ' . $resultado);
            }
        }
    }

    public function processarEnvios(Request $request)
    {
        $id_adiantamento = $request->input('id_adiantamento');
        $adiantamento = Adiantamento::findOrFail($id_adiantamento);
        $tipo = $adiantamento->tipo;

        if ($tipo == 'scf') {
            $resultado = $this->enviarAdiantamento($request);
            if ($resultado == 'success') {
                return redirect('consulta-adiantamentos')->with('success', 'Sucesso!');
            } else {
                return redirect('consulta-adiantamentos')->with('error', 'Erro! ' . $resultado);
            }
        } elseif ($tipo == 'acf') {
            $resultado = $this->enviarAutorizacaoFinanceiro($request);
            if ($resultado == 'success') {
                return redirect('consulta-adiantamentos')->with('success', 'Autorização enviada!');
            } else {
                return redirect('consulta-adiantamentos')->with('error', 'Erro! ' . $resultado);
            }
        }
    }

    public function autorizarAdiantamento(Request $request)
    {

        try {

            $posto = Posto::findOrFail($request->input('id_posto'));
            $contato_posto = Contato::findOrFail($posto->id_contato);

            $cavalo = Cavalo::with('contaBancaria', 'contaBancaria.banco', 'motoristas', 'transportadoras', 'transportadoras.contaBancaria', 'transportadoras.contaBancaria.banco')
                ->where('id', $request->input('id_cavalo'))
                ->has('motoristas')
                ->has('transportadoras')
                ->first();

            if (auth()->check()) {
                $user_email = auth()->user()->email;
            }

            $placa = $cavalo->placa;
            $motorista_strtoupper = strtoupper($cavalo->motoristas[0]->nome);
            $motorista_ucwords = $cavalo->motoristas[0]->nome;
            $cidade_carregamento = $request->input('cidade_carregamento');
            $uf_carregamento = $request->input('uf_carregamento');
            $data_carregamento = $request->input('data_carregamento');
            $dia_mes = substr($data_carregamento, 8, 2) . substr($data_carregamento, 5, 2);
            $codigo_autorizacao = $placa . $dia_mes;
            $valor = $request->input('valor');

            if (strlen($valor) == 4) {
                $valor = 'R$ ' . substr($valor, 0, 1) . '.' . substr($valor, 1) . ',00';
            } elseif (strlen($valor) >= 5) {
                $valor = 'R$ ' . substr($valor, 0, 2) . '.' . substr($valor, 2) . ',00';
            } else {
                $valor = 'R$ ' . $valor . ',00';
            }


            $email_1 = $contato_posto->email_1;
            $email_2 = $contato_posto->email_2;
            $email_3 = $contato_posto->email_3;
            $email_4 = $contato_posto->email_4;


            $emails_to = [];

            if (!empty($email_1)) {
                $emails_to[] = $email_1;
            }

            if (!empty($email_2)) {
                $emails_to[] = $email_2;
            }

            if (!empty($email_3)) {
                $emails_to[] = $email_3;
            }

            if (!empty($email_4)) {
                $emails_to[] = $email_4;
            }

            $users_copia = User::where('setor', 'operacao')
                ->orWhere('setor', '=', 'monitoramento')
                ->orWhere('setor', '=', 'administrativo')
                ->get();

            foreach ($users_copia as $user_copia) {
                if (
                    !empty($user_copia['email']) && $user_copia['email'] !== 'monitoramento.cotramol1@gmail.com'
                    && $user_copia['email'] !== 'cte.itajai@cotramol.com.br'
                ) {
                    $emails_cc[] = $user_copia['email'];
                }
            }

            $emails_cc[] = $user_email;

            $assunto_email = "AUTORIZAÇÃO CARTA FRETE | $motorista_strtoupper | PLACA $placa | AUT. N° $codigo_autorizacao";
            $caminho_imagem = public_path('storage' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'assinatura_mara.png');
            $tipo_contenido = mime_content_type($caminho_imagem);
            $imagem_base64 = base64_encode(file_get_contents($caminho_imagem));
            $tag_imagem = '<img src="data:' . $tipo_contenido . ';base64,' . $imagem_base64 . '" alt="Assinatura Mara">';

            $corpo_email = 'Olá!<br><br>
            Por gentileza, autorizar carta frete no valor de ' . $valor . ' para o Sr. ' . $motorista_ucwords . ', placa ' . $placa . '. <br><br>        
            Autorização N° ' . $codigo_autorizacao . '. <br><br>' . $tag_imagem;



            $email = new EmailController;
            $email->autorizarAdiantamento($assunto_email, $corpo_email, $emails_to, $emails_cc, '');
            $this->store($request, 'Aut N° ' . $codigo_autorizacao, 'Em andamento');
            return 'success';
        } catch (QueryException $e) {
            return ($e);
        }
    }

    public function enviarAdiantamento(Request $request)
    {
        try {
            $anexos = $request->file('carta-frete');

            $anexos = is_array($anexos) ? $anexos : [$anexos];

            $adiantamento = Adiantamento::findOrFail($request->input('id_adiantamento'));
            $id_cavalo = $adiantamento->id_cavalo;
            $id_posto = $adiantamento->id_posto;
            $em_maos = $adiantamento->em_maos;

            $id_adiantamento = $adiantamento->id;

            $posto = Posto::findOrFail($id_posto);
            $nome_posto = $posto->nome_posto;
            $id_posto = $posto->id;
            $id_contato = $posto->id_contato;
            $contato_posto = Contato::findOrFail($id_contato);

            $cavalo = Cavalo::findOrFail($id_cavalo);

            $id_transportadora = $cavalo->id_transportadora;
            $id_conta_bancaria_cavalo = $cavalo->id_conta_bancaria;

            $transportadora = Transportadora::findOrFail($id_transportadora);
            $razao_social = strtoupper($transportadora->razao_social);
            $cnpj = $transportadora->cnpj;
            $id_transportadora = $transportadora->id;

            $id_conta_bancaria_transportadora = $transportadora->id_conta_bancaria;

            $conta_bancaria_cavalo = ContaBancaria::findOrFail($id_conta_bancaria_cavalo);
            $conta_bancaria_transportadora = ContaBancaria::findOrFail($id_conta_bancaria_transportadora);

            $numero_conta_cavalo = $conta_bancaria_cavalo->numero_conta_bancaria;
            $codigo_banco_cavalo = $conta_bancaria_cavalo->codigo_banco;
            $agencia_cavalo = $conta_bancaria_cavalo->agencia;

            $numero_conta_transportadora = $conta_bancaria_transportadora->numero_conta_bancaria;
            $codigo_banco_transportadora = $conta_bancaria_transportadora->codigo_banco;
            $agencia_transportadora = $conta_bancaria_transportadora->agencia;


            if (auth()->check()) {
                $user_email = auth()->user()->email;
            }

            $placa = $cavalo->placa;
            $motorista_strtoupper = strtoupper($cavalo->motoristas[0]->nome);
            $motorista_ucwords = $cavalo->motoristas[0]->nome;

            $email_1 = trim($contato_posto->email_1);
            $email_2 = trim($contato_posto->email_2);
            $email_3 = trim($contato_posto->email_3);
            $email_4 = trim($contato_posto->email_4);

            $users_copia = User::where('setor', 'operacao')
                ->orWhere('setor', '=', 'monitoramento')
                ->orWhere('setor', '=', 'administrativo')
                ->get();

            foreach ($users_copia as $user_copia) {
                if (
                    !empty($user_copia['email']) && $user_copia['email'] !== 'monitoramento.cotramol1@gmail.com'
                    && $user_copia['email'] !== 'cte.itajai@cotramol.com.br'
                ) {
                    $emails_cc[] = $user_copia['email'];
                }
            }

            $email_cte = 'cte.itajai@cotramol.com.br';
            if ($user_email == !$email_cte) {
                $emails_cc[] = $email_cte;
            }

            if ($nome_posto !== 'Depósito') {
                $emails_to = [];

                if (!empty($email_1)) {
                    $emails_to[] = $email_1;
                }

                if (!empty($email_2)) {
                    $emails_to[] = $email_2;
                }

                if (!empty($email_3)) {
                    $emails_to[] = $email_3;
                }

                if (!empty($email_4)) {
                    $emails_to[] = $email_4;
                }
                $assunto_email = "ADIANTAMENTO MOTORISTA | $motorista_strtoupper | PLACA $placa";

                $caminho_imagem = public_path('storage' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'assinatura_mara.png');
                $tipo_contenido = mime_content_type($caminho_imagem);
                $imagem_base64 = base64_encode(file_get_contents($caminho_imagem));
                $tag_imagem = '<img src="data:' . $tipo_contenido . ';base64,' . $imagem_base64 . '" alt="Assinatura Mara">';

                $corpo_email = 'Olá!<br><br>
        Segue anexo carta frete para compensar abastecida do Sr. ' . $motorista_ucwords . ', placa ' . $placa . '. <br><br>' . $tag_imagem;

                $email = new EmailController;
                if ($em_maos == 'on') {

                    $this->alterarStatusAdiantamento($id_adiantamento, 'Concluido');
                    return 'success';
                } else {

                    $email->enviarEmail($assunto_email, $corpo_email, $emails_to, $emails_cc, $anexos, 'cte.itajai@cotramol.com.br');
                    $this->alterarStatusAdiantamento($id_adiantamento, 'Concluido');
                    return 'success';
                }

                $id_adiantamento = $request->input('id_adiantamento');
                $email_id = $this->alterarStatusAdiantamento($id_adiantamento, 'Concluido');
            } elseif ($nome_posto == 'Depósito') {
                $emails_to = ['financeiro@cotramol.com.br'];
                $assunto_email = "ADIANTAMENTO DEPÓSITO PLACA | $placa | $razao_social";


                if ($numero_conta_cavalo !== null &&  $codigo_banco_cavalo !== null && $agencia_cavalo !== null) {
                    $numero_conta = $conta_bancaria_cavalo->numero_conta_bancaria;
                    $codigo_banco = $conta_bancaria_cavalo->codigo_banco;
                    $agencia = $conta_bancaria_cavalo->agencia;
                    $tipo_conta = $conta_bancaria_cavalo->tipo_conta;
                    $titularidade = $conta_bancaria_cavalo->titularidade;
                    $pix = str_replace(['_', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'], '', $conta_bancaria_cavalo->pix);
                    $pix = ucwords(strtolower($pix));
                    $chave_pix = $conta_bancaria_cavalo->chave_pix;
                    $nome_banco_cavalo = $conta_bancaria_cavalo->nome_banco;

                    if ($nome_banco_cavalo == null) {
                        $banco = Banco::findOrFail($codigo_banco);
                        $nome_banco = $banco->nome_banco;
                    } else {
                        $nome_banco = $nome_banco_cavalo;
                    }
                } elseif ($numero_conta_transportadora !== null &&  $codigo_banco_transportadora !== null && $agencia_transportadora !== null) {
                    $numero_conta = $conta_bancaria_transportadora->numero_conta_bancaria;
                    $codigo_banco = $conta_bancaria_transportadora->codigo_banco;
                    $agencia = $conta_bancaria_transportadora->agencia;
                    $tipo_conta = $conta_bancaria_transportadora->tipo_conta;
                    $titularidade = $conta_bancaria_transportadora->titularidade;
                    $pix = str_replace(['_', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'], '', $conta_bancaria_transportadora->pix);
                    $pix = ucwords(strtolower($pix));
                    $chave_pix = $conta_bancaria_transportadora->chave_pix;
                    $nome_banco_transportadora = $conta_bancaria_transportadora->nome_banco;

                    if ($nome_banco_transportadora == null) {
                        $banco = Banco::findOrFail($codigo_banco);
                        $nome_banco = $banco->nome_banco;
                    } else {
                        $nome_banco = $nome_banco_transportadora;
                    }
                } else {

                    return 'Contas bancárias incompletas.';
                }

                switch ($id_transportadora) {
                    case 8:
                        $emails_cc[] = 'arthuresaratransportes@hotmail.com';
                        break;
                    case 52:
                        $emails_cc[] = 'transportesgillara@outlook.com';
                        break;
                }

                $caminho_imagem = public_path('storage' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'assinatura_mara.png');
                $tipo_contenido = mime_content_type($caminho_imagem);
                $imagem_base64 = base64_encode(file_get_contents($caminho_imagem));
                $tag_imagem = '<img src="data:' . $tipo_contenido . ';base64,' . $imagem_base64 . '" alt="Assinatura Mara">';

                $corpo_email = 'Olá!<br><br>
                Segue anexo adiantamento para depósito | ' . $razao_social . ' - PLACA ' . $placa . '.' . '<br><br>' .
                    '
                    <html>
<head>
  <meta http-equiv=Content-Type content=""text/html; charset=windows-1252"">
  <meta name=ProgId content=Word.Document>
  <meta name=Generator content=""Microsoft Word 15"">
  <meta name=Originator content=""Microsoft Word 15"">
  <link rel=File-List href=""complementos%20tabela%20Html_arquivos/filelist.xml"">
  <link rel=Edit-Time-Data
  href=""complementos%20tabela%20Html_arquivos/editdata.mso"">
  <link rel=themeData href=""complementos%20tabela%20Html_arquivos/themedata.thmx"">
  <link rel=colorSchemeMapping
  href=""complementos%20tabela%20Html_arquivos/colorschememapping.xml"">
  <style>
  <!--
   /* Font Definitions */
   @font-face
    {font-family:""Cambria Math"";
    panose-1:2 4 5 3 5 4 6 3 2 4;
    mso-font-charset:0;
    mso-generic-font-family:roman;
    mso-font-pitch:variable;
    mso-font-signature:3 0 0 0 1 0;}
  @font-face
    {font-family:Calibri;
    panose-1:2 15 5 2 2 2 4 3 2 4;
    mso-font-charset:0;
    mso-generic-font-family:swiss;
    mso-font-pitch:variable;
    mso-font-signature:-469750017 -1073732485 9 0 511 0;}
   /* Style Definitions */
   p.MsoNormal, li.MsoNormal, div.MsoNormal
    {mso-style-unhide:no;
    mso-style-qformat:yes;
    mso-style-parent:"""";
    margin:0cm;
    mso-pagination:widow-orphan;
    font-size:11.0pt;
    font-family:""Calibri"",sans-serif;
    mso-fareast-font-family:Calibri;
    mso-fareast-theme-font:minor-latin;
    mso-fareast-language:EN-US;}
  a:link, span.MsoHyperlink
    {mso-style-noshow:yes;
    mso-style-priority:99;
    color:#0563C1;
    text-decoration:underline;
    text-underline:single;}
  a:visited, span.MsoHyperlinkFollowed
    {mso-style-noshow:yes;
    mso-style-priority:99;
    color:#954F72;
    text-decoration:underline;
    text-underline:single;}
  p.msonormal0, li.msonormal0, div.msonormal0
    {mso-style-name:msonormal;
    mso-style-unhide:no;
    mso-margin-top-alt:auto;
    margin-right:0cm;
    mso-margin-bottom-alt:auto;
    margin-left:0cm;
    mso-pagination:widow-orphan;
    font-size:11.0pt;
    font-family:""Calibri"",sans-serif;
    mso-fareast-font-family:Calibri;
    mso-fareast-theme-font:minor-latin;}
  span.EstiloDeEmail18
    {mso-style-type:personal;
    mso-style-noshow:yes;
    mso-style-unhide:no;
    font-family:""Calibri"",sans-serif;
    mso-ascii-font-family:Calibri;
    mso-hansi-font-family:Calibri;
    mso-bidi-font-family:Calibri;
    color:windowtext;}
  .MsoChpDefault
    {mso-style-type:export-only;
    mso-default-props:yes;
    font-size:10.0pt;
    mso-ansi-font-size:10.0pt;
    mso-bidi-font-size:10.0pt;}
  @page WordSection1
    {size:612.0pt 792.0pt;
    margin:70.85pt 3.0cm 70.85pt 3.0cm;
    mso-header-margin:36.0pt;
    mso-footer-margin:36.0pt;
    mso-paper-source:0;}
  div.WordSection1
    {page:WordSection1;}
  -->
  </style>
  <!--[if gte mso 10]>
    <style>
   /* Style Definitions */
   table.MsoNormalTable
    {mso-style-name:""Tabela normal"";
    mso-tstyle-rowband-size:0;
    mso-tstyle-colband-size:0;
    mso-style-noshow:yes;
    mso-style-priority:99;
    mso-style-parent:"""";
    mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
    mso-para-margin:0cm;
    mso-pagination:widow-orphan;
    font-size:10.0pt;
    font-family:""Times New Roman"",serif;}
  </style>
  <![endif]--><!--[if gte mso 9]><xml>
   <o:shapedefaults v:ext=""edit"" spidmax=""1026""/>
  </xml><![endif]--><!--[if gte mso 9]><xml>
   <o:shapelayout v:ext=""edit"">
    <o:idmap v:ext=""edit"" data=""1""/>
   </o:shapelayout></xml><![endif]-->
  </head>
  
  <body lang=PT-BR link=""#0563C1"" vlink=""#954F72"" style="tab-interval:35.4pt;
  word-wrap:break-word">
  
  <div class=WordSection1>
<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=893
 style="width:670.0pt;margin-left:-.05pt;border-collapse:collapse;mso-yfti-tbllook:
 1184;mso-padding-alt:0cm 0cm 0cm 0cm">
 <tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes;height:43.2pt">
  <td width=84 style="width:63.0pt;border:solid windowtext 1.0pt;background:
  #A6A6A6;padding:0cm 3.5pt 0cm 3.5pt;height:43.2pt">
  <p class=MsoNormal align=center style="text-align:center"><b><span
  style="color:black;mso-fareast-language:PT-BR">Pix<o:p></o:p></span></b></p>
  </td>
  <td width=97 style="width:73.0pt;border:solid windowtext 1.0pt;border-left:
  none;background:#A6A6A6;padding:0cm 3.5pt 0cm 3.5pt;height:43.2pt">
  <p class=MsoNormal align=center style="text-align:center"><b><span
  style="color:black;mso-fareast-language:PT-BR">Nome Banco<o:p></o:p></span></b></p>
  </td>
  <td width=97 style="width:73.0pt;border:solid windowtext 1.0pt;border-left:
  none;background:#A6A6A6;padding:0cm 3.5pt 0cm 3.5pt;height:43.2pt">
  <p class=MsoNormal align=center style="text-align:center"><b><span
  style="color:black;mso-fareast-language:PT-BR">Agência<o:p></o:p></span></b></p>
  </td>
  <td width=56 style="width:42.0pt;border:solid windowtext 1.0pt;border-left:
  none;background:#A6A6A6;padding:0cm 3.5pt 0cm 3.5pt;height:43.2pt">
  <p class=MsoNormal align=center style="text-align:center"><b><span
  style="color:black;mso-fareast-language:PT-BR">Conta<o:p></o:p></span></b></p>
  </td>
  <td width=67 style="width:50.0pt;border:solid windowtext 1.0pt;border-left:
  none;background:#A6A6A6;padding:0cm 3.5pt 0cm 3.5pt;height:43.2pt">
  <p class=MsoNormal align=center style="text-align:center"><b><span
  style="color:black;mso-fareast-language:PT-BR">Cód. Banco<o:p></o:p></span></b></p>
 </tr><tr style="mso-yfti-irow:1;mso-yfti-lastrow:yes;height:14.4pt">


 <td width=67 nowrap valign=bottom style="width:50.0pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 3.5pt 0cm 3.5pt;height:14.4pt">
  <p class=MsoNormal align=center style="text-align:center"><span
  style="color:black;mso-fareast-language:PT-BR">' . $pix . ' - ' . $chave_pix . '<o:p></o:p></span></p>
  </td>
  <td width=84 nowrap style="width:63.0pt;border:solid windowtext 1.0pt;
  border-top:none;padding:0cm 3.5pt 0cm 3.5pt;height:14.4pt">
  <p class=MsoNormal align=center style="text-align:center"><span
  style="color:black;mso-fareast-language:PT-BR">' . $nome_banco . '<o:p></o:p></span></p>
  </td>
  <td width=97 nowrap style="width:73.0pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 3.5pt 0cm 3.5pt;height:14.4pt">
  <p class=MsoNormal align=center style="text-align:center"><span
  style="color:black;mso-fareast-language:PT-BR">' . $agencia . '<o:p></o:p></span></p>
  </td>
  <td width=97 nowrap valign=bottom style="width:73.0pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0cm 3.5pt 0cm 3.5pt;height:14.4pt">
  <p class=MsoNormal align=center style="text-align:center"><span
  style="color:black;mso-fareast-language:PT-BR">' . $numero_conta . '<o:p></o:p></span></p>
  </td>
  <td width=56 nowrap valign=bottom style="width:42.0pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 3.5pt 0cm 3.5pt;height:14.4pt">
  <p class=MsoNormal align=center style="text-align:center"><span
  style="color:black;mso-fareast-language:PT-BR">' . $codigo_banco . '<o:p></o:p></span></p>
  </td>
 </tr>
</table><p class=MsoNormal><o:p>&nbsp;</o:p></p>
</div>
</body>
</html> <br><br>' . $tag_imagem;

                $email = new EmailController;
                if ($em_maos == 'on') {
                    return 'Impossível enviar adiantamento em mãos para depósito!';
                } else {
                    $email->enviarEmail($assunto_email, $corpo_email, $emails_to, $emails_cc, $anexos, 'cte.itajai@cotramol.com.br');
                    $this->alterarStatusAdiantamento($id_adiantamento, 'Concluido');
                    return 'success';
                }
            }
        } catch (QueryException $e) {
            return ($e);
        }
    }

    public function enviarAutorizacaoFinanceiro(Request $request)
    {
        try {

            $anexo = $request->file('carta-frete');

            $id_adiantamento = $request->input('id_adiantamento');
            $adiantamento = Adiantamento::findOrFail($id_adiantamento);
            $tipo = $adiantamento->tipo;
            $observacao = $adiantamento->observacao;
            $data_carregamento = $adiantamento->data_carregamento;
            $id_cavalo = $adiantamento->id_cavalo;


            $id_posto = $adiantamento->id_posto;
            $posto = Posto::findOrFail($id_posto);
            $nome_posto = $posto->nome_posto;
            $id_contato = $posto->id_contato;

            $contato_posto = Contato::findOrFail($id_contato);

            $cavalo = Cavalo::findOrFail($id_cavalo);
            $id_transportadora = $cavalo->id_transportadora;
            $placa = $cavalo->placa;
            $dia_mes = substr($data_carregamento, 8, 2) . substr($data_carregamento, 5, 2);
            $codigo_autorizacao = $placa . $dia_mes;

            $transportadora = Transportadora::findOrFail($id_transportadora);

            if (auth()->check()) {
                $user_email = auth()->user()->email;
            }

            $placa = $cavalo->placa;
            $motorista_strtoupper = strtoupper($cavalo->motoristas[0]->nome);
            $motorista_ucwords = $cavalo->motoristas[0]->nome;

            $emails_to = ["financeiro2@cotramol.com.br"];
            $emails_cc = ["$user_email", 'adm.itajai@cotramol.com.br'];

            $assunto_email = "RE: AUTORIZAÇÃO CARTA FRETE | $motorista_strtoupper | PLACA $placa | AUT. N° $codigo_autorizacao";

            $caminho_imagem = public_path('storage' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'assinatura_mara.png');
            $tipo_contenido = mime_content_type($caminho_imagem);
            $imagem_base64 = base64_encode(file_get_contents($caminho_imagem));
            $tag_imagem = '<img src="data:' . $tipo_contenido . ';base64,' . $imagem_base64 . '" alt="Assinatura Mara">';

            $corpo_email = 'Olá!<br><br><br>
            Segue anexo carta frete para compensar abastecida via autorização.
            <br><br>
            <b>Placa:</b> ' . $placa . '
            <br><br>
            <b>Motorista:</b> ' . $motorista_ucwords . '
            <br><br>
            <b>Posto:</b> ' . $nome_posto . '
            <br><br>
            <b>Autorização N°</b> ' . $codigo_autorizacao . '. <br><br>' . $tag_imagem;

            $email = new EmailController;
            $email->enviarEmail($assunto_email, $corpo_email, $emails_to, $emails_cc, $anexo, 'cte.itajai@cotramol.com.br');
            $id_adiantamento = $request->input('id_adiantamento');
            $this->alterarStatusAdiantamento($id_adiantamento, 'Concluido');

            return 'success';
        } catch (QueryException $e) {
            return ($e);
        }
    }


    public function cancelarAdiantamento($id, $obs)
    {
        try {

            $adiantamento = Adiantamento::findOrFail($id);
            $adiantamento->setStatusAttribute('Cancelado');
            $adiantamento->setObservacaoAttribute($obs);
            $adiantamento->update();

            $id_email = $adiantamento->id_email;

            return redirect('consulta-adiantamentos')->with('success', 'Adiantamento cancelado com sucesso!');
        } catch (QueryException $e) {
            return redirect('consulta-adiantamentos')->with('error', 'Erro ao cancelar adiantamento!: ');
        }
    }

    public function consultaAdiantamentos(Request $request)
    {
        if ($request->input('pesquisar') !== null) {
            setcookie("filtroCookie",  $request->input('pesquisar'));
            $filtroCookie = $request->input('pesquisar');
        } else {
            setcookie("filtroCookie", '');
            $filtroCookie = '';
        }

        try {
            $adiantamentos = Adiantamento::with('cavalo', 'motorista', 'transportadora', 'posto')
                ->where(function ($query) use ($filtroCookie) {
                    $query->where('status', '!=', 'Concluido');
                    $query->where('status', '!=', 'Cancelado');
                })
                ->where(function ($query) use ($filtroCookie) {
                    $query->orWhereHas('cavalo', function ($query) use ($filtroCookie) {
                        $query->where('placa', 'LIKE', "%$filtroCookie%");
                    })
                        ->orWhereHas('motorista', function ($query) use ($filtroCookie) {
                            $query->where('nome', 'LIKE', "%$filtroCookie%");
                        })
                        ->orWhereHas('posto', function ($query) use ($filtroCookie) {
                            $query->where('nome_posto', 'LIKE', "%$filtroCookie%");
                        });
                })
                ->get();

            $result = $adiantamentos->map(function ($adiantamento) {
                $em_maos = $adiantamento['em_maos'];

                $id_posto = $adiantamento->id_posto;
                $nome_posto = $adiantamento->posto->nome_posto;
                $observacao = $adiantamento->observacao;

                if ($em_maos == 'on') {
                    $observacao = 'Em mãos ' . $observacao;
                }


                $id_user = $adiantamento->id_user;
                $id_user = $adiantamento->id_user;
                $user = User::findOrFail($id_user);

                if ($user->apelido == null) {
                    $nome_completo_usuario = explode(" ", $user->name);
                    $primeiro_nome = $nome_completo_usuario[0];
                } else {
                    $primeiro_nome = $user->apelido;
                }

                $tratarDadosService = new TrataDadosService();
                $data_solicitacao = $tratarDadosService->tratarDatas($adiantamento->created_at);
                $data_carregamento = $tratarDadosService->tratarDatas($adiantamento->data_carregamento);
                $valor = $tratarDadosService->tratarFloat($adiantamento->valor);

                $id_cavalo = $adiantamento->id_cavalo;
                $dataAtual = Carbon::now()->toDateString();
                $count = DB::table('adiantamentos')
                    ->where('id_cavalo', $id_cavalo)
                    ->where(function ($query) use ($dataAtual) {
                        $query->where('status', '<>', 'Concluido')
                            ->where('status', '<>', 'Cancelado')
                            ->orWhereDate('created_at', $dataAtual);
                    })
                    ->count();
                $maisDeUmaVez = $count > 1;

                if ($maisDeUmaVez) {
                    $placaRepetida = true;
                } else {
                    $placaRepetida = false;
                }

                return [
                    'id' => htmlspecialchars((string) $adiantamento->id),
                    'placa' => htmlspecialchars((string) $adiantamento->cavalo->placa),
                    'placa_repetida' => \htmlspecialchars((string) $placaRepetida),
                    'nome' => htmlspecialchars((string) $adiantamento->motorista->nome),
                    'data' => htmlspecialchars((string) $data_solicitacao),
                    'rota' => htmlspecialchars((string) $adiantamento->rota),
                    'codigo_senior' => htmlspecialchars((string) $adiantamento->motorista->codigo_senior),
                    'razao_social' => htmlspecialchars((string) $adiantamento->transportadora->razao_social),
                    'codigo_senior_transportadora' => htmlspecialchars((string) $adiantamento->transportadora->codigo_transportadora),
                    'nome_posto' => htmlspecialchars((string) $nome_posto),
                    'data_solicitacao' => htmlspecialchars((string) $adiantamento->created_at),
                    'data_carregamento' => htmlspecialchars((string) $data_carregamento),
                    'valor' => htmlspecialchars((string) $valor),
                    'usuario' => htmlspecialchars((string) $primeiro_nome),
                    'observacao' => htmlspecialchars((string) $observacao),
                ];
            })->toArray();
            return view('administrativo.Consultas.consulta-geral-adiantamentos', compact('result'));
        } catch (QueryException $e) {
            dd($e);
        }
    }

    public function consultaHistoricoAdiantamentos(Request $request)
    {
        try {
            $adiantamentoRepository = new AdiantamentoRepository;
            $result = $adiantamentoRepository->consultaHistoricoAdiantamentos($request);

            return view('administrativo.Consultas.consulta-historico-adiantamentos', compact('result'));
        } catch (QueryException $e) {
            return redirect()->back()->with('error', $e);
        }
    }

    public function consultaAdiantamentosSolicitados(Request $request)
    {
        if ($request->input('pesquisar') !== null) {
            setcookie("filtroCookie",  $request->input('pesquisar'));
            $filtroCookie = $request->input('pesquisar');
        } else {
            setcookie("filtroCookie", '');
            $filtroCookie = '';
        }

        try {
            $id_usuario_atual = auth()->user()->id;

            $adiantamentos = Adiantamento::with('cavalo', 'motorista', 'transportadora', 'posto')
                ->where('adiantamentos.id_user', $id_usuario_atual)
                ->where(function ($query) use ($filtroCookie) {
                    $query->where('status', '!=', 'Concluido')
                        ->where('status', '!=', 'Cancelado')
                        ->orWhereDate('created_at', today());
                })
                ->where(function ($query) use ($filtroCookie) {
                    $query->orWhereHas('cavalo', function ($query) use ($filtroCookie) {
                        $query->where('placa', 'LIKE', "%$filtroCookie%");
                    })
                        ->orWhereHas('motorista', function ($query) use ($filtroCookie) {
                            $query->where('nome', 'LIKE', "%$filtroCookie%");
                        })
                        ->orWhereHas('posto', function ($query) use ($filtroCookie) {
                            $query->where('nome_posto', 'LIKE', "%$filtroCookie%");
                        });
                })
                ->orderBy('created_at', 'desc')
                ->get();


            $result = $adiantamentos->map(function ($adiantamento, $em_maos) {
                $em_maos = $adiantamento->em_maos;

                $id_user = $adiantamento->id_user;
                $user = User::findOrFail($id_user);


                if ($user->apelido == null) {
                    $nome_completo_usuario = explode(" ", $user->name);
                    $primeiro_nome = $nome_completo_usuario[0];
                } else {
                    $primeiro_nome = $user->apelido;
                }

                $tratarDadosService = new TrataDadosService();
                $data_solicitacao = $tratarDadosService->tratarDatas($adiantamento->created_at);
                $data_carregamento = $tratarDadosService->tratarDatas($adiantamento->data_carregamento);
                $valor = $tratarDadosService->tratarFloat($adiantamento->valor);

                $observacao = $adiantamento->observacao;
                if ($em_maos == 'on') {
                    $observacao = 'Em mãos ' . $observacao;
                }

                return [
                    'id' => htmlspecialchars((string) $adiantamento->id),
                    'placa' => htmlspecialchars((string) $adiantamento->cavalo->placa),
                    'nome' => htmlspecialchars((string) $adiantamento->motorista->nome),
                    'data' => htmlspecialchars((string) $data_solicitacao),
                    'rota' => htmlspecialchars((string) $adiantamento->rota),
                    'nome' => htmlspecialchars((string) $adiantamento->motorista->nome),
                    'razao_social' => htmlspecialchars((string) $adiantamento->transportadora->razao_social),
                    'codigo_senior_transportadora' => htmlspecialchars((string) $adiantamento->transportadora->codigo_transportadora),
                    'nome_posto' => htmlspecialchars((string) $adiantamento->posto->nome_posto),
                    'data_solicitacao' => htmlspecialchars((string) $adiantamento->created_at),
                    'data_carregamento' => htmlspecialchars((string) $data_carregamento),
                    'valor' => htmlspecialchars((string) $valor),
                    'usuario' => htmlspecialchars((string) $primeiro_nome),
                    'observacao' => htmlspecialchars((string) $observacao),
                    'status' => htmlspecialchars((string) $adiantamento->status),
                ];
            })->toArray();

            return view('administrativo.Consultas.consulta-adiantamentos-solicitados', compact('result'));
        } catch (QueryException $e) {
            dd($e);
        }
    }


    public function destroy($id)
    {
        $adiantamento = Adiantamento::where('id', $id)->first();
        $status = $adiantamento->status;

        if ($status == 'Criado') {
            $adiantamento->delete();
            return redirect('adiantamentos-solicitados')->with('success', 'Adiantamento excluído com sucesso!');
        } else {
            return redirect('adiantamentos-solicitados')->with('error', 'Impossível excluir. Status: ' . $adiantamento->status);
        }
    }


    public function alterarStatusAdiantamento($id, $status)
    {
        $adiantamento = Adiantamento::findOrFail($id);
        $adiantamento->setStatusAttribute($status);
        $adiantamento->update();
    }

    public function consultaParaDashboard()
    {
        $adiantamentosGraficoPizza = Adiantamento::join('postos', 'adiantamentos.id_posto', '=', 'postos.id')
            ->groupBy('postos.rede')
            ->select('postos.rede', DB::raw('SUM(adiantamentos.valor) as valor_total'))
            ->get();

        $adiantamentos = Adiantamento::select(
            'status',
            DB::raw('COUNT(status) as total_status'),
            DB::raw('SUM(valor) as valor_total')
        )
            ->groupBy('status')
            ->get();



        return response()->json([
            'adiantamentosGraficoPizza' => $adiantamentosGraficoPizza,
            'adiantamentos' => $adiantamentos
        ]);
    }
}
