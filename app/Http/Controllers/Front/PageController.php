<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('front.pages.about', [
            'page_title' => 'من نحن'
        ]);
    }

    public function contact()
    {
        return view('front.pages.contact', [
            'page_title' => 'اتصل بنا'
        ]);
    }

    public function sendContact(ContactRequest $request)
    {
        Contact::create($request->validated());

        return redirect()
            ->back()
            ->with('message', 'تم إرسال رسالتك بنجاح')
            ->with('messageType', 'success');
    }

    public function editorialBoard()
    {
        $editors = \App\Models\Editor::with('media')
            ->orderBy('order')
            ->get();

        return view('front.pages.editorial-board', compact('editors'));
    }

    public function privacy()
    {
        return view('front.pages.privacy');
    }

    public function terms()
    {
        return view('front.pages.terms');
    }
}
