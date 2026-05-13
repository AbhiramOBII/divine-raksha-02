<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactEnquiry::latest();

        if ($request->filled('filter') && $request->filter === 'unread') {
            $query->unread();
        }

        $enquiries = $query->paginate(20);
        $unreadCount = ContactEnquiry::unread()->count();

        return view('admin.enquiries.index', compact('enquiries', 'unreadCount'));
    }

    public function show(ContactEnquiry $enquiry)
    {
        if (!$enquiry->is_read) {
            $enquiry->update(['is_read' => true]);
        }

        return view('admin.enquiries.show', compact('enquiry'));
    }

    public function destroy(ContactEnquiry $enquiry)
    {
        $enquiry->delete();
        return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry deleted.');
    }
}
