<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $categorias = DB::table('categorias')
        $categorias = Categoria::included()
            ->filter()
            ->sort()
            ->getOrPaginate()
            ->where('activo', '1');
        return CategoriaResource::collection($categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'required|max:255',
            'slug' => 'required|max:255|unique:categorias'
        ]);
        $categoria = Categoria::create($request->all());

        return CategoriaResource::make($categoria);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoria = Categoria::included()->findOrFail($id);
        return CategoriaResource::make($categoria);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'required|max:255',
            'slug' => 'required|max:255|unique:categorias,slug,'. $categoria->id
        ]);
        $categoria->update($request->all());

        return CategoriaResource::make($categoria);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->activo = '0';
        $categoria->save();
        return CategoriaResource::make($categoria);
    }
}
