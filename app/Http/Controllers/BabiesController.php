<?php

namespace App\Http\Controllers;

use App\Babies;
use Illuminate\Http\Request;

class BabiesController extends Controller
{
    // To make auth necessary for everything with babies
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $babies = auth()->user()->babies;

        return view('babies.index', compact('babies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('babies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $this->validateBaby();

        $validated['user_id'] = auth()->id();

        $baby = Babies::create($validated);

        // request()->validate([
        //     'name' => 'required'
        // ]);

        return redirect('/babies');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Babies  $babies
     * @return \Illuminate\Http\Response
     */
    public function show(Babies $baby)
    {
        $user = auth()->user();

        // dd($user);
        // Check to see if the user is the parent of the baby
        $this->authorize('view', $baby);

        return view('babies.show', compact('baby'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Babies  $babies
     * @return \Illuminate\Http\Response
     */
    public function edit(Babies $babies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Babies  $babies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Babies $babies)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Babies  $babies
     * @return \Illuminate\Http\Response
     */
    public function destroy(Babies $babies)
    {
        //
    }

    /**
     * Validate the form submission for creating babies
     * 
     * 
     */
    protected function validateBaby() {
        return request()->validate([
            'name' => ['required', 'min:1'],
            'age' => ['required', 'min:1'],
            'gender' => ['required']
        ]);
    }
}
