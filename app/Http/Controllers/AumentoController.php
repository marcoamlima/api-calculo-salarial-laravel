<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DescontoController;

class AumentoController extends Controller
{
    /**
     * Calcula o salário final após aplicar aumento e descontos.
     *
     * @param Request $request Deve conter 'salario', 'aumento_percentual' e 'descontos_extras'
     * @return \Illuminate\Http\JsonResponse
     */
    public function calcular(Request $request)
    {
        $salarioOriginal = $request->input('salario');
        $aumentoPercentual = $request->input('aumento_percentual');
        $descontosExtras = $request->input('descontos_extras', 0);

        // Aplica o aumento
        $salarioComAumento = $salarioOriginal * (1 + $aumentoPercentual / 100);

        // Usa o DescontoController para calcular INSS e IRRF
        $descontoController = new DescontoController();
        $requestFake = new Request(['salario' => $salarioComAumento], ['descontos_extras' => $descontosExtras]);
        $descontos = $descontoController->calcular($requestFake)->getData();

        // Soma os descontos
        $totalDescontos = $descontos->desconto_inss + $descontos->desconto_irrf + $descontosExtras;
        $salarioFinal = $salarioComAumento - $totalDescontos;

        return response()->json([
            'salario_original' => round($salarioOriginal, 2),
            'aumento_percentual' => $aumentoPercentual,
            'salario_com_aumento' => round($salarioComAumento, 2),
            'desconto_inss' => round($descontos->desconto_inss, 2),
            'desconto_irrf' => round($descontos->desconto_irrf, 2),
            'descontos_extras' => round($descontosExtras, 2),
            'salario_final' => round($salarioFinal, 2)
        ]);
    }

}
