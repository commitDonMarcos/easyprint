<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'useopr_projects';

    protected $fillable = [
        'session_id',
        'local_storage_key',
        'template_id',
        'project_name',
        'settings_json',
    ];

    protected $casts = [
        'settings_json' => 'array',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
