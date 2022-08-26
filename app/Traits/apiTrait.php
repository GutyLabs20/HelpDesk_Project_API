<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ApiTrait{

    //Funcion para modificar una consulta - scope
    public function scopeIncluded(Builder $query)
    {
        //Validando si la variable de la url existe o en la colección
        if (empty($this->allowIncluded) || empty(request('included'))) {
            return;
        }
        $relaciones = explode(',', request('included')); //['publicaciones','relaion2']
        $allowIncluded = collect($this->allowIncluded); //Convirtiendo en una colleción; función de php

        foreach ($relaciones as $key => $relacion) {
            //Validando el contenido en la colección
            if (!$allowIncluded->contains($relacion)) {
                unset($relaciones[$key]);
            }
        }

        $query->with($relaciones);
    }

    public function scopeFilter(Builder $query){
        //Validando si la variable de la url existe o en la colección
        if (empty($this->allowFilter) || empty(request('filter'))) {
            return;
        }
        $filtros = request('filter');
        $allowFilter = collect($this->allowFilter);

        foreach ($filtros as $filtro => $valor) {
            if ($allowFilter->contains($filtro)) {
                $query->where($filtro, 'LIKE', '%'.$valor.'%');
            }
        }
    }

    public function scopeSort(Builder $query){
        //Validando si la variable de la url existe o en la colección
        if (empty($this->allowSort) || empty(request('sort'))) {
            return;
        }
        $sortFields = explode(',', request('sort'));
        $allowSort = collect($this->allowSort);
        foreach ($sortFields as $sortField) {
            $direccion = 'asc';
            if (substr($sortField, 0, 1) == '-') {
                $direccion = 'desc';
                $sortField = substr($sortField, 1);
            }
            if ($allowSort->contains($sortField)) {
                $query->orderBy($sortField, $direccion);
            }
        }
    }

    public function scopeGetOrPaginate(Builder $query){
        if (request('perPage')) {
            $perPage = intval(request('perPage'));
            if ($perPage) {
                return $query->paginate($perPage);
            }
        }
        return $query->get();
    }

}
