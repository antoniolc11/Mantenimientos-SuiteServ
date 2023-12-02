<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Support\Facades\View;

use App\Models\Incidencia;

use PDF;
use Mpdf\Mpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class PDFController extends Controller
{
    public function generatePDF(Incidencia $incidencia)
    {
        // Obtén los datos de la incidencia y realiza el procesamiento necesario
        // para crear el contenido del PDF.

        $fecha_inicio = Historial::where('incidencia_id', $incidencia->id)
            ->where('estado_id', 2)
            ->pluck('fecha')->first();

        $fecha_fin = Historial::where('incidencia_id', $incidencia->id)
            ->where('estado_id', 3)
            ->pluck('fecha')->first();

        $hora_inicio = Historial::where('incidencia_id', $incidencia->id)
            ->where('estado_id', 2)
            ->pluck('hora_inicio')->first();

        $hora_fin = Historial::where('incidencia_id', $incidencia->id)
            ->where('estado_id', 3)
            ->pluck('hora_fin')->first();


        $trabajo_realizado = Historial::where('incidencia_id', $incidencia->id)
            ->where('estado_id', 3)
            ->orderByDesc('fecha_actualizacion') // Ajusta 'fecha' al nombre real de la columna temporal que estás utilizando
            ->pluck('trabajo_realizado')
            ->first();

        // Crea una instancia de mPDF
        $mpdf = new Mpdf();

        // Renderiza el contenido del PDF utilizando mPDF
        $data = [
            'incidencia' => $incidencia,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'trabajo_realizado' => $trabajo_realizado,
        ];

        $view = view('pdf.parteDeTrabajo', $data)->render();

        $mpdf->WriteHTML($view);

        // Establece el nombre del archivo PDF personalizado
        $fileName = "Parte {$incidencia->numero}.pdf";

        // Envía el PDF al navegador
        return Response::make($mpdf->Output($fileName, 'I'));
    }
}
