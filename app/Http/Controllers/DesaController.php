<?php

// app/Http/Controllers/DesaController.php
namespace App\Http\Controllers;

use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravolt\Indonesia\Models\Village;

class DesaController extends Controller
{
    public function index()
    {
        return Village::all();
    }

    public function show($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid ID'], 400);
        }
        return Village::findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district_code' => 'required|integer',
        ]);

        return Village::create($request->all());
    }

    public function update(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid ID'], 400);
        }
        $desa = Village::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'district_code' => 'required|integer',
        ]);

        $desa->update($request->all());

        return $desa;
    }

    public function destroy($id)
    {
        Log::info('Attempting to delete village with ID: ' . $id);

        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid ID'], 400);
        }

        $desa = Village::find($id);

        if (!$desa) {
            Log::error('Village not found with ID: ' . $id);
            return response()->json(['error' => 'Data not found'], 404);
        }

        $desa->delete();

        Log::info('Successfully deleted village with ID: ' . $id);

        return response()->json(['message'=>'Data Berhasil DiHapus']);
    }
}

