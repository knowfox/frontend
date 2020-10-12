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
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Knowfox\Core\Models\Concept;
use Knowfox\Core\Resources\Concept as ConceptResource;
use Knowfox\Core\Requests\ConceptRequest;
use Knowfox\Core\Actions\ConceptAction;
use Knowfox\Core\Services\PictureService;
use Knowfox\Crud\Services\Crud;

class ConceptController extends Controller
{
    protected $crud;
    protected $activity;

    public function __construct(Crud $crud, ConceptAction $action)
    {
        $this->crud = $crud;
        $this->crud->setup('frontend.concept');
        $this->action = $action;
    }

    public function toplevel(Request $request)
    {
        return $this->index($request, 'toplevel');
    }

    public function flagged(Request $request)
    {
        return $this->index($request, 'flagged');
    }

    public function popular(Request $request)
    {
        return $this->index($request, 'popular');
    }

    public function shares(Request $request)
    {
        return $this->index($request, 'shares');
    }

    public function shared(Request $request)
    {
        return $this->index($request, 'shared');
    }

    public function index(Request $request, $special = false)
    {
        return $this->crud->index($request, 
            $this->action->index($request, $special),
            function ($request, $entities) {
                return $this->action->postProcess($request, $entities);
            }
        );
    }

    public function show(Request $request, Concept $concept)
    {
        $this->authorize('view', $concept);
        $concept->load('related', 'inverseRelated', 'tagged', 'shares', 'parent');

        $theme = config('crud.theme');

        $view_name = 'frontend::uikit3.concept.show';
        if ($concept->type != 'concept') {

            $view_name = "frontend::{$theme}.concept.show";

            $scoped_type = preg_split('/:\s*/', $concept->type, 2);
            if (count($scoped_type) == 1) {
                $type = $scoped_type[0];
            }
            else {
                $package = $scoped_type[0];
                $type = $scoped_type[1];
                $view_name = $package . "::{$theme}.show";
            }

            $suffix = '-' . preg_replace('/\W+/', '-', $type);
            if (View::exists($view_name . $suffix)) {
                $view_name .= $suffix;
            }
        }

        $concept->viewed_at = strftime('%Y-%m-%d %H:%M:%S');
        $concept->viewed_count += 1;
        $concept->timestamps = false;
        $concept->save();

        /** @var Paginator $siblings */
        $siblings = $concept
            ->siblings()
            ->where('owner_id', Auth::id());

        $parent_sort = isset($concept->parent->config->sort)
            ? $concept->parent->config->sort
            : null;

        return view($view_name, [
            'page_title' => $concept->title,
            'uuid' => $concept->uuid,
            'theme' => $theme,
            'concept' => $concept,
            'is_owner' => $concept->owner_id == $request->user()->id,
            'can_update' => $request->user()->can('update', $concept),
            'siblings' => $concept->getPaginated(
                $siblings,
                $parent_sort,
                $request->letter,
                [ null, ['*'], 'spage' ]
            )
        ]);
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

