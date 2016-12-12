<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tours extends Model
{
    protected $table = 'tours';
    const CREATED_AT = 'creation_date';
}
