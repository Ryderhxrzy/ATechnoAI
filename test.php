<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BSIT Learning Messenger</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .messenger-container {
            width: 100%;
            max-width: 900px;
            height: 90vh;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .header {
            background: linear-gradient(135deg, #4285f4, #34a853);
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .lesson-selector {
            background: #fff;
            padding: 15px 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        .lesson-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }

        .lesson-btn {
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s;
            text-align: center;
        }

        .lesson-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(238, 90, 36, 0.3);
        }

        .level-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .level-btn {
            flex: 1;
            background: #e9ecef;
            border: none;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .level-btn.active {
            background: #4285f4;
            color: white;
        }

        .chat-area {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .message {
            max-width: 85%;
            padding: 15px;
            border-radius: 18px;
            word-wrap: break-word;
            animation: fadeIn 0.3s ease-in;
            line-height: 1.5;
        }

        .user-message {
            background: linear-gradient(135deg, #4285f4, #34a853);
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 5px;
        }

        .ai-message {
            background: #f1f3f4;
            color: #333;
            align-self: flex-start;
            border-bottom-left-radius: 5px;
            border-left: 4px solid #4285f4;
        }

        .ai-message code {
            background: #fff;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            border: 1px solid #ddd;
        }

        .ai-message pre {
            background: #2d3748;
            color: #e2e8f0;
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
        }

        .message-input-area {
            padding: 20px;
            background: #f8f9fa;
            border-top: 1px solid #e0e0e0;
            display: flex;
            gap: 10px;
        }

        .message-input {
            flex: 1;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            font-size: 16px;
            resize: none;
            max-height: 100px;
            min-height: 50px;
        }

        .message-input:focus {
            outline: none;
            border-color: #4285f4;
        }

        .send-btn {
            background: linear-gradient(135deg, #4285f4, #34a853);
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .send-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(66, 133, 244, 0.3);
        }

        .send-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 20px;
            color: #666;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #4285f4;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .error-message {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
            padding: 15px;
            border-radius: 8px;
            margin: 10px;
            text-align: center;
        }

        .status-indicator {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            background: rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 768px) {
            .messenger-container {
                height: 95vh;
                margin: 10px;
            }
            
            .lesson-grid {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            }
            
            .message {
                max-width: 95%;
            }
        }
    </style>
</head>
<body>
    <div class="messenger-container">
        <div class="header">
            <h1>🎓 BSIT Learning Assistant</h1>
            <p>Powered by Google Gemini AI via PHP</p>
            <div class="status-indicator" id="statusIndicator">Ready</div>
        </div>

        <div class="lesson-selector">
            <h3>Select Learning Level:</h3>
            <div class="level-selector">
                <button class="level-btn active" data-level="basic">Basic</button>
                <button class="level-btn" data-level="intermediate">Intermediate</button>
                <button class="level-btn" data-level="advanced">Advanced</button>
            </div>

            <h3>Quick Lesson Topics:</h3>
            <div class="lesson-grid">
                <button class="lesson-btn" data-topic="Programming Fundamentals">Programming Fundamentals</button>
                <button class="lesson-btn" data-topic="Database Systems">Database Systems</button>
                <button class="lesson-btn" data-topic="Web Development">Web Development</button>
                <button class="lesson-btn" data-topic="Network Security">Network Security</button>
                <button class="lesson-btn" data-topic="Data Structures">Data Structures</button>
                <button class="lesson-btn" data-topic="Software Engineering">Software Engineering</button>
                <button class="lesson-btn" data-topic="System Analysis">System Analysis</button>
                <button class="lesson-btn" data-topic="Mobile Development">Mobile Development</button>
                <button class="lesson-btn" data-topic="Cloud Computing">Cloud Computing</button>
                <button class="lesson-btn" data-topic="Cybersecurity">Cybersecurity</button>
                <button class="lesson-btn" data-topic="AI & Machine Learning">AI & ML</button>
                <button class="lesson-btn" data-topic="Project Management">Project Management</button>
            </div>
        </div>

        <div class="chat-area" id="chatArea">
            <div class="ai-message">
                <strong>🤖 BSIT Assistant:</strong><br>
                Welcome to your BSIT Learning Assistant! I'm powered by Google Gemini AI through a PHP backend.
                <br><br>
                <strong>How to get started:</strong><br>
                1. Select your learning level (Basic/Intermediate/Advanced)<br>
                2. Click on any topic button for instant lessons<br>
                3. Or type your own questions about IT subjects<br>
                <br>
                I can help you with programming languages, databases, networking, software development, system analysis, project management, and all other BSIT subjects. What would you like to learn today?
            </div>
        </div>

        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p>AI is thinking and generating your lesson...</p>
        </div>

        <div class="message-input-area">
            <textarea class="message-input" id="messageInput" placeholder="Ask me anything about BSIT or request a specific lesson..." rows="1"></textarea>
            <button class="send-btn" id="sendBtn">Send</button>
        </div>
    </div>

    <script>
        class BSITMessenger {
            constructor() {
                this.currentLevel = 'basic';
                this.chatArea = document.getElementById('chatArea');
                this.messageInput = document.getElementById('messageInput');
                this.sendBtn = document.getElementById('sendBtn');
                this.loading = document.getElementById('loading');
                this.statusIndicator = document.getElementById('statusIndicator');

                this.init();
            }

            init() {
                // Event listeners
                this.sendBtn.addEventListener('click', () => this.sendMessage());
                this.messageInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        this.sendMessage();
                    }
                });

                // Level selector
                document.querySelectorAll('.level-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        document.querySelectorAll('.level-btn').forEach(b => b.classList.remove('active'));
                        e.target.classList.add('active');
                        this.currentLevel = e.target.dataset.level;
                    });
                });

                // Topic buttons
                document.querySelectorAll('.lesson-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const topic = e.target.dataset.topic;
                        this.requestLesson(topic);
                    });
                });

                // Auto-resize textarea
                this.messageInput.addEventListener('input', () => {
                    this.messageInput.style.height = 'auto';
                    this.messageInput.style.height = this.messageInput.scrollHeight + 'px';
                });
            }

            async requestLesson(topic) {
                const prompt = `Generate a comprehensive ${this.currentLevel} level lesson about "${topic}" for BSIT students. Include:
                
                📚 LEARNING OBJECTIVES:
                - What students will learn
                
                🔑 KEY CONCEPTS:
                - Core definitions and terminology
                
                💡 PRACTICAL EXAMPLES:
                - Real-world applications
                
                💻 CODE SAMPLES:
                - Practical code examples (if applicable)
                
                🌟 INDUSTRY APPLICATIONS:
                - How this is used in the IT industry
                
                📝 STUDY TIPS:
                - How to master this topic
                
                ❓ ASSESSMENT QUESTIONS:
                - 3-5 questions to test understanding
                
                Format the response clearly for ${this.currentLevel} level BSIT students.`;

                this.addMessage(`Generate a ${this.currentLevel} level lesson about: ${topic}`, 'user');
                await this.sendToBackend(prompt);
            }

            async sendMessage() {
                const message = this.messageInput.value.trim();
                if (!message) return;

                this.addMessage(message, 'user');
                this.messageInput.value = '';
                this.messageInput.style.height = 'auto';

                const enhancedPrompt = `As an expert BSIT (Bachelor of Science in Information Technology) instructor, provide a comprehensive response to this question at a ${this.currentLevel} level:

                QUESTION: ${message}

                Please provide:
                - Clear explanations suitable for ${this.currentLevel} students
                - Practical examples and use cases
                - Code snippets or technical details where relevant
                - Industry insights and best practices
                - Learning resources or next steps

                Keep the tone educational but engaging for IT students.`;

                await this.sendToBackend(enhancedPrompt);
            }

            async sendToBackend(prompt) {
                this.showLoading(true);
                this.sendBtn.disabled = true;
                this.statusIndicator.textContent = 'Processing...';

                try {
                    // Fixed: Changed from 'geminihandler.php' to 'gemini_handler.php'
                    const response = await fetch('gemini_handler.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            prompt: prompt,
                            level: this.currentLevel
                        })
                    });

                    if (!response.ok) {
                        const errorText = await response.text();
                        console.error('Server response:', errorText);
                        throw new Error(`HTTP error! status: ${response.status} - ${errorText}`);
                    }

                    const data = await response.json();
                    
                    if (data.success) {
                        this.addMessage(data.response, 'ai');
                        this.statusIndicator.textContent = 'Ready';
                    } else {
                        throw new Error(data.error || 'Unknown error occurred');
                    }

                } catch (error) {
                    console.error('Error:', error);
                    this.showError(`Error: ${error.message}`);
                    this.statusIndicator.textContent = 'Error';
                }

                this.showLoading(false);
                this.sendBtn.disabled = false;
            }

            addMessage(content, sender) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${sender}-message`;
                
                if (sender === 'ai') {
                    messageDiv.innerHTML = `<strong>🤖 BSIT Assistant:</strong><br>${this.formatMessage(content)}`;
                } else {
                    messageDiv.innerHTML = `<strong>👨‍🎓 You:</strong><br>${this.escapeHtml(content)}`;
                }

                this.chatArea.appendChild(messageDiv);
                this.chatArea.scrollTop = this.chatArea.scrollHeight;
            }

            formatMessage(text) {
                // Enhanced formatting for better readability
                return text
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                    .replace(/\*(.*?)\*/g, '<em>$1</em>')
                    .replace(/`([^`]+)`/g, '<code>$1</code>')
                    .replace(/```([\s\S]*?)```/g, '<pre><code>$1</code></pre>')
                    .replace(/📚|🔑|💡|💻|🌟|📝|❓|🎯|⚡|🔧|📊|🚀/g, '<strong>$&</strong>')
                    .replace(/\n\n/g, '<br><br>')
                    .replace(/\n/g, '<br>');
            }

            escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            showLoading(show) {
                this.loading.style.display = show ? 'block' : 'none';
                this.chatArea.style.display = show ? 'none' : 'flex';
            }

            showError(message) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.textContent = message;
                
                const existing = document.querySelector('.error-message');
                if (existing) existing.remove();
                
                this.chatArea.parentNode.insertBefore(errorDiv, this.chatArea);
                setTimeout(() => errorDiv.remove(), 8000);
            }
        }

        // Initialize the messenger when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            new BSITMessenger();
        });
    </script>
</body>
</html>