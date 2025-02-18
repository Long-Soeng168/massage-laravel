<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\CustomerCredit;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdjustCredits extends Component
{
    use WithFileUploads;

    public $customer_id;
    public $action = 'add';
    public $amount;
    public $credit_amount;

    public function updateCredit()
    {
        $validated = $this->validate([
            'customer_id' => 'required',
            'action' => 'required',
            'amount' => 'required',
            'credit_amount' => 'required',
        ]);

        // dd($validated);

        CustomerCredit::create([
            'customer_id' => $this->customer_id,
            'action' => $this->action,
            'add_by_user_id' => request()->user()->id,
            'amount' => $this->amount,
            'credit' => $this->credit_amount,
        ]);

        $customer = Customer::find($this->customer_id);
        $customer->update([
            'credit' => $this->action == 'add' ? $customer->credit + $this->credit_amount : $customer->credit - $this->credit_amount,
            'updated_user_id' => request()->user()->id,
        ]);

        return redirect('/admin/people/customers')->with('success', 'Adjust Credit Successfully.');
    }

    public function updated()
    {
        $this->dispatch('livewire:updated');
    }

    public function render()
    {
        // dd($allKeywords);
        // dump($this->selectedallKeywords);
        $customers = Customer::all();

        return view('livewire.adjust_credits', [
            'customers' => $customers,
        ]);
    }
}
