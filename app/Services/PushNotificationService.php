<?php

namespace App\Services;

use App\Models\PushSubscription;
use Illuminate\Support\Facades\Log;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class PushNotificationService
{
    /**
     * Kirim push notification ke user
     */
    public function sendToUser($userId, $title, $message, $data = [])
    {
        $subscriptions = PushSubscription::where('user_id', $userId)->get();
        
        foreach ($subscriptions as $subscription) {
            $this->sendPushNotification(
                $subscription->endpoint,
                $subscription->public_key,
                $subscription->auth_token,
                $title,
                $message,
                $data
            );
        }
    }

    /**
     * Kirim push notification ke multiple users
     */
    public function sendToUsers($userIds, $title, $message, $data = [])
    {
        foreach ($userIds as $userId) {
            $this->sendToUser($userId, $title, $message, $data);
        }
    }

    /**
     * Kirim push notification menggunakan Web Push API
     */
    private function sendPushNotification($endpoint, $publicKey, $authToken, $title, $message, $data = [])
    {
        $publicVapidKey = env('VAPID_PUBLIC_KEY');
        $privateVapidKey = env('VAPID_PRIVATE_KEY');

        if (!$publicVapidKey || !$privateVapidKey) {
            Log::warning('VAPID keys not configured; push skipped');
            return false;
        }

        $subscription = Subscription::create([
            'endpoint' => $endpoint,
            'publicKey' => $publicKey,
            'authToken' => $authToken,
        ]);

        $payload = json_encode([
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ], JSON_UNESCAPED_UNICODE);

        $webPush = new WebPush([
            'VAPID' => [
                'subject' => env('APP_URL', 'https://example.org'),
                'publicKey' => $publicVapidKey,
                'privateKey' => $privateVapidKey,
            ],
        ]);

        $webPush->queueNotification($subscription, $payload);

        foreach ($webPush->flush() as $report) {
            if (!$report->isSuccess()) {
                Log::warning('Push failed: ' . $report->getReason());
            }
        }

        return true;
    }
}

