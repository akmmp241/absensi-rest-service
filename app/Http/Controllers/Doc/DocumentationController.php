<?php

namespace App\Http\Controllers\Doc;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function get(): JsonResponse
    {
        $file = base_path('docs/API-Spec.json');
        $content = file_get_contents($file);
        return response()->json(json_decode($content));
    }
}
