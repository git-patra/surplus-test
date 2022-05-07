<?php

namespace App\Models\Filters\Interfaces;

use Illuminate\Http\Request;

interface FilterInterface {
    /**
     * Set filter query
     *
     * @param  Request  $request
     * @return void
     */
    public function setFilterQueries(Request $request): void;
}
