<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\AddProduct;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

class AddAProduct extends Component
{
    use WithFileUploads;

    public $productName;
    public $photos = [];
    public $productQuantity;
    public $productDescription;
    public $price;
    public $ecommercePlatform;

    public function add()
    {
        // dd($this->photos);
        $this->validate([
            'photos.*' => 'image|max:6024', // Adjust validation as needed
            'productQuantity' => 'required',
            'productName' => 'required',
            'productDescription' => 'required',
            'price' => 'required',
            'ecommercePlatform' => 'required',
        ]);

        $photoPaths = [];

        foreach ($this->photos as $photo) {
            $photoPath = $photo->storeAs('addproduct', time() . '_' . $photo->getClientOriginalName(), 'public');
            $photoPaths[] = $photoPath;
        }        
        $user = Auth::user();

        // Save to database
        $result = AddProduct::create([
            'user_id' => $user->id,
            'productName' => $this->productName,
            'photos' => json_encode($photoPaths),
            'productQuantity' => $this->productQuantity,
            'productDescription' => $this->productDescription,
            'price' => $this->price,
            'ecommercePlatform' => $this->ecommercePlatform,
            "soldInStock" => 1,
            "status" => 1,
        ]);

        if ($result) {

            session()->flash('success', 'Product added successfully!');
            $this->reset();
            return redirect('/users/add-product')->with('wire:navigate', true);
        }

        $this->reset();
        session()->flash('error', 'An error occurred please try again');
        return redirect('/users/add-product');
    }
    public function render()
    {
        return view('livewire.user.add-a-product');
    }
}
