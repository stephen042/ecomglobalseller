<?php

namespace App\Livewire\User;

use App\Jobs\SendMail;
use App\Models\Deposit;
use Livewire\Component;
use App\Models\AdminWallet;
use Illuminate\Support\Facades\Auth;

class FundModal extends Component
{
    
    public $amount;
    protected $rules = [
        'amount' => ['required', 'numeric', 'min:100'],
    ];

    public $payment_method;

    public $copyAddress;

    public $admin_wallets;

    public function mount(AdminWallet $admin_wallet)
    {
        $this->admin_wallets = (object) $admin_wallet->get()->first();
    }

    // to choose if copy address will show
    public $display = "d-none";

    public function updated($amount)
    {
        $this->validateOnly($amount);

        if ($this->payment_method == "Bitcoin") {
            $this->copyAddress = $this->admin_wallets->bitcoin ?? "wallet address not available. Contact us ";
            return $this->display = "";
        } elseif ($this->payment_method == "USDT") {
            $this->copyAddress = $this->admin_wallets->usdt ?? "wallet address not available. Contact us ";
            return $this->display = "";
        } elseif ($this->payment_method == "PayPal") {
            $this->copyAddress = $this->admin_wallets->pay_pal ?? "wallet address not available. Contact us ";
            return $this->display = "";
        }elseif ($this->payment_method == "Cash App") {
            $this->copyAddress = $this->admin_wallets->cash_app ?? "wallet address not available. Contact us ";
            return $this->display = "";
        } elseif ($this->payment_method == "Ethereum") {
            $this->copyAddress = $this->admin_wallets->ethereum ?? "wallet address not available. Contact us ";
            return $this->display = "";
        } elseif ($this->payment_method == "MoneyGram") {
            $this->copyAddress = $this->admin_wallets->money_gram ?? "wallet address not available. Contact us ";
            return $this->display = "";
        } elseif ($this->payment_method == "WesternUnion") {
            $this->copyAddress = $this->admin_wallets->western_union ?? "wallet address not available. Contact us ";
            return $this->display = "";
        } elseif ($this->payment_method == "GiftCard") {
            return $this->display = "d-none";
        }
    }

    public function fund()
    {
        if ($this->payment_method == "GiftCard") {
            // Save the amount to the session
            session(['amount' => $this->amount]);

            // Redirect to the giftcard route
            return redirect()->route('giftcard')->with('wire:navigate', true);
        }
        
        $user = Auth::user();

        $result = Deposit::create([
            "user_id" => $user->id,
            "amount" => $this->amount,
            "payment_method" => $this->payment_method,
            "status" => 1
        ]);

        if ($result) {
            $app = config('app.name');
            $userEmail = $user->email;

            $name = $user->name;
            $subject = "Deposit Request Notification";


            $bodyUser = [
                "name" => $name,
                "title" => "Deposit Request Notification",
                "message" => "We have successfully received your deposit request of $$this->amount through $this->payment_method, Your account will be credited after confirmation .
                <br>
                <br>
                We will get back to you with further details soon. ",
            ];
            $bodyAdmin = [
                "name" => "Admin",
                "title" => "Deposit Request Notification",
                "message" => " Hello Admin a User by the name $name have successfully made a Deposit Request of $$this->amount through $this->payment_method on your $app . Please check it out ;
                ",
            ];

            SendMail::dispatch($userEmail,$subject, $bodyUser ,$bodyAdmin);

            session()->flash('success', 'Deposit request Created Successfully. Check Your email for more information');
            
            $this->reset();

            return redirect('/users')->with('wire:navigate', true);
        }

        session()->flash('error', 'An error occurred please try again');
        return redirect('/users')->with('wire:navigate', true);

    }

    public function render()
    {
        return view('livewire.user.fund-modal');
    }
}
