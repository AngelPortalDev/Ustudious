<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;
use App\Models\CourseMaster as Course;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public $currentDate;
    public $time;
    public $date;
    public $course;



    public function __construct()
    {
        $this->currentDate = Carbon::now('Europe/Malta');
        $this->time = $this->currentDate->format('Y-m-d H:i:s');
        $this->date = $this->currentDate->format('Y-m-d');
        $this->course = new Course;
    }
}
