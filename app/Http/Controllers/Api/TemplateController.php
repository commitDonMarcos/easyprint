<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TemplateResource;
use App\Models\Template;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TemplateController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return TemplateResource::collection(Template::all());
    }

    public function show(Template $template): TemplateResource
    {
        return new TemplateResource($template);
    }
}
