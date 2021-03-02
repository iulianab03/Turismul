using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Data.Entity;

namespace Flori.Models
{
    public class FloriContext:DbContext
    {
        public DbSet<Compozitie> Compozities { get; set; }
    }

    public class FloriDbInitializer : DropCreateDatabaseAlways<FloriContext>
    {
        protected override void Seed(FloriContext db)
        {
            db.Compozities.Add(new Compozitie { Denumire = "Trandafir", Pret = 200, Dataaducerii = new DateTime(2020, 02, 04), Poza="/Content/Images/img1.jpg" });
            base.Seed(db);

        }
    }
}