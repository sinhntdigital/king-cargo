<?php
	
	use \App\Models\Option;
	
	/**
	 * Class Settings
	 */
	class Settings {
		
		/**
		 * Thiet lap cac gia tri cua thuoc tinh
		 *
		 * @param $thuocTinh
		 * @param $giaTri
		 *
		 * @return bool
		 */
		public static function set($thuocTinh, $giaTri) {
			try {
				$caiDat = Option::where('key', $thuocTinh)->first();
				if(empty($caiDat))
					Option::create([
						'id'    => str_random(65),
						'key'   => $thuocTinh,
						'value' => $giaTri,
					]);
				else
					$caiDat->update([
						'key'   => $thuocTinh,
						'value' => $giaTri,
					]);
				
				return true;
			} catch(\Exception $ex) {
				dd($ex->getMessage());
				return false;
			}
		}
		
		/**
		 * Lay gia tri cua thuoc tinh
		 *
		 * @param $thuocTinh
		 *
		 * @return string
		 */
		public static function get($thuocTinh) {
			try {
				$caiDat = Option::where('key', $thuocTinh)->first();
				if(empty($caiDat))
					return '';
				else
					return $caiDat->value;
			} catch(\Exception $ex) {
				return '';
			}
		}
		
	}