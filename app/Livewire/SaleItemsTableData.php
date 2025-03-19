<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Book;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class SaleItemsTableData extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $sortBy = 'invoice_id';

    #[Url(history: true)]
    public $sortDir = 'DESC';
    public $customerId = null;
    public $createdBy = null;
    public $paymentId = null;
    public $itemType = null;
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

        return Excel::download(new class($start_date, $end_date, $search, $customerId, $createdBy, $paymentId, $itemType, $sortBy, $sortDir) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $start_date;
            private $end_date;
            private $search;
            private $customerId;
            private $createdBy;
            private $paymentId;
            private $itemType;
            private $sortBy;
            private $sortDir;

            public function __construct($start_date, $end_date, $search, $customerId, $createdBy, $paymentId, $itemType, $sortBy, $sortDir)
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
            }

            public function collection()
            {
                $query = InvoiceItem::query();
                $query->with('invoice', 'customer', 'payment', 'user', 'product');

                if (!empty($this->search)) {
                    $searchTerm = trim($this->search);

                    $query->where(function($subQuery) use ($searchTerm){
                        $subQuery->where('title', 'LIKE', "%{$searchTerm}%")
                        ->orWhereHas('product', function ($productQuery) use ($searchTerm) {
                            $productQuery->where('code', 'LIKE', "%{$searchTerm}%");
                        })
                        ->orWhereHas('service', function ($serviceQuery) use ($searchTerm) {
                            $serviceQuery->where('code', 'LIKE', "%{$searchTerm}%");
                        })
                        ->orWhereHas('package', function ($packageQuery) use ($searchTerm) {
                            $packageQuery->where('code', 'LIKE', "%{$searchTerm}%");
                        });
                    });
                }

                if ($this->customerId) {
                    $query->whereHas('invoice', function ($invoiceQuery) {
                        $invoiceQuery->where('customerId', $this->customerId);
                    });
                } elseif ($this->customerId == '0') {
                    $query->whereHas('invoice', function ($invoiceQuery) {
                        $invoiceQuery->where('customerId', null);
                    });
                }

                if ($this->createdBy) {
                    $query->whereHas('invoice', function ($invoiceQuery) {
                        $invoiceQuery->where('userId', $this->createdBy);
                    });
                } elseif ($this->createdBy == '0') {
                    $query->whereHas('invoice', function ($invoiceQuery) {
                        $invoiceQuery->where('userId', null);
                    });
                }

                if ($this->paymentId) {
                    $query->whereHas('invoice', function ($invoiceQuery) {
                        $invoiceQuery->where('paymentTypeId', $this->paymentId);
                    });
                } elseif ($this->paymentId == '0') {
                    $query->whereHas('invoice', function ($invoiceQuery) {
                        $invoiceQuery->where('paymentTypeId', 0);
                    });
                }
                $query->whereHas('invoice', function ($invoiceQuery) {
                    $invoiceQuery->where('status', 1);
                });

                if ($this->itemType) {
                    $query->where('type', '=', $this->itemType);
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
                                'Invoice_ID' => $item->invoice_id,
                                'Item' => $item->title,
                                'Item Type' => $item->type,
                                'Code' => $item->type == 'product' ? $item->product?->code : ($item->type == 'service' ? $item->service?->code : ($item->type == 'package' ? $item->package?->code : 'N/A')),
                                'Unit Price' => $item->price,
                                'Quantity' => $item->quantity,
                                'Unit Discount' => $item->discount,
                                'Sub Total' => ($item->price - ($item->discount / 100) * $item->price) * $item->quantity,
                                'Date' => $item->created_at->format('Y-m-d H:i:s'),
                                'Customer' => $item->customer->name ?? 'N/A',
                                'Pay By' => empty($item->payment) ? 'Credit' : ($item->payment ? $item->payment->name : 'N/A'),
                                'Sale By' => $item->user->name ?? 'N/A', // User who created the item
                            ];
                        });
            }

            public function headings(): array
            {
                // Define the column headings
                return [
                    'No',
                    'Invoice_ID',
                    'Item',
                    'Item Type',
                    'Code',
                    'Unit Price ($)',
                    'Quantity',
                    'Unit Discount',
                    'Sub Total ($)',
                    'Date',
                    'Customer',
                    'Pay By',
                    'Sale By',
                ];
            }
        }, 'salesItems.xlsx');
    }


    public function render()
    {

        $customers = Customer::all();
        $users = User::all();
        $payments = Payment::orderBy('order_index', 'asc')->get();
        
        $query = InvoiceItem::query();
        $query->with('invoice', 'customer', 'payment', 'user', 'product');

        if (!empty($this->search)) {
            $searchTerm = trim($this->search);

            $query->where(function($subQuery) use ($searchTerm){
                $subQuery->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('product', function ($productQuery) use ($searchTerm) {
                      $productQuery->where('code', 'LIKE', "%{$searchTerm}%");
                  })
                  ->orWhereHas('service', function ($serviceQuery) use ($searchTerm) {
                      $serviceQuery->where('code', 'LIKE', "%{$searchTerm}%");
                  })
                  ->orWhereHas('package', function ($packageQuery) use ($searchTerm) {
                    $packageQuery->where('code', 'LIKE', "%{$searchTerm}%");
                });
            });
        }

        if ($this->customerId) {
            $query->whereHas('invoice', function ($invoiceQuery) {
                $invoiceQuery->where('customerId', $this->customerId);
            });
        } elseif ($this->customerId == '0') {
            $query->whereHas('invoice', function ($invoiceQuery) {
                $invoiceQuery->where('customerId', null);
            });
        }
        if ($this->createdBy) {
            $query->whereHas('invoice', function ($invoiceQuery) {
                $invoiceQuery->where('userId', $this->createdBy);
            });
        } elseif ($this->createdBy == '0') {
            $query->whereHas('invoice', function ($invoiceQuery) {
                $invoiceQuery->where('userId', null);
            });
        }
        $query->whereHas('invoice', function ($invoiceQuery) {
            $invoiceQuery->where('status', 1);
        });

        if ($this->paymentId) {
            $query->whereHas('invoice', function ($invoiceQuery) {
                $invoiceQuery->where('paymentTypeId', $this->paymentId);
            });
        } elseif ($this->paymentId == '0') {
            $query->whereHas('invoice', function ($invoiceQuery) {
                $invoiceQuery->where('paymentTypeId', 0);
            });
        }

        if ($this->itemType) {
            $query->where('type', '=', $this->itemType);
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


        return view('livewire.sale-items-table-data', [
            'items' => $items,
            'customers' => $customers,
            'users' => $users,
            'payments' => $payments,
        ]);
    }
}
