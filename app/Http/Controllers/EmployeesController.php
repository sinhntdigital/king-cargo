<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Resource;
    use Illuminate\Http\Request;
    
    /**
     * Class EmployeesController
     * @package App\Http\Controllers
     */
    class EmployeesController extends Controller {
        
        /**
         * Get list employee.
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
         */
        public function index(Request $request) {
            try {
                if($request->wantsJson()) {
                    $employees = Resource::whereClass('employee')->orderBy('created_at', 'DESC')->get();
                    return response()->json(['data' => $employees], 200);
                } else {
                    return view('backend.employee.index');
                }
            } catch(\Exception $ex) {
                if($request->wantsJson()) return response()->json(['error' => $ex->getMessage()], 200);
                else abort(500);
            }
        }
        
    }
