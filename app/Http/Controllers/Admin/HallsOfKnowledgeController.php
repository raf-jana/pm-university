<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use App\Models\HallsOfKnowledge;
use App\Http\Controllers\Controller;

class HallsOfKnowledgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hoks = HallsOfKnowledge::recent()
            ->get(HallsOfKnowledge::defaultAttributes([
                'created_at', 'published_at'
            ]));
        return view('admin.halls_of_knowledge.index', compact('hoks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.halls_of_knowledge.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        HallsOfKnowledge::create($this->_validateInput());
        $notification = $this->notification('Saved successfully', 'success');
        return redirect(route('hok'))->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hok = HallsOfKnowledge::find($id);
        return view('admin.halls_of_knowledge.edit', compact('hok'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $hok = HallsOfKnowledge::find($id);
        $hok->update($this->_validateInput());
        $notification = $this->notification('Saved successfully', 'success');
        return redirect(route('hok'))->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hok = HallsOfKnowledge::find($id);
        $hok->unpublish();
        $notification = $this->notification('Deleted successfully', 'success');
        return redirect(route('hok'))->with($notification);
    }

    private function _validateInput()
    {
        $data = $this->validate(request(), [
            'title' => 'required|max:150',
            'link' => 'url',
            'picture' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
        ]);
        if (request()->hasFile('picture'))
            $data['picture'] = request()->file('picture')->store('images', 'public');
        $filters = [
            'title' => 'strip_tags|trim|capitalize_first_letter',
            'link' => 'lowercase'
        ];
        return \Sanitizer::make($data, $filters)->sanitize();
    }
}
