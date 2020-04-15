<?php

use App\Http\Controllers\Filters\UserFilters;

class ClassName extends AnotherClass
{
    public function index(Request $request) {
        $user = (new User)->newQuery();

        // check var exist in the query string
        if ($request->exists('name')) { }

        // check var exist with the val
        if ($request->has('name')) { }

        return $user;
    }

    public function index1(UserFilters $filters) {
        return User::filter($filters)->get();
    }

    public function store()
    {
        // validate
        $rules = array(
            'name'       => 'required',
            'email'      => 'required|email',
            'level' => 'required|numeric'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('nerds/create')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            // store

            // redirect
            Session::flash('message', 'Successfully created records!');
            return Redirect::to('nerds');
        }
    }

    public function show($id)
    {
        // get the nerd
        $nerd = Nerd::find($id);

        // show the view and pass the nerd to it
        return View::make('nerds.show')->with('nerd', $nerd);
    }

    public function edit($id)
    {
        // get the nerd
        $nerd = Nerd::find($id);

        // show the edit form and pass the nerd
        return View::make('nerds.edit')
            ->with('nerd', $nerd);
    }

    public function update($id)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
            'email'      => 'required|email',
            'nerd_level' => 'required|numeric'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('nerds/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $nerd = Nerd::find($id);
            $nerd->name       = Input::get('name');
            $nerd->email      = Input::get('email');
            $nerd->nerd_level = Input::get('nerd_level');
            $nerd->save();

            // redirect
            Session::flash('message', 'Successfully updated nerd!');
            return Redirect::to('nerds');
        }
    }

    public function destroy($id)
    {
        // delete
        $nerd = Nerd::find($id);
        $nerd->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the nerd!');
        return Redirect::to('nerds');
    }
}
