<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserPreferenceController extends Controller
{
    /**
     * Update the user's theme preference.
     */
    public function updateTheme(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'required|in:light,dark,system',
            'accent_color' => 'nullable|string|max:50',
        ]);

        $user = auth()->user();
        $user->theme = $validated['theme'];
        if (isset($validated['accent_color'])) {
            $user->accent_color = $validated['accent_color'];
        }
        $user->save();

        return back()->with('success', 'Theme preference updated.');
    }

    /**
     * Update the user's accent color.
     */
    public function updateAccentColor(Request $request)
    {
        $validated = $request->validate([
            'accent_color' => 'nullable|string|max:50',
        ]);

        $user = auth()->user();
        $user->accent_color = $validated['accent_color'];
        $user->save();

        return back()->with('success', 'Accent color updated.');
    }
}
