<?php
	include_once 'header.php';
?>
<div class='container-fluid mt-5'>
    <div class='row justify-content-center'>
        <div class='card col-6 align-items-center bg-light'>
            <div class='card=header'>
                <h2 class='display-4 text-center'>SIGNUP</h2>
            </div>
            <?php
                if(isset($_GET['status'])){
                    switch($_GET['status']){
                        case 'signup-success':
                            echo "<div class='alert alert-success' role='alert'>Account Successfully created.</div>
                                ";break;
                    }
                }
             ?>
            <form class='form-group' action='signup' method='POST'>
                <input type='text' placeholder='First Name' name='first' required autofocus='auto' autocomplete="off" class='form-control'>
                <input type='text' placeholder='Last Name' name='last' required autocomplete="off" class='form-control'>
                <input type='text' placeholder='Username' name='uid' required autocomplete="off" class='form-control'>
                <input type='password' placeholder='Password' name='pwd' required autocomplete="off" class='form-control'>
                <select name='type' class='form-control'>
                    <option>ADMIN</option>
                    <option>STUDENT</option>
                    <option>TEACHER</option>
                </select>
                <button type='submit' name='signup-submit' class='btn btn-primary'>Sign up</button>
            </form>
        </div>
    </div>
</div>
