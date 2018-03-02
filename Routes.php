<?php
	Route::set('index', function(){
		
		//insert the controller function here
		//Controller::function();
		Controller::createView('index');
	});
	Route::set('home', function(){
		//the redirector
		HomeController::findHome();

	});
	Route::set('signup', function(){
		echo('signup!');
	});
	Route::set('quiz-take', function(){
		QuestionController::generateQuestion();
		QuestionController::createView('quiz-take');
	});

	Route::set('quiz-answer', function(){
		QuestionController::processAnswer();
	});

	Route::set('add-question', function(){
		QuestionController::addQuestion();
	});

	Route::set('add-question-form', function(){
		QuestionController::createView('add-question');
	});

	Route::set('question-edit-populate', function(){
		QuestionController::populate();
	});

	Route::set('question-edit-list', function(){
		QuestionController::createView('edit-question');
	});

	Route::set('question-edit', function(){
		echo('Editting question!');
	});

	Route::set('view-students', function(){
		echo('Viewing students!');
	});

	Route::set('activate-quiz', function(){
		QuestionController::activateQuiz();
	});

	Route::set('quiz-reset', function(){
		echo('Reset quiz of a student!');
	});
	Route::set('quiz-start', function(){
		QuestionController::generateQuestionSet();
	});
	Route::set('login', function(){
		LoginController::login();
	});

	Route::set('logout', function(){
		LoginController::logout();
	});

	Route::set('pdo', function(){
		
		DBController::test();
	});

	Route::set('signup-form', function(){
		Controller::createView('signup');
	});
	Route::set('signup', function(){
		LoginController::signup();
	});
	Route::set('test', function(){
		Controller::createView('test');
	});
?>