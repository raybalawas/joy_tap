<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use App\Models\PrivacyPolicy;
use App\Models\TermsCondition;
use Illuminate\Http\Request;

class PagesController extends Controller
{
 public function pages()
 {
    return view('admin.pages.index');
 }
 public function privacyPolicy()
 {
    $data = PrivacyPolicy::first();
    return view('admin.pages.privacy_policy',compact('data'));
 }
 public function privacyPolicyEdit(Request $request)
 {
    $request->validate([
        'title'     => 'required',
        'content'     => 'required|min:10',
    ]);
    
    $data = PrivacyPolicy::first();
    $data->title = $request->title;
    $data->content = $request->content;
    $data->save();

    return redirect()->route('pages','pages')->with('success', 'Privacy Policy updated successfully');

 }
 public function termsConditions()
 {
    $data = TermsCondition::first();
    return view('admin.pages.terms_conditions',compact('data'));
 }
 public function termsConditionsEdit(Request $request)
 {
    $request->validate([
        'title'     => 'required',
        'content'     => 'required|min:10',
    ]);

    $data = TermsCondition::first();
    $data->title = $request->title;
    $data->content = $request->content;
    $data->save();

    return redirect()->route('pages','pages')->with('success', 'Terms & Condition updated successfully');

 }
}
