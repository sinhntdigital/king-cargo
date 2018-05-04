<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Currency;
    use App\Models\InvestmentPackage;
    use Illuminate\Http\Request;
	
	/**
	 * Class HomeController
	 *
	 * @package App\Http\Controllers
	 */
	class HomeController extends Controller {
		
		/**
		 * Show the application dashboard.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function getDashboardPage() {
			return view('backend.dashboard');
		}
		
	}
