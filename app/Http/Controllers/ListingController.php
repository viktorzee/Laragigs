<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    //show all listing
    public function index(){
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }
    //show single listing
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing
        ]);
    }
    
    // create new listing
    public function create(){
        return view('listings.create');
    }
    // create new listing
    public function store(Request $request){
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);
        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);
        return redirect('/')->with('message', 'Listing sucessfully created');
    }
    
    //show edit form
    public function edit(Listing $listing){
        return view('listings.edit', 
        ['listing' => $listing]
    );
}

    //update form
    public function update(Request $request, Listing $listing){
        //only user can edit
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized Action');
        }
        
        $formFields = $request->validate([
           'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);
        return redirect('/')->with('message', 'Listing sucessfully update');
        
    }

    //delete entry
    public function destroy(Listing $listing){
        //only logged in user can edit
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $listing->delete();
        return redirect('/',)->with('message', "Listing deleted sucessfully");
    }

    //manage listing
    public function manage()
    {
        # code...
        return view('listings.manage', 
        ['listings' => 
        auth()->user()->listings()->get()]);
    }
}
