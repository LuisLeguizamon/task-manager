<?php

namespace App\Http\Controllers;

use App\Services\Priority\UpdatePriority;
use Illuminate\Http\Request;

class PriorityTaskController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        app(UpdatePriority::class)->execute($request);

        return ["error" => false];
    }

}
