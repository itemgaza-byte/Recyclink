<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWasteListingRequest extends FormRequest
{
    // ponytail: seller role only
    public function authorize(): bool
    {
        return $this->user()?->isSeller() ?? false;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'sometimes|required|exists:waste_categories,id',
            'title' => 'sometimes|required|string|min:5|max:150',
            'description' => 'sometimes|required|string|min:10',
            'quantity' => 'sometimes|required|numeric|min:0.01',
            'unit' => 'sometimes|required|string|in:kg,liter,pcs,karung',
            'price_per_unit' => 'sometimes|required|numeric|min:1000',
            'address' => 'sometimes|required|string|min:5',
            'city' => 'sometimes|required|string|max:100',
            'province' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori limbah wajib dipilih.',
            'category_id.exists' => 'Kategori limbah yang dipilih tidak valid.',
            'title.required' => 'Judul listing limbah wajib diisi.',
            'title.min' => 'Judul listing minimal 5 karakter.',
            'title.max' => 'Judul listing maksimal 150 karakter.',
            'description.required' => 'Deskripsi limbah wajib diisi.',
            'description.min' => 'Deskripsi limbah minimal 10 karakter.',
            'quantity.required' => 'Volume/jumlah limbah wajib diisi.',
            'quantity.numeric' => 'Volume limbah harus berupa angka.',
            'quantity.min' => 'Volume limbah minimal 0.01.',
            'unit.required' => 'Satuan limbah wajib dipilih.',
            'unit.in' => 'Satuan limbah tidak valid.',
            'price_per_unit.required' => 'Harga per satuan wajib diisi.',
            'price_per_unit.numeric' => 'Harga per satuan harus berupa angka.',
            'price_per_unit.min' => 'Harga per satuan minimal Rp 1.000.',
            'address.required' => 'Alamat pengambilan limbah wajib diisi.',
            'address.min' => 'Alamat pengambilan minimal 5 karakter.',
            'city.required' => 'Kota/Kabupaten lokasi limbah wajib diisi.',
            'images.*.image' => 'File yang diunggah harus berupa gambar.',
            'images.*.mimes' => 'Format foto yang diizinkan hanya JPG, JPEG, PNG, dan WEBP.',
            'images.*.max' => 'Ukuran foto maksimal 2MB per file.',
        ];
    }
}
