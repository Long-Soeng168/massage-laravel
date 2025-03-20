<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Payment;
use App\Models\AdjustmentItem;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class AdjustmentItemsTableData extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $sortBy = 'adjustment_id';

    #[Url(history: true)]
    public $sortDir = 'DESC';
    public $createdBy = null;
    public $paymentId = null;
    public $adjustmentAction = null;
    public $start_date = null;
    public $end_date = null;
    public function mount()
    {
        $this->end_date = Carbon::tomorrow()->toDateString();
    }

    // ResetPage when updated search
    public function updatedSearch()
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
    public function updatedAdjustmentAction()
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
        $createdBy = $this->createdBy;
        $paymentId = $this->paymentId;
        $adjustmentAction = $this->adjustmentAction;
        $sortBy = $this->sortBy;
        $sortDir = $this->sortDir;

        return Excel::download(new class($start_date, $end_date, $search, $createdBy, $paymentId, $adjustmentAction, $sortBy, $sortDir) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $start_date;
            private $end_date;
            private $search;
            private $createdBy;
            private $paymentId;
            private $adjustmentAction;
            private $sortBy;
            private $sortDir;

            public function __construct($start_date, $end_date, $search, $createdBy, $paymentId, $adjustmentAction, $sortBy, $sortDir)
            {
                $this->start_date = $start_date;
                $this->end_date = $end_date;
                $this->search = $search;
                $this->createdBy = $createdBy;
                $this->paymentId = $paymentId;
                $this->adjustmentAction = $adjustmentAction;
                $this->sortBy = $sortBy;
                $this->sortDir = $sortDir;
            }

            public function collection()
            {
                $query = AdjustmentItem::query();
                $query->with('product', 'adjustment');

                if (!empty($this->search)) {
                    $searchTerm = trim($this->search);

                    $query->where(function ($subQuery) use ($searchTerm) {
                        $subQuery->whereHas('product', function ($productQuery) use ($searchTerm) {
                            $productQuery->where('code', 'LIKE', "%{$searchTerm}%")->orWhere('title', 'LIKE', "%{$searchTerm}%");
                        });
                    });
                }

                if ($this->createdBy) {
                    $query->whereHas('adjustment', function ($invoiceQuery) {
                        $invoiceQuery->where('user_id', $this->createdBy);
                    });
                } elseif ($this->createdBy == '0') {
                    $query->whereHas('adjustment', function ($invoiceQuery) {
                        $invoiceQuery->where('user_id', null);
                    });
                }

                if ($this->adjustmentAction) {
                    $query->where('action', $this->adjustmentAction);;
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
                            'Adjustment_ID' => $item->adjustment_id,
                            'Product' => $item->product->title,
                            'Code' => $item->product->code,
                            'Quantity' => $item->quantity,
                            'Action' => $item->action,
                            'Date' => $item->created_at->format('Y-m-d'),
                            'Created By' => $item->user->name ?? 'N/A', // User who created the item
                            'Updated By' => $item->updatedBy->name ?? 'N/A', // User who created the item
                        ];
                    });
            }

            public function headings(): array
            {
                // Define the column headings
                return [
                    'No',
                    'Adjustment_ID',
                    'Product',
                    'Code',
                    'Quantity',
                    'Action',
                    'Date',
                    'Created By',
                    'Updated By',
                ];
            }
        }, 'adjustmentItems.xlsx');
    }


    public function render()
    {

        $users = User::all();
        $payments = Payment::orderBy('order_index', 'asc')->get();

        $query = AdjustmentItem::query();
        $query->with('product', 'adjustment');

        if (!empty($this->search)) {
            $searchTerm = trim($this->search);

            $query->where(function ($subQuery) use ($searchTerm) {
                $subQuery->whereHas('product', function ($productQuery) use ($searchTerm) {
                    $productQuery->where('code', 'LIKE', "%{$searchTerm}%")->orWhere('title', 'LIKE', "%{$searchTerm}%");
                });
            });
        }

        if ($this->createdBy) {
            $query->whereHas('adjustment', function ($invoiceQuery) {
                $invoiceQuery->where('user_id', $this->createdBy);
            });
        } elseif ($this->createdBy == '0') {
            $query->whereHas('adjustment', function ($invoiceQuery) {
                $invoiceQuery->where('user_id', null);
            });
        }

        if ($this->adjustmentAction) {
            $query->where('action', $this->adjustmentAction);;
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


        return view('livewire.adjustment-items-table-data', [
            'items' => $items,
            'users' => $users,
            'payments' => $payments,
        ]);
    }
}
