# RestoreCord-Source-Code
<a href="https://discord.gg/letoa">
        <img src="https://img.shields.io/discord/983253635871952927?logo=discord"
            alt="Letoa Backups Discord"></a>
<a href="https://letoa.me">
        <img src="https://img.shields.io/badge/website-000000?style=for-the-badge&logo=About.me&logoColor=white"
            alt="Letoa Backups Website"></a>


Source code for the member backup bot RestoreCord, found at restorecord.com

**I am the legal owner of this source code. I paid a developer for this source code. While I gave the new owner of RestoreCord this code when I sold it to him, I did NOT relinquish copyrights to him. Any false DMCA will be counterstriked and I will pursue legal action if I'm able to find the copyright troll's address.**

## License

The license allows you to use this source code and sell it, meaning you can create a competitor to RestoreCord if you wanted to. The only requirement is that you open-source your version of the code. If you do not do that, your website will be taken down for copyright infringement. Pretty simple license, I feel it's more than fair that you contribute back to the community given that I've contributed back the community.

## Reasoning:

*RestoreCord, the John Deere of restore bots (John Deere doesn't allow anyone to work on the tractor they paid thousands for. They make the firmware super hard to reverse, you must know computer hacking to work on your own tractor).*

*RestoreCord is evidently scared of competiton and therefore tries to monopolize the restore bot market. they know they can't innovate so they attack others. Their developer has been caught DDoSing Letoa, proof: https://www.youtube.com/watch?v=HOnlI5FoWJ8 The developer was fine when I shared source with xenos, though when I open-sourced the code I paid for, he launched a lengthy DDoS attack to Letoa which has been going on and off for hours now. I signed no contract with him, I agreed to no ToS saying I couldn't share the code. He's just ignorant and thinks I'm going to cave into his harassment he tries on everyone else.*

Also, the RestoreCord developer keeps bitching me making public a source code I paid for wherein he never made me agree to a ToS or anything saying I couldn't distribute the source I bought among others. However, when I gave him access to my VPS for him to setup his source, he without my permission stole all my website files (he never worked on my website or was asked to - he has no business doing so and did this far before he was mad at me) and made a private GitHub repository for them. And then a few days ago when I created this GitHub repository, he made that private GitHub repository public, leaking several of my credentials. 10/10 ethical developer would highly recommend 🤡, proof: https://linktr.ee/nebula.ethics (if you don't see the leaked credential right away, scroll down on the page and the line is highlighted in yellow)

Since January 2022 I've no longer been selling member restore bots. I founded RestoreCord in 2020 and sold it then. Unfortunately, I sold it to an individual who goes by the monikers "xenos" or "ytmcgamer". It was later revealed this individual has token logged people. Video of him admitting it: https://www.youtube.com/watch?v=8dVNMcUR00A

He claimed he did it 2 years ago, though there was an incident where he Mass DM spammed the Discord server of a competitor restore bot service named Guild Restore. The developer for Guild Restore, Gannicus, showed a screenshot from a user where the user said his account was hacked.

He also just scammed me for $10 server boosts. They were suppsosed to be until August and he scammed me because I released this source, despite having full rights to and not ever promising him I wouldn't release it, proof: https://www.youtube.com/watch?v=VrGNffMNX0k. He denies ever being paid for the boosts however I made a scam report and provided evidence of me paying him plus him inviting the boost bots, and he was banned https://cracked.io/Thread-Scammed-for-10-by-RestoreCord-owner-xenos1337

He also commited credit card fraud against Letoa. imagine being so broke you must fraudulently spend $7, proof: https://imgur.com/a/EQpSIEo

RestoreCord was banned late April 2022 due to messages in their server from users which explained how they evaded Discord ToS with RestoreCord. I notified xenos of these messages and suggested that he delete them. He didn't take action on the messages and all RestoreCord assets were later banned. RestoreCord now intends to come back with "custom bots", where each server has its own bot. Given that Discord has clearly expressed they don't want RestoreCord on their platform by banning multiple accounts and servers, it is illegal for Discord to bypass this technological ban. So we could see RestoreCord facing legal action, and depending on where the person behind the moniker "xenos" lives, we could see that person facing criminal charges if that jurisdiction makes it illegal. It is criminally illegal in the United States to do what RestoreCord plans to do with the custom bots, after being banned by Discord multiple times.

So, for all these reasons I suggest you stay the hell away from RestoreCord. they're very shady and I am very sorry to have sold to such a dissolute individual. I recommend you check out https://letoa.me, they have automatic server backups and are as cheap as RestoreCord - $10/year

## Features

- Multi server
- Restore members (nothing else, this was one of the early versions of RestoreCord)
- IP logging
- Discord webhook notifications
- Handles rate limiting and access token expiry. Most bots don't and break when you try to pull members, not RestoreCord
- VPN block
- IP blacklisting

## How to setup

PHP and MySQL. Should work on most PHP versions. I tested on PHP 7.4 and PHP 8.0, worked on both.
**You must have a VPS. Shared hosting such as NameCheap will not work, as you have to run c# application also**

Please setup your MySQL database now and import the structure from here https://github.com/wnelson03/RestoreCord-Source-Code/blob/main/restorecord_db_schema.sql

