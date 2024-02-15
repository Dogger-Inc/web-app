<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class StaticViewController extends Controller
{
    public function homepage(): Response
    {
        return Inertia::render('Public/Index');
    }

    public function setLocale(string $locale): \Illuminate\Http\RedirectResponse
    {
        $availableLocales = ['en', 'fr', 'de', 'zh', 'ja', 'ru'];
        if (!in_array($locale, $availableLocales)) {
            abort(400);
        }

        session()->put('locale', $locale);

        return redirect()->back();
    }
}
