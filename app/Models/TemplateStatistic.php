<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateStatistic extends Model
{
    protected $fillable = [
        'template_id',
        'selection_count',
        'docx_export_count',
        'pdf_export_count',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
