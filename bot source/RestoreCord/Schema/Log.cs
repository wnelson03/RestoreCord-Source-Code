using System;
using System.ComponentModel.DataAnnotations;

namespace RestoreCord.Schema
{
    public class Log
    {
        public class Errors
        {
            [Key]
            public int ID { get; set; }

            public string Name { get; set; }

            public string Location { get; set; }

            public string Reason { get; set; }

            public DateTime ErrorTime { get; set; }
        }
    }
}
