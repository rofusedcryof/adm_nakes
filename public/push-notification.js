// Push Notification Service
class PushNotificationService {
    constructor() {
        // ⚠️ PENTING: Ganti dengan VAPID Public Key Anda!
        // Cara mendapatkan: https://web-push-codelab.glitch.me/ atau https://vapidkeys.com/
        // Atau jalankan: npm install -g web-push && web-push generate-vapid-keys
        this.publicVapidKey = 'BJJfuV0o56MujWrpynftdpHqNJng33dSOF4fCCN6NuJBtmwmca9W8AE-t6pi_TmBAM2lwHa2KYfLF-CBvkoYLZs';
        this.subscription = null;
    }

    // Convert VAPID key to Uint8Array
    urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
            .replace(/\-/g, '+')
            .replace(/_/g, '/');

        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);

        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    // Subscribe to push notifications
    async subscribe() {
        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
            console.log('Push messaging is not supported');
            return false;
        }

        try {
            const registration = await navigator.serviceWorker.ready;
            
            // Check if already subscribed
            this.subscription = await registration.pushManager.getSubscription();
            
            if (this.subscription) {
                console.log('Already subscribed to push notifications');
                return true;
            }

            // Subscribe to push notifications
            this.subscription = await registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: this.urlBase64ToUint8Array(this.publicVapidKey)
            });

            // Send subscription to server
            await this.sendSubscriptionToServer(this.subscription);
            
            console.log('Successfully subscribed to push notifications');
            return true;
        } catch (error) {
            console.error('Error subscribing to push notifications:', error);
            return false;
        }
    }

    // Send subscription to server
    async sendSubscriptionToServer(subscription) {
        const response = await fetch('/api/push/subscribe', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({
                endpoint: subscription.endpoint,
                keys: {
                    p256dh: btoa(String.fromCharCode(...new Uint8Array(subscription.getKey('p256dh')))),
                    auth: btoa(String.fromCharCode(...new Uint8Array(subscription.getKey('auth'))))
                }
            })
        });

        if (!response.ok) {
            throw new Error('Failed to send subscription to server');
        }

        return await response.json();
    }

    // Unsubscribe from push notifications
    async unsubscribe() {
        if (!this.subscription) {
            return false;
        }

        try {
            await this.subscription.unsubscribe();
            await fetch('/api/push/unsubscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({
                    endpoint: this.subscription.endpoint
                })
            });
            
            this.subscription = null;
            console.log('Successfully unsubscribed from push notifications');
            return true;
        } catch (error) {
            console.error('Error unsubscribing from push notifications:', error);
            return false;
        }
    }
}

// Initialize push notification service
const pushService = new PushNotificationService();

// Auto-subscribe when page loads (if user is authenticated)
if (document.querySelector('meta[name="csrf-token"]')) {
    // Request notification permission
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                pushService.subscribe();
            }
        });
    } else if (Notification.permission === 'granted') {
        pushService.subscribe();
    }
}

