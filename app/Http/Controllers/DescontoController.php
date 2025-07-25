<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DescontoController extends Controller
{
    /**
     * Calcula os descontos de INSS e IRRF sobre o salário bruto informado.
     *
     * @param Request $request Requisição contendo o campo 'salario' no corpo JSON.
     * @return \Illuminate\Http\JsonResponse Retorna os valores dos descontos e o salário líquido.
     */
    public function calcular(Request $request)
    {
        $salarioBruto = $request->input('salario');
        $descontos_extras = $request->input('descontos_extras');

        // INSS 2025 (valores fictícios para exemplo)
        $inss = $this->calcularINSS($salarioBruto);

        // IRRF 2025 (valores fictícios para exemplo)
        $irrf = $this->calcularIRRF($salarioBruto - $inss);

        $salarioLiquido = $salarioBruto - $inss - $irrf - $descontos_extras;

        return response()->json([
            'salario_bruto' => $salarioBruto,
            'desconto_inss' => round($inss, 2),
            'desconto_irrf' => round($irrf, 2),
            'descontos_extras' => round($descontos_extras, 2),
            'salario_liquido' => round($salarioLiquido, 2)
        ]);
    }

    /**
     * Realiza o cálculo do desconto de INSS com base no salário bruto.
     *
     * @param float $salario Valor do salário bruto.
     * @return float Valor do desconto de INSS.
     */
    private function calcularINSS($salario)
    {
        // salario * aliquota - dedução
        if ($salario <= 1518.00)
            return $salario * 0.075;
        elseif ($salario <= 2793.88)
            return $salario * 0.09 - 22.77;
        elseif ($salario <= 4190.83)
            return $salario * 0.12 - 106.59;
        elseif ($salario <= 8157.41)
            return $salario * 0.14 - 190.40;
        else
            return 8157.41 * 0.14 - 190.40; // teto
    }

    /**
     * Calcula o valor do Imposto de Renda (IRRF) com base na base de cálculo.
     *
     * @param float $base Base de cálculo (salário bruto - INSS).
     * @return float Valor do desconto de IRRF.
     */
    private function calcularIRRF($base)
    {
        // salario * aliquota - dedução
        if ($base <= 2428.80)
            return 0;
        elseif ($base <= 2826.65)
            return $base * 0.075 - 182.16;
        elseif ($base <= 3751.05)
            return $base * 0.15 - 394.16;
        elseif ($base <= 4664.68)
            return $base * 0.225 - 675.49;
        else
            return $base * 0.275 - 908.73;
    }
}
