using Discord;
using Discord.WebSocket;
using RestoreCord.Miscellaneous;
using RestoreCord.Services;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace RestoreCord.Commands.Staff
{
    public class Owner
    {
        public async Task Kill(SocketSlashCommand cmd, Database database)
        {
            #region Discord Embed
            var RichEmbed = new EmbedBuilder()
                .WithTitle("Shutdown Started")
                .WithDescription($"Attempting to save database, please wait...")
                .WithAuthor("Nelson Cybersecurity LLC", "https://nelsoncybersecurity.com/icon.png", "https://nelsoncybersecurity.com")
                .WithColor(Utilities.RandomDiscordColour())
                .WithFooter($"RestoreCord", "")
                .WithCurrentTimestamp()
                .Build();

            IUserMessage EmbedMSG = null;
            #endregion

            try
            {
                EmbedMSG = await cmd.Channel.SendMessageAsync(embed: RichEmbed);
                await database.SaveChangesAsync();
                await EmbedMSG.ModifyAsync(x => x.Embed = RichEmbed.ToEmbedBuilder().WithDescription("Successfully saved database, shutting down now.").Build());
                //await Context.Client.StopAsync();
                Environment.Exit(0);
            }
            catch (Exception e)
            {
                await e.LogErrorAsync(cmd);
            }
        }

        public async Task Reboot(SocketSlashCommand cmd, Database database)
        {
            #region Discord Embed
            var RichEmbed = new EmbedBuilder()
                .WithTitle("Reboot Started")
                .WithDescription($"Attempting to save database, please wait...")
                .WithAuthor("Nelson Cybersecurity LLC", "https://nelsoncybersecurity.com/icon.png", "https://nelsoncybersecurity.com")
                .WithColor(Utilities.RandomDiscordColour())
                .WithFooter($"RestoreCord", "")
                .WithCurrentTimestamp()
                .Build();

            IUserMessage EmbedMSG = null;
            #endregion

            try
            {
                EmbedMSG = await cmd.Channel.SendMessageAsync(embed: RichEmbed);
                await database.SaveChangesAsync();
                await EmbedMSG.ModifyAsync(x => x.Embed = RichEmbed.ToEmbedBuilder().WithDescription("Successfully saved database, rebooting now.").Build());
                //await .Client.StopAsync();
                Environment.Exit(69);
            }
            catch (Exception e)
            {
                await e.LogErrorAsync(cmd);
            }
        }
    }
}
