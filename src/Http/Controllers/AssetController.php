<?php

namespace Jakyeru\LaravelShell\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AssetController extends Controller
{
    /**
     * Serve the asset.
     */
    public function serve(Request $request, string $asset): BinaryFileResponse
    {
        if (! file_exists($path = __DIR__ . "/../../resources/css/{$asset}") && ! file_exists($path = __DIR__ . "/../../resources/js/{$asset}")) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => str_ends_with($asset, '.css') ? 'text/css' : 'application/javascript',
        ]);
    }
}