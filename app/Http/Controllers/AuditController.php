<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\pessoas\Motorista;
use App\Models\User;
use App\Services\TrataDadosService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuditController extends Controller
{

    function formatIfDate($value)
    {
        // Verifica se o valor é uma string e parece uma data
        if (is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2}( \d{2}:\d{2}:\d{2})?$/', $value)) {
            try {
                $date = Carbon::parse($value);
                return $date->format('d/m/Y');
            } catch (\Exception $e) {
                return $value;
            }
        }
        return $value;
    }

    function normalizePhoneNumber($phoneNumber)
    {
        // Remove caracteres não numéricos
        return preg_replace('/\D/', '', $phoneNumber);
    }

    public function historicoMotorista(Request $request)
    {

        $filtro = $request->input('pesquisar');
        $auditsQuery = Audit::query()->orderBy('created_at', 'desc');

        if ($filtro !== null) {
            $auditsQuery->where('old_values', 'LIKE', "%$filtro%")->limit(100);
        } else {
            $auditsQuery->limit(100);
        }

        $audits = $auditsQuery->get()
            ->flatMap(function ($audit) {
                $user = User::find($audit->user_id);
                $oldValues = json_decode($audit->old_values, true);
                $newValues = json_decode($audit->new_values, true);
                $alteracoes = [];

                foreach ($oldValues as $key => $oldValue) {
                    if (in_array($key, ['created_at', 'updated_at'])) {
                        continue;
                    }


                    $newValue = $newValues[$key] ?? null;

                    if ($key === 'telefone') {
                        // Normaliza os números de telefone
                        $oldValue = $this->normalizePhoneNumber($oldValue);
                        $newValue = $this->normalizePhoneNumber($newValue);
                    }

                    $formattedOldValue = $this->formatIfDate($oldValue);
                    $formattedNewValue = $this->formatIfDate($newValue);

                    $motorista = Motorista::find($audit->auditable_id);
                    $nome_motorista = $motorista->nome;

                    if ($formattedNewValue !== $formattedOldValue) {
                        if (!is_numeric($formattedOldValue) || (float)$formattedOldValue !== (float)$formattedNewValue) {
                            $alteracoes[] = [
                                'id' => $audit->id,
                                'nome_placa' => $nome_motorista,
                                'quem_alterou' => $user ? $user->name : 'Desconhecido',
                                'quando_alterou' => Carbon::parse($audit->created_at)->format('d/m/Y H:i:s'),
                                'coluna' => $key,
                                'valor_antigo' => $formattedOldValue,
                                'novo_valor' => $formattedNewValue
                            ];
                        }
                    }
                }

                return $alteracoes;
            });
        return view('cadastro.Consultas.historico-cadastro', compact('audits'));
    }
}
