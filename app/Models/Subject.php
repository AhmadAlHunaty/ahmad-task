<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Student;


class Subject extends Model
{
    protected $fillable = ['name', 'min_mark'];

    public function student(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)
            ->withTimestamps()
            ->withPivot(['mark'])
            ->as('subjectMark');
    }
}
