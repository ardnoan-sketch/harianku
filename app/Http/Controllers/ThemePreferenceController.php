<?php

namespace App\Http\Controllers;

use App\Models\ThemeMode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ThemePreferenceController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'theme_mode_id' => [
                'required',
                'integer',
                Rule::exists('ar_theme_modes', 'id')->where(function ($q) {
                    $q->where('is_active', true)->where('is_user_selectable', true);
                }),
            ],
        ]);

        $request->user()->update(['theme_mode_id' => $validated['theme_mode_id']]);

        return back()->with('success', 'Tema berhasil diperbarui.');
    }
}
