
# Discord Alert Pro – Kamrul Edition

> Real-time WHMCS Notifications to Discord  
> Developed & Secured by **Kamrul**  
> 🔗 [kamrul.us](https://kamrul.us) | 📘 [facebook.com/elitekamrul](https://facebook.com/elitekamrul)

---

## 🚀 Overview

**Discord Alert Pro** is the most advanced and secured WHMCS-to-Discord notification module.  
Built with precision, privacy, and performance — it delivers rich ticket alerts with staff tracking, location info, and more.

---

## ✅ Features

- 🔧 Simple WHMCS Admin Setup  
- 🧑‍💻 Responding Staff Name Shown  
- 🌐 Client Country & Flag (via IP)  
- 📛 Discord Role Mentions  
- 🎨 Color-coded Embed Messages  
- 🖼 Custom Avatar & Sender Name  
- 🕐 Auto Date-Time & Timezone Display  
- 🧠 Dual IP Geo API Fallback  
- 🔐 Developer Lock System (`143.key`)  
- 💤 Silent Mode Toggle (no alerts if enabled)  
- 🕓 Last Reply Time of Ticket  
- ✅ No database required — Fully file-based!

---

## 📦 Installation

1. Upload the folder to:  
   `modules/notifications/DiscordAlertPro/`

2. Folder Structure:

```
DiscordAlertPro/
├── DiscordAlertPro.php
├── lib/
│   ├── Embed.php
│   ├── Field.php
│   └── Message.php
├── whmcs.json
├── 143.key
└── logo.png (optional)
```

3. Go to WHMCS Admin Panel:
   - Setup → Notifications → Activate "Discord Alert Pro"
   - Fill in your webhook and settings
   - Create your notification rules

---

## ⚙️ Configuration

### Global Settings:

| Field               | Description                             |
|---------------------|-----------------------------------------|
| Webhook URL         | Your Discord webhook link               |
| Sender Name         | Displayed name in Discord               |
| Message Color       | HEX (e.g., `3498db` = blue)             |
| Role ID             | Discord Role ID for mentions            |
| Avatar URL          | Optional sender avatar image            |
| Silent Mode         | Enable to block Discord message sending |

### Per Rule Override:

| Field               | Description                             |
|---------------------|-----------------------------------------|
| Custom Message      | Override message body                   |
| Custom Webhook URL  | Send to alternate Discord channel       |
| Custom Color        | HEX override for that message           |
| Custom Role ID      | Ping specific role on this message      |

---

## 📸 Discord Message Structure

Each alert sent by **Discord Alert Pro** is displayed in Discord as a beautiful, structured embed.  
Below is the complete layout and what each part includes:

```
🧑‍💻 Ticket Replied: [Ticket Subject]
────────────────────────────────────
Responded by: [Staff Name who replied]
Client Location: [Flag + Country Name]
Client IP: [IP Address]
Status: [Emoji + WHMCS Ticket Status]
Last Reply: [Time ago from WHMCS]
Date & Time: [Y-m-d | h:i A (Timezone)]
Department: [WHMCS Ticket Department]
Priority: [Low / Medium / High]
Ticket ID: #[Ticket Number]
Client Name: [Name from ticket]

🔗 Click to View Ticket
────────────────────────────────────
🛠 Developed by Kamrul • Powered by Discord Alert Pro
```

---

## 🔐 Security Lock (`143.key`)

This file prevents unauthorized use or tampering.  
It must exist at the root of the module with this exact content:

```
143
```

Without it, the module will not send any messages.

---

## 🔍 Need Help?

- ✅ Check webhook URL validity
- ✅ Make sure cron is running
- ✅ Ensure server can access Discord API
- ✅ Enable module logging if debugging

Contact: [facebook.com/elitekamrul](https://facebook.com/elitekamrul)

---

## ⚠️ Disclaimer

This module is developed by **Kamrul** and is **not affiliated** with Discord Inc. or WHMCS LLC.  
Use at your own risk. Always test in a staging environment before production.

---

## 👥 Credits

- 🛠️ **Developed, Customized & Secured by:**  
  **Kamrul**  
  🔗 [https://kamrul.us](https://kamrul.us)  
  📘 [https://facebook.com/elitekamrul](https://facebook.com/elitekamrul)

- 🧩 **Base Structure Inspired From:**  
  **William Beacroft** (Original [Discord Notification Module](https://github.com/BillyAB/WHMCS-Discord-Notification-Module))  
  🔗 [https://billyab.co.uk](https://billyab.co.uk)

This version is a full-featured, re-engineered, and professionally secured upgrade of the base concept by Kamrul with extensive new functionality, smart controls, and WHMCS production-grade compatibility.

