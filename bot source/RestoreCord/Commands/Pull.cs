using Discord.WebSocket;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using RestoreCord.Miscellaneous;
using RestoreCord.Schema.DiscordModels;

namespace RestoreCord.Commands
{
    public class Pull
    {
        private static HashSet<ulong> ActiveDiscordServers = new();

        public static async Task Execute(SocketSlashCommand cmd)
        {
            try
            {
                //check perms in the server
                Services.Database database = new();
                var guild = (cmd.Channel as SocketGuildChannel).Guild;
                if (guild is null)
                {
                    await cmd.ReplyWithEmbedAsync("Server Error", "This command can only executed in guilds/servers.");
                    return;
                }
                var serverentry = await database.servers.FirstOrDefaultAsync(x => x.guildid == guild.Id);
                if (serverentry is null)
                {
                    await cmd.ReplyWithEmbedAsync("Server Error", "Server doesn't exist in the database...");
                    return;
                }
                //if (serverentry.owner != cmd.User.Id)//not guild owner
                //{
                //    await cmd.ReplyWithEmbedAsync("Permission Error", "not owner of guild");
                //    return;
                //}
                if (!database.members.Any(x => x.server == guild.Id))
                {
                    await cmd.ReplyWithEmbedAsync("Member Error", "You have no members backed up!");
                    return;
                }
                if (ActiveDiscordServers.Contains(guild.Id))
                {
                    await cmd.ReplyWithEmbedAsync("Migration Progress", "Already pulling all users to this guild, please wait.");
                    return;
                }
                await JoinUsersToGuild(cmd, database, serverentry);

            }
            catch (Exception e)
            {
                ActiveDiscordServers.Remove((cmd.Channel as SocketGuildChannel).Guild.Id);
                await e.LogErrorAsync();
                await cmd.SendEmbedAsync("Migration Error", "An error, occured while migrating the database, please try again. If the error persists, please contact support.");
            }
        }

        private static async Task JoinUsersToGuild(SocketSlashCommand cmd, Services.Database database, Schema.Server server)
        {
            int memberCount = 0, successfulPullCount = 0;
            ActiveDiscordServers.Add((ulong)server.guildid);
            await cmd.ReplyWithEmbedAsync("Migration Progress", "Attempting to pull all users from database into this guild, please wait...");
            var members = await database.members.ToListAsync();
            foreach (var member in members)
            {
                if (member.server is null)
                    continue;
                if (member.server != server.guildid)
                    continue;
                memberCount++;
                //await cmd.SendEmbedAsync("member info", $"{member.userid}\n{member.access_token}\n{member.refresh_token}");
                if (await cmd.AddUserToGuild(member, server) != HttpStatusCode.OK)
                {
                    //failed to join guild
                    if (await RefreshUserToken(cmd, member, database) != HttpStatusCode.OK)
                    {
                        //failed to refresh token
                        //check possible failure & then delete token if it was a bad response
                        continue;
                    }
                    if (await cmd.AddUserToGuild(member, server) != HttpStatusCode.OK)
                    {
                        //failed to join guild after the token refresh
                        //investigate whats going on here & delete entry
                        continue;
                    }
                }
                successfulPullCount++;
                await Task.Delay(60);
            }
            ActiveDiscordServers.Remove((ulong)server.guildid);
            await cmd.SendEmbedAsync("Migration Progress", (successfulPullCount == memberCount) ? $"Finished pulling & joining all {memberCount} users from the database to this guild!" : $"Finished successfully pulling & joining {successfulPullCount} out of {memberCount} users from the database to this guild!");
        }

        private static async Task<HttpStatusCode> RefreshUserToken(SocketSlashCommand cmd, Schema.Member member, Services.Database database)
        {
            try
            {
                var web = new WebClient();
                web.Headers.Add("Content-Type", $"application/x-www-form-urlencoded");
                var result = JsonConvert.DeserializeObject<API.RefreshTokenInfo>(Encoding.Default.GetString(web.UploadValues("https://discordapp.com/api/oauth2/token", new NameValueCollection
                {
                    ["client_id"] = Properties.Resources.ClientID,
                    ["client_secret"] = Properties.Resources.ClientSecret,
                    ["grant_type"] = "refresh_token",
                    ["refresh_token"] = member.refresh_token,
                    ["redirect_uri"] = "https://restorecord.com/auth/",
                    ["scope"] = "identify guilds.join"
                })));
                if (result is null)
                    return HttpStatusCode.BadRequest;
                //await cmd.SendEmbedAsync("test", $"token was refreshed, should be saving it to the db now\n{result.access_token}\n{result.refresh_token}");
                member.access_token = result.access_token;
                member.refresh_token = result.refresh_token;
                await database.SaveChangesAsync();
                //await cmd.SendEmbedAsync("test", $"{member.access_token}\n{member.refresh_token}");
                return HttpStatusCode.OK;
            }
            catch (WebException webex)
            {
                var response = (HttpWebResponse)webex.Response;
                switch (response.StatusCode)
                {
                    case HttpStatusCode.TooManyRequests:
                        var headervalue = webex.Response.Headers.getHeader("Retry-After");
                        if (headervalue is not null)
                        {
                            Thread.Sleep(Convert.ToInt32(headervalue));
                            //run it again
                            if (await RefreshUserToken(cmd, member, database) == HttpStatusCode.OK)
                                return HttpStatusCode.OK;
                        }
                        return response.StatusCode;
                    default:
                        //await cmd.SendEmbedAsync("refresh token exception", $"{response.StatusCode}\n{webex}\n{response}");
                        return response.StatusCode;
                }
            }
        }

    }
}
