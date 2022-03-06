<?php

namespace App\Http\Controllers\Invoice\Admin;

use App\Models\Invoice\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function index() {
        $projects = Project::all();

        return view('invoice.admin.invoice.index', compact('projects'));
    }
}
