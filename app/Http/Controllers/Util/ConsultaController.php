<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use App\Models\documentos\Crlv;
use App\Models\pessoas\Motorista;
use App\Models\util\Senha;
use App\Models\veiculos\Carreta;
use Illuminate\Support\Facades\Mail;
use App\Models\veiculos\Cavalo;
use App\Repositories\Pessoas\MotoristaRepository;
use App\Repositories\Util\ConsultaRepository;
use App\Repositories\Util\SenhaRepository;
use App\Repositories\Util\SenhasRepository;
use App\Repositories\Veiculos\CavaloRepository;
use App\Services\TrataDadosService;
use Database\Seeders\MotoristasSeeder;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Else_;

class ConsultaController extends Controller
{

    public function verificarVisual(Request $request)
    {

        try {
            $result = $this->consultaPrincipal($request);

            if ($request->input('visual') !== null) {
                $visual = $request->input('visual');
            } elseif (isset($_COOKIE['visualCookie'])) {
                $user = Auth::user();
                $visual = $_COOKIE['visualCookie'];
            } else {
                $user = Auth::user();
                $visual = $user->setor;
            }

            setcookie("visualCookie", $visual);

            switch ($visual) {
                case 'administrativo':
                    $result = $this->consultaPrincipal($request);
                    return view('consultas.consulta-administrativo', compact('result', 'visual'));
                    break;
                case 'cte':
                    $result = $this->consultaPrincipal($request);
                    return view('consultas.consulta-cte', compact('result', 'visual'));
                    break;
                case 'monitoramento':
                    $result = $this->consultaPrincipal($request);
                    return view('consultas.consulta-monitoramento', compact('result', 'visual'));
                    break;
                case 'operacao':
                    $result = $this->consultaPrincipal($request);
                    return view('consultas.consulta-operacao', compact('result', 'visual'));
                    break;
                case 'ssma':
                    $result = $this->consultaPrincipal($request);
                    return view('consultas.consulta-ssma', compact('result', 'visual'));
                    break;
                case 'motorista_reserva':
                    $result = $this->consultaMotoristaReserva($request);
                    return view('consultas.consulta-motorista-reserva', compact('result', 'visual'));
                    break;
                case 'cavalos_reserva':
                    $result = $this->consultaCavaloReserva($request);
                    return view('consultas.consulta-cavalos-reserva', compact('result', 'visual'));
                    break;
                case 'senhas':
                    $result = $this->consultaSenhas($request);
                    return view('consultas.consulta-senhas', compact('result', 'visual'));
                    break;
                case 'vencimentos':
                    $resultMotoristas =  $this->consultarVencimentosMotoristas($request);
                    $resultVeiculos = $this->consultarVencimentosVeiculos($request);
                    return view('consultas.consulta-vencimentos', compact('resultMotoristas', 'resultVeiculos', 'visual'));
                    break;
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e);
        }

        if (isset($_COOKIE['visualCookie'])) {
            $visual = $_COOKIE['visualCookie'];
        } else {
            $visual = '';
        }

        if (isset($_COOKIE['searchCookie'])) {
            $search = $_COOKIE['searchCookie'];
        } else {
            $search = '';
        }

        if ($visual != '') {
            return view('consultas.consulta-' . $visual, compact('result', 'visual'));
        } else {
            return view('consultas.consulta-ssma', compact('result', 'visual'));
        }
    }

    public function consultaPrincipal(Request $request)
    {
        try {
            $consultaRepository = new ConsultaRepository();
            $result = $consultaRepository->consultaPrincipal($request);
            return $result;
        } catch (QueryException $e) {
            return redirect()->back()->with('error', $e);
        }
    }

    public function consultaMotoristaReserva(Request $request)
    {
        $motorista = new Motorista();
        $motoristaRepository = new MotoristaRepository($motorista);
        $motoristas = $motoristaRepository->consultaMotoristaReserva($request);
        return $motoristas;
    }

    public function consultaCavaloReserva(Request $request)
    {
        try {
            $cavalo = new Cavalo;
            $cavaloRepository = new CavaloRepository($cavalo);
            $cavalos = $cavaloRepository->consultaCavaloReserva($request);
            return $cavalos;
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e);
        }
    }

    public function consultaSenhas($request)
    {
        $senha = new Senha();
        $senhaRepository = new SenhaRepository($senha);
        $senhas = $senhaRepository->consultaSenhas($request);

        return ($senhas);
    }

    public function consultarVencimentosMotoristas($request)
    {
        try {
            $motorista = new Motorista();
            $motoristaRepository = new MotoristaRepository($motorista);
            $consultaVencimentosMotoristas = $motoristaRepository->consultaVencimentosMotoristas($request);
            return $consultaVencimentosMotoristas;
        } catch (QueryException $e) {
            return redirect()->back()->with('error', $e);
        }
    }

    public function consultarVencimentosVeiculos($request)
    {
        try {
            $cavalo = new Cavalo();
            $cavaloRepository = new CavaloRepository($cavalo);
            $consultaVencimentosVeiculos = $cavaloRepository->consultaVencimentosVeiculos($request);
            return $consultaVencimentosVeiculos;
        } catch (QueryException $e) {
            return redirect()->back()->with('error', $e);
        }
    }
}
