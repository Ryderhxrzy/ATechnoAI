<!DOCTYPE html>
<html data-theme="dark">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Techno.ai</title>
  <link rel="stylesheet" href="../assets/styles.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
</head>
<body>
  <div id="app-container">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
      <button class="sidebar-minimizer">
        <i class="fas fa-chevron-right"></i>
      </button>
      <!-- Logo Section -->
      <div class="sidebar-logo">
        <div class="logo-icon">
          <i class="fas fa-cog gear"></i>
          <i class="fas fa-robot robot"></i>
        </div>
        <span class="logo-text">Techno.ai</span>
      </div>

      <button class="new-chat-btn" onclick="startNewChat()">
        <i class="fas fa-plus"></i>
        <span>New Chat</span>
      </button>

      <div class="chat-history" id="chat-history">
        <div class="chat-item active" data-chat-id="1">
          <div class="chat-title">Welcome Chat</div>
          <div class="chat-preview">How can I help you today?</div>
          <div class="chat-time">Just now</div>
        </div>
      </div>
      <div class="user-profile">
        <div class="profile-avatar">JA</div>
        <div class="profile-info">
          <div class="profile-name">Jeeee-Arrr</div>
          <div class="profile-status">
            <div class="status-dot"></div>
            Online
          </div>
        </div>
      </div>
    </div>

    <div class="chat-container">
      <div class="chat-header">
        <div class="header-info">
          <h2>
            <div class="header-minimizer" id="header-minimizer">
              <i class="fas fa-chevron-left"></i>
            </div>
            Techno.ai
          </h2>
        </div>
        <div class="header-actions">
          <button class="action-btn" id="theme-toggle-btn" title="Toggle dark/light mode">
            <i class="fas fa-moon"></i>
          </button>
        </div>
      </div>

      <div id="chat-box">
        <div class="welcome-message">
          <div class="welcome-icon">
            <i class="fas fa-robot"></i>
          </div>
          <h3>Welcome to Techno.ai!</h3>
          <p>I'm here to help you with coding, questions, and tasks. Ask me anything!</p>
        </div>
      </div>

      <div class="typing-indicator" id="typing-indicator">
        <div class="typing-dots">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>

      <div class="input-container">
          <div class="input-wrapper">
              <textarea id="user-input" placeholder="Message Techno.ai" rows="1"></textarea>
              <button id="send-btn" onclick="sendMessage()">
                <i class="fas fa-arrow-up"></i>
              </button>
          </div>
      </div>
    </div>
  </div>

  <script src="../scripts/script.js"></script>
</body>
</html>