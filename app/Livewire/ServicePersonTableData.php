<?php

namespace App\Livewire;

use App\Models\ServicePerson;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ServicePersonTableData extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $filter = 0;

    #[Url(history: true)]
    public $sortBy = 'id';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    public function setFilter($value)
    {
        $this->filter = $value;
        $this->resetPage();
    }

    public function setSortBy($newSortBy)
    {
        if ($this->sortBy == $newSortBy) {
            $newSortDir = ($this->sortDir == 'DESC') ? 'ASC' : 'DESC';
            $this->sortDir = $newSortDir;
        } else {
            $this->sortBy = $newSortBy;
        }
    }

    // ResetPage when updated search
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $publisher = ServicePerson::find($id);
        $publisher->delete();

        session()->flash('success', 'Customer successfully deleted!');
    }

    // ==========Add New Publisher============
    public $newPublisherName = null;
    public $newPublisherPhone = null;
    public $newPublisherAddress = null;
    public $newPublisherGender = null;
    public $newPublishercommission = null;

    public function saveNewPublisher()
    {
        try {
            $validated = $this->validate([
                'newPublisherName' => 'required|string|max:255',
            ]);

            ServicePerson::create([
                'name' => $this->newPublisherName,
                'gender' => $this->newPublisherGender,
                'address' => $this->newPublisherAddress,
                'phone' => $this->newPublisherPhone,
                'commission' => $this->newPublishercommission,
                'add_by_user_id' => request()->user()->id,
                'updated_user_id' => request()->user()->id,
            ]);

            session()->flash('success', 'Add New Customer successfully!');

            $this->reset(['newPublisherName', 'newPublisherGender', 'newPublisherPhone', 'newPublisherAddress', 'newPublishercommission']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', $e->validator->errors()->all());
        }
    }

    public $editId = null;
    public $name;
    public $gender;
    public $address;
    public $phone;
    public $commission;

    public function setEdit($id)
    {
        $publisher = ServicePerson::find($id);
        $this->editId = $id;
        $this->name = $publisher->name;
        $this->gender = $publisher->gender;
        $this->phone = $publisher->phone;
        $this->address = $publisher->address;
        $this->commission = $publisher->commission;
    }

    public function cancelUpdatePublisher()
    {
        $this->editId = null;
        $this->name = null;
        $this->phone = null;
        $this->gender = null;
        $this->address = null;
        $this->commission = null;
    }

    public function updatePublisher($id)
    {
        try {
            $validated = $this->validate([
                'name' => 'required|string|max:255',
            ]);

            $publisher = ServicePerson::find($id);
            $publisher->update([
                'name' => $this->name,
                'gender' => $this->gender,
                'phone' => $this->phone,
                'address' => $this->address,
                'commission' => $this->commission,
                'updated_user_id' => request()->user()->id,
            ]);

            session()->flash('success', 'Customer successfully edited!');

            $this->reset(['name', 'gender', 'editId', 'address', 'commission']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', $e->validator->errors()->all());
        }
    }

    public $customer_id;
    public $action = 'add';
    public $amount;
    public $commission_amount;

    public function updatecommission()
    {
        try {
            $validated = $this->validate([
                'customer_id' => 'required',
                'action' => 'required',
                'amount' => 'required',
                'commission_amount' => 'required',
            ]);

            $customer = ServicePerson::find($this->curstomer_id);
            $customer->update([
                'name' => $this->name,
                'gender' => $this->gender,
                'phone' => $this->phone,
                'address' => $this->address,
                'commission' => $this->commission,
                'updated_user_id' => request()->user()->id,
            ]);

            session()->flash('success', 'Customer successfully edited!');

            $this->reset(['name', 'gender', 'editId', 'address', 'commission']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', $e->validator->errors()->all());
        }
    }

    public function updated()
    {
        $this->dispatch('livewire:updated');
    }

    public function render()
    {

        $items = ServicePerson::where(function ($query) {
            $query->where('name', 'LIKE', "%$this->search%");
        })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        $customers = ServicePerson::all();

        return view('livewire.service-person-table-data', [
            'items' => $items,
            'customers' => $customers,
        ]);
    }
}
