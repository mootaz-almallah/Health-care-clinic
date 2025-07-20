<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pharma;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class PharmaController_Admin extends Controller
{
    public function index()
    {
        $pharmacies = Pharma::with('category')->paginate(10);
        $categories = Category::all();
        return view('admin.pharma_admin.index', compact('pharmacies', 'categories'));
    }
    
    // public function create()
    // {
    //     $categories = Category::all();
    //     return view('admin.pharma_admin.create', data: compact('categories'));
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
'image' => 'nullable|string|max:255',
        ]);


        Pharma::create($validated);

        return redirect()->route('pharmacies.index')
            ->with('success', 'Pharmacy created successfully.');
    }
    
    // public function show(Pharma $pharmacy)
    // {
    //     return view('admin.pharma_admin.show', compact('pharmacy'));
    // }
    
    // public function edit(Pharma $pharmacy)
    // {
    //     $categories = Category::all();
    //     return view('admin.pharma_admin.edit', compact('pharmacy', 'categories'));
    // }

    public function update(Request $request, Pharma $pharmacy)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
'image' => 'nullable|string|max:255',
        ]);

        

        $pharmacy->update($validated);

        return redirect()->route('pharmacies.index')
            ->with('success', 'Pharmacy updated successfully.');
    }
    
    public function destroy(Pharma $pharmacy)
    {
        if ($pharmacy->image) {
            Storage::disk('public')->delete($pharmacy->image);
        }
        
        $pharmacy->delete();

        return redirect()->route('pharmacies.index')
            ->with('success', 'Pharmacy deleted successfully.');
    }

    public function updateStatus(Request $request, Pharma $pharmacy)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,pending,inactive',
        ]);

        $pharmacy->update($validated);

        return redirect()->back()
            ->with('success', 'Pharmacy status updated successfully.');
    }
} 