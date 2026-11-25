<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Chat - CLAIRE</title>

    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&family=Nanum+Myeongjo:wght@400;700&display=swap" rel="stylesheet">

    @vite('resources/js/app.js')

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Raleway', sans-serif;
            background: #f5f7f4;
            color: #26382b;
            min-height: 100vh;
        }

        .navbar {
            height: 75px;
            background: #24442f;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 7%;
            color: white;
        }

        .logo {
            font-family: 'Nanum Myeongjo', serif;
            font-size: 29px;
            letter-spacing: 4px;
            color: white;
            text-decoration: none;
        }

        .back-link {
            color: white;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .page-container {
            max-width: 1050px;
            margin: 45px auto;
            padding: 0 20px;
        }

        .page-title {
            margin-bottom: 22px;
        }

        .page-title h1 {
            font-family: 'Nanum Myeongjo', serif;
            font-size: 30px;
            color: #24442f;
            margin-bottom: 8px;
        }

        .page-title p {
            color: #7a857c;
            font-size: 13px;
        }

        .chat-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid #e8ede8;
            box-shadow: 0 8px 30px rgba(36, 68, 47, 0.07);
            display: flex;
            flex-direction: column;
            height: 650px;
        }

        .chat-header {
            background: #24442f;
            color: white;
            padding: 20px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .avatar {
            width: 43px;
            height: 43px;
            border-radius: 50%;
            background: #e5eee5;
            color: #24442f;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 17px;
            flex-shrink: 0;
        }

        .user-details h3 {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .user-details p {
            font-size: 11px;
            color: #d3e0d4;
        }

        .online-status {
            font-size: 11px;
            color: #dcebdc;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            background: #8bd49b;
            border-radius: 50%;
        }

        .chat-messages {
            flex: 1;
            padding: 25px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
            background: #fbfcfa;
        }

        .message {
            max-width: 70%;
            padding: 12px 15px;
            border-radius: 12px;
            font-size: 13px;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        .message.sent {
            align-self: flex-end;
            background: #24442f;
            color: white;
            border-bottom-right-radius: 3px;
        }

        .message.received {
            align-self: flex-start;
            background: #edf1ec;
            color: #26382b;
            border-bottom-left-radius: 3px;
        }

        .message small {
            display: block;
            font-size: 10px;
            margin-top: 7px;
            opacity: 0.7;
            text-align: right;
        }

        .empty-chat {
            margin: auto;
            text-align: center;
            color: #9aa39a;
            font-size: 13px;
        }

        .chat-footer {
            padding: 17px 22px;
            border-top: 1px solid #edf0ed;
            background: white;
        }

        .chat-form {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chat-input {
            flex: 1;
            height: 46px;
            border: 1px solid #e1e7e0;
            border-radius: 8px;
            padding: 0 15px;
            outline: none;
            font-family: 'Raleway', sans-serif;
            font-size: 13px;
            color: #26382b;
            min-width: 0;
        }

        .chat-input:focus {
            border-color: #52765a;
            box-shadow: 0 0 0 3px rgba(36, 68, 47, 0.06);
        }

        .send-button {
            height: 46px;
            padding: 0 24px;
            background: #24442f;
            border: none;
            border-radius: 8px;
            color: white;
            font-family: 'Raleway', sans-serif;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }

        .send-button:hover {
            background: #355d40;
        }

        .send-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        @media (max-width: 600px) {
            .navbar {
                height: 65px;
                padding: 0 20px;
            }

            .logo {
                font-size: 23px;
            }

            .page-container {
                margin: 25px auto;
                padding: 0 12px;
            }

            .page-title h1 {
                font-size: 25px;
            }

            .chat-container {
                height: calc(100dvh - 185px);
                min-height: 420px;
                border-radius: 10px;
            }

            .chat-header {
                padding: 16px;
            }

            .chat-messages {
                padding: 16px 12px;
            }

            .message {
                max-width: 85%;
                font-size: 12px;
            }

            .chat-footer {
                padding: 12px;
            }

            .chat-form {
                gap: 8px;
            }

            .chat-input {
                font-size: 12px;
            }

            .send-button {
                padding: 0 16px;
                font-size: 11px;
            }

            .online-status {
                display: none;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <a href="/" class="logo">CLAIRE</a>

        <a href="javascript:history.back()" class="back-link">
            ← Kembali
        </a>
    </nav>

    <main class="page-container">

        <div class="page-title">
            <h1>Chat Consultation</h1>
            <p>Hubungi therapist Anda untuk informasi seputar treatment.</p>
        </div>

        <div
            class="chat-container"
            id="chatContainer"
            data-chat-id="{{ $chat->id }}"
            data-user-id="{{ Auth::id() }}"
            data-messages-url="{{ route('chat.messages', $chat->id) }}"
            data-send-url="{{ route('chat.send', $chat->id) }}">

            <!-- HEADER CHAT -->
            <div class="chat-header">

                <div class="user-info">

                    <div class="avatar">
                        {{ strtoupper(substr(Auth::id() == $chat->customer_id ? $chat->therapist->name : $chat->customer->name, 0, 1)) }}
                    </div>

                    <div class="user-details">
                        <h3>
                            {{ Auth::id() == $chat->customer_id ? $chat->therapist->name : $chat->customer->name }}
                        </h3>

                        <p>
                            {{ Auth::id() == $chat->customer_id ? 'Your Therapist' : 'Customer' }}
                        </p>
                    </div>

                </div>

                <div class="online-status">
                    <span class="status-dot"></span>
                    Chat Consultation
                </div>

            </div>

            <!-- AREA PESAN -->
            <div class="chat-messages" id="chatMessages">

                <div class="empty-chat" id="emptyChat">
                    Memuat percakapan...
                </div>

            </div>

            <!-- FORM KIRIM PESAN -->
            <div class="chat-footer">

                <form class="chat-form" id="chatForm">

                    @csrf

                    <input
                        type="text"
                        id="messageInput"
                        class="chat-input"
                        placeholder="Ketik pesan Anda..."
                        maxlength="5000"
                        autocomplete="off"
                        required>

                    <button
                        type="submit"
                        class="send-button"
                        id="sendButton">
                        SEND
                    </button>

                </form>

            </div>

        </div>

    </main>

    <script>
        // DATA CHAT DARI LARAVEL
        const chatContainer = document.getElementById('chatContainer');

        const chatId = Number(chatContainer.dataset.chatId);
        const currentUserId = Number(chatContainer.dataset.userId);

        const messagesUrl = chatContainer.dataset.messagesUrl;
        const sendUrl = chatContainer.dataset.sendUrl;

        // ELEMENT HTML
        const chatMessages = document.getElementById('chatMessages');
        const chatForm = document.getElementById('chatForm');
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');

        // MENCEGAH PESAN DUPLIKAT
        const displayedMessageIds = new Set();

        // MENAMPILKAN PESAN
        function addMessage(message) {

            if (displayedMessageIds.has(Number(message.id))) {
                return;
            }

            displayedMessageIds.add(Number(message.id));

            document.getElementById('emptyChat')?.remove();

            const bubble = document.createElement('div');

            bubble.className = 'message ' +
                (Number(message.sender_id) === currentUserId ?
                    'sent' :
                    'received');

            const content = document.createElement('div');
            content.textContent = message.message;

            const time = document.createElement('small');

            time.textContent = new Date(message.created_at)
                .toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

            bubble.appendChild(content);
            bubble.appendChild(time);

            chatMessages.appendChild(bubble);

            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // MEMUAT RIWAYAT PESAN
        async function loadMessages() {

            try {

                const response = await fetch(messagesUrl, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error('Gagal mengambil pesan.');
                }

                const messages = await response.json();

                if (messages.length === 0 && displayedMessageIds.size === 0) {

                    chatMessages.innerHTML = `
                        <div class="empty-chat" id="emptyChat">
                            Belum ada pesan. Mulai percakapan sekarang.
                        </div>
                    `;

                    return;
                }

                messages.forEach(addMessage);

            } catch (error) {

                console.error('Error memuat pesan:', error);

                chatMessages.innerHTML = `
                    <div class="empty-chat">
                        Gagal memuat pesan. Silakan coba kembali.
                    </div>
                `;

            }
        }

        // MENGIRIM PESAN
        chatForm.addEventListener('submit', async function(event) {

            event.preventDefault();

            const message = messageInput.value.trim();

            if (!message) return;

            sendButton.disabled = true;

            try {

                const response = await fetch(sendUrl, {

                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',

                        'X-CSRF-TOKEN': document.querySelector(
                            'input[name="_token"]'
                        ).value,

                        'X-Requested-With': 'XMLHttpRequest',

                        'X-Socket-ID': window.Echo?.socketId() ?? ''
                    },

                    body: JSON.stringify({
                        message: message
                    })

                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(
                        data.message || 'Pesan gagal dikirim.'
                    );
                }

                addMessage(data.message);

                messageInput.value = '';
                messageInput.focus();

            } catch (error) {

                console.error('Error mengirim pesan:', error);

                alert(error.message);

            } finally {

                sendButton.disabled = false;

            }

        });


        // KONEKSI REAL-TIME
        async function initializeChat() {
            // Tunggu sampai Laravel Echo tersedia
            let attempts = 0;

            while (!window.Echo && attempts < 50) {
                await new Promise(resolve => setTimeout(resolve, 100));
                attempts++;
            }

            if (!window.Echo) {
                console.error('Laravel Echo gagal dimuat.');
                return;
            }

            console.log('Laravel Echo tersedia.');

            // Pasang listener sebelum mengambil riwayat pesan
            window.Echo.private(`chat.${chatId}`)
                .subscribed(() => {
                    console.log('Berhasil terhubung ke chat:', chatId);
                })
                .error((error) => {
                    console.error('Gagal terhubung ke channel chat:', error);
                })
                .listen('.chat.message.sent', (event) => {
                    console.log('Pesan baru diterima:', event.message);
                    addMessage(event.message);
                });

            await loadMessages();
        }


        initializeChat();
    </script>

</body>

</html>