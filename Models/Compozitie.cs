using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.ComponentModel.DataAnnotations;

namespace Flori.Models
{
    public class Compozitie
    {
        public int FloriId { get; set; }
        public string Denumire { get; set; }
        public double Pret { get; set; }
        [DataType(DataType.Date)]
        public DateTime Dataaducerii { get; set; } = DateTime.Now;
        public string Poza { get; set; }
    }
}