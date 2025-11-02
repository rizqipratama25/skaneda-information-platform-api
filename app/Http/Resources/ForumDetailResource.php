<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ForumDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "forum_name" => $this->forum_name,
            "status" => $this->status->status,
            "chats" => $this->chats->map(function ($chat) {
                return [
                    "user_status" => $chat->user->role->name,
                    "username" => $chat->user->username,
                    "chat" => $chat->chat,
                    "status" => $chat->status->status
                ];
            })
        ];
    }
}
