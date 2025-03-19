<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Book;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseItemsTableData extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $sortBy = 'purchase_id';

    #[Url(history: true)]
    public $sortDir = 'DESC';
    public $supplier_id = null;
    public $createdBy = null;
    public $paymentId = null;
    public $itemStatus = null;
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
    public function updatedsupplier_id()
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
    public function updateditemStatus()
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
        $supplier_id = $this->supplier_id;
        $createdBy = $this->createdBy;
        $paymentId = $this->paymentId;
        $itemStatus = $this->itemStatus;
        $sortBy = $this->sortBy;
        $sortDir = $this->sortDir;

        return Excel::download(new class($start_date, $end_date, $search, $supplier_id, $createdBy, $paymentId, $itemStatus, $sortBy, $sortDir) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $start_date;
            private $end_date;
            private $search;
            private $supplier_id;
            private $createdBy;
            private $paymentId;
            private $itemStatus;
            private $sortBy;
            private $sortDir;

            public function __construct($start_date, $end_date, $search, $supplier_id, $createdBy, $paymentId, $itemStatus, $sortBy, $sortDir)
            {
                $this->start_date = $start_date;
                $this->end_date = $end_date;
                $this->search = $search;
                $this->supplier_id = $supplier_id;
                $this->createdBy = $createdBy;
                $this->paymentId = $paymentId;
                $this->itemStatus = $itemStatus;
                $this->sortBy = $sortBy;
                $this->sortDir = $sortDir;
            }

            public function collection()
            {
                $query = PurchaseItem::query();
                $query->with('product', 'supplier', 'purchase');

                if (!empty($this->search)) {
                    $searchTerm = trim($this->search);

                    $query->where(function ($subQuery) use ($searchTerm) {
                        $subQuery->whereHas('product', function ($productQuery) use ($searchTerm) {
                            $productQuery->where('code', 'LIKE', "%{$searchTerm}%")->orWhere('title', 'LIKE', "%{$searchTerm}%");
                        });
                    });
                }

                if ($this->supplier_id) {
                    $query->whereHas('purchase', function ($supplierQuery) {
                        $supplierQuery->where('supplier_id', $this->supplier_id);
                    });
                } elseif ($this->supplier_id == '0') {
                    $query->whereHas('purchase', function ($invoiceQuery) {
                        $invoiceQuery->where('supplier_id', null);
                    });
                }

                if ($this->createdBy) {
                    $query->whereHas('purchase', function ($invoiceQuery) {
                        $invoiceQuery->where('user_id', $this->createdBy);
                    });
                } elseif ($this->createdBy == '0') {
                    $query->whereHas('purchase', function ($invoiceQuery) {
                        $invoiceQuery->where('user_id', null);
                    });
                }

                if ($this->itemStatus || $this->itemStatus == '0') {
                    $query->whereHas('purchase', function ($invoiceQuery) {
                        $invoiceQuery->where('status', $this->itemStatus);
                    });
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
                            'Purchase_ID' => $item->purchase_id,
                            'Product' => $item->product->title,
                            'Code' => $item->product->code,
                            'Unit Cost' => $item->price,
                            'Quantity' => $item->quantity,
                            'Sub Total' => $item->subtotal,
                            'Date' => $item->created_at->format('Y-m-d'),
                            'Supplier' => $item->supplier->name ?? 'N/A',
                            'Status' => $item->purchase->status == 1 ? 'Recieved' : 'Not-Recieved',
                            'Created By' => $item->user->name ?? 'N/A', // User who created the item
                        ];
                    });
            }

            public function headings(): array
            {
                // Define the column headings
                return [
                    'No',
                    'Purchase_ID',
                    'Product',
                    'Code',
                    'Unit Cost ($)',
                    'Quantity',
                    'Sub Total ($)',
                    'Date',
                    'Supplier',
                    'Status',
                    'Created By',
                ];
            }
        }, 'puchaseItems.xlsx');
    }


    public function render()
    {

        $suppliers = Supplier::all();
        $users = User::all();
        $payments = Payment::orderBy('order_index', 'asc')->get();

        $query = PurchaseItem::query();
        $query->with('product', 'supplier', 'purchase');

        if (!empty($this->search)) {
            $searchTerm = trim($this->search);

            $query->where(function ($subQuery) use ($searchTerm) {
                $subQuery->whereHas('product', function ($productQuery) use ($searchTerm) {
                    $productQuery->where('code', 'LIKE', "%{$searchTerm}%")->orWhere('title', 'LIKE', "%{$searchTerm}%");
                });
            });
        }

        if ($this->supplier_id) {
            $query->whereHas('purchase', function ($supplierQuery) {
                $supplierQuery->where('supplier_id', $this->supplier_id);
            });
        } elseif ($this->supplier_id == '0') {
            $query->whereHas('purchase', function ($invoiceQuery) {
                $invoiceQuery->where('supplier_id', null);
            });
        }
        if ($this->createdBy) {
            $query->whereHas('purchase', function ($invoiceQuery) {
                $invoiceQuery->where('user_id', $this->createdBy);
            });
        } elseif ($this->createdBy == '0') {
            $query->whereHas('purchase', function ($invoiceQuery) {
                $invoiceQuery->where('user_id', null);
            });
        }

        if ($this->itemStatus || $this->itemStatus == '0') {
            $query->whereHas('purchase', function ($invoiceQuery) {
                $invoiceQuery->where('status', $this->itemStatus);
            });
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


        return view('livewire.purchase-items-table-data', [
            'items' => $items,
            'suppliers' => $suppliers,
            'users' => $users,
            'payments' => $payments,
        ]);
    }
}
