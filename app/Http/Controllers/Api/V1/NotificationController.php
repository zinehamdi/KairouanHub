<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;

class NotificationController extends BaseApiController
{
	/**
	 * List user notifications.
	 */
	public function index(Request $request)
	{
		$user = $request->user();

		$notifications = $user->notifications()
			->paginate(20);

		return $this->successResponse([
			'data' => $notifications->items(),
			'unread_count' => $user->unreadNotifications()->count(),
			'pagination' => [
				'current_page' => $notifications->currentPage(),
				'last_page' => $notifications->lastPage(),
				'per_page' => $notifications->perPage(),
				'total' => $notifications->total(),
			],
		]);
	}

	/**
	 * Mark notification as read.
	 */
	public function markAsRead(Request $request, $id)
	{
		$user = $request->user();

		$notification = $user->notifications()->find($id);

		if (!$notification) {
			return $this->errorResponse('Notification not found', 404);
		}

		$notification->markAsRead();

		return $this->successResponse(null, 'Notification marked as read');
	}

	/**
	 * Mark all notifications as read.
	 */
	public function markAllAsRead(Request $request)
	{
		$user = $request->user();
		$user->unreadNotifications->markAsRead();

		return $this->successResponse(null, 'All notifications marked as read');
	}
}
