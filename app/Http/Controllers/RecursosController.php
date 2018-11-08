<?php

namespace App\Http\Controllers;

use App\Http\Resources\SistemaResource;
use App\Negocio;
use App\Sistema;
use Illuminate\Http\Request;

class RecursosController extends Controller
{

  public function sistemas () {
   	$sistemas = Sistema::with(['lote'])->get()->makeVisible(['lote']);

   	$sistemas = $sistemas->map( function($item) {
   		if ($item->lote != null)
        $item->lote->actual = fill_zeros($item->lote->actual);
   		return $item;
   	});
   	return response()->json($sistemas);
   }

   public function negocios () {
   	$negocios = Negocio::all();
   	$negocios->makeHidden(['comprobantes']);
    $negocios->map(function ($item) {
        $item->guias = $item->setDocumentosActivos('guia')->comprobantes;
        $item->setDefaultFilter();
        $item->guias->map(function ($g) {
            $g->actual = fill_zeros($g->actual);
            return $g;
        });
        return $item;
    });
    return response()->json($negocios);
   }
}
