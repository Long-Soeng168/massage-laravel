<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Package;
use App\Models\PackageItem;
use App\Models\Service;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Ramsey\Uuid\Type\Decimal;

class PackageEdit extends Component
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

    public $purchase_item;
    public $product_id = [];
    public $supplier_id = null;
    public $status = 1;
    public $init_status = 1;
    public $selectedProducts = [];
    public $purchase_date = null;
    public $total_amount = 0;
    public $name = null;
    public $package_price = null;
    public $usable_number = 1;

    public function mount($id)
    {
        $this->purchase_item = Package::findOrFail($id);
        // if(request()->user()->id !== $this->item->publisher_id && !request()->user()->hasRole(['super-admin', 'admin'])){
        //     return redirect('admin/books')->with('error', ['Only Onwer or Admin can update!']);
        // }

        $this->name = $this->purchase_item->name ?? null;
        $this->total_amount = $this->purchase_item->total_amount ?? 0;
        $this->package_price = $this->purchase_item->price ?? null;
        $this->usable_number = $this->purchase_item->usable_number ?? null;

        $purchase_items = PackageItem::where('package_id', $id)->with('service')->get();
        foreach ($purchase_items as $key => $value) {
            if (!collect($this->selectedProducts)->contains('id', $id)) {
                array_unshift($this->selectedProducts, [
                    'id' => $value->service_id,
                    'title' => $value->service?->title,
                    'price' => $value->price > 0 ? $value->price : 0,
                ]);
            }
        }
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
        ]);

        // dd('hello');

        $this->total_amount = 0;
        foreach ($this->selectedProducts as $index => $item) {
            $this->total_amount +=  $item['price'];
        }

        // dd($this->total_amount);

        $this->purchase_item->update([
            'status' => $this->status,
            'updated_user_id' => request()->user()->id,
            'total_amount' => $this->total_amount * $this->usable_number,
            'price' => $this->package_price,
            'usable_number' => $this->usable_number,
            'name' => $this->name,
        ]);
        $purchaseItems = PackageItem::where('package_id', $this->purchase_item->id)->delete();

        // dd($purchase);

        foreach ($this->selectedProducts as $product) {
            PackageItem::create([
                'package_id' => $this->purchase_item->id,
                'service_id' => $product['id'],
                'price' => $product['price'],
                'subtotal' => $product['price'],
            ]);

        }

        session()->flash('success', 'Package updated successfully!');
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
