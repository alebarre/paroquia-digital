<?php

namespace App\Http\Controllers;

use App\Models\Fiel;
use App\Models\Sacramento;
use App\Models\Grupo;
use App\Models\Evento;
use App\Models\Financa;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalFieis = Fiel::where('status', 'ativo')->count();
        $totalGrupos = Grupo::where('ativo', true)->count();
        $sacramentosMes = Sacramento::whereMonth('data', now()->month)->count();
        $totalEntradas = Financa::entradas()->whereMonth('data', now()->month)->sum('valor');
        $totalSaidas = Financa::saidas()->whereMonth('data', now()->month)->sum('valor');
        $saldo = $totalEntradas - $totalSaidas;

        $proximosEventos = Evento::where('data_inicio', '>=', now())
            ->orderBy('data_inicio')
            ->limit(5)
            ->get();

        // Aniversariantes desta semana (SQLite compatible)
        $hoje = now()->format('m-d');
        $fimSemana = now()->addDays(7)->format('m-d');
        $aniversariantes = Fiel::where('status', 'ativo')
            ->whereNotNull('data_nascimento')
            ->get()
            ->filter(function ($fiel) {
            $aniv = $fiel->data_nascimento->format('m-d');
            $hoje = now()->format('m-d');
            $fim = now()->addDays(7)->format('m-d');
            return $aniv >= $hoje && $aniv <= $fim;
        })->take(10);

        $sacramentosPorTipo = Sacramento::selectRaw('tipo, count(*) as total')
            ->groupBy('tipo')
            ->pluck('total', 'tipo');

        return view('dashboard', compact(
            'totalFieis', 'totalGrupos', 'sacramentosMes',
            'totalEntradas', 'totalSaidas', 'saldo',
            'proximosEventos', 'aniversariantes', 'sacramentosPorTipo'
        ));
    }
}