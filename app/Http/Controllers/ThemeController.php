<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetRecordsRequest;
use App\Models\Theme;
use App\Repositories\ThemeRepository;
use Illuminate\Http\JsonResponse;

class ThemeController extends Controller
{

    public function __construct(
        protected ThemeRepository $themeRepository
    )
    {
    }

    public function handleGetThemes(GetRecordsRequest $request): JsonResponse
    {
        $data = $request->validated();

        return response()->json([
            'themes' => $this->themeRepository->getThemes($data),
        ]);
    }

    public function handleGetTheme(string $slug): JsonResponse
    {
        $theme = Theme::query()->where('slug', $slug);

        return response()->json([
            'theme' => $theme
        ]);
    }

}
