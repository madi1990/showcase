<?php

namespace App\Http\Controllers\Api\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model{
	const CREATED_AT = false;
    const UPDATED_AT = 'updated_time';
	protected $table = 'pet';
	protected $primaryKey = 'id';
}