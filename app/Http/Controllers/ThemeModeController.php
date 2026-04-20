<?php

namespace App\Http\Controllers;

use App\Models\ThemeMode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ThemeModeController extends Controller
{
    public function index()
    {
        $themeModes = ThemeMode::query()->orderBy('sort_order')->paginate(15);

        return view('admin.theme-modes.index', compact('themeModes'));
    }

    public function create()
    {
        return view('admin.theme-modes.form');
    }

    public function store(Request $request)
    {
        ThemeMode::create($this->validatedThemePayload($request));

        return redirect()->route('admin.theme-modes.index')->with('success', 'Mode tema berhasil ditambahkan.');
    }

    public function edit(ThemeMode $theme_mode)
    {
        return view('admin.theme-modes.form', ['themeMode' => $theme_mode]);
    }

    public function update(Request $request, ThemeMode $theme_mode)
    {
        $theme_mode->update($this->validatedThemePayload($request, $theme_mode->id));

        return redirect()->route('admin.theme-modes.index')->with('success', 'Mode tema berhasil diperbarui.');
    }

    public function destroy(ThemeMode $theme_mode)
    {
        $theme_mode->delete();

        return redirect()->route('admin.theme-modes.index')->with('success', 'Mode tema dihapus. Pengguna yang memakai tema ini akan kembali ke tema default.');
    }

    private function validatedThemePayload(Request $request, ?int $ignoreId = null): array
    {
        $slugRule = Rule::unique('ar_theme_modes', 'slug');
        if ($ignoreId) {
            $slugRule = $slugRule->ignore($ignoreId);
        }

        $validated = $request->validate([
            'slug' => ['required', 'string', 'max:64', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slugRule],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
            'is_active' => ['required', 'in:0,1'],
            'is_user_selectable' => ['required', 'in:0,1'],
            'css_tokens' => ['nullable', 'string'],
        ]);

        $cssTokens = $this->parseCssTokens($request->input('css_tokens'));

        return [
            'slug' => $validated['slug'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'sort_order' => (int) $validated['sort_order'],
            'is_active' => (bool) (int) $validated['is_active'],
            'is_user_selectable' => (bool) (int) $validated['is_user_selectable'],
            'css_tokens' => $cssTokens,
        ];
    }

    private function parseCssTokens(?string $tokensRaw): ?array
    {
        if (! is_string($tokensRaw) || trim($tokensRaw) === '') {
            return null;
        }

        $decoded = json_decode($tokensRaw, true);
        if (! is_array($decoded)) {
            throw ValidationException::withMessages([
                'css_tokens' => ['Isi harus JSON objek valid, contoh: {"--bg-body":"#0a0a0a","--text-primary":"#e5e5e5"}'],
            ]);
        }

        foreach ($decoded as $key => $value) {
            if (! is_string($key) || ! preg_match('/^--[a-zA-Z0-9_-]+$/', $key)) {
                throw ValidationException::withMessages([
                    'css_tokens' => ['Kunci harus nama properti CSS custom yang valid (misalnya --bg-body).'],
                ]);
            }
            if (! is_string($value)) {
                throw ValidationException::withMessages([
                    'css_tokens' => ['Nilai untuk '.$key.' harus berupa string.'],
                ]);
            }
            if (preg_match('/[;{}<>`]/u', $value)) {
                throw ValidationException::withMessages([
                    'css_tokens' => ['Nilai tema tidak boleh mengandung karakter ; { } < > `'],
                ]);
            }
        }

        return $decoded;
    }
}
