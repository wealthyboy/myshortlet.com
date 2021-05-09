<?php

namespace App\Http\Controllers\Admin\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Service;
use App\Models\User;


class ServicesController extends Controller
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
        $services =  Service::orderBy('name','asc')->get();
        return view('admin.services.index',compact('services'));
	}
	

	 public function create()
    {   
		User::canTakeAction(2);
		return view('admin.services.create');
    }
	
	public function store(Request $request)
    {   
		$this->validate($request, [
			'name' => 'required|unique:services',
		]);

        $services = new Service;
        $services->name  = $request->name;
        $services->price  = $request->price;
        $services->save();	

		return redirect()->route('services.index') ; 
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
		Service::destroy($request->selected);  	
		return redirect()->back();
    		 
	}
}
