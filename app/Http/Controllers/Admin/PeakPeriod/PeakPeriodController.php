<?php

namespace App\Http\Controllers\Admin\PeakPeriod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeakPeriod;
use App\Http\Helper;


class PeakPeriodController extends Controller
{
    	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('admin');
	}
	

	public function index() {
		$peak_periods = PeakPeriod::all();
		return view('admin.peak_period.index',compact('peak_periods'));
	}

	
	public function edit(Request $request,$id) {
		$peak_period = PeakPeriod::find($id);    
		return view('admin.peak_period.edit',compact('id','peak_period'));
	}

	public function update(Request $request,$id){
			
		$peak_period = PeakPeriod::find($id);
		// $this->validate($request, [
		// 	'code'      => 'required|unique:vouchers,code,'.$id,
		// 	'discount'  => 'required',
		// 	'type'    =>'required',

		// ]);
		$peak_period->start_date = Helper::getFDate($request->start_date);
        $peak_period->end_date = Helper::getFDate($request->end_date);
		$peak_period->discount = $request->discount;
		$peak_period->days_limit = $request->days_limit;
		$peak_period->save(); 
		return redirect('admin/peak_periods');
				
	}





	public function create(Request $request) {		
		return view('admin.peak_period.create');
	}
		
 


	public function store(Request $request) {

		$peak_period = new PeakPeriod();
		//VALIDATE NEW RECORDS
		// $this->validate($request, [
		// 	'code'      => 'required|unique:vouchers|max:150',
		// 	'type'      => 'required',
		// 	'discount'  => 'required',
		// ]);

		//dd($request->expiry);

		$peak_period->start_date = Helper::getFDate($request->start_date);
        $peak_period->end_date = Helper::getFDate($request->end_date);
		$peak_period->discount = $request->discount;
		$peak_period->days_limit = $request->days_limit;
		$peak_period->save(); 
		return redirect('admin/peak_periods');	
	}
		
	
	public function destroy(Request $request,$id) { 
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
		PeakPeriod::destroy($request->selected);
		return redirect()->back();
	
	}
}
