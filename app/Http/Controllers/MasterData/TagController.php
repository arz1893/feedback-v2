<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function index() {
        return view('master_data.tag.tag_index');
    }

    public function create() {
        return view('master_data.tag.tag_create');
    }
}
