<?php

namespace App\Livewire\Auth;

use App\Jobs\SendMail;

use App\Models\Booking as Bookings;
use Livewire\Component;

class Booking extends Component
{
    public $name;
    public $email;
    public $phone;
    public $country;
    public $watch_training_before_applying;
    public $budget_to_invest;
    public $struggle_growing_business;
    public $experience_selling_on_amazon;
    public $how_soon_will_you_start;
    public $promise;

    public function save()
    {
        // dd($this->watch_training_before_applying);
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Bookings::class],
            'phone' => ['required', 'min:8', 'max:13', 'unique:' . Bookings::class],
            'country' => ['required'],
            'watch_training_before_applying' => ['required'],
            'budget_to_invest' => ['required'],
            'struggle_growing_business' => ['required', 'max:2000'],
            'experience_selling_on_amazon' => ['required', 'max:2000'],
            'how_soon_will_you_start' => ['required', 'max:200'],
            'promise' => ['required'],
        ]);

        // dd($validated['watch_training_before_applying']);
        $insert = Bookings::create([
            "name" => $validated['name'],
            "email" => $validated['email'],
            "phone" => $validated['phone'],
            "country" => $validated['country'],
            "watch_training_before_applying" => $validated['watch_training_before_applying'],
            "budget_to_invest" => $validated['budget_to_invest'],
            "struggle_growing_business" => $validated['struggle_growing_business'],
            "experience_selling_on_amazon" => $validated['experience_selling_on_amazon'],
            "how_soon_will_you_start" => $validated['how_soon_will_you_start'],
            "promise" => $validated['promise'],
        ]);

        if ($insert) {
            $app = config('app.name');
            $userEmail = $validated['email'];

            $name = $validated['name'];
            $subject = "Booking Notification";


            $bodyUser = [
                "name" => $name,
                "title" => "Booking Notification",
                "message" => "Thank you for booking with us. We have received your request and will review your application shortly.
                <br>
                <br>
                We will get back to you with further details soon. ",
            ];
            $bodyAdmin = [
                "name" => "Admin",
                "title" => "Booking Notification",
                "message" => " Hello Admin a User by the name $name have successfully make a Booking on your $app . Please check it out ;
                ",
            ];

            SendMail::dispatch($userEmail,$subject, $bodyUser ,$bodyAdmin);

            session()->flash('success', 'Booking Created Successfully. Check Your email for more information');
            
            $this->reset();

            return $this->redirect('/booking');
        }

        session()->flash('error', 'An error occurred please try again');
        return redirect('/register');
    }
    public function render()
    {
        return view('livewire.auth.booking');
    }
}
