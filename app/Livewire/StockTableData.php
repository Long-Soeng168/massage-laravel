<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Book;
use App\Models\BookBrand;
use App\Models\BookCategory;
use Maatwebsite\Excel\Facades\Excel;

class StockTableData extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $sortBy = 'quantity';

    #[Url(history: true)]
    public $sortDir = 'asc';
    public $category_id = null;
    public $brand_id = null;
    public $start_date = null;
    public $end_date = null;
    public $createdBy = null;
    public $quantitySort = null;
 
    // ResetPage when updated search
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedCategory_id()
    {
        $this->resetPage();
    }
    public function updatedQuantitySort()
    {
        $this->resetPage();
    }

    public function export()
    {
        $start_date = $this->start_date;
        $end_date = $this->end_date;
        $search = $this->search;
        $createdBy = $this->createdBy;
        $category_id = $this->category_id;
        $brand_id = $this->brand_id;
        $sortBy = $this->sortBy;
        $sortDir = $this->sortDir;
        $quantitySort = $this->quantitySort;

        return Excel::download(new class($start_date, $end_date, $search, $createdBy, $category_id, $brand_id, $sortBy, $sortDir, $quantitySort) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $start_date;
            private $end_date;
            private $search;
            private $createdBy;
            private $category_id;
            private $brand_id;
            private $sortBy;
            private $sortDir;
            private $quantitySort;

            public function __construct($start_date, $end_date, $search, $createdBy, $category_id, $brand_id, $sortBy, $sortDir, $quantitySort)
            {
                $this->start_date = $start_date;
                $this->end_date = $end_date;
                $this->search = $search;
                $this->createdBy = $createdBy;
                $this->category_id = $category_id;
                $this->brand_id = $brand_id;
                $this->sortBy = $sortBy;
                $this->sortDir = $sortDir;
                $this->quantitySort = $quantitySort;
            }

            public function collection()
            {
                $query = Book::query();

                if (!empty($this->search)) {
                    $searchTerm = trim($this->search);
        
                    $query->where(function ($subQuery) use ($searchTerm) {
                        $subQuery->where('code', 'LIKE', "%{$searchTerm}%")->orWhere('title', 'LIKE', "%{$searchTerm}%");
                    });
                }
        
                if ($this->category_id) {
                    $query->where('category_id', $this->category_id);
                }  
                if ($this->brand_id) {
                    $query->where('brand_id', $this->brand_id);
                }  

                if ($this->quantitySort == 'zero') {
                    $query->where('quantity', 0);
                }elseif ($this->quantitySort == 'below') {
                    $query->where('quantity', '<', 0);
                }elseif ($this->quantitySort == 'above') {
                    $query->where('quantity', '>', 0);
                } 
                return  $query
                    ->orderBy('quantity', 'ASC')->orderBy('id', 'desc')
                    ->get()
                    ->map(function ($item, $index) {
                        return [
                            'No' => $index + 1,
                            'Product' => $item->title,
                            'Code' => $item->code,
                            'Quantity' => $item->quantity,
                            'Category' => $item->category->name ?? 'N/A',
                            'Brand' => $item->brand->name ?? 'N/A',
                            // 'Created By' => $item->user->name ?? 'N/A', // User who created the item
                            // 'Updated By' => $item->updatedBy->name ?? 'N/A', // User who created the item
                        ];
                    });
            }

            public function headings(): array
            {
                // Define the column headings
                return [
                    'No',
                    'Product',
                    'Code',
                    'Quantity',
                    'Category',
                    'Brand',
                    // 'Created By',
                    // 'Updated By',
                ];
            }
        }, 'stockItems.xlsx');
    }

    public function render()
    {
        $query = Book::query();

        if (!empty($this->search)) {
            $searchTerm = trim($this->search);

            $query->where(function ($subQuery) use ($searchTerm) {
                $subQuery->where('code', 'LIKE', "%{$searchTerm}%")->orWhere('title', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($this->quantitySort == 'zero') {
            $query->where('quantity', 0);
        }elseif ($this->quantitySort == 'below') {
            $query->where('quantity', '<', 0);
        }elseif ($this->quantitySort == 'above') {
            $query->where('quantity', '>', 0);
        } 

        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }  
        if ($this->brand_id) {
            $query->where('brand_id', $this->brand_id);
        }  

        $items = $query
            ->orderBy($this->sortBy, $this->sortDir)->orderBy('id', 'desc')
            ->paginate($this->perPage); 

        $categories = BookCategory::orderBy('name')->get();
        $brands = BookBrand::orderBy('name')->get();

        return view('livewire.stock-table-data', [
            'items' => $items,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
}
