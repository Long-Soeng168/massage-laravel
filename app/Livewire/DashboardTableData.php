<?php

namespace App\Livewire;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookBrand;
use App\Models\Customer;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Link;
use App\Models\News;
use App\Models\Publisher;
use App\Models\Supplier;
use App\Models\User;

class DashboardTableData extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $sortBy = 'order_index';

    #[Url(history: true)]
    public $sortDir = 'ASC';

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
    public function delete($id)
    {
        $item = Link::findOrFail($id);
        $item->delete();

        session()->flash('success', 'Successfully deleted!');
    }

    // ResetPage when updated search
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $items = Book::count();
        $items_with_file = Book::count();
        $brands = BookBrand::count();
        $customers = Customer::count();
        $suppliers = Supplier::count();
        $news = News::count();
        $users = User::count();

        $counts = [
            'items' => $items ?? 0,
            'items_with_file' => $items_with_file ?? 0,
            'brands' => $brands ?? 0,
            'customers' => $customers ?? 0,
            'suppliers' => $suppliers ?? 0,
            'news' => $news,
            'users' => $users,
        ];

        return view('livewire.dashboard-table-data', [
            'counts' => $counts,
        ]);
    }
}
