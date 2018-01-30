<?php

use Illuminate\Database\Eloquent\Model;

class Inmueble extends Model {

   protected $table = 'inmuebles';
   public $timestamps = false;

}

class Grupo extends Model {

    protected $table = 'grupos';
    public $timestamps = false;

}