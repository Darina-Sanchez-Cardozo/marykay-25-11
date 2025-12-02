<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class AdminConsultoraController extends Controller
{
    // Vista única
    public function panel($id = null)
    {
        $consultoras = Persona::where('rol', 'consultora')->get();

        // Si viene un ID, obtenemos esa consultora
        $detalle = $id ? Persona::find($id) : null;

        return view('admin.consultoras.panel', compact('consultoras', 'detalle'));
    }

    // Eliminar consultora
    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->delete();

        return redirect()->route('admin.consultoras.panel')
            ->with('success', 'Consultora eliminada correctamente.');
    }
}
