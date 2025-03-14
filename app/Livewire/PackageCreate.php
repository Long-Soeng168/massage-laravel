<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\PackageItem;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Service;
use Carbon\Carbon;
use Livewire\WithPagination;
use Livewire\Attributes\Url;


class PackageCreate extends Component
{
    use WithFileUploads;
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 5;

    #[Url(history: true)]
    public $sortBy = 'id';

    #[Url(history: true)]
    public $sortDir = 'DESC';
    public $status = 1;
    public $selectedProducts = [];
    public $total_amount = 0;
    public $name = null;
    public $package_price = null;
    public $code = null;
    public $usable_number = 1;
    public $purchase_date = null;
    public function mount()
    {
        $this->purchase_date = Carbon::tomorrow()->toDateString();
    }

    public function handleSelectProduct($id)
    {
        $product = Service::find($id);

        if ($product) {
            // Add the product only if it's not already selected
            if (!collect($this->selectedProducts)->contains('id', $id)) {
                array_unshift($this->selectedProducts, [
                    'id' => $product->id,
                    'title' => $product->title,
                    'quantity' => 1,
                    'price' => $product->price > 0 ? $product->price : 0,
                ]);
            }
        }
        $this->dispatch('livewire:updated');
    }

    public function removeProduct($productId)
    {
        unset($this->selectedProducts[$productId]);
        $this->dispatch('livewire:updated');
    }

    public function updateProduct($productId, $field, $value)
    {
        foreach ($this->selectedProducts as $index => $product) {

            if ($product['id'] == $productId) {

                $this->selectedProducts[$index][$field] = $value; // Update the value
                // dd($this->selectedProducts[$index][$field]);

                // break;
            }
        }
        $this->dispatch('livewire:updated');

        // dd($this->selectedProducts);



        // session()->flash('success', 'Product updated successfully!');
    }
    public function updatedSearch()
    {
        $this->resetPage();
        $this->dispatch('livewire:updated');
    }

    public function save()
    {
        $validated = $this->validate([
            'selectedProducts' => 'required|array|min:1',
            'usable_number' => 'required',
            'name' => 'required',
            'package_price' => 'required',
            'code' => 'nullable',
        ]);

        // dd('hello');

        foreach ($this->selectedProducts as $index => $item) {
            $subtotal = $item['price'];
            $this->total_amount += $subtotal;
        }

        $purchase = Package::create([
            'status' => $this->status,
            'user_id' => request()->user()->id,
            'total_amount' => $this->total_amount * $this->usable_number,
            'price' => $this->package_price,
            'code' => $this->code,
            'usable_number' => $this->usable_number,
            'name' => $this->name,
        ]);

        // dd($purchase);

        foreach ($this->selectedProducts as $product) {
            PackageItem::create([
                'package_id' => $purchase->id,
                'service_id' => $product['id'],
                'price' => $product['price'],
                'subtotal' => $product['price'],
            ]);
        }

        session()->flash('success', 'Package saved successfully!');
        $this->reset(['selectedProducts']);
        return redirect('/admin/packages');
    }




    public function updated()
    {
        $this->dispatch('livewire:updated');
    }


    public function render()
    {
        // dd($selectedProducts);


        $items = Service::where(function ($query) {
            $query->where('title', 'LIKE', "%$this->search%");
        })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.package-create', [
            'items' => $items,
        ]);
    }
}
