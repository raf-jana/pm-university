<?php

namespace App\Http\Controllers\Admin;

use App\Models\Placement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlacementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $placements = Placement::recent()
            ->get(Placement::defaultAttributes(['created_at', 'published_at']));
        return view('admin.placements.index', compact('placements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.placements.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Placement::create($this->_validateInput());
        $notification = $this->notification('Saved successfully', 'success');
        return redirect(route('placements'))->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $placement = Placement::find($id);
        return view('admin.placements.edit', compact('placement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $placement = Placement::find($id);
        $placement->update($this->_validateInput());
        $notification = $this->notification('Saved successfully', 'success');
        return redirect(route('placements'))->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $placement = Placement::find($id);
        $placement->unpublish();
        $notification = $this->notification('Deleted successfully', 'success');
        return redirect(route('placements'))->with($notification);
    }

    private function _validateInput()
    {
        $data = $this->validate(request(), [
            'title' => 'required|max:150',
            'summary' => 'required',
            'link' => 'url',
            'picture' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
        ]);
        if (request()->hasFile('picture'))
            $data['picture'] = request()->file('picture')->store('images', 'public');
        $filters = [
            'title' => 'strip_tags|trim|capitalize_first_letter',
            'summary' => 'strip_tags|trim|capitalize_first_letter',
            'link' => 'lowercase'
        ];
        return \Sanitizer::make($data, $filters)->sanitize();
    }
}
