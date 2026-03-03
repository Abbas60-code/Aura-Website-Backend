<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // React se aane wale field names ko validate + map karo
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email',
            'subject'    => 'nullable|string|max:255',
            'message'    => 'required|string',
        ]);

        Contact::create([
            'FirstName' => $data['first_name'],
            'LastName'  => $data['last_name'] ?? null,
            'Email'     => $data['email'],
            'Subject'   => $data['subject'] ?? null,
            'Message'   => $data['message'],
        ]);

        return response()->json(['message' => 'Saved']);
    }
}