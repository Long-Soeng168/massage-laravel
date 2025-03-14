<?php

namespace App\Livewire;

use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Book;
use App\Models\Customer;
use Image;
use Maatwebsite\Excel\Facades\Excel;

class CustomerInvoice extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $purchase;
    public $update_status;
    public function mount($id)
    {
        $this->purchase = Customer::findOrFail($id);
    }

    public function updateStatus($id, $status)
    {
        $getedItem = Customer::findOrFail($id);
        if ($status == $getedItem->status) {
            return;
        }
        $getedItem->update([
            'status' => $status,
            'updated_user_id' => request()->user()->id,
        ]);

        $getedProducts = Invoice::where('customerId', $id)->get();

        if ($status == 1) {
            foreach ($getedProducts as $product) {
                $book = Book::find($product->product_id);
                $book->update([
                    'quantity' => $book->quantity + $product->quantity,
                ]);
            }
        } elseif ($status == 0) {
            foreach ($getedProducts as $product) {
                $book = Book::find($product->product_id);
                $book->update([
                    'quantity' => $book->quantity - $product->quantity,
                ]);
            }
        }
        $this->update_status = $status;
        session()->flash('success', 'Update Successfully!');
        return redirect()->to('admin/purchases/' . $this->purchase->id);
    }

    public function export()
    {
        $purchaseId = $this->purchase->id;
        $purchase = $this->purchase;

        return Excel::download(new class($purchaseId, $purchase) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $purchaseId;
            private $purchase;

            public function __construct($purchaseId, $purchase)
            {
                $this->purchaseId = $purchaseId;
                $this->purchase = $purchase;
            }

            public function collection()
            {
                // Fetch purchases with related data
                return Invoice::where('customerId', $this->purchaseId)
                    ->with('items')
                    ->get()
                    ->map(function ($invoice, $index) {
                        return [
                            'No' => $index + 1,
                            'ID' => $invoice->id,
                            'Customer' => $invoice->customer->name ?? 'N/A', // Related customer name
                            'Subtotal' => number_format($invoice->subtotal, 2) ?? 'N/A', // Format subtotal
                            'Discount' => $invoice->discountType === 'percentage'
                                ? ($invoice->discount . '%')
                                : ('$' . number_format($invoice->discount, 2)),
                            'Total' => number_format($invoice->total, 2) ?? 'N/A', // Format total
                            'Payment Methode' => $invoice->paymentTypeId == 0 ? 'Credit' : ($invoice->payment ? $invoice->payment->name : 'N/A'), // Related payment type
                            'Created By' => $invoice->user->name ?? 'N/A', // User who created the invoice
                            'Created At' => $invoice->created_at->format('Y-m-d H:i:s'), // Format date
                        ];
                    });
            }

            public function headings(): array
            {
                // Define the column headings
                return [
                    [
                        'Name',
                        'Gender',
                        'Phone',
                        'Address',
                        'Credit',
                        'Updated By',
                    ],
                    [
                        $this->purchase?->name ?? 'N/A',
                        $this->purchase?->gender ?? 'N/A',
                        $this->purchase?->phone ?? 'N/A',
                        $this->purchase?->address ?? 'N/A',
                        $this->purchase?->credit ?? 'N/A',
                        $this->purchase?->updated_by?->name ?? 'N/A',
                    ],
                    [],
                    [
                        'No',
                        'Invoice ID',
                        'Customer',
                        'Subtotal',
                        'Discount',
                        'Total',
                        'Payment Methode',
                        'Sale By',
                        'Created At',
                    ]
                ];
            }
        }, 'customer.xlsx');
    }


    public function render()
    {
        $items = Invoice::where('customerId', $this->purchase->id)
            ->with('items')
            ->paginate(10);

        return view('livewire.customer-invoice', [
            'items' => $items,
            'order' => $this->purchase,
        ]);
    }
}
