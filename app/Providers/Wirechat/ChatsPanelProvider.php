<?php
namespace App\Providers\Wirechat;

use Wirechat\Wirechat\Panel;
use Wirechat\Wirechat\PanelProvider;
use Wirechat\Wirechat\Support\Enums\EmojiPickerPosition;
use Wirechat\Wirechat\Support\Enums\UnreadIndicatorType;
use Wirechat\Wirechat\Support\Color;

class ChatsPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
             ->id('chats')
             ->path('chats')
             ->chatsSearch()
             ->redirectToHomeAction()
             ->createChatAction()
             ->middleware(['web','auth'])
             ->unreadIndicator(type: UnreadIndicatorType::Count)
             ->settings()
             ->emojiPicker(position: EmojiPickerPosition::Docked)
             ->attachments()
             ->colors([
                'primary' => Color::Orange,
             ])
             ->heading('Chat')
             ->createGroupAction()
             ->clearChatAction()
             ->deleteChatAction()
             ->deleteMessageActions()
             ->messageReplyAction()
             ->redirectToHomeAction(url: '/auth')
             ->webPushNotifications()
             ->messagesQueue('messages')
             ->eventsQueue('default')
             ->default();
    }
}
