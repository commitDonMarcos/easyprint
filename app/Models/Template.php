<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_free',
        'preview_image',
        'json_structure',
    ];

    protected $casts = [
        'json_structure' => 'array',
        'is_free' => 'boolean',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function usageLogs()
    {
        return $this->hasMany(UsageLog::class);
    }

    public function statistics()
    {
        return $this->hasMany(TemplateStatistic::class);
    }
}
