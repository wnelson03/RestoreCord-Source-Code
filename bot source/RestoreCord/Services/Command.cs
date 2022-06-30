using Discord;
using Discord.Net;
using Discord.WebSocket;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Threading.Tasks;

namespace RestoreCord.Services
{
    public class Command
    {
        private readonly DiscordShardedClient _client;
        private readonly Database _database;

        public Command(DiscordShardedClient discord, Database database)
        {
            _client = discord;
            _database = database;
            _client.ShardReady += RegisterCommands;
            _client.InteractionCreated += HandleSlashCommandAsync;
        }

        private async Task RegisterCommands(DiscordSocketClient arg)
        {
            List<ApplicationCommandProperties> applicationCommandProperties = new();
            try
            {
                //// Let's build a guild command! We're going to need a guild so lets just put that in a variable.
                //var guild = _client.GetGuild(889330271046995988);
                ////if (guild.GetApplicationCommandsAsync() is not null)
                //  //  return;
                //// Next, lets create our slash command builder. This is like the embed builder but for slash commands.
                //var guildCommand = new SlashCommandBuilder();

                //// Note: Names have to be all lowercase and match the regular expression ^[\w-]{3,32}$
                //guildCommand.WithName("pull");

                //// Descriptions can have a max length of 100.
                //guildCommand.WithDescription("pull users");
                //await guild.CreateApplicationCommandAsync(guildCommand.Build());

                ////// Slash command with name as its parameter.
                ////SlashCommandOptionBuilder slashCommandOptionBuilder = new();
                ////slashCommandOptionBuilder.WithName("name");
                ////slashCommandOptionBuilder.WithType(ApplicationCommandOptionType.String);
                ////slashCommandOptionBuilder.WithDescription("Add a family");
                ////slashCommandOptionBuilder.WithRequired(true); // Only add this if you want it to be required

                SlashCommandBuilder pullCommand = new();
                pullCommand.WithName("pull");
                pullCommand.WithDescription("Pull all Discord users into this server.");
                applicationCommandProperties.Add(pullCommand.Build());

                await _client.Rest.BulkOverwriteGlobalCommands(applicationCommandProperties.ToArray());
            }
            catch (ApplicationCommandException exception)
            {
                var json = JsonConvert.SerializeObject(exception.Error, Formatting.Indented);
                Console.WriteLine(json);
            }
        }
        private async Task HandleSlashCommandAsync(SocketInteraction arg)
        {
            switch (arg)
            {
                case SocketSlashCommand commandInteraction:
                    _ = MySlashCommandHandler(commandInteraction);
                    break;
                // Button clicks/selection dropdowns
                case SocketMessageComponent componentInteraction:
                    //await MyMessageComponentHandler(componentInteraction);
                    break;
                default:
                    break;
            }
        }
        private async Task MySlashCommandHandler(SocketSlashCommand interaction)
        {
            switch(interaction.Data.Name)
            {
                case "pull":
                    await Commands.Pull.Execute(interaction);
                    break;
                default:
                    break;
            }
        }


    }
}
