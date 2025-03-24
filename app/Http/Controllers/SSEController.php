<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SSEController extends Controller
{
    public function stream($model)
    {
        return new StreamedResponse(function () use ($model) {
            $lastState = [
                'max_id' => 0,
                'last_updated' => '1970-01-01 00:00:00',
                'total' => 0
            ];

            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            header('Connection: keep-alive');
            header('X-Accel-Buffering: no');

            while (true) {
                try {
                    // Obtener el estado actual de la tabla
                    $currentState = DB::table($model)
                        ->selectRaw('
                            COALESCE(MAX(id), 0) as max_id,
                            COALESCE(MAX(updated_at), "1970-01-01 00:00:00") as last_updated,
                            COUNT(*) as total
                        ')
                        ->first();

                    // Verificar cambios
                    $hasChanges = $currentState->max_id != $lastState['max_id'] ||
                                  $currentState->last_updated != $lastState['last_updated'] ||
                                  $currentState->total != $lastState['total'];

                    if ($hasChanges) {
                        echo "data: " . json_encode(['message' => 'Cambios detectados']) . "\n\n";
                        ob_flush();
                        flush();
                        
                        // Actualizar último estado conocido
                        $lastState = [
                            'max_id' => $currentState->max_id,
                            'last_updated' => $currentState->last_updated,
                            'total' => $currentState->total
                        ];
                    }

                    sleep(2); // Intervalo de verificación más eficiente
                    
                    if (connection_aborted()) break;

                } catch (\Exception $e) {
                    Log::error("SSE Error: " . $e->getMessage());
                    break;
                }
            }
        }, 200);
    }
}
