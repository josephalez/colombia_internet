<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fields extends Model
{
    protected $fillable=[
        "name",
        "type",
        "unit",
        "service_id",
        "trash",
    ];

    public static function storeData($service_id,$data){

        $data->service_id=$service_id;

        return Fields::create((array) $data);
    }
}
