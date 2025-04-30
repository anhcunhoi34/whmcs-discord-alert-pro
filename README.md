
# Discord Alert Pro – Kamrul Edition

> Real-time WHMCS Notifications to Discord  
> Developed & Secured by **Kamrul**  
> 🔗 https://kamrul.us | 📘 https://facebook.com/elitekamrul

---

## 🚀 Overview

**Discord Alert Pro** is a professional-grade WHMCS-to-Discord notification system.  
It shows staff name, client IP & flag, ticket info, and sends beautifully styled embeds to Discord — securely and smartly.

---

## ✅ Features

- 🧑‍💻 Staff responder name in message
- 🌐 Auto country flag from client IP (dual API fallback)
- 📛 Discord role mentions (via ID)
- 🎨 Color-coded embed (custom per rule)
- 🖼 Avatar + Sender Name
- 🕐 Auto Time + Timezone
- 🕓 Last Reply Time (relative)
- 🔐 Developer Lock via `143.key`
- 💤 Silent Mode (no webhook if enabled)
- 🧠 No database used – file-based logic
- 📊 Daily file-based reply counter (optional)
- 🔄 Fully WHMCS 8.6 – 8.9.x compatible
- ✅ Lightweight, efficient, secured

---

## 📦 Installation

1. Upload the `DiscordAlertPro/` folder to:  
   `modules/notifications/DiscordAlertPro/`

2. Your folder should look like this:

```
DiscordAlertPro/
├── DiscordAlertPro.php
├── lib/
│   ├── Embed.php
│   ├── Field.php
│   └── Message.php
├── whmcs.json
├── 143.key
├── logo.png
└── README.md
```

3. Go to WHMCS Admin:  
   - Setup → Notifications  
   - Activate "Discord Alert Pro"  
   - Fill in global settings

---

## 🔧 How to Create Discord Webhook

Use this official guide from Discord:  
**https://support.discord.com/hc/en-us/articles/228383668-Intro-to-Webhooks**

---

## 🔧 How to Create Notification Rules in WHMCS

1. Setup → Notifications → Create Rule  
2. Select event (e.g. Ticket Reply)  
3. Set conditions (if needed)  
4. Select **"Discord Alert Pro"** as the provider  
5. Customize any per-rule settings  
6. Save

---

## 📸 Discord Message Structure

```
🧑‍💻 Ticket Replied: [Subject]
────────────────────────────────────
Responded by: Kamrul  
Client Location: 🇧🇩 Bangladesh  
Client IP: 103.120.21.15  
Status: 🟡 Answered  
Last Reply: 2 min ago  
Date & Time: 2025-04-30 | 05:35 PM (GMT+6)  
Department: Technical  
Priority: High  
Ticket ID: #192  
Client Name: Rifat Rahman

🔗 Click to View Ticket
────────────────────────────────────
🛠 Developed by Kamrul • Powered by Discord Alert Pro
```

---

## ⚙️ Configuration Options

### Global Settings

| Name            | Description                              |
|-----------------|------------------------------------------|
| Webhook URL     | Main Discord webhook                     |
| Sender Name     | Shown in Discord as username             |
| Embed Color     | HEX code without # (e.g. `3498db`)       |
| Role ID         | Discord Role ID to mention               |
| Avatar URL      | Custom sender avatar                     |
| Silent Mode     | Disable all messages when enabled        |

### Per Rule Overrides

| Name            | Description                              |
|-----------------|------------------------------------------|
| Custom Message  | Override default message body            |
| Webhook URL     | Send this rule to different channel      |
| Embed Color     | Use different HEX color                  |
| Role ID         | Mention different Discord role           |

---

## 🧠 Smart Functionalities

- **Silent Mode**: When enabled, no message is sent. Great for testing or off-hours.
- **Developer Lock**: If `143.key` is missing or modified, the addon will self-disable.
- **IP Geo Lookup**: Auto-detects client country using:
  1. `ip-api.com` (primary)
  2. `ipwho.is` (fallback)
- **Country Flag Emoji**: Country code is auto-translated into flag emoji.
- **Last Reply Calculation**: From WHMCS `lastreply` field → shows e.g. “5 min ago”
- **File-Based Counter**: (Optional) tracks daily replies without using SQL
- **Fully file-powered**: No custom DB table created.

---

## 🔐 Security Lock: `143.key`

- Required file in addon root  
- Must contain: `143`  
- Without it, no notification will be sent  
- Logs will show: `Developer Lock Missing`

---

## ✅ Compatibility

- ✅ WHMCS 8.6.x → 8.9.x tested  
- ✅ Works with any PHP 7.4 – 8.1  
- ❌ No ionCube or encoded code  
- ✅ Fully Open Source (MIT Protected)

---

## 📜 Changelog

### v1.0.0 – Initial Release
- Ticket responder name added
- Country flag from IP lookup
- Smart status emojis (Open, Answered, etc.)
- Last reply time auto-calculation
- Silent mode switch added
- Developer lock file validation
- No database dependency

---

## ❓ FAQ

**Can I remove the developer credit?**  
→ No. Credit is fixed inside embed footer to protect original work.

**Can I use this commercially?**  
→ Not without permission. This version is MIT-licensed for personal/educational use only.

**Can I modify the code?**  
→ Yes, as long as it’s not for resale or rebranding without credit.

---

## 🤝 License

This software is provided under a **Custom MIT License**.  
Free for personal and non-commercial use.

Commercial redistribution or resale is prohibited without license from the author.

See: `LICENSE` file

---

## 🙏 Special Thanks

Original concept & base structure inspired by:  
**William Beacroft**  
GitHub: [BillyAB Discord Notifier](https://github.com/BillyAB/WHMCS-Discord-Notification-Module)  
Respectfully acknowledged with gratitude.

---

## 👤 Author

Made with ❤️ by **Kamrul**  
🔗 Website: https://kamrul.us  
📘 Facebook: https://facebook.com/elitekamrul  
Telegram: @MIH1R  
Email: Mr.Kamrul61@gmail.com

Support available for customization
