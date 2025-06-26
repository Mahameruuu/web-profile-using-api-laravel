<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kegiatan;
use App\Models\DynamicInput;
use Illuminate\Http\JsonResponse;
use Exception;

class DashboardController extends Controller
{
    public function summary(): JsonResponse
    {
        try {
            return response()->json([
                'users' => User::count(),
                'kegiatan' => Kegiatan::count(),
                'fitur' => DynamicInput::count(),
                'user_items' => User::select('created_at')->get(),
                'kegiatan_items' => Kegiatan::select('created_at')->get(),
                'fitur_items' => DynamicInput::select('created_at')->get(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Gagal mengambil data summary.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
