<?php

namespace App\Http\Controllers;

use App\DocumentosIdentidad;
use App\Http\Resources\PropietariosResource;
use App\Propietarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
  public function news () {

    return view('home.news');
  }
  public function index () {
    //dd(Session::get('usuario_data')->toArray());
    return view('home.dashboard');
  }

  public function propietarios () {
    $documentos = DocumentosIdentidad::all();
    $data = [
      'documentos' => $documentos
    ];
    return view('home.propietarios', $data);
  }

  public function cilindros_listar () {

    return view('home.cilindros.listar');
  }
  public function cilindros_registro () {
    return view('home.cilindros.registro');
  }

  public function test () {
    $pro = Propietarios::all();
    $res = PropietariosResource::collection($pro);
    // dd($res);
    // dd($pro[0]->documento->toArray());
    return response()->json($res);
    // dd(new Propietarios);
  }

}
