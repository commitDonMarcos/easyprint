<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TemplateResource;
use App\Models\Template;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class TemplateController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        try {
            return TemplateResource::collection(Template::all());
        } catch (\Throwable $e) {
            Log::error('Template index error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    public function show(Template $template): TemplateResource
    {
        return new TemplateResource($template);
    }
}
