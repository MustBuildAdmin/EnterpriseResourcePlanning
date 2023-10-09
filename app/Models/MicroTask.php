<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class MicroTask extends Model
{
    protected $table = 'micro_tasks';
    use HasFactory, Searchable;

    public function toSearchableArray()
    {
        return [
            'task_id' => $this->id,
            'text' => $this->text
        ];
    }
}
