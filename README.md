# RestoreCord Source Code

### Tutorial video how to host for 100% free forever: https://www.youtube.com/watch?v=804Fzc5j4vo

Source code for the member backup bot RestoreCord, found at [restorecord.com](https://restorecord.com)

I founded RestoreCord sometime in April 2020, I forget the exact date. I then sold to [@xenos1337](https://github.com/xenos1337) in January 2022. RestoreCord was the first ever restore bot! Now there's more than a dozen 😆

[@xenos1337](https://github.com/xenos1337) made some mistakes in June  2022 resulting in the bot getting banned from Discord. I then released this source code since [RestoreCord.com](https://restorecord.com) no longer uses it anymore due to them changing to a Node.js source code with a custom bot for each user, so a mass ban couldn't occur again.

This source is completely functional. It just doesn't have as many features as the latest RestoreCord, but it serves as a great example to anyone who's interested in these types of bots.

RestoreCord, the live website can be trusted fine now. They're not going to have another mass ban problem. I have inspected it closely and it follows all of my suggestions (rotating proxy, optional custom domain, etc) just follow the [RestoreCord Documentation](https://docs.restorecord.com/guides/secure-your-bot/) if you use the live site and you'll have no issues.

## Copyright License

The code can be used for **commercial use** if you would like. The requirements are that you must **open-source the code** and **link to this repository** in order to not be in violation of the **GNU General Public License v2.0**

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

## Old source

I paid a different developer for a bot source before the current c# one and it was a shitshow. I paid this developer who went by "Missy", "Steer", or "Vultrex Development". This is a node.js react source and it's shit. For example, when someone redeems a premium key it deletes that premium key, and all the other premium keys in the array. If you delete a user, it deletes that user and all the rest of the items in the array. This is easy to fix and I've done it before, though I deleted that source when I switched to this one. Maybe some of it will be of use to you, so I'm making it open too. Aside from those minor bugs, it works completely fine. It handles rate limiting and access token expiration. Download it here https://github.com/wnelson03/RestoreCord-Source-Code/blob/main/old_source.zip, no instructions for it, you must inspect yourself. I didn't save instructions and I'm not familiar with it, so that's up to you.
