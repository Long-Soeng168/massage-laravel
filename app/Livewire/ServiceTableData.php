<?php

namespace App\Livewire;

use App\Models\BookBrand;
use App\Models\brand;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Service;
use App\Models\BookCategory;
use App\Models\BookSubCategory;
use Maatwebsite\Excel\Facades\Excel;

class ServiceTableData extends Component
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

    public $brand_id = null;
    public $category_id = null;
    public $sub_category_id = null;
    public $fromYear = null;
    public $toYear = null;
    public $priceFrom = null;
    public $priceTo = null;
    public $orderBy = null;
    public $limit = null;


    public function setSortBy($newSortBy)
    {
        if ($this->sortBy == $newSortBy) {
            $newSortDir = ($this->sortDir == 'DESC') ? 'ASC' : 'DESC';
            $this->sortDir = $newSortDir;
        } else {
            $this->sortBy = $newSortBy;
        }
        $this->dispatch('livewire:updated');
    }
    public function delete($id)
    {
        $item = Service::findOrFail($id);

        // Check and delete associated image and thumbnail
        if (!empty($item->image)) {
            $imagePath = public_path('assets/images/isbn/' . $item->image);
            $thumbPath = public_path('assets/images/isbn/thumb/' . $item->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            if (file_exists($thumbPath)) {
                unlink($thumbPath);
            }
        }

        // Delete the book record
        $item->delete();

        // Flash success message
        $this->dispatch('livewire:updated');
        session()->flash('success', 'Successfully deleted!');
    }


    // ResetPage when updated search
    public function updatedSearch()
    {
        $this->resetPage();
        $this->dispatch('livewire:updated');
    }

    public function updateStatus($id, $status)
    {
        $getedItem = Service::findOrFail($id);
        $getedItem->update([
            'status' => $status,
            'last_edit_user_id' => request()->user()->id
        ]);
        $this->dispatch('livewire:updatedStatus');
        // session()->flash('success', 'Update Successfully!');
    }
    public function updateForSell($id, $status)
    {
        $getedItem = Service::findOrFail($id);
        $getedItem->update([
            'is_for_sell' => $status,
        ]);
        $this->dispatch('livewire:updatedStatus');
        // session()->flash('success', 'Update Successfully!');
    }

    public function updateIsFree($id, $status)
    {
        $getedItem = Service::findOrFail($id);
        $getedItem->update([
            'is_free' => $status,
        ]);
        $this->dispatch('livewire:updatedStatus');
        // session()->flash('success', 'Update Successfully!');
    }

    public function updated()
    {
        $this->dispatch('livewire:updated');
    }
    public function export()
    {
        // Fetch all books without pagination
        $query = Service::query()->with('brand');

        // Apply search filter
        if ($this->search) {
            $query->where(function ($sub_query) {
                $sub_query->where('title', 'LIKE', "%{$this->search}%")
                    ->orWhere('year', 'LIKE', "%{$this->search}%")
                    ->orWhere('short_description', 'LIKE', "%{$this->search}%")
                    ->orWhereHas('brand', function ($q) {
                        $q->where('name', 'LIKE', "%{$this->search}%");
                    });
            });
        }

        // Apply category filters
        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }

        if ($this->sub_category_id) {
            $query->where('sub_category_id', $this->sub_category_id);
        }

        // Apply price filters
        if ($this->priceFrom) {
            $query->where('price', '>=', $this->priceFrom);
        }

        if ($this->priceTo) {
            $query->where('price', '<=', $this->priceTo);
        }

        // Apply year filters
        if ($this->fromYear) {
            $query->where('year', '>=', $this->fromYear);
        }

        if ($this->toYear) {
            $query->where('year', '<=', $this->toYear);
        }

        if ($this->brand_id) {
            $query->where('brand_id', $this->brand_id);
        }

        // Apply ordering logic
        if ($this->orderBy) {
            if ($this->orderBy === 'totalSaleDesc') {
                $query->withCount('invoice_items')->orderBy('invoice_items_count', 'desc');
            } elseif ($this->orderBy === 'totalSaleAsc') {
                $query->withCount('invoice_items')->orderBy('invoice_items_count', 'asc');
            } elseif ($this->orderBy === 'totalViewDesc') {
                $query->orderBy('view_count', 'desc');
            } elseif ($this->orderBy === 'totalViewAsc') {
                $query->orderBy('view_count', 'asc');
            } elseif ($this->orderBy === 'totalPriceDesc') {
                $query->orderBy('price', 'desc');
            } elseif ($this->orderBy === 'totalPriceAsc') {
                $query->orderBy('price', 'asc');
            }
        }

        if ($this->limit) {
            $query->limit($this->limit);
        }


        // Apply status filter and pagination
        $items = $query->get();


        return Excel::download(new class($items) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $items;

            public function __construct($items)
            {
                $this->items = $items;
            }

            public function collection()
            {
                return $this->items->map(function ($book) {
                    return [
                        'ID' => $book->id,
                        'Title' => $book->title,
                        'Cost' => $book->cost ?? 'N/A',
                        'Price' => $book->price ?? 'N/A',
                        'Discount' => $book->discount ?? 'N/A',
                        'Quantity' => $book->quantity ?? 'N/A',
                        'Year' => $book->year ?? 'N/A',
                        'Short Description' => $book->short_description ?? 'N/A',
                        'Long Description' => $book->description ?? 'N/A',
                        'Image' => $book->image ?? 'N/A',
                        'Order Approved Count' => $book->order_approved ?? 'N/A',
                        'Brand' => $book->brand?->name ?? 'N/A',
                        'Category' => $book->category?->name ?? 'N/A',
                        'SubCategory' => $book->subCategory?->name ?? 'N/A',
                        'Created By' => $book->created_by?->name ?? 'N/A',
                        'Updated By' => $book->updated_by?->name ?? 'N/A',
                        'Created At' => $book->created_at,
                        'View Count' => $book->view_count,
                        'Status' => $book->status == 1 ? 'Public' : 'Not-Public',
                    ];
                });
            }

            public function headings(): array
            {
                return [
                    'ID',
                    'Title',
                    'Cost',
                    'Price',
                    'Discount',
                    'Quantity',
                    'Year',
                    'Short Description',
                    'Long Description',
                    'Image',
                    'Order Approved Count',
                    'Brand',
                    'Category',
                    'SubCategory',
                    'Created By',
                    'Updated By',
                    'Created At',
                    'View Count',
                    'Status'
                ];
            }
        }, 'products.xlsx');
    }

    public $selectedItems = [];

    public function exportMutiItems()
    {
        if (!empty($this->selectedItems)) {
            $getedItems = Service::whereIn('id', $this->selectedItems)->get();
            $this->reset(['selectedItems']);
            return Excel::download(new class($getedItems) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
                private $getedItems;

                public function __construct($getedItems)
                {
                    $this->getedItems = $getedItems;
                }

                public function collection()
                {
                    return $this->getedItems->map(function ($book) {
                        return [
                            'ID' => $book->id,
                            'Title' => $book->title,
                            'Cost' => $book->cost ?? 'N/A',
                            'Price' => $book->price ?? 'N/A',
                            'Discount' => $book->discount ?? 'N/A',
                            'Quantity' => $book->quantity ?? 'N/A',
                            'Year' => $book->year ?? 'N/A',
                            'Short Description' => $book->short_description ?? 'N/A',
                            'Long Description' => $book->description ?? 'N/A',
                            'Image' => $book->image ?? 'N/A',
                            'Order Approved Count' => $book->order_approved ?? 'N/A',
                            'Brand' => $book->brand?->name ?? 'N/A',
                            'Category' => $book->category?->name ?? 'N/A',
                            'SubCategory' => $book->subCategory?->name ?? 'N/A',
                            'Created By' => $book->created_by?->name ?? 'N/A',
                            'Updated By' => $book->updated_by?->name ?? 'N/A',
                            'Created At' => $book->created_at,
                            'View Count' => $book->view_count,
                            'Status' => $book->status == 1 ? 'Public' : 'Not-Public',
                        ];
                    });
                }

                public function headings(): array
                {
                    return [
                        'ID',
                        'Title',
                        'Cost',
                        'Price',
                        'Discount',
                        'Quantity',
                        'Pages',
                        'Year',
                        'Short Description',
                        'Long Description',
                        'Image',
                        'Order Approved Count',
                        'Brand',
                        'Category',
                        'SubCategory',
                        'Created By',
                        'Updated By',
                        'Created At',
                        'View Count',
                        'Status'
                    ];
                }
            }, 'selected_items_export.xlsx');
        }
    }
    public function deleteMultiItems()
    {
        if (!empty($this->selectedItems)) {
            $getedItems = Service::whereIn('id', $this->selectedItems)->get();
            foreach ($getedItems as $value) {
                // dd($value);
                $value->delete();
            }
            // dd($getedItems);
            // session()->flash('message', 'Statuses updated successfully.');
            $this->reset(['selectedItems']);
            return redirect('/admin/services')->with(['success' => 'Deleted items successfully.']);
        }
    }
    public function updateMultiStatus($statusValue)
    {
        // dd([$this->selectedItems, $this->status]);
        if (!empty($this->selectedItems)) {
            $getedItems = Service::whereIn('id', $this->selectedItems)->get();
            foreach ($getedItems as $value) {
                // dd($value);
                $value->update([
                    'status' => $statusValue,
                ]);
            }
            // dd($getedItems);
            // session()->flash('message', 'Statuses updated successfully.');
            $this->reset(['selectedItems']); // Reset selection
            return redirect('/admin/services')->with(['success' => 'Statuses updated successfully.']);
        }
    }


    public function setSelectAll($productIds)
    {
        $this->selectedItems = $productIds;
    }


    public function render()
    {

        $query = Service::query()->with('brand');

        // Apply search filter
        if ($this->search) {
            $query->where(function ($sub_query) {
                $sub_query->where('title', 'LIKE', "%{$this->search}%")
                    ->orWhere('year', 'LIKE', "%{$this->search}%")
                    ->orWhere('short_description', 'LIKE', "%{$this->search}%")
                    ->orWhereHas('brand', function ($q) {
                        $q->where('name', 'LIKE', "%{$this->search}%");
                    });
            });
        }

        // Apply category filters
        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }

        if ($this->sub_category_id) {
            $query->where('sub_category_id', $this->sub_category_id);
        }

        // Apply price filters
        if ($this->priceFrom) {
            $query->where('price', '>=', $this->priceFrom);
        }

        if ($this->priceTo) {
            $query->where('price', '<=', $this->priceTo);
        }

        // Apply year filters
        if ($this->fromYear) {
            $query->where('year', '>=', $this->fromYear);
        }

        if ($this->toYear) {
            $query->where('year', '<=', $this->toYear);
        }

        if ($this->brand_id) {
            $query->where('brand_id', $this->brand_id);
        }

        // Apply ordering logic
        if ($this->orderBy) {
            if ($this->orderBy === 'totalSaleDesc') {
                $query->withCount('invoice_items')->orderBy('invoice_items_count', 'desc');
            } elseif ($this->orderBy === 'totalSaleAsc') {
                $query->withCount('invoice_items')->orderBy('invoice_items_count', 'asc');
            } elseif ($this->orderBy === 'totalViewDesc') {
                $query->orderBy('view_count', 'desc');
            } elseif ($this->orderBy === 'totalViewAsc') {
                $query->orderBy('view_count', 'asc');
            } elseif ($this->orderBy === 'totalPriceDesc') {
                $query->orderBy('price', 'desc');
            } elseif ($this->orderBy === 'totalPriceAsc') {
                $query->orderBy('price', 'asc');
            }
        } else {
            $query->orderBy($this->sortBy, $this->sortDir);
        }

        // Apply status filter and pagination
        $products = $query->paginate($this->perPage);

        $categories = BookCategory::orderBy('name')->get();
        $subCategories = BookSubCategory::where('category_id', $this->category_id)->orderBy('name')->get();
        $brands = BookBrand::orderBy('name')->get();

        return view('livewire.service-table-data', [
            'products' => $products,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'brands' => $brands,
        ]);
    }
}
