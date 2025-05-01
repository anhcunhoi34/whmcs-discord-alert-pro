
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
- 🔐 Developer Lock via `143.key` + UI activation panel
- 💤 Silent Mode (no webhook if enabled)
- 📩 Test Webhook Button (send test embed)
- 🟢 Lock Status: Green/Red Badge
- 🧠 No database used – file-based logic
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
├── test.php
├── lock.php
├── 143.key (auto-created)
├── whmcs.json
├── lib/
│   ├── Embed.php
│   ├── Field.php
│   └── Message.php
├── logo.png
└── README.md
```

3. Go to WHMCS Admin:  
   - Setup → Notifications  
   - Activate "Discord Alert Pro"  
   - Fill in global settings  
   - Optional: enter developer code `143` to activate the lock

---

## 🔧 How to Create Discord Webhook

Use this official guide from Discord:  
**https://support.discord.com/hc/en-us/articles/228383668-Intro-to-Webhooks**

---

## 🔔 How to Create Notification Rules in WHMCS

1. Setup → Notifications → Create Rule  
2. Select event (e.g. Ticket Reply)  
3. Set conditions (if needed)  
4. Select **"Discord Alert Pro"** as the provider  
5. Customize per-rule settings (if needed)  
6. Save and test

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

| Name                | Description                                 |
|---------------------|---------------------------------------------|
| Webhook URL         | Main Discord webhook                        |
| Sender Name         | Shown in Discord as username                |
| Embed Color         | HEX code without # (e.g. `3498db`)          |
| Role ID             | Discord Role ID to mention                  |
| Avatar URL          | Custom sender avatar                        |
| Silent Mode         | Disable all messages when enabled           |
| Show Flag           | Enable/disable country flag emoji           |
| IP API              | Choose `ip-api` or `ipwho` for location     |
| Addon Version       | Static display of current module version    |

### Per Rule Overrides

| Name                | Description                                  |
|---------------------|----------------------------------------------|
| Custom Message      | Override default embed message               |
| Webhook URL         | Send this rule to different channel          |
| Embed Color         | Use different HEX color                      |
| Role ID             | Mention different Discord role               |

---

## 🧠 Smart Functionalities

- **Silent Mode**: When enabled, no message is sent. Great for testing or off-hours.
- **Developer Lock UI**: Dashboard shows lock status (🟢 Active or 🔴 Inactive)
- **Lock Activation Panel**: Admin can enter code `143` to activate
- **IP Geo Lookup**: Auto-detects client country using:
  1. `ip-api.com` (primary)
  2. `ipwho.is` (fallback)
- **Country Flag Emoji**: Country code is converted into flag emoji.
- **Test Webhook**: Sends sample embed to verify settings
- **Last Reply Calculation**: From WHMCS `lastreply` → shows “5 min ago”
- **Fully file-powered**: No custom DB table created.

---

## 🔐 Security Lock: `143.key`

- Required file in addon root  
- Must contain: `143`  
- Auto-created via dashboard input  
- Without it, no notification will be sent  
- Logs will show: `Developer Lock Missing`

---

## ✅ Compatibility

- ✅ WHMCS 8.6.x – 8.9.x fully tested and stable  
- ✅ PHP 7.4 – PHP 8.1 supported  
- ⚠ WHMCS 9.x+ support will be added in a future version  
- ❌ Does not require ionCube, MySQL table, or third-party library  
- ✅ 100% file-based logic, no DB dependency


---

## 🧪 Test Webhook Feature

- Fill global fields (webhook URL, sender name, avatar)
- Click “Send Test” from dashboard
- You’ll get this message in Discord:
  - Title: Test Notification
  - Description: This is a test message sent from Discord Alert Pro
  - Includes sender name, color, and footer info

---

## 📜 Changelog

### v1.1.0 – Latest Version
- ✅ Full UI Lock Status + Activation Panel
- ✅ Test Webhook System added
- ✅ Clean IP + Flag + Country auto-show
- ✅ Role ID ping support
- ✅ Avatar override
- ✅ All file-based, no DB
- ✅ WHMCS 8.9+ support

---

## ❓ FAQ

**Can I remove the developer credit?**  
→ No. Credit is fixed in the embed footer.

**Can I sell or redistribute this?**  
→ No, not without written permission.

**Can I customize this addon?**  
→ Yes, for personal/internal use. Respect credit/license.

---

## 🤝 License

MIT-style (custom) license.  
Free for personal and non-commercial projects.  
Commercial use, resale, or rebranding without license is prohibited.  
See LICENSE file for more.

---

## 🙏 Special Thanks

Original module logic idea inspired by:  
**William Beacroft**  
GitHub: [BillyAB Discord Notifier](https://github.com/BillyAB/WHMCS-Discord-Notification-Module)

---

## 👤 Author

Made with ❤️ by **Kamrul**  
🔗 Website: https://kamrul.us  
📘 Facebook: https://facebook.com/elitekamrul  
📨 Email: Mr.Kamrul61@gmail.com  
📲 Telegram: @MIH1R

Need help? Contact for paid customizations.
