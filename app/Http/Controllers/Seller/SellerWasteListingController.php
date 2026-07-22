<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\WasteListing;
use App\Models\WasteCategory;
use App\Http\Requests\StoreWasteListingRequest;
use App\Http\Requests\UpdateWasteListingRequest;
use App\Http\Requests\ChangeListingAvailabilityRequest;
use App\Services\WasteListingService;
use App\Exceptions\RecyclinkException;
use Illuminate\Routing\Controllers\HasMiddleware;

class SellerWasteListingController extends Controller implements HasMiddleware
{
    protected WasteListingService $listingService;

    public function __construct(WasteListingService $listingService)
    {
        $this->listingService = $listingService;
    }

    public static function middleware(): array
    {
        return [
            'auth',
            'role:seller',
        ];
    }

    // ponytail: view owned listings with eager loading
    public function index()
    {
        $listings = auth()->user()->wasteListings()->with(['category', 'primaryImage'])->latest()->paginate(15);
        return view('seller.listings.index', compact('listings'));
    }

    // ponytail: creation form with categories
    public function create()
    {
        $categories = WasteCategory::getActiveCached();
        return view('seller.listings.create', compact('categories'));
    }

    // ponytail: store listing
    public function store(StoreWasteListingRequest $request)
    {
        $this->authorize('create', WasteListing::class);
        try {
            $validated = $request->validated();
            $listing = $this->listingService->createListing(auth()->user(), collect($validated)->except('images')->toArray());
            
            if ($request->hasFile('images')) {
                $this->listingService->uploadListingImages($listing, $request->file('images'));
            }
            
            return redirect()->route('seller.listings.index')->with('success', 'Listing submitted for admin review.');
        } catch (RecyclinkException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // ponytail: view listing details
    public function show(WasteListing $wasteListing)
    {
        $this->authorize('view', $wasteListing);

        $wasteListing->load(['category', 'images']);
        return view('seller.listings.show', compact('wasteListing'));
    }

    // ponytail: edit listing form
    public function edit(WasteListing $wasteListing)
    {
        $this->authorize('update', $wasteListing);

        $categories = WasteCategory::getActiveCached();
        return view('seller.listings.edit', compact('wasteListing', 'categories'));
    }

    // ponytail: update listing details
    public function update(UpdateWasteListingRequest $request, WasteListing $wasteListing)
    {
        $this->authorize('update', $wasteListing);

        try {
            $validated = $request->validated();
            $this->listingService->updateListing(auth()->user(), $wasteListing, collect($validated)->except('images')->toArray());
            
            if ($request->hasFile('images')) {
                $this->listingService->uploadListingImages($wasteListing, $request->file('images'));
            }
            
            return redirect()->route('seller.listings.index')->with('success', 'Listing updated successfully.');
        } catch (RecyclinkException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // ponytail: delete listing
    public function destroy(WasteListing $wasteListing)
    {
        $this->authorize('delete', $wasteListing);

        try {
            $this->listingService->deleteListing(auth()->user(), $wasteListing);
            return redirect()->route('seller.listings.index')->with('success', 'Listing deleted successfully.');
        } catch (RecyclinkException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // ponytail: change availability (available/sold_out/inactive)
    public function changeAvailability(ChangeListingAvailabilityRequest $request, WasteListing $wasteListing)
    {
        $this->authorize('update', $wasteListing);

        try {
            $this->listingService->changeAvailability(auth()->user(), $wasteListing, $request->validated()['status']);
            return redirect()->back()->with('success', 'Listing status changed successfully.');
        } catch (RecyclinkException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
