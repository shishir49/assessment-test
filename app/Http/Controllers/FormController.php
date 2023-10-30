<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormTemplate;
use App\Models\FormSubmission;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    public function dashboard() {
        return view('pages.dashboard');
    }

    public function list() {
        $list = FormTemplate::get();
        return view('pages.list', compact('list'));
    }

    public function create() {
        return view('pages.create');
    }

    public function store(Request $request) {
        $validate = Validator::make($request->all(), [
            'form_name' => 'required|min:3'
        ]);

        if($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        } else {
            FormTemplate::create([
                'form_name'  => $request->form_name,
                'validation' => json_encode($request->validation_rules),
                'form_body'  => json_encode($request->form_body)
            ]);
    
            return redirect('/list')->with(['msg' => 'Form Created Successfully!']);
        }
    }

    public function edit(Request $request, $id) {
        $template = FormTemplate::where('id', $id)->first();
        return view('pages.edit', compact('template'));
    }

    public function update(Request $request) {
        $validate = Validator::make($request->all(), [
            'form_name' => 'required|min:3'
        ]);

        if($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        } else {
            FormTemplate::where('id', $request->id)->update([
                'form_name'  => $request->form_name,
                'validation' => json_encode($request->validation_rules),
                'form_body'  => json_encode($request->form_body)
            ]);
    
            return redirect()->back()->with(['msg' => 'Form updated Successfully!']);
        }
    }

    public function submit(Request $request) {
        $formValidationRules = FormTemplate::where('id', $request->id)->first()->validation;
        $rules = str_replace(array('{', '}', ':', '"'), array('', '', '=>', ''), json_decode($formValidationRules));
        
        $dd = explode(',', $rules);

        foreach($dd as $key => $value) {
            $get = explode('=>', $value);
            $ruleDesign[] = [$get[0] => $get[1]];
        }

        $validate = Validator::make($request->all(), array_merge(...$ruleDesign));

        if($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        } else {
            FormSubmission::create([
                'data'  => json_encode($request->all())
            ]);
    
            return redirect()->back()->with(['msg' => 'Form submitted Successfully!']);
        }
    }

    public function getFormTemplate(Request $request, $id) {
        $template = FormTemplate::where('id', $id)->first();
        return view('pages.preview', compact('template'));
    }
}
