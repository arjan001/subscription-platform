<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Website;

class SubscriptionController extends Controller
{
    /**
     * Subscribe a user to a website.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $websiteId
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe(Request $request, $websiteId)
    {
        // Validate email input
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        // Create or fetch the user by email
        $user = User::firstOrCreate(['email' => $validated['email']]);

        // Find the website or fail with a 404 error
        $website = Website::findOrFail($websiteId);

        // Attach the user to the website's subscribers, avoiding duplicates
        $website->subscribers()->syncWithoutDetaching($user->id);

        return response()->json([
            'message' => 'Subscribed successfully',
            'user' => $user->only(['id', 'email']),
            'website' => $website->only(['id', 'name']),
        ], 200);
    }
}
