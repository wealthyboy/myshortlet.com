<?php

namespace App\Http\Controllers\Admin\Requirements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requirement;
use App\Models\User;


class RequirementsController extends Controller
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
        $requirements =  Requirement::orderBy('name','asc')->get();
        return view('admin.requirements.index',compact('requirements'));
	}
	

	 public function create()
    {   
		User::canTakeAction(2);
		return view('admin.requirements.create');
    }
	
	public function store(Request $request)
    {   
		$this->validate($request, [
			'name' => 'required|unique:requirements',
		]);
        $requirements = new Requirement;
        $requirements->name  = $request->name;
        $requirements->save();	
		return redirect()->route('requirements.index') ; 
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
		Requirement::destroy($request->selected);  	
		return redirect()->back();
    		 
	}
}
