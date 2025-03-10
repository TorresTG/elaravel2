<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use App\Models\Editorial;
use App\Models\EventoLiterario;
use App\Models\Lector;
use App\Models\Libreria;
use App\Models\Libro;
use App\Models\ParticipacionEvento;
use App\Models\Prestamo;
use App\Models\Publicacion;
use App\Models\Resena;
use App\Models\Inventario;
use App\Models\Token;

//Validaciones
use Illuminate\Support\Facades\Validator;
use Database\Seeders\DatabaseSeeder;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Faker\Factory;
use Faker\Factory as Faker;

class LibroController extends Controller
{
    ///////////////////////////////////////////////////////////////////////////////
    public function indexLibrerías()
    {
        $Librerias = Libreria::all();
        return response()->json([
            'Librerias' => $Librerias,
        ]); 
    }
    public function storeLibrerías(Request $request)
    {
        $Libreria = Libreria::create([
            'nombre' => $request->input('nombre'),
            'ubucacion' => $request->input('ubucacion'),
        ]);
        return response()->json([
            'Libreria' => $Libreria,
        ]);
    }
    public function showLibrerías($id)
    {
        $Libreria = Libreria::find($id);
        return response()->json([
            'Libreria' => $Libreria,
        ]);
    }
    public function updateLibrerías(Request $request, Libreria $libreria)
    {

        $libreria->update([
            'nombre' => $request->input('nombre'),
            'ubucacion' => $request->input('ubucacion'),
        ]);
        return response()->json([
            'Libreria' => $libreria,
        ]);
    }
    public function destroyLibrerías($id)
    {

        Libreria::destroy($id);
        return response()->json([
            'message' => 'Librería eliminado exitosamente',
        ], 204);
    }
    ///////////////////////////////////////////////////////////////////////////////

}
