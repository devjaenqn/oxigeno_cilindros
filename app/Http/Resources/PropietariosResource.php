<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropietariosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $x = parent::toArray($request);
        $x['documento'] = $this->documento;
        $x['locaciones'] = $this->locaciones;
        return $x;

        // return [
        //     'name' => $this->nombre,
        //     'doc' => $this->documento
        // ];
    }
}
