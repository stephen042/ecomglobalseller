<?php

namespace App\Livewire\Auth;

use App\Jobs\SendMail;
use App\Models\Booking as Bookings;
use App\Models\User;
use Illuminate\Support\Str;
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Bookings::class],
            'phone' => ['required', 'min:8', 'max:13', 'unique:'.Bookings::class],
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
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'country' => $validated['country'],
            'watch_training_before_applying' => $validated['watch_training_before_applying'],
            'budget_to_invest' => $validated['budget_to_invest'],
            'struggle_growing_business' => $validated['struggle_growing_business'],
            'experience_selling_on_amazon' => $validated['experience_selling_on_amazon'],
            'how_soon_will_you_start' => $validated['how_soon_will_you_start'],
            'promise' => $validated['promise'],
        ]);

        if ($insert) {

            // Approve booking automatically
            $password = Str::random(10);

            $insert->update([
                'status' => 2,
            ]);

            User::create([
                'name' => $insert->name,
                'email' => $insert->email,
                'phone' => $insert->phone,
                'country' => $insert->country,
                'account_bal' => 0,
                'number_of_sales' => 0,
                'total_sales' => 0,
                'total_product' => 0,
                'password' => $password, // assuming User model hashes automatically
            ]);

            $app = config('app.name');
            $userEmail = $insert->email;
            $name = $insert->name;
            $subject = 'FbaBeginners Booking Approval';

            $bodyUser = [
                'name' => $name,
                'title' => 'Booking Approval',
                'message' => "
                Hi there, thanks for signing up with us.<br><br>

                Email: {$userEmail}<br>
                Password: {$password}<br><br>

                Thanks for trusting our services.
            ",
            ];

            $bodyAdmin = [
                'name' => 'Admin',
                'title' => 'Booking Approval',
                'message' => "
            {$name} registered and was automatically approved on {$app}.<br><br>

            Email: {$userEmail}<br>
            Password: {$password}
        ",
            ];

            SendMail::dispatch($userEmail, $subject, $bodyUser, $bodyAdmin);

            session()->flash(
                'success',
                'Registration successful. Your account has been created. Check your email.'
            );

            return redirect('/booking');
        }

        session()->flash('error', 'An error occurred please try again');

        return redirect('/register');
    }

    public function render()
    {
        return view('livewire.auth.booking');
    }
}
