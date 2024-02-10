<?php

namespace App\Http\Controllers\Admin\Rooms;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomsController extends Controller
{


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Apartment::find($id);
        $delete->delete();
        return response()->json([], 200);
    }
}
