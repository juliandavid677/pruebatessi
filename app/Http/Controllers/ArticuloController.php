<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;
use App\Categoria;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use DB;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos=DB::table('articulos as a')
        ->join('categorias as c','a.categoria_id','=','c.id')
        ->select('a.id','a.categoria_id','a.numero_registro','a.nombre_articulo','a.cantidad','c.nombre_categoria as categoria')->get();
        
        $categorias=DB::table('categorias')
            ->select('id','nombre_categoria')->get(); 
            return $productos;
            // return [$productos, $categorias];
            // return view('index',["articulos"=>$productos,"categorias"=>$categorias]);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $articulo = new Articulo();
        $articulo->numero_registro = $request->numero_registro;
        $articulo->nombre_articulo = $request->nombre_articulo;
        $articulo->cantidad = $request->cantidad;
        $articulo->categoria_id = $request->categoria_id;
        $articulo->save();
        
        return $articulo;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $articulo = Articulo::find($id);
        $articulo->numero_registro = $request->numero_registro;
        $articulo->nombre_articulo = $request->nombre_articulo;
        $articulo->cantidad = $request->cantidad;
        $articulo->categoria_id = $request->categoria_id;
        $articulo->save();
        return $articulo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $articulo = Articulo::find($id);
        $articulo->delete();
    }
}
