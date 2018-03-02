<?php
	Class DBController extends Controller{
		public static function test(){
			print_r(self::query("SELECT * from users"));
		}

	}
?>