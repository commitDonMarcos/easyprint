<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'session_id' => $this->session_id,
            'local_storage_key' => $this->local_storage_key,
            'template_id' => $this->template_id,
            'project_name' => $this->project_name,
            'settings_json' => $this->settings_json,
            'template' => new TemplateResource($this->whenLoaded('template')),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
