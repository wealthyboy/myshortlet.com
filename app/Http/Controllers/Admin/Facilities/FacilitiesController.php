<?php

namespace App\Http\Controllers\Admin\Facilities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Facility;
use App\Models\User;

class FacilitiesController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


    public function index()
    {    
        $facilities =  Facility::orderBy('name','asc')->get();
        return view('admin.facilities.index',compact('facilities'));
	}
	

	 public function create()
    {   
		User::canTakeAction(2);
		return view('admin.facilities.create');
    }
	
	public function store(Request $request)
    {   
		$this->validate($request, [
			'name' => 'required|unique:facilities',

		]);
        $facilities = new Facility;
        $facilities->name  = $request->name;
        $facilities->save();	
		return redirect()->route('facilities.index') ; 
	}
	
	
	public function edit(Request $request ,$id)
    {   

	}
	
	
	public function destroy(Request $request,$id)
    {     
		User::canTakeAction(5);
		$rules = array(
				'_token' => 'required',
		);
		$validator = \Validator::make($request->all(),$rules);
		if ( empty ( $request->selected)) {
			$validator->getMessageBag()->add('Selected', 'Nothing to Delete');
			return \Redirect::back()
			->withErrors($validator)
			->withInput();
		}
		Facility::destroy($request->selected);  	
		return redirect()->back();
    		 
	}
}
