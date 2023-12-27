# RestoreCord Source Code

> [!NOTE]  
> **TLDR:**
> <br>New RestoreCord owner xenos1337 can't really be trusted, with [large YouTubers even exposing](https://www.youtube.com/watch?v=WZNWAoLJmyk&t=240s) the scam.
> <br>I would recommend either using this source code, or use my new service [VaultCord](https://vaultcord.com) which already has far more features and actively listens to customer feedback 👍

### Tutorial video how to host for 100% free forever: https://www.youtube.com/watch?v=804Fzc5j4vo

I created RestoreCord in April 2020, a Discord service for the backup of server members, so server owners could pull them back into a server after a raid or other member loss scenario.

Due to my busy schedule, I hastily sold RestoreCord to a new owner in January 2022. Lesson learned, this isn't how you sell a business. This new owner, 'xenos1337', took things in a new direction. Unfortunately he started catering to scammers and those who sell their members. Meaning, he promoted the sale of members to other random server owners which serves as an annoyance and probably a privacy violation as well. You can see an [official sanctioned member-selling marketplace by RestoreCord here](https://t.me/restorecordtrade).

It also became apparent that xenos1337 was involved with [token logging](https://www.youtube.com/watch?v=8dVNMcUR00A) (stealing Discord accounts) and [Discord phishing pages](https://www.youtube.com/watch?v=idho403wdLg) (more Discord account stealing). Not exactly what you would want someone who has access to **millions** of Discord accounts via RestoreCord doing in his free time..

Unsuprisingly, the company operating Discord didn't take kindly to this brazen activity and shut down the bot in June 2022. 1,000,000+ members were lost forever. No explanation or compensation was given by the RestoreCord management to their customers.

xenos1337 had shared his plans to develop a new codebase that would be compatiable with custom bots, one bot per customer. This meant no use for the original source code, which I developed and had retained copyright ownership over, since I never transferred the copyright ownership.

I published the original source code, seen in this GitHub repository. I had the legal right and felt an ethical obligation to do so, as RestoreCord customers were left waiting for months with no explanation or clear ETA when the service would return.

xenos1337 was not happy about this, first attemtping to [illegally remove this GitHub repository](https://imgur.com/a/HEopxtG). Then, he [pettily scammed me for $10](https://www.youtube.com/watch?v=VrGNffMNX0k) and [stole my Discord server vanity](https://cracked.io/Thread-Scammed-for-10-by-RestoreCord-owner-xenos1337)

He continued to level attacks against me and anyone affiliated with me. He [successfully commited credit card fraud](https://imgur.com/a/EQpSIEo) on a competitor of RestoreCord that I was affiliating with. He conspired with a former co-worker of mine ([@NebulaMods](https://github.com/NebulaMods)/nebulamods.ca) to [DDoS that same RestoreCord competitor](https://www.youtube.com/watch?v=HOnlI5FoWJ8), and [leak private API credentials](https://allmylinks.com/nebula-ethics) that the co-worker stole from my server without consent.

While he did finally stop the attacks, no compensation was ever made for these wrongful, unlawful attacks, nor were RestoreCord customers compensated either for their losses.

The problems continue to this day. Just a few months ago in May 2023, the new owner lost 10,000+ members due to failing to backup his database automatically, which led to him reverting to a 3 month old backup after they were banned from the hosting company OVH for fraud & abuse.

I don't think the new management of RestoreCord has proven to be professional or reliable. That is why I would recommend using the source code or using my new service [VaultCord](https://vaultcord.com) which has far more features and values customer feedback.

## Copyright License

The code can be used for **commercial use** if you would like. The requirements are that you must **open-source the code** and **link to this repository** in order to not be in violation of the **GNU General Public License v2.0**

Do note, however, that absolutely nobody aside from myself (William Nelson) has legal rights to use my logo for RestoreCord, or repost videos I've recorded for RestoreCord. If you do not follow this, you will recieve a copyright takedown.

## Features

- Multi server
- Restore members
- IP logging
- Discord webhook notifications
- Handles rate limits and access token refreshing. Most bots don't and break when you try to pull members, not this.
- VPN detection/block
- IP blacklist

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
