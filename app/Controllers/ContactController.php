<?php

namespace App\Controllers;

use App\Middlewares\AuthMiddleware;
use App\Models\Contact;
use Asaa\Http\Controller;
use Asaa\Http\Request;

class ContactController extends Controller {

    public function __construct()
    {
        $this->setMiddlewares([AuthMiddleware::class]);
    }

    public function index(){
        return view('contacts/index', ['contacts' => Contact::all()]);
    }

    public function create(){
        return view('contacts/create');
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
        ]);
        $data['user_id'] = auth()->id();
        Contact::create($data);

        return redirect('/contacts');
    }

    public function edit(Contact $contact){
        return view('contacts/edit', compact('contact'));
    }

    public function update(Contact $contact, Request $request){
        $data = $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
        ]);
        $contact->name = $data['name'];
        $contact->phone_number = $data['phone_number'];
        $contact->update();

        return redirect('/contacts');
    }

    public function destroy(Contact $contact){
        $contact->delete();
        session()->flash('alert', "Contact $contact->name deleted");
        return redirect('/contacts');
    }
}