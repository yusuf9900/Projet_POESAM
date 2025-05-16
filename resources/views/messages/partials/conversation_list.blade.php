<!-- Conversation List -->
<div class="conversation-list">
    <div class="conversation-header">
        <h4>Messages</h4>
        <a href="{{ route('messages.index') }}" class="new-conversation-btn">
            <i class="fas fa-plus"></i>
        </a>
    </div>
    <div class="search-box">
        <input type="text" class="search-input" placeholder="Rechercher une conversation...">
    </div>
    <div class="conversations">
        @if(isset($conversations) && $conversations->count() > 0)
            @foreach($conversations as $conv)
                @php
                    $otherUser = $conv->users->where('id', '!=', session('user_id'))->first();
                    $unreadCount = $conv->messagesNonLus(session('user_id'));
                    $lastMessage = $conv->dernierMessage;
                    $isUnread = $unreadCount > 0;
                    $isActive = isset($currentConversation) && $currentConversation->id == $conv->id;
                    $timestamp = $lastMessage ? $lastMessage->created_at : $conv->created_at;
                    $displayTime = $timestamp->isToday() ? $timestamp->format('H:i') : $timestamp->format('d/m/Y');
                @endphp
                <a href="{{ route('messages.show', $conv->id) }}" class="conversation-item {{ $isUnread ? 'unread' : '' }} {{ $isActive ? 'active' : '' }}">
                    <div class="user-avatar {{ $conv->est_groupe ? 'group-icon' : '' }}">
                        @if($conv->est_groupe)
                            <i class="fas fa-users"></i>
                        @else
                            {{ $otherUser ? substr($otherUser->name, 0, 1) : '?' }}
                        @endif
                    </div>
                    <div class="conversation-info">
                        <div class="conversation-name">
                            @if($conv->est_groupe)
                                {{ $conv->titre }}
                            @else
                                {{ $otherUser ? $otherUser->name : 'Utilisateur inconnu' }}
                            @endif
                        </div>
                        <div class="conversation-last-message">
                            {{ $lastMessage ? \Illuminate\Support\Str::limit($lastMessage->contenu, 30) : 'Aucun message' }}
                        </div>
                    </div>
                    <div class="conversation-meta">
                        <div class="conversation-time">{{ $displayTime }}</div>
                        @if($isUnread)
                            <div class="unread-count">{{ $unreadCount }}</div>
                        @endif
                    </div>
                </a>
            @endforeach
        @else
            <div class="p-4 text-center text-muted">
                Aucune conversation pour le moment
            </div>
        @endif
    </div>
</div>
