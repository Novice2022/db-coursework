<?php

namespace App\Http\Controllers;

use App\Models\FinesModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class FinesController {
    public function store(): Response {
        return new Response('coming soon', 200);
    }

    public function update(string $id): RedirectResponse {
        FinesModel::find($id) -> update([
            'payed_at' => now()
        ]);

        return back();
    }
}