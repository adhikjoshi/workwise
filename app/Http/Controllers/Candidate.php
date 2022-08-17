<?php

namespace App\Http\Controllers;

use App\Models\Candidate as ModelsCandidate;
use Illuminate\Http\Request;

class Candidate extends Controller
{
    // Get list of candidates
    public function index()
    {
        return  ModelsCandidate::all();
    }

    // filter candidates 
    public function filter()
    {
        $employment = request()->query('employment');
        $location = request()->query('location');
        $skills = request()->query('skills');
        $candidates = new ModelsCandidate();
        if (isset($employment)) {
            $condition[] = ['type_of_employment',$employment];
        }
        if (isset($location)) {
            $condition[] = ['location',$location];
        }
        if (isset($skills)) {
            $condition[] = ['skills',$skills];
        }
        return $candidates->where($condition)->get();
    }

    // Get list of all available locations
    function location_list(){

    }

    // Get list of all skills 
    function skills_list(){
        
    }

    // get list of emplyment lists
    function employment_list(){
        
    }
}
