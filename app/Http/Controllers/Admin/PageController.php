<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function edit($page)
    {
        $content = '';
        switch ($page) {
            case 'about-us':
                $content = setting('about_us');
                $title = 'من نحن';
                break;
            case 'privacy-policy':
                $content = setting('privacy_policy');
                $title = 'سياسة الخصوصية';
                break;
            case 'terms':
                $content = setting('terms');
                $title = 'الشروط والأحكام';
                break;
            default:
                abort(404);
        }

        return view('admin.pages.edit', compact('content', 'page', 'title'));
    }

    public function update(Request $request, $page)
    {
        $request->validate([
            'content' => 'required'
        ]);

        switch ($page) {
            case 'about-us':
                setting(['about_us' => $request->content])->save();
                break;
            case 'privacy-policy':
                setting(['privacy_policy' => $request->content])->save();
                break;
            case 'terms':
                setting(['terms' => $request->content])->save();
                break;
            default:
                abort(404);
        }

        return redirect()->back()->with('success', 'تم تحديث الصفحة بنجاح');
    }

    public function show($page)
    {
        $content = '';
        switch ($page) {
            case 'about-us':
                $content = setting('about_us');
                $title = 'من نحن';
                break;
            case 'privacy-policy':
                $content = setting('privacy_policy');
                $title = 'سياسة الخصوصية';
                break;
            case 'terms':
                $content = setting('terms');
                $title = 'الشروط والأحكام';
                break;
            default:
                abort(404);
        }

        return view('admin.pages.show', compact('content', 'title'));
    }
}
