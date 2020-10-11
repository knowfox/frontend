<?php
/**
 * Knowfox - Personal Knowledge Management
 * Copyright (C) 2017 .. 2019  Olav Schettler
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace Knowfox\Frontend\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Knowfox\Core\Models\Concept;
use Knowfox\Core\Resources\Concept as ConceptResource;
use Knowfox\Core\Requests\ConceptRequest;
use Knowfox\Core\Activities\ConceptActivity;
use Knowfox\Core\Services\PictureService;
use Knowfox\Crud\Services\Crud;

class ConceptController extends Controller
{
    protected $crud;
    protected $activity;

    public function __construct(Crud $crud, ConceptActivity $activity)
    {
        $this->crud = $crud;
        $this->crud->setup('frontend.concept');
        $this->activity = $activity;
    }

    public function index(Request $request, $special = false)
    {
        return view('frontend::concept.index', ['concepts' => $activity->index($request, 'index')]);
    }

    public function create()
    {
        return $this->crud->create();
    }

    public function create()
    {
        return $this->crud->create();
    }

    public function store(ConceptRequest $request)
    {
        list($concept, $response) = $this->crud->store($request);
        return $response;
    }

    public function edit(Concept $concept)
    {
        return $this->crud->edit($concept);
    }

    public function update(ConceptRequest $request, Concept $concept)
    {
        return $this->crud->update($request, $concept);
    }

    public function destroy(Link $concept)
    {
        return $this->crud->destroy($concept);
    }
}

