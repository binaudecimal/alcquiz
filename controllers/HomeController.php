<?php
	class HomeController extends Controller{
		
		public static function findHome(){
			if(!isset($_SESSION)){
				session_start();
			}

			if(isset($_SESSION['u_type'])){
				switch($_SESSION['u_type']){
					case 'ADMIN': self::createView('admin-panel'); exit(); break;
					case 'TEACHER': self::createView('teacher-home'); exit(); break;
					case 'STUDENT': self::createView('student-home'); exit(); break;
					default: self::createView('index');
				}
			}
			else{
				self::createView('index');
			}
			
		}
	}
?>