<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\PushNotificationService;

class PushNotificationController extends Controller
{
    /**
     * Simpan push subscription dari user
     */
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'endpoint' => 'required|url',
            'keys' => 'required|array',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
        ]);

        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        PushSubscription::updateOrCreate(
            [
                'user_id' => $user->id,
                'endpoint' => $validated['endpoint'],
            ],
            [
                'public_key' => $validated['keys']['p256dh'],
                'auth_token' => $validated['keys']['auth'],
            ]
        );

        return response()->json(['success' => true]);
    }

    /**
     * Hapus push subscription
     */
    public function unsubscribe(Request $request)
    {
        $validated = $request->validate([
            'endpoint' => 'required|url',
        ]);

        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        PushSubscription::where('user_id', $user->id)
            ->where('endpoint', $validated['endpoint'])
            ->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Trigger push notification untuk testing
     */
    public function trigger(Request $request)
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get user's subscription
        $subscription = PushSubscription::where('user_id', $user->id)->first();
        
        if (!$subscription) {
            return response()->json(['error' => 'No subscription found'], 404);
        }

        // Return subscription data untuk dikirim via JavaScript
        return response()->json([
            'success' => true,
            'subscription' => [
                'endpoint' => $subscription->endpoint,
                'keys' => [
                    'p256dh' => $subscription->public_key,
                    'auth' => $subscription->auth_token
                ]
            ]
        ]);
    }

    /**
     * Kirim push notifikasi ke satu subscription (opsional, untuk testing)
     */
    public function send(Request $request)
    {
        $request->validate([
            'subscription' => ['required','array'],
            'subscription.endpoint' => ['required','url'],
            'subscription.keys' => ['required','array'],
            'subscription.keys.p256dh' => ['required','string'],
            'subscription.keys.auth' => ['required','string'],
            'title' => ['required','string'],
            'message' => ['required','string'],
            'data' => ['nullable','array'],
        ]);

        $push = new PushNotificationService();
        $ok = $push->sendToUser(auth()->id(), $request->title, $request->message, $request->data ?? []);

        return response()->json(['success' => (bool) $ok]);
    }

    /**
     * Kirim push ke seluruh subscription milik user tertentu
     */
    public function triggerUser(Request $request, $userId)
    {
        $request->validate([
            'title' => ['required','string'],
            'message' => ['required','string'],
            'data' => ['nullable','array'],
        ]);

        $push = new PushNotificationService();
        $push->sendToUsers([$userId], $request->title, $request->message, $request->data ?? []);

        return response()->json(['success' => true]);
    }
}
