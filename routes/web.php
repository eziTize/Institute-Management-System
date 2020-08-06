<?php

include_once("admin.php");

include_once("branch.php");

include_once("telecaller.php");

include_once("tpo.php");

include_once("marketing_person.php");

include_once("teacher.php");

include_once("student.php");

Route::get('cron/run','Cron\CronController@run');