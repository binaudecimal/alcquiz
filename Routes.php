<?php
	Route::set('', function(){
		header('Location: home');
		exit();
	});
    Route::set('index', function(){
		header('Location: home');
		exit();
	});

	Route::set('home', function(){
		HomeController::findHome();
	});

	Route::set('test', function(){
		Controller::createView('test');
	});

	//LoginController
	Route::set('login', function(){
		LoginController::login();
	});

	Route::set('logout', function(){
		LoginController::logout();
	});


	Route::set('signup-form', function(){
		Controller::createView('signup');
	});

	Route::set('signup', function(){
		LoginController::signup();
	});

	//QuestionController

	Route::set('add-question-form', function(){
		Controller::createView('add-question');
	});

	Route::set('add-question', function(){
		QuestionController::addQuestion();
	});

	Route::set('activate-quiz', function(){
		QuestionController::activateQuiz();
	});
	Route::set('start-quiz', function(){
		QuestionController::startQuiz();
	});

	Route::set('quiz-take', function(){
		Controller::createView('quiz-take');
	});
	Route::set('quiz-answer', function(){
		QuestionController::processAnswer();
	});
	//populate $question_set
	Route::set('populate-question', function(){
		Controller::createView('edit-question');
	});

	Route::set('edit-question', function(){
		Controller::createView('edit-question-form');
	});

	Route::set('update-question', function(){
		QuestionController::updateQuestion();
	});

	Route::set('delete-question', function(){
		QuestionController::deleteQuestion();
	});

	Route::set('ping', function(){
		Controller::createView('ping');
	});

?>
