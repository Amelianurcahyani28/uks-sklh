<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'nis', 'class_name', 'gender'])]
class Student extends Model
{
    public function visits(): HasMany
    {
        return $this->hasMany(UksVisit::class);
    }
}
