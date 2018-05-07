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
        
        /**
         * Get employee info.
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function show(Request $request, $id) {
            try {
                $employee = Resource::find($id);
                if(empty($employee)) return response()->json(['error' => 'Cannot find employee'], 200);
                return response()->json(['success' => $employee], 200);
            } catch(\Exception $ex) {
                return response()->json(['error' => $ex->getMessage()], 200);
            }
        }
        
        /**
         * Store employee.
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function store(Request $request) {
            try {
                $input          = $request->all();
                $input['id']    = \Helpers::generateId();
                $input['class'] = 'employee';
                //                $input['creator_id'] = \Auth::user()->id;
                $employee = Resource::create($input);
                if(!empty($employee))
                    return response()->json(['success' => __('New employee had been created.')], 200);
                else
                    return response()->json(['error' => 'System error, please contact administrator.'], 200);
            } catch(\Exception $ex) {
                return response()->json(['error' => $ex->getMessage()], 200);
            }
        }
        
        /**
         * Update employee info.
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function update (Request $request, $id) {
            try {
                $employee = Resource::find($id);
                if(empty($employee)) return response()->json(['error' => 'Cannot find employee'], 200);
                $input = $request->all();
                $employee->update($input);
                return response()->json(['success' => ''], 200);
            } catch (\Exception $ex) {
                return response()->json(['error' => $ex->getMessage()], 200);
            }
        }
        
        /**
         * Destroy employee.
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function destroy (Request $request, $id) {
            try {
                $employee = Resource::find($id);
                if(empty($employee)) return response()->json(['error' => 'Cannot find employee'], 200);
                $employee->delete();
                return response()->json(['success' => 'Your employee had been deleted!'], 200);
            } catch (\Exception $ex) {
                return response()->json(['error' => $ex->getMessage()], 200);
            }
        }
        
    }
