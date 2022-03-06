<?php
    
    namespace App\Http\Controllers\Admin;
    
    use App\Furnitures;
    use App\Models\Category;
    use App\Models\User;
    use App\Positions;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\DB;
    
    class PositionController extends Controller
    {
        public function index(Request $request)
        {
            $positions = Positions::query()->get();
            $user = User::query()->get();
            
            return view('admin.position')->with([
                'positions' => $positions,
                'user' => $user
            ]);
        }
        
        public function create(Request $request)
        {
            $validate = $this->validate($request, [
                'positionType' => 'required',
                'name' => 'required'
            ]);
            $positions = Positions::create([
                'type' => $request->post('positionType'),
                'name' => $request->post('name')
            ]);
            
            return back();
        }
        
        public function edit($id)
        {
            $position = Positions::query()
                ->select("positions.*")
                ->where('id', $id)
                ->first();
            
            $positionAll = Positions::query()
                ->select("positions.*")
                ->get();
            return view('admin.positionedit', [
                'position' => $position,
                'positionAll' => $positionAll
            ]);
        }
        
        public function update(Request $request)
        {
            
            $this->validate($request, [
                'positionname' => 'required'
            ]);
            
            $positionId = $request->post('position_id');
            
            $position = Positions::find($positionId);
            $position->name = $request->post('positionname');
            $position->type = $request->post('positiontype');
            
            $position->save();
            return back();
        }
        
        public function deleteFinally(Request $request, $id)
        {
            
            if($request->get('selectPosition') === '0'){
                $this->validate($request, [
                    'selectPosition' => 'required'
                ]);
            }
            
            $selectedPosition = $request->get('selectPosition');
    
           
           
            if ($selectedPosition > 0) {
                DB::table('users')->where('position', $id)->update(['position' => $selectedPosition]);
                $position = Positions::find($id);
                $position->delete();
            }else if($selectedPosition == null) {
                $position = Positions::find($id);
                $position->delete();
            }
            
            return back();
        }
    }
