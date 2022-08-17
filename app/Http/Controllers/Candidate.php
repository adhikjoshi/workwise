<?php

namespace App\Http\Controllers;

use App\Models\Candidate as ModelsCandidate;
use Illuminate\Http\Request;

class Candidate extends Controller
{
    public function index()
    {
        return  ModelsCandidate::all();
    }
    public function filter()
    {
        $employment = request()->query('employment');
        $location = request()->query('location');
        $skills = request()->query('skills');
        $candidates = new ModelsCandidate();
        if (isset($employment)) {
            $candidates->where('type_of_employment', $employment);
        }
        if (isset($location)) {
            $candidates->Where('location', $location);
        }
        if (isset($skills)) {
            $candidates->Where('skills', $skills);
        }
        return $candidates->get();
    }
}
