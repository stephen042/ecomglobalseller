<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class EditUserAccount extends Component
{

    public $user_data;

    public $credit_bal_amount;
    public $debit_bal_amount;

    public $increase_sales;
    public $reduce_sales;

    public $increase_total_sales;
    public $reduce_total_sales;

    public $increase_total_product;
    public $reduce_total_products;

    public $increase_last_30_days;
    public $increase_last_year;

    public $edit_returns;

    
    public function credit_balance()
    {

        $this->validate([
            "credit_bal_amount" => 'required',
        ]);

        $user_id = $this->user_data->id;

        $new_balance = $this->user_data->account_bal + $this->credit_bal_amount;

        $result = User::where("id",$user_id)->update([
            "account_bal" => $new_balance,
        ]);

        if ($result) {
            session()->flash('success', 'Customer Credited successfully');

            return redirect()->route('admin_editUser', [$user_id]);
        }

        session()->flash('error', 'An error occurred try again later');

        return redirect()->route('admin_editUser', [$user_id]);
    }

    public function debit_balance()
    {
        
        $this->validate([
            "debit_bal_amount" => 'required',
        ]);

        $user_id = $this->user_data->id;

        $new_balance = $this->user_data->account_bal - $this->debit_bal_amount;

        $result = User::where("id",$user_id)->update([
            "account_bal" => $new_balance,
        ]);

        if ($result) {
            session()->flash('success', 'Customer Debited successfully');

            return redirect()->route('admin_editUser', [$user_id]);
        }

        session()->flash('error', 'An error occurred try again later');

        return redirect()->route('admin_editUser', [$user_id]);
    }

    public function increase_user_sales()
    {
        $this->validate([
            "increase_sales" => 'required',
        ]);

        $user_id = $this->user_data->id;

        $new_sales_number = $this->user_data->number_of_sales + $this->increase_sales;

        $result = User::where("id",$user_id)->update([
            "number_of_sales" => $new_sales_number,
        ]);

        if ($result) {
            session()->flash('success', 'Customer sales increased successfully');

            return redirect()->route('admin_editUser', [$user_id]);
        }

        session()->flash('error', 'An error occurred try again later');

        return redirect()->route('admin_editUser', [$user_id]);

    }

    public function reduce_user_sales()
    {
        $this->validate([
            "reduce_sales" => 'required',
        ]);

        $user_id = $this->user_data->id;

        $new_sales_number = $this->user_data->number_of_sales - $this->reduce_sales;

        $result = User::where("id",$user_id)->update([
            "number_of_sales" => $new_sales_number,
        ]);

        if ($result) {
            session()->flash('success', 'Customer sales reduced successfully');

            return redirect()->route('admin_editUser', [$user_id]);
        }

        session()->flash('error', 'An error occurred try again later');

        return redirect()->route('admin_editUser', [$user_id]);

    }

    public function increase_user_total_sales()
    {
        $this->validate([
            "increase_total_sales" => 'required',
        ]);

        $user_id = $this->user_data->id;

        $new_sales_total_number = $this->user_data->total_sales + $this->increase_total_sales;

        $result = User::where("id",$user_id)->update([
            "total_sales" => $new_sales_total_number,
        ]);

        if ($result) {
            session()->flash('success', 'Customer total sales increased successfully');

            return redirect()->route('admin_editUser', [$user_id]);
        }

        session()->flash('error', 'An error occurred try again later');

        return redirect()->route('admin_editUser', [$user_id]);
    }

    public function reduce_user_total_sales()
    {
        $this->validate([
            "reduce_total_sales" => 'required',
        ]);

        $user_id = $this->user_data->id;

        $new_sales_total_number = $this->user_data->total_sales - $this->reduce_total_sales;

        $result = User::where("id",$user_id)->update([
            "total_sales" => $new_sales_total_number,
        ]);

        if ($result) {
            session()->flash('success', 'Customer total sales reduced successfully');

            return redirect()->route('admin_editUser', [$user_id]);
        }

        session()->flash('error', 'An error occurred try again later');

        return redirect()->route('admin_editUser', [$user_id]);
    }

    public function increase_user_total_products()
    {
        $this->validate([
            "increase_total_product" => 'required',
        ]);

        $user_id = $this->user_data->id;

        $new_product_total_number = $this->user_data->total_product + $this->increase_total_product;

        $result = User::where("id",$user_id)->update([
            "total_product" => $new_product_total_number,
        ]);

        if ($result) {
            session()->flash('success', 'Customer total products reduced successfully');

            return redirect()->route('admin_editUser', [$user_id]);
        }

        session()->flash('error', 'An error occurred try again later');

        return redirect()->route('admin_editUser', [$user_id]);
    }

    public function reduce_user_total_products()
    {
        $this->validate([
            "reduce_total_products" => 'required',
        ]);

        $user_id = $this->user_data->id;

        $new_product_total_number = $this->user_data->total_product - $this->reduce_total_products;

        $result = User::where("id",$user_id)->update([
            "total_product" => $new_product_total_number,
        ]);

        if ($result) {
            session()->flash('success', 'Customer total products reduced successfully');

            return redirect()->route('admin_editUser', [$user_id]);
        }

        session()->flash('error', 'An error occurred try again later');

        return redirect()->route('admin_editUser', [$user_id]);
    }

    public function last_30_days()
    {
        $this->validate([
            "increase_last_30_days" => 'required',
        ]);

        $user_id = $this->user_data->id;
        $result = User::where("id",$user_id)->update([
            "last_30_days" => $this->increase_last_30_days,
        ]);

        
        if ($result) {
            session()->flash('success', 'Customer Last 30 days edited successfully');

            return redirect()->route('admin_editUser', [$user_id]);
        }

        session()->flash('error', 'An error occurred try again later');

        return redirect()->route('admin_editUser', [$user_id]);
    }

    public function last_year()
    {
        $this->validate([
            "increase_last_year" => 'required',
        ]);

        $user_id = $this->user_data->id;
        $result = User::where("id",$user_id)->update([
            "last_year" => $this->increase_last_year,
        ]);

        
        if ($result) {
            session()->flash('success', 'Customer Last year edited successfully');

            return redirect()->route('admin_editUser', [$user_id]);
        }

        session()->flash('error', 'An error occurred try again later');

        return redirect()->route('admin_editUser', [$user_id]);
    }
    public function returns()
    { 
        $this->validate([
            "edit_returns" => 'required',
        ]);

        $user_id = $this->user_data->id;
        $result = User::where("id",$user_id)->update([
            "returns" => $this->edit_returns,
        ]);

        
        if ($result) {
            session()->flash('success', 'Customer returns edited successfully');

            return redirect()->route('admin_editUser', [$user_id]);
        }

        session()->flash('error', 'An error occurred try again later');

        return redirect()->route('admin_editUser', [$user_id]);
    }

    public function render()
    {
        return view('livewire.admin.edit-user-account');
    }
}
