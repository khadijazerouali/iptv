<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\CategoryProduct;

class CategoriesManager extends Component
{
    public $categories;
    public $name;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = CategoryProduct::all();
    }

    public function save()
    {
        $this->validate();
        CategoryProduct::create(['name' => $this->name]);
        session()->flash('success', 'Catégorie créée !');
        $this->name = '';
        $this->loadCategories();
    }

    public function delete($id)
    {
        CategoryProduct::findOrFail($id)->delete();
        session()->flash('success', 'Catégorie supprimée !');
        $this->loadCategories();
    }

    public function render()
    {
        return view('livewire.admin.categories-manager');
    }
}
