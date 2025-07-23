<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Devicetype;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class ProductsManager extends Component
{
    use WithFileUploads;
    public $products;
    public $categories;
    public $devices;
    public $showForm = false;
    public $editMode = false;
    public $productId;
    public $title, $category_uuid, $status = 'actif', $selectedDevices = [], $options = [];
    public $image;
    public $type = '';
    public $description = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'category_uuid' => 'required|exists:category_products,uuid',
        'status' => 'required|string',
        'type' => 'required',
        'selectedDevices' => 'nullable|array',
        'selectedDevices.*' => 'exists:devicetypes,uuid',
        'options' => 'required|array|min:1',
        'options.*.name' => 'required|string',
        'options.*.price' => 'required|numeric',
        'image' => 'nullable|image|max:2048',
        'description' => 'nullable|string',
    ];

    public function mount()
    {
        $this->loadAll();
    }

    public function loadAll()
    {
        $this->products = Product::with(['productOptions', 'devices', 'category'])->get();
        $this->categories = CategoryProduct::all();
        $this->devices = Devicetype::all();
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editMode = false;
    }

    public function showEditForm($id)
    {
        $product = Product::with(['productOptions', 'devices'])->findOrFail($id);
        $this->productId = $product->uuid;
        $this->title = $product->title;
        $this->category_uuid = $product->category_uuid;
        $this->status = $product->status;
        $this->type = $product->type;
        $this->selectedDevices = $product->devices->pluck('uuid')->toArray();
        $this->options = $product->productOptions->map(function($opt) {
            return [
                'uuid' => $opt->uuid,
                'name' => $opt->name,
                'price' => $opt->price,
            ];
        })->toArray();
        $this->image = null;
        $this->description = $product->description;
        $this->showForm = true;
        $this->editMode = true;
    }

    public function addOption()
    {
        $this->options[] = ['name' => '', 'price' => ''];
    }

    public function removeOption($index)
    {
        array_splice($this->options, $index, 1);
    }

    public function save()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $imagePath = null;
            if ($this->image) {
                $imagePath = $this->image->store('products', 'public');
            }
            if ($this->editMode) {
                $product = Product::findOrFail($this->productId);
                $updateData = [
                    'title' => $this->title,
                    'category_uuid' => $this->category_uuid,
                    'status' => $this->status,
                    'type' => $this->type,
                    'price' => $this->options[0]['price'] ?? 0,
                    'description' => $this->description,
                ];
                if ($imagePath) {
                    $updateData['image'] = $imagePath;
                }
                $product->update($updateData);
            } else {
                $createData = [
                    'title' => $this->title,
                    'category_uuid' => $this->category_uuid,
                    'status' => $this->status,
                    'type' => $this->type,
                    'price' => $this->options[0]['price'] ?? 0,
                    'description' => $this->description,
                ];
                if ($imagePath) {
                    $createData['image'] = $imagePath;
                }
                $product = Product::create($createData);
            }
            $product->devices()->sync($this->selectedDevices ?? []);
            // Gérer les options
            $existingIds = [];
            foreach ($this->options as $option) {
                if (!empty($option['uuid'])) {
                    $product->productOptions()->where('uuid', $option['uuid'])->update([
                        'name' => $option['name'],
                        'price' => $option['price'],
                    ]);
                    $existingIds[] = $option['uuid'];
                } else {
                    $newOption = $product->productOptions()->create([
                        'name' => $option['name'],
                        'price' => $option['price'],
                    ]);
                    $existingIds[] = $newOption->uuid;
                }
            }
            $product->productOptions()->whereNotIn('uuid', $existingIds)->delete();
            DB::commit();
            session()->flash('success', $this->editMode ? 'Produit modifié !' : 'Produit ajouté !');
            $this->showForm = false;
            $this->resetForm();
            $this->loadAll();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->productOptions()->delete();
        $product->devices()->detach();
        $product->delete();
        session()->flash('success', 'Produit supprimé !');
        $this->loadAll();
    }

    public function resetForm()
    {
        $this->reset(['title', 'category_uuid', 'status', 'selectedDevices', 'options', 'productId', 'image', 'type', 'description']);
        $this->options = [['name' => '', 'price' => '']];
    }

    public function cancel()
    {
        $this->showForm = false;
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.admin.products-manager');
    }
}
