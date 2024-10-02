<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecondDatabaseModel extends Model
{
    protected $connection = 'sqlite_second';
}
