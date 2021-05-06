<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('employee.index')->with('employees',Employee::orderBy('created_at', 'DESC')->paginate(5));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $upload = $request->file->getClientOriginalName();
        $ran_upload = Str::random(10);
        $upload = $ran_upload.$upload;
        $request->file->storeAs("employees",$upload,"public");

        if($request->still_working == null)
        {

        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'date_of_joining' => 'required',
            'date_of_leaving' => 'required',
            'file' => 'required|mimes:jpeg,bmp,png',
        ]);

        Employee::create([
            'email' => $request->email,
            'name' => $request->name,
            'date_of_joining' => $request->date_of_joining,
            'date_of_leaving' => $request->date_of_leaving,
            'image' => $upload,
        ]);

        }

        else
        {
            $request->validate([
                'email' => 'required',
                'name' => 'required',
                'date_of_joining' => 'required',
                'file' => 'required|mimes:jpeg,bmp,png',
            ]);
    
            Employee::create([
                'email' => $request->email,
                'name' => $request->name,
                'date_of_joining' => $request->date_of_joining,
                'image' => $upload,
            ]);
    
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Employee::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $employee = Employee::find($request->employee_id);
        $file = '/public/employees/'.$employee->image;
        
        Storage::delete($file);     
        $employee->delete();

        return redirect()->back();
    }
}
