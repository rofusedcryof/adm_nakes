// Function to send push notification using Web Push API
async function sendPushNotification(subscription, title, message, data = {}) {
    try {
        const response = await fetch('/api/push/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({
                subscription: subscription,
                title: title,
                message: message,
                data: data
            })
        });

        if (!response.ok) {
            throw new Error('Failed to send push notification');
        }

        return await response.json();
    } catch (error) {
        console.error('Error sending push notification:', error);
        return null;
    }
}

// Function to trigger push notification for all subscribers of a user
async function triggerPushForUser(userId, title, message, data = {}) {
    try {
        const response = await fetch(`/api/push/trigger-user/${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({
                title: title,
                message: message,
                data: data
            })
        });

        return await response.json();
    } catch (error) {
        console.error('Error triggering push notification:', error);
        return null;
    }
}

