using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using Flori.Models;
using System.IO;
using System.Data.Entity;

namespace Flori.Controllers
{
    public class HomeController : Controller
    {
        FloriContext db = new FloriContext();

        public ActionResult Index()
        {
            var compozities = db.Compozities;
            ViewBag.Compozities = compozities;
            return View();
        }

       public ActionResult Stergere(int id){

            var compozitie = db.Compozities.Find(id);
            string name = ((Compozitie)compozitie).Denumire;
            db.Compozities.Remove(compozitie);
            db.SaveChanges();

            ViewBag.text = "Floare cu numele " + name + ", a fost ștearsă cu succes ! ";
            return View("/Views/Afisare.cshtml");
        }

        public ActionResult Modificare(int id)
        {
            var compozitie = db.Compozities.Find(id);

            ViewBag.FloriId = id;
            ViewBag.Denumire = ((Compozitie)compozitie).Denumire;
            ViewBag.Pret = ((Compozitie)compozitie).Pret;
            ViewBag.Dataaducerii = ((Compozitie)compozitie).Dataaducerii;
            ViewBag.Poza = ((Compozitie)compozitie).Poza;

            return View();
        }

        [HttpPost]
        public ActionResult Modificare (Compozitie data)
        {
            var compozitie = db.Compozities.Find(data.FloriId);
            ((Compozitie)compozitie).Denumire = data.Denumire;
            ((Compozitie)compozitie).Pret = data.Pret;
            ((Compozitie)compozitie).Dataaducerii = data.Dataaducerii;

            HttpPostedFileBase Poza = Request.Files["Poza"];
            if (Poza != null && Poza.ContentLength > 0)
            {
                ((Compozitie)compozitie).Poza = data.Poza;
                var fileName = Path.GetFileName(Poza.FileName);
                var path = Path.Combine(Server.MapPath("/Image/"), fileName);
                Poza.SaveAs(path);
                compozitie.Poza = Path.Combine("/Image/", fileName);
            }
            db.SaveChanges();

            ViewBag.text = "Floare cu numele " + compozitie + ", a fost modificată cu succes ! ";
            return View("/Views/Afisare.cshtml");
        }

        [HttpGet]
        public ActionResult Adauga()
        {
            return View();
        }

        [HttpPost]
        public ActionResult Adauga (Compozitie compozitie)
        {
            HttpPostedFileBase Poza = Request.Files["Poza"];
            if (Poza != null && Poza.ContentLength > 0)
            {
                var fileName = Path.GetFileName(Poza.FileName);
                var path = Path.Combine(Server.MapPath("/Image/"), fileName);
                Poza.SaveAs(path);
                compozitie.Poza = Path.Combine("/Image/", fileName);
            }
            db.Compozities.Add(compozitie);
            db.SaveChanges();
            return RedirectToAction("Index");

        }

    }
}