- Change the `restorecord.com` at https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/verify/index.php#L20 to `example.com` (where example.com) is your website's domain
- Replace `botTokenHere` with your Discord bot token https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/includes/connection.php#L14
- (optional - only needed if you do NOT use cloudflare) change `HTTP_CF_CONNECTING_IP` to `REMOTE_ADDR` (do NOT do this if you're using cloudflare) at https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/verify/index.php#L77, https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/verify/index.php#L82, https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/verify/index.php#L120, https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/verify/index.php#L211, and https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/verify/index.php#L290
- (optional - only needed if you have more than 1,000 people verify a day) change `proxyCheckKeyHere` to a proxycheck API key if you have so many users you need to pay at https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/verify/index.php#L84
- Change OAuth2 authorization link at https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/verify/index.php#L419 you get your authorization link from Discord developer portal, like this https://imgur.com/a/G3q4oDM
- Change captcha keys here https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/register/index.php#L38 and https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/register/index.php#L101 or remove the captcha. I don't recommend removing captcha if you plan to sell this. Captcha is very neccesary for public websites. But if it's not a commercial site, you should remove lines 100-109 and then register will work
- Set MySQL connection info at https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/includes/connection.php#L5
- If you have other users than yourself owning servers on this source and you want to log their actions, replace `discordWebhookHere` with your webhook url on https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/dashboard/account/settings/index.php#L445, https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/dashboard/account/settings/index.php#L499, https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/dashboard/server/settings/index.php#L573, and https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/includes/connection.php#L23
- If you plan to sell this source, replace `8hCOmd6` with your Shoppy.GG product ID https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/dashboard/account/upgrade/index.php#L243 and then on Shoppy.GG, set these settings for the product https://imgur.com/a/XkRC3Pe and then make sure you set your Shoppy.GG webhook secret at https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/includes/connection.php#L18
- Replace `DiscordBotClientID` with your Discord bot's application ID https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/includes/connection.php#L12
- Replace `DiscordBotClientSecret` with your Discord bot's client secret https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/includes/connection.php#L13
- Replace `https://restorecord.com/auth/` with `https://example.com/auth/` and use your website's domain instead of `example.com` https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/includes/connection.php#L16
- Replace `https://restorecord.com/verify/` with `https://example.com/verify/` and use your website's domain instead of `example.com` https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/website%20source/includes/connection.php#L17

Now for c# part

- Change `https://restorecord.com/auth/` to `https://example.com/verify/` and use your website's domain instead of `example.com` https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/bot%20source/RestoreCord/Commands/Pull.cs#L113
- **(important, you don't want Discord to think you're a bot RestoreCord owns and ban you)** Change `RestoreCord (public release, 1.0.0.0)` to the name of your site or something https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/bot%20source/RestoreCord/Miscellaneous/Utilities.cs#L38
- Replace `rest_admin` with database username, replace `rest_main` with database name https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/bot%20source/RestoreCord/Services/Database.cs#L8
- Replace `databasePasswordHere` with database password https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/bot%20source/RestoreCord/Properties/Resources.resx#L127
- Replace `clientSecretHere` your Discord bot's client secret https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/bot%20source/RestoreCord/Properties/Resources.resx#L124
- Replace `discordIdHere` with your Discord bot's application ID https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/bot%20source/RestoreCord/Properties/Resources.resx#L121
- Replace `botTokenHere` with your Discord bot's token https://github.com/wnelson03/RestoreCord-Source-Code/blob/eef52c3e87ff59b0b928f58cf8332dfde4060543/bot%20source/RestoreCord/Properties/Resources.resx#L139

Note that this is written for Debian 11. For any other distro this is self explanatory. If you can't figure this out then leave.

```bash
wget https://packages.microsoft.com/config/debian/11/packages-microsoft-prod.deb -O packages-microsoft-prod.deb
sudo dpkg -i packages-microsoft-prod.deb
rm packages-microsoft-prod.deb
```

```bash
sudo apt-get update; \
  sudo apt-get install -y apt-transport-https && \
  sudo apt-get update && \
  sudo apt-get install -y dotnet-sdk-5.0 dotnet-runtime-5.0
```

For this next part make sure you are in the bot's root directory.

```bash
dotnet restore
dotnet build
```

You now have an executable!

Create a service using systemctl, make sure to replace the paths.

```
[Unit]
Description=Nebula Mods Inc. Restorecord
After=multi-user.target
[Service]
WorkingDirectory=/path/to/working/directory
ExecStart=/path/to/bot/executable 
SyslogIdentifier=Restorecord
Type=idle
Restart=always
RestartSec=15
RestartPreventExitStatus=0
[Install]
WantedBy=multi-user.target
```

Once you set this up, the bot should come online and slash commands should work, do `/` and you'll see slash commands

Here's a YouTube video showing how to use the bot https://www.youtube.com/watch?v=dVWPEdJY0zA


**How to give yourself lifetime premium (replace `yourUsernameHere` with your username):**
```sql
UPDATE `users` SET `role` = 'premium',`expiry` = 2224663363 WHERE `username` = 'yourUsernameHere'
```


## Security issues/bugs

Don't care, not fixing. This is not my issue anymore, I'm simply releasing for whoever wants it.

## Old source

I paid a different developer for a bot source before the current c# one and it was a shitshow. I paid this developer who went by "Missy", "Steer", or "Vultrex Development". This is a node.js react source and it's shit. For example, when someone redeems a premium key it deletes that premium key, and all the other premium keys in the array. If you delete a user, it deletes that user and all the rest of the items in the array. This is easy to fix and I've done it before, though I deleted that source when I switched to this one. Maybe some of it will be of use to you, so I'm making it open too. Aside from those minor bugs, it works completely fine. It handles rate limiting and access token expiration. Download it here https://github.com/wnelson03/RestoreCord-Source-Code/blob/main/old_source.zip, no instructions for it, you must inspect yourself. I didn't save instructions and I'm not familiar with it, so that's up to you.
