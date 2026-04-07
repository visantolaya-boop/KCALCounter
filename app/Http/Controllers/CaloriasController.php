<?php

namespace App\Http\Controllers;

use App\Models\Alimento;
use App\Models\Consumo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class CaloriasController extends Controller
{
    public function index(Request $request)
    {
        $fecha = $request->get('fecha', Carbon::today()->toDateString());
        $user = auth()->user();

        $consumos = Consumo::with('alimento')
            ->where('user_id', $user->id)
            ->where('fecha', $fecha)
            ->orderBy('comida_numero')
            ->orderBy('created_at')
            ->get();

        $alimentos = Alimento::all();

        // Calcular totales por comida y día
        $totalesComidas = [];
        $totalDia = ['kcal' => 0, 'proteinas' => 0, 'carbohidratos' => 0, 'grasas' => 0];

        for ($i = 1; $i <= 5; $i++) {
            $comida = $consumos->where('comida_numero', $i);
            $totalesComidas[$i] = ['kcal' => 0, 'proteinas' => 0, 'carbohidratos' => 0, 'grasas' => 0];
            foreach ($comida as $consumo) {
                $factor = $consumo->gramos / 100;
                $totalesComidas[$i]['kcal'] += $consumo->alimento->kcal_100g * $factor;
                $totalesComidas[$i]['proteinas'] += $consumo->alimento->proteinas_100g * $factor;
                $totalesComidas[$i]['carbohidratos'] += $consumo->alimento->carbohidratos_100g * $factor;
                $totalesComidas[$i]['grasas'] += $consumo->alimento->grasas_100g * $factor;
            }
            $totalDia['kcal'] += $totalesComidas[$i]['kcal'];
            $totalDia['proteinas'] += $totalesComidas[$i]['proteinas'];
            $totalDia['carbohidratos'] += $totalesComidas[$i]['carbohidratos'];
            $totalDia['grasas'] += $totalesComidas[$i]['grasas'];
        }

        return Inertia::render('Calorias/Index', [
            'consumos' => $consumos,
            'alimentos' => $alimentos,
            'fecha' => $fecha,
            'totalesComidas' => $totalesComidas,
            'totalDia' => $totalDia,
            'objetivoCalorias' => $user->calorias_objetivo,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'alimento_id' => 'required|exists:alimentos,id',
            'comida_numero' => 'required|integer|min:1|max:5',
            'gramos' => 'required|numeric|min:0',
            'fecha' => 'required|date',
        ]);

        Consumo::create([
            'user_id' => auth()->id(),
            'alimento_id' => $request->alimento_id,
            'comida_numero' => $request->comida_numero,
            'gramos' => $request->gramos,
            'fecha' => $request->fecha,
        ]);

        return redirect()->back();
    }

    public function destroy(Consumo $consumo)
    {
        if ($consumo->user_id !== auth()->id()) {
            abort(403);
        }

        $consumo->delete();

        return redirect()->back();
    }

    public function alimentos()
    {
        $alimentos = Alimento::all();
        return Inertia::render('Calorias/Alimentos', [
            'alimentos' => $alimentos,
        ]);
    }

    public function storeAlimento(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'kcal_100g' => 'required|numeric|min:0',
            'proteinas_100g' => 'required|numeric|min:0',
            'carbohidratos_100g' => 'required|numeric|min:0',
            'grasas_100g' => 'required|numeric|min:0',
        ]);

        Alimento::create($request->all());

        return redirect()->back();
    }

    public function updateAlimento(Request $request, Alimento $alimento)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'kcal_100g' => 'required|numeric|min:0',
            'proteinas_100g' => 'required|numeric|min:0',
            'carbohidratos_100g' => 'required|numeric|min:0',
            'grasas_100g' => 'required|numeric|min:0',
        ]);

        $alimento->update($request->all());

        return redirect()->back();
    }

    public function destroyAlimento(Alimento $alimento)
    {
        $alimento->delete();

        return redirect()->back();
    }

    public function historial()
    {
        $user = auth()->user();
        $currentMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $fechas = Consumo::where('user_id', $user->id)
            ->whereBetween('fecha', [$currentMonth, $endOfMonth])
            ->select('fecha')
            ->distinct()
            ->orderBy('fecha')
            ->pluck('fecha');

        return Inertia::render('Calorias/Historial', [
            'fechas' => $fechas,
        ]);
    }

    public function updateObjetivo(Request $request)
    {
        $request->validate([
            'calorias_objetivo' => 'required|integer|min:500|max:10000',
        ]);

        auth()->user()->update(['calorias_objetivo' => $request->calorias_objetivo]);

        return back();
    }
}
