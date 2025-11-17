<?php

namespace App\Services;

use App\Models\PushSubscription;
use Illuminate\Support\Facades\Log;

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
        // Untuk production, gunakan library seperti minishlink/web-push
        // Untuk development, kita bisa menggunakan JavaScript di client side
        
        // Simpan ke queue atau kirim langsung via API
        // Di sini kita akan menggunakan pendekatan hybrid:
        // 1. Simpan notifikasi ke database (sudah ada)
        // 2. Trigger push notification via service worker di client
        
        // Untuk sekarang, kita akan trigger via event yang akan di-handle oleh JavaScript
        return true;
    }
}

