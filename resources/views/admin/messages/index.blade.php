@extends('admin.layouts.admin_layout')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content" style="background: #f1f5f9; min-height: calc(100vh - 70px);">
            <div class="container-fluid" style="padding: 20px;">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            style="background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; display: flex; height: 750px;">

                            <!-- Left Sidebar: Conversations (For Super Admin) -->
                            @if(Auth::guard('admin')->user()->role->role_name == 'SUPER_ADMIN')
                                <div
                                    style="width: 320px; border-right: 1px solid #f1f5f9; background: #fff; display: flex; flex-direction: column;">
                                    <div style="padding: 25px; border-bottom: 1px solid #f1f5f9;">
                                        <h4 style="font-weight: 800; color: #1e293b; margin: 0;">Mesajlarım</h4>
                                        <p style="font-size: 13px; color: #64748b; margin-top: 5px;">Personel yazışmaları</p>
                                    </div>
                                    <div id="conversation-list" style="flex: 1; overflow-y: auto;">
                                        <!-- Conversations will be loaded here -->
                                        <div style="text-align: center; color: #94a3b8; margin-top: 50px;">
                                            <i class="fa fa-spinner fa-spin" style="font-size: 24px;"></i>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Right Area: Chat Window -->
                            <div style="flex: 1; display: flex; flex-direction: column; background: #fff;">
                                <!-- Chat Header -->
                                <div id="chat-header"
                                    style="padding: 20px 30px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <div id="target-avatar"
                                            style="width: 45px; height: 45px; border-radius: 12px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700;">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div>
                                            <h5 id="target-name" style="font-weight: 700; color: #1e293b; margin: 0;">Sistem
                                                Yöneticisi</h5>
                                            <p id="target-status"
                                                style="font-size: 12px; color: #10b981; margin: 0; font-weight: 600;">
                                                Çevrimiçi</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Chat Messages -->
                                <div id="main-chat-messages"
                                    style="flex: 1; overflow-y: auto; padding: 30px; background: #f8fafc; display: flex; flex-direction: column;">
                                    <div style="text-align: center; color: #94a3b8; margin-top: 150px;">
                                        <i class="fa fa-comments-o" style="font-size: 48px; opacity: 0.2;"></i>
                                        <p style="margin-top: 15px; font-weight: 600;">Yazışmaya başlamak için birini seçin
                                            veya mesaj yazın.</p>
                                    </div>
                                </div>

                                <!-- Chat Input -->
                                <div
                                    style="padding: 25px 30px; border-top: 1px solid #f1f5f9; display: flex; gap: 15px; align-items: flex-end;">
                                    <textarea id="main-chat-input" class="form-control" rows="1"
                                        placeholder="Mesajınızı buraya yazın..."
                                        style="resize: none; border-radius: 15px !important; padding: 15px 20px !important; border: 1px solid #e2e8f0; font-size: 14px; min-height: 50px;"></textarea>
                                    <button id="btn-main-send" class="btn btn-primary"
                                        style="width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center; padding: 0; border: none; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); box-shadow: 0 4px 12px rgba(59,130,246,0.3);">
                                        <i class="fa fa-paper-plane" style="font-size: 18px;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #conversation-list::-webkit-scrollbar,
        #main-chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        #conversation-list::-webkit-scrollbar-thumb,
        #main-chat-messages::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .conv-item {
            padding: 15px 25px;
            border-bottom: 1px solid #f1f5f9;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .conv-item:hover {
            background: #f8fafc;
        }

        .conv-item.active {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
        }

        .message-bubble {
            max-width: 75%;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        .message-bubble.me {
            align-self: flex-end;
            align-items: flex-end;
        }

        .message-bubble.other {
            align-self: flex-start;
            align-items: flex-start;
        }

        .bubble-content {
            padding: 12px 18px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: 500;
            line-height: 1.5;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .message-bubble.me .bubble-content {
            background: #e0f2fe;
            color: #0369a1;
            border-bottom-right-radius: 2px;
        }

        .message-bubble.other .bubble-content {
            background: #fff;
            color: #334155;
            border: 1px solid #f1f5f9;
            border-bottom-left-radius: 2px;
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            const isSuperAdmin = {{ Auth::guard('admin')->user()->role->role_name == 'SUPER_ADMIN' ? 'true' : 'false' }};
            let activeTargetId = isSuperAdmin ? null : {{ $superAdminId }};
            const messagesContainer = $('#main-chat-messages');
            const conversationList = $('#conversation-list');
            const chatInput = $('#main-chat-input');
            const btnSend = $('#btn-main-send');

            function loadHistory(targetId) {
                if (!targetId) return;
                messagesContainer.html('<div style="text-align: center; color: #94a3b8; margin-top: 150px;"><i class="fa fa-spinner fa-spin" style="font-size: 24px;"></i></div>');

                $.get('{{ route('admin.messages.history', '') }}/' + targetId, function (data) {
                    messagesContainer.empty();
                    if (data.length === 0) {
                        messagesContainer.append('<div style="text-align: center; color: #94a3b8; margin-top: 50px;">Henüz mesaj bulunmuyor.</div>');
                    } else {
                        data.forEach(function (msg) {
                            const isMe = msg.sender_id == {{ Auth::guard('admin')->user()->id }};
                            const type = isMe ? 'me' : 'other';
                            const msgHtml = `
                            <div class="message-bubble ${type}">
                                <div class="bubble-content">${msg.message}</div>
                                <small style="font-size: 10px; color: #94a3b8; margin-top: 5px;">${new Date(msg.created_at).toLocaleTimeString('tr-TR', { hour: '2-digit', minute: '2-digit' })}</small>
                            </div>
                        `;
                            messagesContainer.append(msgHtml);
                        });
                        messagesContainer.scrollTop(messagesContainer[0].scrollHeight);
                    }
                });
            }

            if (isSuperAdmin) {
                function loadConversations() {
                    $.get('{{ route('admin.messages.recent') }}', function (data) {
                        conversationList.empty();
                        // Filter unique senders
                        const uniqueConversations = [];
                        const seenIds = new Set();

                        data.forEach(msg => {
                            const otherId = msg.sender_id;
                            if (!seenIds.has(otherId)) {
                                seenIds.add(otherId);
                                uniqueConversations.push(msg);
                            }
                        });

                        if (uniqueConversations.length === 0) {
                            conversationList.append('<div style="text-align: center; color: #94a3b8; padding: 30px;">Henüz bir yazışma yok.</div>');
                        } else {
                            uniqueConversations.forEach(msg => {
                                const sender = msg.sender;
                                const item = $(`
                                <div class="conv-item ${activeTargetId == sender.id ? 'active' : ''}" data-id="${sender.id}">
                                    <div style="width: 40px; height: 40px; border-radius: 10px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #3b82f6;">
                                        ${sender.name.substr(0, 1)}
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <div style="font-weight: 700; color: #1e293b; font-size: 14px;">${sender.name}</div>
                                        <div style="font-size: 12px; color: #64748b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${msg.message}</div>
                                    </div>
                                    ${msg.is_read == 0 && msg.receiver_id == {{ Auth::guard('admin')->id() }} ? '<div style="width: 8px; height: 8px; border-radius: 50%; background: #3b82f6;"></div>' : ''}
                                </div>
                            `);
                                conversationList.append(item);

                                item.on('click', function () {
                                    activeTargetId = sender.id;
                                    $('.conv-item').removeClass('active');
                                    $(this).addClass('active');
                                    $('#target-name').text(sender.name);
                                    loadHistory(sender.id);
                                });
                            });
                        }
                    });
                }
                loadConversations();
            } else {
                // Personel view
                loadHistory(activeTargetId);
            }

            btnSend.on('click', function () {
                const val = chatInput.val().trim();
                if (!val || !activeTargetId) return;

                btnSend.prop('disabled', true);
                $.post('{{ route('admin.messages.send') }}', {
                    _token: '{{ csrf_token() }}',
                    receiver_id: activeTargetId,
                    message: val
                }, function () {
                    chatInput.val('').trigger('input');
                    btnSend.prop('disabled', false);
                    loadHistory(activeTargetId);
                    if (isSuperAdmin) loadConversations();
                });
            });

            chatInput.on('keypress', function (e) {
                if (e.which == 13 && !e.shiftKey) {
                    e.preventDefault();
                    btnSend.click();
                }
            });
        });
    </script>
@endpush