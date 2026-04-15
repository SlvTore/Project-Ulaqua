<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::latest()->get();
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['nullable', 'email', 'max:255', Rule::unique('clients')->whereNull('deleted_at')],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',  // TAMBAHAN BARU
            'longitude' => 'nullable|numeric' // TAMBAHAN BARU
        ]);

        Client::create($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['nullable', 'email', 'max:255', Rule::unique('clients')->ignore($client->id)->whereNull('deleted_at')],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',  // TAMBAHAN BARU
            'longitude' => 'nullable|numeric' // TAMBAHAN BARU
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }

    /**
     * Update tag for a client.
     */
    public function updateTag(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $client->update(['tag' => $request->tag]);
        return back()->with('success', 'Tag klien berhasil diperbarui.');
    }

    /**
     * Update photo for a client.
     */
    public function updatePhoto(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $client = Client::findOrFail($id);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($client->photo && Storage::disk('public')->exists($client->photo)) {
                Storage::disk('public')->delete($client->photo);
            }

            // Simpan foto baru ke folder klien
            $path = $request->file('photo')->store('clients', 'public');
            $client->update(['photo' => $path]);
        }

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}
