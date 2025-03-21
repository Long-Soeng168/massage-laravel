<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Customer;
use App\Models\CustomerCredit;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class CustomerCreditTableData extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $sortBy = 'id';

    #[Url(history: true)]
    public $sortDir = 'DESC';
    public $customerId = null;
    public $createdBy = null;
    public $paymentId = null;
    public $itemType = null;
    public $start_date = null;
    public $end_date = null;
    public $adjustmentAction = null;

    public function updatedAdjustmentAction()
    {
        $this->resetPage();
    }
    public function mount()
    {
        $this->end_date = Carbon::tomorrow()->toDateString();
    }

    // ResetPage when updated search
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedCustomerId()
    {
        $this->resetPage();
    }
    public function updatedCreatedBy()
    {
        $this->resetPage();
    }
    public function updatedPaymentId()
    {
        $this->resetPage();
    }
    public function updatedItemType()
    {
        $this->resetPage();
    }
    public function updated()
    {
        $this->dispatch('livewire:updated');
    }

    public function export()
    {
        $start_date = $this->start_date;
        $end_date = $this->end_date;
        $search = $this->search;
        $customerId = $this->customerId;
        $createdBy = $this->createdBy;
        $paymentId = $this->paymentId;
        $itemType = $this->itemType;
        $sortBy = $this->sortBy;
        $sortDir = $this->sortDir;
        $adjustmentAction = $this->adjustmentAction;

        return Excel::download(new class($start_date, $end_date, $search, $customerId, $createdBy, $paymentId, $itemType, $sortBy, $sortDir, $adjustmentAction) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $start_date;
            private $end_date;
            private $search;
            private $customerId;
            private $createdBy;
            private $paymentId;
            private $itemType;
            private $sortBy;
            private $sortDir;
            private $adjustmentAction;

            public function __construct($start_date, $end_date, $search, $customerId, $createdBy, $paymentId, $itemType, $sortBy, $sortDir, $adjustmentAction)
            {
                $this->start_date = $start_date;
                $this->end_date = $end_date;
                $this->search = $search;
                $this->customerId = $customerId;
                $this->createdBy = $createdBy;
                $this->paymentId = $paymentId;
                $this->itemType = $itemType;
                $this->sortBy = $sortBy;
                $this->sortDir = $sortDir;
                $this->adjustmentAction = $adjustmentAction;
            }

            public function collection()
            {
                $query = CustomerCredit::query();
                $query->with('customer', 'payment', 'user');

                if (!empty($this->search)) {
                    $searchTerm = trim($this->search);

                    $query->where(function ($subQuery) use ($searchTerm) {
                        $subQuery
                            ->orWhereHas('customer', function ($productQuery) use ($searchTerm) {
                                $productQuery->where('name', 'LIKE', "%{$searchTerm}%")
                                    ->orWhere('phone', 'LIKE', "%{$searchTerm}%")
                                    ->orWhere('address', 'LIKE', "%{$searchTerm}%");
                            });
                    });
                }

                if ($this->adjustmentAction) {
                    $query->where('action', $this->adjustmentAction);;
                }

                if ($this->customerId) {
                    $query->where('customer_id', $this->customerId);
                } elseif ($this->customerId == '0') {
                    $query->where('customer_id', null);
                }
                if ($this->createdBy) {
                    $query->where('add_by_user_id', $this->createdBy);
                } elseif ($this->createdBy == '0') {
                    $query->where('add_by_user_id', null);
                }
                if ($this->paymentId) {
                    $query->where('paymentTypeId', $this->paymentId);
                } elseif ($this->paymentId == '0') {
                    $query->where('paymentTypeId', 0);
                }

                if ($this->start_date) {
                    $query->where('created_at', '>=', $this->start_date);
                }

                if ($this->end_date) {
                    $query->where('created_at', '<=', $this->end_date);
                }

                return  $query
                    ->orderBy($this->sortBy, $this->sortDir)->orderBy('id', 'desc')
                    ->get()
                    ->map(function ($item, $index) {
                        return [
                            'No' => $index + 1,
                            'Customer' => $item->customer->name ?? 'N/A',
                            'Phone' => $item->customer->phone ?? 'N/A',
                            'Amount' => $item->amount,
                            'Credit' => $item->credit,
                            'Action' => $item->action,
                            'Date' => $item->created_at->format('Y-m-d'),
                            'Created By' => $item->user->name ?? 'N/A', // User who created the item
                        ];
                    });
            }

            public function headings(): array
            {
                // Define the column headings
                return [
                    'No',
                    'Customer',
                    'Phone',
                    'Amount',
                    'Credit',
                    'Action',
                    'Date',
                    'Created By',
                ];
            }
        }, 'creditHistories.xlsx');
    }


    public function render()
    {

        $customers = Customer::all();
        $users = User::all();
        $payments = Payment::orderBy('order_index', 'asc')->get();

        $query = CustomerCredit::query();
        $query->with('customer', 'payment', 'user');

        if (!empty($this->search)) {
            $searchTerm = trim($this->search);

            $query->where(function ($subQuery) use ($searchTerm) {
                $subQuery
                    ->orWhereHas('customer', function ($productQuery) use ($searchTerm) {
                        $productQuery->where('name', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('phone', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('address', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        if ($this->adjustmentAction) {
            $query->where('action', $this->adjustmentAction);;
        }

        if ($this->customerId) {
            $query->where('customer_id', $this->customerId);
        } elseif ($this->customerId == '0') {
            $query->where('customer_id', null);
        }
        if ($this->createdBy) {
            $query->where('add_by_user_id', $this->createdBy);
        } elseif ($this->createdBy == '0') {
            $query->where('add_by_user_id', null);
        }
        if ($this->paymentId) {
            $query->where('paymentTypeId', $this->paymentId);
        } elseif ($this->paymentId == '0') {
            $query->where('paymentTypeId', 0);
        }

        if ($this->start_date) {
            $query->where('created_at', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->where('created_at', '<=', $this->end_date);
        }

        $items = $query
            ->orderBy($this->sortBy, $this->sortDir)->orderBy('id', 'desc')
            ->paginate($this->perPage);

        // dd($items);


        return view('livewire.customer-credit-table-data', [
            'items' => $items,
            'customers' => $customers,
            'users' => $users,
            'payments' => $payments,
        ]);
    }
}
