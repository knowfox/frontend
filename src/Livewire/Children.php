<?php

namespace Knowfox\Frontend\Livewire;

use Illuminate\Http\Request;

use Livewire\Component;
use Livewire\WithPagination;
use Knowfox\Core\Models\Concept;

class Children extends Component
{
    use WithPagination;

    public Concept $concept;
    
    public function render(Request $request)
    {
        $sort = isset($this->concept->config->sort)
            ? $this->concept->config->sort
            : null;

        $children = $this->concept->getPaginated(
            $this->concept->children(),
            $sort,
            $request->letter
        );

        return view('frontend::livewire.children', ['children' => $children]);
    }
}
