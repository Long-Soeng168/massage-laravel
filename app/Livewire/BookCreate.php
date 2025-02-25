<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookBrand;
use App\Models\BookSubCategory;

use Image;

class BookCreate extends Component
{
    use WithFileUploads;

    public $image;

    public $title = null;
    public $brand_id = null;
    public $price = null;
    public $cost = null;
    public $quantity = 0;
    public $discount = null;
    public $code = null;
    public $year = null;
    public $short_description = null;
    public $description = null;

    public $category_id = null;
    public $sub_category_id = null;

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

    public $newAuthorName = null;
    public $newAuthorGender = null;

    public $newPublisherName = null;
    public $newPublisherGender = null;

    public function save()
    {

        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'price' => 'required',
            'cost' => 'nullable',
            'quantity' => 'nullable',
            'discount' => 'nullable',
            'code' => 'nullable',
            'image' => 'nullable|image|max:2048',
            'year' => 'nullable',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'brand_id' => 'nullable',
            'category_id' => 'nullable',
            'sub_category_id' => 'nullable',
        ]);

        // dd($validated);
        $validated['user_id'] = request()->user()->id;

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
        }

        $createdPublication = Book::create($validated);

        // dd($createdPublication);
        return redirect('/admin/books')->with('success', 'Successfully Created!');

        // session()->flash('success', 'Successfully Submit!');
    }

    public $brand_image = null;
    public $brand_name = null;
    public $brand_name_kh = null;
    public $brand_order_index = null;

    public function save_brand()
    {
        try {
            $validated = $this->validate([
                'brand_name' => 'required|string|max:255|unique:brands,name',
                'brand_name_kh' => 'required|string|max:255',
                'brand_order_index' => 'nullable',
            ]);

            if (!empty($this->brand_image)) {
                // $filename = time() . '_' . $this->brand_image->getClientOriginalName();
                $filename = time() . str()->random(10) . '.' . $this->brand_image->getClientOriginalExtension();
                $this->brand_image->storeAs('brands', $filename, 'realPublicImagePath');
                $validated['image'] = $filename;
            }

            BookBrand::create([
                'name' => $this->brand_name,
                'name_kh' => $this->brand_name_kh,
                'order_index' => $this->brand_order_index,
                'image' => $filename ?? '',
            ]);

            session()->flash('success', 'Add New Brand successfully!');

            $this->reset(['brand_name', 'brand_name_kh', 'brand_order_index']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', $e->validator->errors()->all());
        }
    }
    public $category_image = null;
    public $category_name = null;
    public $category_name_kh = null;
    public $category_order_index = null;

    public function save_category()
    {
        try {
            $validated = $this->validate([
                'category_name' => 'required|string|max:255|unique:categories,name',
                'category_name_kh' => 'required|string|max:255',
                'category_order_index' => 'nullable',
            ]);

            if (!empty($this->category_image)) {
                // $filename = time() . '_' . $this->category_image->getClientOriginalName();
                $filename = time() . str()->random(10) . '.' . $this->category_image->getClientOriginalExtension();
                $this->category_image->storeAs('categories', $filename, 'realPublicImagePath');
                $validated['image'] = $filename;
            }

            BookCategory::create([
                'name' => $this->category_name,
                'name_kh' => $this->category_name_kh,
                'order_index' => $this->category_order_index,
                'image' => $filename ?? '',
            ]);

            session()->flash('success', 'Add New Category successfully!');

            $this->reset(['category_name', 'category_name_kh', 'category_order_index']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', $e->validator->errors()->all());
        }
    }


    public function render()
    {
        // dd($allKeywords);
        // dump($this->selectedallKeywords);
        $categories = BookCategory::orderBy('id', 'desc')->get();
        $subCategories = BookSubCategory::where('category_id', $this->category_id)->orderBy('id', 'desc')->get();
        $brands = BookBrand::orderBy('id', 'desc')->get();

        return view('livewire.book-create', [
            'categories' => $categories,
            'subCategories' => $subCategories,
            'brands' => $brands,
        ]);
    }
}
