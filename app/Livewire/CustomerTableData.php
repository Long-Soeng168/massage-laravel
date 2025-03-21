<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\CustomerCredit;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class CustomerTableData extends Component
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
        $publisher = Customer::find($id);
        CustomerCredit::where('customer_id', $id)->delete();
        $publisher->delete();

        session()->flash('success', 'Customer successfully deleted!');
    }

    // ==========Add New Publisher============
    public $newCustomerName = null;
    public $newCustomerPhone = null;
    public $newCustomerAddress = null;
    public $newCustomerGender = null;
    public $newCustomerCredit = null;
    public $newCustomerAmount = null;

    public function saveNewCustomer()
    {
        try {
            $validated = $this->validate([
                'newCustomerName' => 'required|string|max:255',
            ]);

            $created_customer = Customer::create([
                'name' => $this->newCustomerName,
                'gender' => $this->newCustomerGender,
                'address' => $this->newCustomerAddress,
                'phone' => $this->newCustomerPhone,
                'credit' => $this->newCustomerCredit ?? 0,
                'add_by_user_id' => request()->user()->id,
                'updated_user_id' => request()->user()->id,
            ]);

            if ($this->newCustomerCredit > 0 && $this->newCustomerCredit != null) {
                CustomerCredit::create([
                    'customer_id' => $created_customer->id,
                    'action' => 'add',
                    'add_by_user_id' => request()->user()->id,
                    'amount' => $this->newCustomerAmount ?? 0,
                    'credit' => $this->newCustomerCredit,
                ]);
            }

            session()->flash('success', 'Add New Customer successfully!');

            $this->reset(['newCustomerName', 'newCustomerGender', 'newCustomerPhone', 'newCustomerAddress', 'newCustomerCredit']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', $e->validator->errors()->all());
        }
    }

    public $editId = null;
    public $name;
    public $gender;
    public $address;
    public $phone;
    public $credit;

    public function setEdit($id)
    {
        $publisher = Customer::find($id);
        $this->editId = $id;
        $this->name = $publisher->name;
        $this->gender = $publisher->gender;
        $this->phone = $publisher->phone;
        $this->address = $publisher->address;
        $this->credit = $publisher->credit;
    }

    public function cancelUpdatePublisher()
    {
        $this->editId = null;
        $this->name = null;
        $this->phone = null;
        $this->gender = null;
        $this->address = null;
        $this->credit = null;
    }

    public function updatePublisher($id)
    {
        try {
            $validated = $this->validate([
                'name' => 'required|string|max:255',
            ]);

            $publisher = Customer::find($id);
            $publisher->update([
                'name' => $this->name,
                'gender' => $this->gender,
                'phone' => $this->phone,
                'address' => $this->address,
                'credit' => $this->credit,
                'updated_user_id' => request()->user()->id,
            ]);

            session()->flash('success', 'Customer successfully edited!');

            $this->reset(['name', 'gender', 'editId', 'address', 'credit']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', $e->validator->errors()->all());
        }
    }

    public $customer_id;
    public $action = 'add';
    public $amount;
    public $credit_amount;

    public function updateCredit()
    {
        try {
            $validated = $this->validate([
                'customer_id' => 'required',
                'action' => 'required',
                'amount' => 'required',
                'credit_amount' => 'required',
            ]);

            $customer = Customer::find($this->curstomer_id);
            $customer->update([
                'name' => $this->name,
                'gender' => $this->gender,
                'phone' => $this->phone,
                'address' => $this->address,
                'credit' => $this->credit,
                'updated_user_id' => request()->user()->id,
            ]);

            session()->flash('success', 'Customer successfully edited!');

            $this->reset(['name', 'gender', 'editId', 'address', 'credit']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', $e->validator->errors()->all());
        }
    }

    public function updated()
    {
        $this->dispatch('livewire:updated');
    }

    public function export()
    {

        return Excel::download(new class() implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {

            public function collection()
            {
                return Customer::with('updated_by', 'invoices')->get()
                    ->map(function ($customer) {
                        return [
                            'ID' => $customer->id,
                            'Name' => $customer->name ?? 'N/A', // Related supplier name
                            'Gender' => $customer->gender ?? 'N/A',
                            'Phone' => $customer->phone ?? 'N/A',
                            'Address' => $customer->address ?? 'N/A',
                            'Credit' => $customer->credit ?? '0',
                            'Total Invoices' => count($customer->invoices) ?? '0',
                            'Updated By' => $customer->updated_by->name ?? 'N/A',
                        ];
                    });
            }

            public function headings(): array
            {
                // Define the column headings
                return [
                    'ID',
                    'Name',
                    'Gender',
                    'Phone',
                    'Address',
                    'Credit ($)',
                    'Total Invoices',
                    'Updated By',
                ];
            }
        }, 'purchases.xlsx');
    }

    public function render()
    {

        $items = Customer::where(function ($query) {
            $query->where('name', 'LIKE', "%$this->search%");
        })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        $customers = Customer::with('invoices')->get();
        // dd($customers);
        return view('livewire.customer-table-data', [
            'items' => $items,
            'customers' => $customers,
        ]);
    }
}
