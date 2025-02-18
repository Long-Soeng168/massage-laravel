<?php

namespace App\Livewire;

use App\Models\BookBrand;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\BookSubCategory;

use Image;

class BookEdit extends Component
{
    use WithFileUploads;

    public $item;
    public $image;

    public $title = null;
    public $brand_id = null;
    public $price = null;
    public $cost = null;
    public $quantity = 0;
    public $discount = null;
    public $year = null;
    public $short_description = null;
    public $description = null;

    public $category_id = null;
    public $sub_category_id = null;

    public function mount($id)
    {
        $this->item = Book::findOrFail($id);
        // if(request()->user()->id !== $this->item->publisher_id && !request()->user()->hasRole(['super-admin', 'admin'])){
        //     return redirect('admin/books')->with('error', ['Only Onwer or Admin can update!']);
        // }

        $this->title = $this->item->title;
        $this->price = $this->item->price;
        $this->cost = $this->item->cost;
        $this->quantity = $this->item->quantity;
        $this->description = $this->item->description;
        $this->brand_id = $this->item->brand_id;
        $this->category_id = $this->item->category_id;
        $this->sub_category_id = $this->item->sub_category_id;
        $this->short_description = $this->item->short_description;
        $this->discount = $this->item->discount;
        $this->year = $this->item->year;
    }


    public function updatedCategory_id()
    {
        $this->sub_category_id = null;
    }

    public function updated()
    {
        $this->dispatch('livewire:updated');
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:2048', // 2MB Max
        ]);

        session()->flash('success', 'Image successfully uploaded!');
    }


    public function save()
    {

        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'price' => 'required',
            'cost' => 'nullable',
            'quantity' => 'nullable',
            'discount' => 'nullable',
            'year' => 'nullable',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'brand_id' => 'nullable',
            'category_id' => 'nullable',
            'sub_category_id' => 'nullable',
        ]);

        // dd($validated);
        $validated['last_edit_user_id'] = request()->user()->id;

        foreach ($validated as $key => $value) {
            if (is_null($value) || $value === '') {
                $validated[$key] == null;
            }
        }

        if (!empty($this->image)) {
            // $filename = time() . '_' . $this->image->getClientOriginalName();
            $filename = time() . str()->random(10) . '.' . $this->image->getClientOriginalExtension();

            $image_path = public_path('assets/images/isbn/' . $filename);
            $image_thumb_path = public_path('assets/images/isbn/thumb/' . $filename);
            $imageUpload = Image::make($this->image->getRealPath())->save($image_path);
            $imageUpload->resize(600, null, function ($resize) {
                $resize->aspectRatio();
            })->save($image_thumb_path);
            $validated['image'] = $filename;

            if (!empty($this->item->image)) {
                $oldImagePath = public_path('assets/images/isbn/' . $this->item->image);
                $oldThumbPath = public_path('assets/images/isbn/thumb/' . $this->item->image);

                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                if (file_exists($oldThumbPath)) {
                    unlink($oldThumbPath);
                }
            }
        }
        $createdPublication = $this->item->update($validated);

        // dd($createdPublication);
        return redirect('/admin/books')->with('success', 'Successfully Created!');

        // session()->flash('success', 'Successfully Submit!');
    }

    public function updatedFile()
    {
        $this->validate([
            'file' => 'file|max:51200', // 2MB Max
        ]);

        session()->flash('success', 'file successfully uploaded!');
    }

    public function render()
    {
        // dd($allKeywords);
        // dump($this->selectedallKeywords);
        $categories = BookCategory::orderBy('name')->get();
        $subCategories = BookSubCategory::where('category_id', $this->category_id)->orderBy('name')->get();
        $brands = BookBrand::orderBy('name')->get();

        return view('livewire.book-create', [
            'categories' => $categories,
            'subCategories' => $subCategories,
            'brands' => $brands,
        ]);
    }
}
